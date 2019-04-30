<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TrackingCode;
use App\TrackingHistory;
use App\Mail\TrackingDetails;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Mail;
use Validator;

class TrackingController extends Controller
{
    public function submit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'courier_id' => 'required|exists:couriers,id',
            'code' => 'required|string|max:30',
            'email' => 'nullable|email',
        ]);

        if ($validator->fails()) {
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
        $tracking_code = TrackingCode::whereHashId('code', $request->code)->with('histories', 'courier')->first();

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

                if (strpos($process, 'Item delivered') !== false) {
                    $tracking_code->update([
                        'completed_at' => $date->format('Y-m-d H:i:s'),
                    ]);
                }
            }
        }

        if ($tracking_code->email && $sendEmail) {
            if (filter_var($tracking_code->email, FILTER_VALIDATE_EMAIL)) {
                Mail::to($tracking_code->email)->send(new TrackingDetails($tracking_code));
            }
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

        // dd($parsed);
        $dom = new \DOMDocument('1.0', 'UTF-8');
        $internalErrors = libxml_use_internal_errors(true);
        $dom->loadHTML($parsed[0][0]);
        libxml_use_internal_errors($internalErrors);

        $xpath = new \DOMXpath($dom);
        $trs = $xpath->query('//td[@class="trackItemFont"]');

        $sendEmail = false;
        $previousDate = NULL;
        foreach ($trs as $key => $tr) {
            $description       = $tr->childNodes[1]->childNodes[1]->childNodes[1]->childNodes[3]->childNodes[1]->childNodes[1]->childNodes[1]->nodeValue;
            $event = $tr->childNodes[1]->childNodes[1]->childNodes[1]->childNodes[3]->childNodes[1]->childNodes[1]->childNodes[3]->nodeValue;

            $date = trim(preg_replace('/\s+/', ' ', $tr->previousSibling->previousSibling->parentNode->previousSibling->previousSibling->nodeValue));
            $time = trim(preg_replace('/\s+/', ' ', $tr->previousSibling->previousSibling->nodeValue));

            try {
                $carbonDate = Carbon::createFromFormat('j M Y g:iA', $date.' '.$time);
                $previousDate = $date;
            } catch (\Exception $e) {
                $carbonDate = Carbon::createFromFormat('j M Y g:iA', $previousDate.' '.$time);
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
        }

        if ($tracking_code->email && $sendEmail) {
            if (filter_var($tracking_code->email, FILTER_VALIDATE_EMAIL)) {
                Mail::to($tracking_code->email)->send(new TrackingDetails($tracking_code));
            }
        }
    }
}
