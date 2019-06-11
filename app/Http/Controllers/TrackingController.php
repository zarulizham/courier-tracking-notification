<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TrackingCode;
use App\TrackingHistory;
use App\Mail\TrackingDetails;
use Carbon\Carbon;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use LaravelFCM\Message\Topics;
use FCM;
use GuzzleHttp\Client;
use Mail;
use Validator;
use App\Http\Controllers\Courier\JnTTracking;

class TrackingController extends Controller
{
    public function submit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'courier_id' => 'required|exists:couriers,id',
            'code' => 'required|string',
            'email' => 'nullable|email',
        ]);

        $validator->sometimes('code', 'min:12|max:14', function($input) {
            return $input->courier_id == 1;
        });
        $validator->sometimes('code', 'size:11', function($input) {
            return $input->courier_id == 3;
        });
        $validator->sometimes('code', 'size:18', function($input) {
            return $input->courier_id == 4;
        });
        $validator->sometimes('code', 'size:12', function($input) {
            return $input->courier_id == 5;
        });

        if ($validator->fails()) {
            if ($request->wantsJson()) {
                return response()->json([
                    'message' => $validator->errors()->first(),
                ], 400);
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $tracking_code = TrackingCode::updateOrCreate([
            'code' => $request->code,
            'courier_id' => $request->courier_id,
        ], [
            'email' => $request->email,
        ]);

        if ($tracking_code->courier_id == 1) {
            $this->checkPoslaju($tracking_code);
        } else if ($tracking_code->courier_id == 3) {
            $this->checkSkynet($tracking_code);
        } else if ($tracking_code->courier_id == 4) {
            $this->checkNinjaVan($tracking_code);
        } else if ($tracking_code->courier_id == 5) {
            $this->checkJnT($tracking_code);
        }

        if ($request->wantsJson()) {
            return response()->json([
                'tracking_code' => $tracking_code->load('courier', 'histories'),
            ], 200);
        }

        return redirect()->route('tracking.view', $tracking_code->tracking_code_id)->with('success', 'Tracking has been registered');
    }

    public function view(Request $request)
    {
        $tracking_code = TrackingCode::whereHashId($request->code)->with('histories', 'courier')->first();

        if (!$tracking_code) {
            if ($request->wantsJson()) {
                return response()->json([
                    'message' => 'Tracking code not found',
                ], 404);
            }
            abort(404);
        }

        if ($request->wantsJson()) {
            return response()->json([
                'tracking_code' => $tracking_code,
            ], 200);
        }
        return view('view')
        ->with([
            'tracking_code' => $tracking_code,
        ]);
    }

    public function email(Request $request)
    {
        $tracking_code = TrackingCode::find(1);
        return (new \App\Mail\TrackingDetails($tracking_code))->render();
    }

    public function checkPoslaju(TrackingCode $tracking_code)
    {
        $client = new Client();
        $result = $client->post('https://www.poslaju.com.my/track-trace-v2/', [
            'form_params' => [
                'trackingNo03' => $tracking_code->code,
                'hvtrackNoHeader03' => '',
                'hvfromheader03' => 0,
            ]
        ]);

        $contents = $result->getBody()->getContents();

        $patern = "#<table id='tbDetails'(.*?)</table>#";
        preg_match_all($patern, $contents, $parsed);

        $trpatern = "#<tr>(.*?)</tr>#";
        preg_match_all($trpatern, implode('', $parsed[0]), $tr);
        unset($tr[0][0]); # remove an array element because we don't need the 1st row (<th></th>)
        $tr[0] = array_values($tr[0]); # rearrange the array index
        $trackres = array();
        $sendEmail = false;

        if (count($tr[0]) > 0) {
            $tr[0] = array_reverse($tr[0]);
            for($i=0; $i<count($tr[0]); $i++) {
                $tdpatern = "#<td>(.*?)</td>#";
                preg_match_all($tdpatern, $tr[0][$i], $td);

                $datetime = strip_tags($td[0][0]);
                $process = strip_tags($td[0][1]);
                $event = strip_tags($td[0][2]);


                $date = Carbon::createFromFormat('d M Y, H:i:s A', $datetime);

                $tracking_history = TrackingHistory::updateOrCreate([
                    'tracking_code_id' => $tracking_code->id,
                    'history_date_time' => $date->format('Y-m-d H:i:s'),
                ], [
                    'description' => $process,
                    'event' => $event,
                ]);


                if ($tracking_history->wasRecentlyCreated) {
                    $sendEmail = true;
                }

                if (strpos($process, 'Item delivered') !== false || strpos($process, 'successfully delivered') !== false) {
                    $tracking_code->update([
                        'completed_at' => $date->format('Y-m-d H:i:s'),
                    ]);
                }
            }
        }

        if ($sendEmail) {
            if ($tracking_code->email) {
                if (filter_var($tracking_code->email, FILTER_VALIDATE_EMAIL)) {
                    Mail::to($tracking_code->email)->send(new TrackingDetails($tracking_code));
                }
            }
            $this->fcm($tracking_code);
        }
    }

    public function checkSkynet(TrackingCode $tracking_code)
    {
        $client = new Client();
        $result = $client->post('https://www.skynet.com.my/track', [
            'form_params' => [
                'hawbNoList' => $tracking_code->code,
                'btnAWBopt' => 'Airway Bill No.',
            ]
        ]);

        $contents = $result->getBody()->getContents();

        $search = array("<header>", "</header>", "<nav", "</nav>", "<section>", "</section>");
        $replace = array("<div>", "</div>","<div>", "</div", "<div>", "</div>");
        $contents = str_replace($search, $replace, $contents);
        $contents = preg_replace("/[\n\r\t]/","",$contents);

        $patern = '#<body onload="(.*?)">(.*?)</body>#';
        preg_match_all($patern, $contents, $parsed);

        $dom = new \DOMDocument('1.0', 'UTF-8');
        $internalErrors = libxml_use_internal_errors(true);
        $dom->loadHTML($parsed[0][0]);
        libxml_use_internal_errors($internalErrors);

        $xpath = new \DOMXpath($dom);
        $trs = $xpath->query('//td[@class="trackItemFont"]');

        $sendEmail = false;
        $previousDate = NULL;
        foreach ($trs as $key => $tr) {

            $description = '';
            $event = '';
            try {
                $description       = $tr->childNodes[1]->childNodes[1]->childNodes[1]->childNodes[3]->childNodes[1]->childNodes[1]->childNodes[1]->nodeValue;
                $event = $tr->childNodes[1]->childNodes[1]->childNodes[1]->childNodes[3]->childNodes[1]->childNodes[1]->childNodes[3]->nodeValue;
            } catch (\Exception $e) {
                $description = $tr->childNodes[1]->childNodes[1]->childNodes[0]->childNodes[2]->childNodes[1]->childNodes[0]->childNodes[0]->nodeValue; // for server
                $event = $tr->childNodes[1]->childNodes[1]->childNodes[0]->childNodes[2]->childNodes[1]->childNodes[0]->childNodes[2]->nodeValue;
            }

            $date = trim(preg_replace('/\s+/', ' ', $tr->previousSibling->previousSibling->parentNode->previousSibling->previousSibling->nodeValue));

			if ($date == '') {
				$date = trim(preg_replace('/\s+/', ' ', $tr->previousSibling->previousSibling->parentNode->previousSibling->nodeValue));
			}

            $time = trim(preg_replace('/\s+/', ' ', $tr->previousSibling->previousSibling->nodeValue));

            try {
                $carbonDate = Carbon::createFromFormat('j M Y g:iA', $date.' '.$time);
                $previousDate = $date;
            } catch (\Exception $e) {
	            try {
		            $date = trim(preg_replace('/\s+/', '', $tr->parentNode->previousSibling->nodeValue));
		            $carbonDate = Carbon::createFromFormat('j M Y g:iA', $date.' '.$time);
		            $previousDate = $date;
	            } catch(\Exception $e) {
	                $carbonDate = Carbon::createFromFormat('j M Y g:iA', $previousDate.' '.$time);
	            }
            }

            $tracking_history = TrackingHistory::updateOrCreate([
                'tracking_code_id' => $tracking_code->id,
                'history_date_time' => $carbonDate->format('Y-m-d H:i:s'),
            ], [
                'description' => $description,
                'event' => $event,
            ]);

            if ($tracking_history->wasRecentlyCreated) {
                $sendEmail = true;
            }

            if (strpos($description, 'Delivered') !== false) {
                $tracking_code->update([
                    'completed_at' => $carbonDate->format('Y-m-d H:i:s'),
                ]);
            }
        }

        if ($sendEmail) {
            if ($tracking_code->email) {
                if (filter_var($tracking_code->email, FILTER_VALIDATE_EMAIL)) {
                    Mail::to($tracking_code->email)->send(new TrackingDetails($tracking_code));
                }
            }
            $this->fcm($tracking_code);
        }
    }

    public function checkNinjaVan(TrackingCode $tracking_code)
    {
        $sendEmail = false;
        $client = new \GuzzleHttp\Client();
        $request = $client->get('https://api.ninjavan.co/my/shipperpanel/app/tracking?&id='.$tracking_code->code);
        try {
            $response = json_decode($request->getBody(), true);
            $events = $response['orders'][0]['events'];

            foreach ($events as $key => $event) {
                $date = Carbon::createFromTimestamp($event['time']/1000);

                $tracking_history = TrackingHistory::updateOrCreate([
                    'tracking_code_id' => $tracking_code->id,
                    'history_date_time' => $date->format('Y-m-d H:i:s'),
                ], [
                    'description' => $event['description'],
                    'event' => '',
                ]);

                if ($tracking_history->wasRecentlyCreated) {
                    $sendEmail = true;
                }

                if (strpos($event['description'], 'Successfully delivered') !== false) {
                    $tracking_code->update([
                        'completed_at' => $date->format('Y-m-d H:i:s'),
                    ]);
                }
            }

            if ($sendEmail) {
                if ($tracking_code->email) {
                    if (filter_var($tracking_code->email, FILTER_VALIDATE_EMAIL)) {
                        Mail::to($tracking_code->email)->send(new TrackingDetails($tracking_code));
                    }
                }
                $this->fcm($tracking_code);
            }
        } catch(\Exception $e) {

        }
    }

    public function fcm(TrackingCode $tracking_code)
    {
        $title = $tracking_code->courier->name.': '.$tracking_code->code;
        $body = $tracking_code->latestHistory->description.' '.$body = $tracking_code->latestHistory->event;
        $notificationBuilder = new PayloadNotificationBuilder($title);
        $notificationBuilder->setBody($body)
                            ->setSound('default');

        $notification = $notificationBuilder->build();

        $topic = new Topics();
        $topic->topic($tracking_code->code);

        $topicResponse = FCM::sendToTopic($topic, null, $notification, null);

        $topicResponse->isSuccess();
        $topicResponse->shouldRetry();
        $topicResponse->error();
    }

    public function checkJnT(TrackingCode $tracking_code)
    {
        $jnt = new JnTTracking($tracking_code);
        $jnt->get();
    }
}
