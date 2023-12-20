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

        // Handle the response...
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



    public function checkoutPagePost(Request $request)
    {
        $request->validate([
            'firstName' => 'required|min:1',
            'lastName' => 'required|min:1',
            'address' => 'required|min:1',
            'zipcode' => 'required|numeric',
            'city' => 'required|min:1',
            'phone' => 'required|numeric',
        ]);

        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        // Fetch the cart for the authenticated user
        $cart = Cart::with('products')->find($user->cart_id);

        if (!$cart) {
            // Handle the case where the cart doesn't exist
            return view('cart')->with('cartItems', []);
        }

        foreach ($cart->products as $product) {
            // Here you subtract the amount bought from the product's quantity
            $boughtQuantity = $product->pivot->quantity;
            $product->quantity -= $boughtQuantity;

            // Save the updated product quantity
            $product->save();
        }


        // Clear the items in the cart
        $cart->products()->detach();

        // Persist the changes to the database
         $cart->save();

        return redirect(route('paymentComplete'))->with('success', 'Payment success');
    }


}
