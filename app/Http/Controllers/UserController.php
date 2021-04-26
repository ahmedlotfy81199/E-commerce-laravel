<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()  // displays all user with orders
    {
        $id = auth()->guard('api')->user()->id;
        $userId = User::find($id);
            return response()->json(Order::where('user_id', '=', $id)->get(), 200);
        
    }

    public function login(Request $request)  // authenticates the user
    {

        $status = 401;
        $response = ['error' => 'Unauthorised'];

        if (Auth::attempt($request->only(['email', 'password']))) {
            error_log('$userId');

            $userId = Auth::id();
            $user = User::find($userId);
            $accessToken = auth()->user()->createToken('bagisto')->accessToken;

            return response()->json([
                'user' => auth()->user(),
                'token' => $accessToken,
            ]);
        }

        return response()->json([
            'message' => 'These credentials do not match our records.'
        ], 400);
    }

    public function register(Request $request)  //create user account
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:50',
            'email' => 'required|email',
            'password' => 'required|min:6',
            'c_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->messages(), 'status' => 400], 400);
        }

        $data = $request->only(['name', 'email', 'password']);
        $data['password'] = bcrypt($data['password']);

        $user = User::create($data);
        $user->is_admin = 0;

        return response()->json([
            'user' => $user,
            'token' => $user->createToken('bagisto')->accessToken,
        ]);
    }

    public function show(User $user)  // fetch details of users
    {
        if ($user) {
            return response()->json($user);
        }
    }

    public function showOrders(User $user)  // fetch the orders of the users
    {
        return response()->json($user->orders()->with(['product'])->get());
    }
}
