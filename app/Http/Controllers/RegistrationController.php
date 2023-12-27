<?php

namespace App\Http\Controllers;
use App\Models\Cart;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegistrationController extends Controller
{

    protected $apiConsumerController;

    public function __construct(ApiConsumerController $apiConsumerController)
    {
        $this->apiConsumerController = $apiConsumerController;
    }


    public function userRegPostAPI(Request $request) {

        $formData = $request->only(['email', 'password', 'rpassword', 'phone']);

        // Call the API consumer method
        $response = $this->apiConsumerController->userReg($formData);

        // Handle the response based on the success key
        if (isset($response['success']) && $response['success']) {
            return redirect()->route('homeIndex')->with('success', 'Registration successful.');
        } else {
            $errorMessage = $response['message'] ?? 'Registration failed.';
            return redirect()->back()->with('error', $errorMessage);
        }
    }

    public function userReg()
    {
        return view('userReg');
    }


}
