<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
class ProfileController extends Controller
{

    protected $apiConsumerController;

    public function __construct(ApiConsumerController $apiConsumerController)
    {
        $this->apiConsumerController = $apiConsumerController;
    }


    public function changePasswordAPI(Request $request) {
        $user = Auth::user();

        $request->validate([
            'passwordOld' => 'required',
            'passwordNew1' => 'required|min:1',
            'passwordNew2' => 'required|min:1|same:passwordNew1'
        ]);

        $response = $this->apiConsumerController->changePassword($user->id, [
            'passwordOld' => $request->passwordOld,
            'passwordNew' => $request->passwordNew1
        ]);

        if ($response['success']) {
            return redirect(route('homeIndex'))->with('success', $response['message']);
        } else {
            return back()->withErrors(['passwordOld' => $response['message']]);
        }
    }

    public function showProfile()
    {
        $user = auth()->user();

        return view('profile', compact('user'));

    }


}
