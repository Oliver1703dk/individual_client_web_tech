<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Customer;

class AuthenticationController extends Controller {

    protected $apiConsumerController;

    public function __construct(ApiConsumerController $apiConsumerController)
    {
        $this->apiConsumerController = $apiConsumerController;
    }


    public function loginPostAPI(Request $request) {
        $formData = $request->only(['email', 'password']);

        // Call the API consumer method
        $response = $this->apiConsumerController->login($formData);

        // Handle the response based on the success key
        if (isset($response['success']) && $response['success']) {
            $user = User::where('email', $formData['email'])->first();
            if ($user) {
                Auth::login($user);

                return redirect()->route('homeIndex')->with('success', 'Login successful.');
            }

            return redirect()->route('homeIndex')->with('error', 'User not found in client database');
        } else {
            $errorMessage = $response['message'] ?? 'Login failed.';
            return redirect()->back()->with('error', $errorMessage);
        }
    }

    public function login()
    {
        return view('login');
    }


    public function logoutPost()
    {
        Auth::logout();
        return redirect('/');
    }

}
