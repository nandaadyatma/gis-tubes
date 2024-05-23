<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('login', [
            'title' => "Login",
        ]);
        
    }


    public function login(Request $request)
    {
        $response = Http::post('https://gisapis.manpits.xyz/api/login', [
            'email' => $request->email,
            'password' => $request->password,
        ]);

        echo '<script type="text/JavaScript">  
        document.getElementById("login-button").innerHTML = "Login";
        document.getElementById("login-button").style.opacity = "1"
        </script>';
        
      

            

        if ($response->successful()) { //code 200

            if($response->json()['meta']['code'] == 200){
                session([
                    'token' => $response->json()['meta']['token'],

            ]); 

            $name =  $responseGetUser = Http::withToken(session('token'))->get('https://gisapis.manpits.xyz/api/user');
                if($responseGetUser->successful()) {
                    session([
                        'name' => $responseGetUser->json()['data']['user']['name']
                    ]);
                }


            return redirect()->route('home');
            
            } else {
                $errorCode = json_decode($response->body(), true)['meta']['code'];
                $errorMessage = json_decode($response->body(), true)['meta']['message'];
                return back()->withErrors(['errors' => $errorCode . " | " . $errorMessage]);
            }
            
        } else {
            $errorCode = json_decode($response->body(), true)['meta']['code'];
            $errorMessage = json_decode($response->body(), true)['meta']['message'];
            return back()->withErrors(['errors' => $errorCode . " | " . $errorMessage]);
        }
        
        
    }

    public function showRegisterForm()
    {
        return view('register',[
            "title" => "Register",
        ]);
    }

    public function register(Request $request)
    {
        $response = Http::post('https://gisapis.manpits.xyz/api/register', [
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
        ]);

        if ($response->successful()) { //code 200

            if($response->json()['meta']['message'] != "Successfully create user") {

                $errorMessage = $response->json()['meta']['message'];
                $errorCode = $response->json()['meta']['code'];

                return back()->withErrors(['errors' => $errorCode . " | " . $errorMessage]);
            }
            else {
                
                return redirect()->route('login')->with('status', 'User created successfully. Please login.');
                
            }
            
            
        } else {
            $errorMessage = json_decode($response->body())['meta']['message'];
            $errorCode = json_decode($response->body())['meta']['code'];

            return back()->withErrors(['errors' => $errorCode . " | " . $errorMessage]);
        }
        
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->flush();
        return redirect()->route('login');
    }
}
