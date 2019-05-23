<?php

namespace App\Http\Controllers\Courier;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\FileCookieJar;
use App\TrackingHistory;
use App\TrackingCode;
use Carbon\Carbon;
use File;

class JnTTracking extends Controller
{
    private $tracking_code;
    private $csrf_token;
    private $url = "https://www.jtexpress.my/track";
    private $cookie_path;

    public function __construct(TrackingCode $tracking_code) {
        $this->tracking_code = $tracking_code;
        $this->cookie_path = storage_path("cookies/jnt_express.txt");

        if (!storage_path("cookies")) {
            File::makeDirectory(storage_path("cookies"), 0755, true, true);
        }
    }

    public function get()
    {
        $this->getToken();
        $this->getDetails();
    }

    public function getToken()
    {
        $cookieJar = new FileCookieJar($this->cookie_path, TRUE);

        $client = new Client([
            'cookies' => $cookieJar
        ]);

        $request = $client->get($this->url);
        $response = $request->getBody();

        libxml_use_internal_errors(true);
        $dom = new \DomDocument();
        $dom->loadHTML($response);
        libxml_use_internal_errors(false);
        $tokens = $dom->getElementsByTagName("input");

        for ($i = 0; $i < $tokens->length; $i++) {
            $meta = $tokens->item($i);
            if($meta->getAttribute('name') == '_token') {
                $this->csrf_token = $meta->getAttribute('value');
            }

        }
    }

    public function getDetails()
    {
        $cookieJar = new FileCookieJar($this->cookie_path, TRUE);

        $headers = [
            'Accept' => 'text/xml,application/xml,application/xhtml+xml,',
            'X-CSRF-Token' => $this->csrf_token,
            'Accept-Charset' => 'ISO-8859-1,UTF-8;q=0.7,*;q=0.7',
        ];

        $client = new Client([
            'cookies' => $cookieJar,
            'url' => $this->url,
            'headers' => $headers,
        ]);

        $myBody['billcode'] = $this->tracking_code->code;
        $request = $client->post($this->url,  ['form_params' => $myBody]);
        $response = $request->getBody();

        libxml_use_internal_errors(true);
		$dom2 = new \DomDocument();
		$dom2->loadHTML($response);
		libxml_use_internal_errors(false);
		$finder = new \DomXPath($dom2);

		$classname="entry";

		$entries = $finder->query("//*[contains(@class, '$classname')]");

		foreach ($entries as $entry) {
            $date = $entry->childNodes[1]->childNodes[1]->nodeValue;
            $time = $entry->childNodes[1]->childNodes[3]->nodeValue;

			$dropPoint = $entry->childNodes[3]->childNodes[1]->nodeValue;
			$city = $entry->childNodes[3]->childNodes[3]->nodeValue;
            $city = str_replace("City :", '', $city);
            if (isset($entry->childNodes[3]->childNodes[5]->nodeValue)) {
                $status = $entry->childNodes[3]->childNodes[5]->nodeValue;
            }
            try {
                $status = $entry->childNodes[3]->childNodes[5]->nodeValue;
            } catch (\Throwable $th) {
                $status = '';
            }

            $carbonDate = Carbon::createFromFormat('m/d/Y H:i:s', $date.' '.$time);
            $tracking_history = TrackingHistory::updateOrCreate([
                'tracking_code_id' => $this->tracking_code->id,
                'history_date_time' => $carbonDate->format('Y-m-d H:i:s'),
            ], [
                'description' => $status,
                'event' => $dropPoint,
                'city' => $city,
            ]);
		}
    }
}
