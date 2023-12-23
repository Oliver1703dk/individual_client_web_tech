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
        // Prepare form data
        $formData = $request->only(['email', 'password']);

        // Call the API consumer method
        $response = $this->apiConsumerController->login($formData);

        // Handle the response based on the success key or HTTP status code
        if (isset($response['success']) && $response['success']) {
            // Here, you might want to set session data or perform other tasks to log in the user on the client side
            $user = User::where('email', $formData['email'])->first();
            if ($user) {
                Auth::login($user);

                return redirect()->route('homeIndex')->with('success', 'Login successful.');
            }

            return redirect()->route('homeIndex')->with('error', 'User not found in client database');
        } else {
            // Extract error message or set a default one
            $errorMessage = $response['message'] ?? 'Login failed.';
            return redirect()->back()->with('error', $errorMessage);
        }
    }







    public function login()
    {
        return view('login');
    }
    public function loginPost(Request $request)
    {

        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials)) {

            return redirect('/')->with('success', 'login');
        }

        return back()->with('error', 'Email or phone');
    }
    public function logoutPost(Request $request)
    {
        Auth::logout();
        return redirect('/');
    }


}
