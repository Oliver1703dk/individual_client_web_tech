<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Cart; // Import the Cart model
use App\Models\Product; // If you use the Product model, you should import it too
use App\Services\PaymentGateway; // Import the PaymentGateway service if used
use App\Models\CartProduct;


class CartController extends Controller {


    protected $apiConsumerController;

    public function __construct(ApiConsumerController $apiConsumerController)
    {
        $this->apiConsumerController = $apiConsumerController;
    }



    public function addProductToCartAPI(Request $request)
    {
        $user = auth()->user();
        $productId = $request->input('product_id');

        // Call the API consumer method
        $this->apiConsumerController->addProductToCart($user->id, $productId);

        return redirect()->back()->with('success', 'Product added to cart successfully.');


    }

    public function minusQuantityAPI(Request $request)
    {
        $user = auth()->user();
        $productId = $request->input('product_id');

        // Call the API consumer method
        $this->apiConsumerController->minusQuantity($user->id, $productId);

        return redirect()->back()->with('success', 'Product added to cart successfully.');

    }


    public function cartProductsAPI(Request $request){
        $user = auth()->user();

        // Call the API consumer method to get cart items
        $cartItems = $this->apiConsumerController->getCartProducts($user->id);
        // Pass the cart items to the view
        return view('cart', ['cartItems' => $cartItems]);
    }

    public function cart()
    {
        return view('cart');
    }

}
