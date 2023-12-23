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
        // Validate the request data here or assume it's already validated

        // Prepare form data
        $formData = $request->only(['email', 'password', 'rpassword', 'phone']);

        // Call the API consumer method
        $response = $this->apiConsumerController->userReg($formData);

        // Handle the response based on the success key or HTTP status code
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

    public function userRegPost2(Request $request)
    {

        // Validate the request data
        $request->validate([
            'email' => 'required|email|unique:users',
            'password' => 'required|min:1',
            'rpassword' => 'required|same:password',
            'phone' => 'required|numeric'
        ], [
            'rpassword.same' => 'The password and confirmation password do not match.',
        ]);


        // Check if a user with the given email already exists
        $existingUser = User::where('email', $request->email)->first();



        if($existingUser){
            return Redirect::back()->withInput()->withErrors(['email' => 'This email is already registered']);
        }

        // Create a new Cart and associate it with the customer
        $cart = new Cart();
        $cart->save();

        $user = new User();

        $user->email = $request->email;
        $user->password = $request->password;
        $user->phone = $request->phone;

        $user->admin = false;
        $user->cart_id;

        $user->cart_id = $cart->id;

        $user->save();



        Auth::login($user);

        return redirect(route('homeIndex'))->with('success', 'Register sucessfully');

    }


}
