<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Cookie\CookieJar;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
// use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    private $PHPSESSID;

    // Initialize cURL session outside the function
    private $ch;

    public function __construct(){
        if(!$this->PHPSESSID){
            $this->setCookieSession();
        }

        $this->PHPSESSID = session('PHPSESSID');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!$this->PHPSESSID){
            return redirect()->route('login');
        }

        $settingObjects = [];
        $objects = [];
        // $settingObjects = $this->getSettingObjects();
        // $objects = $this->getObjects();
        return view('pages.index', compact('settingObjects', 'objects'));

    }

    public function getOnLoadData(){
        return [
            'settingObject' => $this->getSettingObjects(),
            'listObject' => $this->getObjects(),
        ];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getSettingObjects()
    {
        $cacheName = $this->PHPSESSID.'_setting_objects';
        // Check if the data is already cached
        if (Cache::has($cacheName)) {
            return Cache::get($cacheName);
        }
        // Set the target URL
        $url = env('APP_URL') . '/func/fn_settings.objects.php';

        // Prepare the POST data
        $postData = [
            'cmd' => 'load_object_data',
        ];

        // Initialize cURL session
        $ch = curl_init($url);

        // Set common cURL options
        $commonOptions = [
            CURLOPT_RETURNTRANSFER => true, // Return the response as a string instead of outputting it
            CURLOPT_POST => true, // Set the request method to POST
            CURLOPT_POSTFIELDS => $postData, // Set the POST data
            CURLOPT_COOKIEJAR => storage_path('app/cookies.txt'), // Specify the file to save cookies in
            CURLOPT_COOKIEFILE => storage_path('app/cookies.txt'), // Specify the file to read cookies from
            CURLOPT_HTTPHEADER => [
                'Access-Control-Allow-Origin: http://localhost', // Add any other headers if needed
            ],
            // CURLOPT_TIMEOUT => 15, // Set a timeout value in seconds
        ];

        // Set common options for each cURL handle
        foreach ($commonOptions as $option => $value) {
            curl_setopt($ch, $option, $value);
        }

        // Execute cURL session and get the response
        $response = curl_exec($ch);

        // Check for cURL errors
        if (curl_errno($ch)) {
            echo 'cURL error: ' . curl_error($ch);
        }

        // Close cURL session
        curl_close($ch);

        // Decode JSON response
        $decodedResponse = json_decode($response, true);

        // Cache the response for 15 minutes (adjust the value as needed)
        Cache::put($cacheName, $decodedResponse, 900);

        return $decodedResponse;
    }

    public function getObjects()
    {
        $cacheName = $this->PHPSESSID.'_fn_objects';
        // Check if the data is already cached
        if (Cache::has($cacheName) && !request()->ajax()) {
            return Cache::get($cacheName);
        }

        // Set the target URL
        $url = env('APP_URL') . '/func/fn_objects.php';

        // Prepare the POST data
        $postData = [
            'cmd' => 'load_object_data',
        ];

        // Initialize cURL session
        $ch = curl_init($url);

        // Set common cURL options
        $commonOptions = [
            CURLOPT_RETURNTRANSFER => true, // Return the response as a string instead of outputting it
            CURLOPT_POST => true, // Set the request method to POST
            CURLOPT_POSTFIELDS => $postData, // Set the POST data
            CURLOPT_COOKIEJAR => storage_path('app/cookies.txt'), // Specify the file to save cookies in
            CURLOPT_COOKIEFILE => storage_path('app/cookies.txt'), // Specify the file to read cookies from
            CURLOPT_HTTPHEADER => [
                'Access-Control-Allow-Origin: http://localhost', // Add any other headers if needed
            ],
            // CURLOPT_TIMEOUT => 15, // Set a timeout value in seconds
        ];

        // Set common options for each cURL handle
        foreach ($commonOptions as $option => $value) {
            curl_setopt($ch, $option, $value);
        }

        // Execute cURL session and get the response
        $response = curl_exec($ch);

        // Check for cURL errors
        if (curl_errno($ch)) {
            echo 'cURL error: ' . curl_error($ch);
        }

        // Close cURL session
        curl_close($ch);

        if(!request()->ajax()){
            // Cache the response for 15 minutes (adjust the value as needed)
            Cache::put($cacheName, $response, 900);
        }
        return $response;
    }

    public function getObjectHistory(Request $request)
    {
        // Set the target URL
        $url = env('APP_URL') . '/func/fn_history.php';

        // Prepare the POST data
        $postData = [
            'cmd' => $request->cmd,
            'imei' => $request->imei,
            'dtf' => $request->dtf,
            'dtt' => $request->dtt,
            'min_stop_duration' => $request->min_stop_duration,
        ];

        // Initialize cURL session
        $ch = curl_init($url);

        // Set common cURL options
        $commonOptions = [
            CURLOPT_RETURNTRANSFER => true, // Return the response as a string instead of outputting it
            CURLOPT_POST => true, // Set the request method to POST
            CURLOPT_POSTFIELDS => $postData, // Set the POST data
            CURLOPT_COOKIEJAR => storage_path('app/cookies.txt'), // Specify the file to save cookies in
            CURLOPT_COOKIEFILE => storage_path('app/cookies.txt'), // Specify the file to read cookies from
            CURLOPT_HTTPHEADER => [
                'Access-Control-Allow-Origin: http://localhost', // Add any other headers if needed
            ],
            // CURLOPT_TIMEOUT => 15, // Set a timeout value in seconds
        ];

        // Set common options for each cURL handle
        foreach ($commonOptions as $option => $value) {
            curl_setopt($ch, $option, $value);
        }

        // Execute cURL session and get the response
        $response = curl_exec($ch);

        // Check for cURL errors
        if (curl_errno($ch)) {
            echo 'cURL error: ' . curl_error($ch);
        }

        // Close cURL session
        curl_close($ch);

        return $response;
    }

    public function getEventsList(Request $request)
    {
        // Set the target URL
        $url = env('APP_URL') . '/func/fn_events.php';

        // Prepare the POST data
        $postData = [
            'cmd' => 'load_last_event_1'
        ];

        if(!empty($request->last_id)){
            $postData['last_id'] = $request->last_id;
        }

        // Initialize cURL session
        $ch = curl_init($url);

        // Set common cURL options
        $commonOptions = [
            CURLOPT_RETURNTRANSFER => true, // Return the response as a string instead of outputting it
            CURLOPT_POST => true, // Set the request method to POST
            CURLOPT_POSTFIELDS => $postData, // Set the POST data
            CURLOPT_COOKIEJAR => storage_path('app/cookies.txt'), // Specify the file to save cookies in
            CURLOPT_COOKIEFILE => storage_path('app/cookies.txt'), // Specify the file to read cookies from
            CURLOPT_HTTPHEADER => [
                'Access-Control-Allow-Origin: http://localhost', // Add any other headers if needed
            ],
            // CURLOPT_TIMEOUT => 15, // Set a timeout value in seconds
        ];

        // Set common options for each cURL handle
        foreach ($commonOptions as $option => $value) {
            curl_setopt($ch, $option, $value);
        }

        // Execute cURL session and get the response
        $response = curl_exec($ch);

        // Check for cURL errors
        if (curl_errno($ch)) {
            echo 'cURL error: ' . curl_error($ch);
        }

        // Close cURL session
        curl_close($ch);

        return $response;
    }

    public function resolveEvent(Request $request)
    {
        // Set the target URL
        $url = env('APP_URL') . '/func/fn_events.php';

        // Prepare the POST data
        $postData = [
            'cmd' => 'load_last_event_2'
        ];

        if(!empty($request->last_id)){
            $postData['last_id'] = $request->last_id;
        }

        // Initialize cURL session
        $ch = curl_init($url);

        // Set common cURL options
        $commonOptions = [
            CURLOPT_RETURNTRANSFER => true, // Return the response as a string instead of outputting it
            CURLOPT_POST => true, // Set the request method to POST
            CURLOPT_POSTFIELDS => $postData, // Set the POST data
            CURLOPT_COOKIEJAR => storage_path('app/cookies.txt'), // Specify the file to save cookies in
            CURLOPT_COOKIEFILE => storage_path('app/cookies.txt'), // Specify the file to read cookies from
            CURLOPT_HTTPHEADER => [
                'Access-Control-Allow-Origin: http://localhost', // Add any other headers if needed
            ],
            // CURLOPT_TIMEOUT => 15, // Set a timeout value in seconds
        ];

        // Set common options for each cURL handle
        foreach ($commonOptions as $option => $value) {
            curl_setopt($ch, $option, $value);
        }

        // Execute cURL session and get the response
        $response = curl_exec($ch);

        // Check for cURL errors
        if (curl_errno($ch)) {
            echo 'cURL error: ' . curl_error($ch);
        }

        // Close cURL session
        curl_close($ch);

        return $response;
    }

    public function setCookieSession()
    {
        // Now you can read cookies from the saved file if needed
        $cookies = file_get_contents(storage_path('app/cookies.txt'));
        // Check if the cookie file content is not empty
        if (!empty($cookies)) {
            // Split the content into lines
            $lines = explode("\n", $cookies);

            // Loop through each line
            foreach ($lines as $line) {

                // Split the line into fields
                $fields = explode("\t", $line);

                // Check if the line contains the PHPSESSID
                if (count($fields) >= 7 && $fields[5] == 'PHPSESSID') {
                    $phpsessid = $fields[6];
                    session(['PHPSESSID' => $phpsessid]);
                    break; // Stop looping once PHPSESSID is found
                }
            }
        } else {
            echo 'Cookie file is empty or cannot be read.';
        }
    }

    public function getCookies(){
        // Read cookies from a text file
        // $cookiesFile = storage_path('app/cookies.txt'); // Adjust the path accordingly
        $cookiesContent = file_get_contents(storage_path('app/cookies.txt'));

        // Split the content into lines and extract cookies
        $lines = explode("\n", $cookiesContent);
        $cookies = [];

        foreach ($lines as $line) {
            $line = trim($line);

            // Skip lines starting with '#' (comments or header)
            if (empty($line) || $line[0] === '#') {
                continue;
            }

            // Split the line into fields
            $fields = explode("\t", $line);

            // Extract the cookie values
            // $domain = $fields[0];
            // $path = $fields[2];
            $name = $fields[5];
            $value = $fields[6];

            // Store the cookie in the array
            // $cookies[$name] = $value;
            // Store the cookie in the array
            $cookies[] = "{$name}={$value}";
        }

        return $cookies;
    }

    public function getDataFromJsonFile($json_file_path)
    {
        if (file_exists($json_file_path)) {
            // Read the content of the JSON file
            $jsonContent = file_get_contents($json_file_path);

            if($jsonContent){
                return $jsonContent;
            }
        }

        return false;
    }

    public function getGroupList()
    {
        // Set the target URL
        $url = env('APP_URL') . '/func/fn_settings.objects.php';

        $postData = [
            'cmd' => 'load_whatsapp_data',
        ];

        // Initialize cURL session
        $ch = curl_init($url);

        // Set common cURL options
        $commonOptions = [
            CURLOPT_RETURNTRANSFER => true, // Return the response as a string instead of outputting it
            CURLOPT_POST => true, // Set the request method to POST
            CURLOPT_POSTFIELDS => $postData, // Set the POST data
            CURLOPT_COOKIEJAR => storage_path('app/cookies.txt'), // Specify the file to save cookies in
            CURLOPT_COOKIEFILE => storage_path('app/cookies.txt'), // Specify the file to read cookies from
            CURLOPT_HTTPHEADER => [
                'Access-Control-Allow-Origin: http://localhost', // Add any other headers if needed
            ],
            // CURLOPT_TIMEOUT => 15, // Set a timeout value in seconds
        ];

        // Set common options for each cURL handle
        foreach ($commonOptions as $option => $value) {
            curl_setopt($ch, $option, $value);
        }

        // Execute cURL session and get the response
        $response = curl_exec($ch);

        // Check for cURL errors
        if (curl_errno($ch)) {
            echo 'cURL error: ' . curl_error($ch);
        }

        // Close cURL session
        curl_close($ch);

        return $response;
    }

    public function sendMessage(Request $request)
    {
        $to = $request->to;
        $clientId = "eyJpZCI6IkthM3pvekRzbGttNnNTcVVOTTQ4UzJXVkc3dk9DRWVTIiwiY2xpZW50X2lkIjoiaml6YSA1In0=";
        $token = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1aWQiOiJNRlVNT01KcGIySnd4U0tGWUlEZmhVRTN0ZWc2REhKWSIsInJvbGUiOiJ1c2VyIiwiaWF0IjoxNzE2MjIzMTY1fQ.cuf9pb82nePCOwg1dovSnyyW2pcVrYgy-l2ulOm_aYo";
        $clientId = urlencode($clientId);
        $token = urlencode($token);
        $to = urlencode($to);
        $text = $request->message;
        $text = urlencode($text);

        $params = "client_id=$clientId&text=$text&token=$token&to=$to";

        // }
        // $url = "http://127.0.0.1:8001/api/send-message/chat?$params";
        $url = "https://msg.alphaxcloud.com/api/send-message/chat?$params";
        // return "https://msg.alphaxcloud.com/api/send-message/chat?".$params;
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            // CURLOPT_HTTPHEADER => array(
            //     "content-type: application/x-www-form-urlencoded"
            // ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $this->resolveEvent($request);
            return $response;
        }
    }
}
