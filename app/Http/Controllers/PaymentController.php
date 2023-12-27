<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use \Illuminate\Http\Request;


class PaymentController extends Controller
{

    protected $apiConsumerController;

    public function __construct(ApiConsumerController $apiConsumerController)
    {
        $this->apiConsumerController = $apiConsumerController;
    }


    public function cartProductsCheckoutPageAPI(){

        $user = auth()->user();

        // Call the API consumer method
        $cartItems = $this->apiConsumerController->getCartProducts($user->id);

        return view('checkoutPage', compact('cartItems'));
    }


    public function checkoutPagePostAPI(Request $request) {
        $user = auth()->user();

        // Include form data in the API request
        $response = $this->apiConsumerController->checkoutPagePost($user->id, $request->all());

        if ($response['success']) {
            return redirect()->route('paymentComplete')->with('success', 'Payment complete.');
        } else {
            return redirect()->back()->with('error', 'Error during checkout.');
        }
    }

    public function checkoutPage ()
    {
        return view('CheckoutPage');
    }

}
