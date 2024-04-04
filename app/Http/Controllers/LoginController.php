<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Set the target URL
        $url = env('APP_URL').'/func/fn_connect.php';

        // Prepare the POST data
        $postData = array(
            'cmd' => 'login',
            'mobile' => false,
            'password' => $request->password,
            'remember_me' => true,
            'username' => $request->username,
        );

        // Initialize cURL session
        $ch = curl_init($url);

       // Set cURL options in an array
        $commonOptions = [
            CURLOPT_RETURNTRANSFER => true, // Return the response as a string instead of outputting it
            CURLOPT_POST => true, // Set the request method to POST
            CURLOPT_POSTFIELDS => $postData, // Set the POST data
            CURLOPT_HTTPHEADER => [
                'Access-Control-Allow-Origin: http://localhost', // Add any other headers if needed
            ],
            CURLOPT_COOKIEJAR => storage_path('app/cookies.txt'), // Save cookies to a file
            CURLOPT_TIMEOUT => 10, // Set a timeout value in seconds
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
        $response;

        if($response == 'LOGIN_TRACKING'){
            return redirect()->route('dashboard');
        }else{
            return back();
        }


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getLoginPage()
    {
        // if(session('PHPSESSID')){
        //     return redirect()->route('dashboard');
        // }
        return view('pages.login');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function show(Message $message)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function edit(Message $message)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Message $message)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function destroy(Message $message)
    {
        //
    }
}
