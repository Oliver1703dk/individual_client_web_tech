<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    protected $apiConsumerController;

    public function __construct(ApiConsumerController $apiConsumerController)
    {
        $this->apiConsumerController = $apiConsumerController;
    }

    public function homeIndexAPI()
    {
        // Fetch products from the API
        $products = $this->apiConsumerController->getProducts();

        // Pass products to the view
        return view('index', compact('products'));
    }

    public function catalogIndexAPI()
    {
        // Fetch products from the API
        $products = $this->apiConsumerController->getProducts();

        // Pass products to the view
        return view('productsCatalog', compact('products'));
    }

    public function showProductAPI(Request $request)
    {
        $productId = $request->input('product_id');

        $product = $this->apiConsumerController->getProductById($productId);

        if ($product) {
            return view('productPage', ['product' => $product]);
        } else {
            // Handle the case where the product is not found
            return redirect()->back()->withErrors(['Product not found']);
        }
    }


    public function addProductDBAPI(Request $request) {
        $formData = $request->only([
            'name', 'price', 'quantity', 'product_info1', 'product_info2', 'product_info3', 'product_info4', 'description', 'image'
        ]);

        if (!auth()->user() || !auth()->user()->admin) {
            return back()->with('error', "User not admin");
        }

        // Call the API consumer method
        $response = $this->apiConsumerController->addProduct($formData);

        if ($response['success']) {
            return redirect()->route('homeIndex')->with('success', $response['message']);
        } else {
            return back()->with('error', $response['message']);
        }
    }


    public function deleteProductAPI(Request $request) {
        $productId = $request->input('product_id');

        if (!auth()->user() || !auth()->user()->admin) {
            return back()->with('failed', "User not admin");
        }

        $response = $this->apiConsumerController->deleteProduct($productId);


        if ($response['success']) {
            return redirect()->route('homeIndex')->with('success', $response['message']);
        } else {
            return redirect()->back()->with('error', $response['message']);
        }
    }





    public function productPageAdmin(){
        return view('productPageAdmin');
    }



}



