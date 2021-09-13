<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public function login(Request $request)
    {
        $loginData = $request->only([
            'phone',
            'password'
        ]);
        if (!auth('customer')->attempt($loginData)) {
            $response = [
                'status' => Response::HTTP_NOT_FOUND,
                'message' => 'Invalid Credentials',
            ];
            return response($response, Response::HTTP_NOT_FOUND);
        }
        $accessToken = auth('customer')->user()->createToken('authToken')->accessToken;
        $response = [
            'status' => Response::HTTP_OK,
            'message' => 'Successed',
            'data' => [
                'user' => auth('customer')->user(),
                'access_token' => $accessToken
            ],
        ];
        return response($response, Response::HTTP_OK);
    }
    public function getMe()
    {
        $customer = auth()->user();
        return response()->json(['customer' => $customer], 200);
    }
    public function update(Request $request)
    {
        $customer = Customer::find(Auth::user()->id);
        $customer->email = $request->email;
        $customer->phone = $request->phone;
        $customer->birthday = $request->birthday;
        $customer->full_name = $request->full_name;
        $customer->password = bcrypt($request->password);
        $customer->reset_password = bcrypt($request->password);
        $customer->address = $request->address;
        $customer->province_id = $request->province_id;
        $customer->district_id = $request->district_id;
        $customer->commune_id = $request->commune_id;
        $customer->status = $request->status;
        $customer->save();
        $response = [
            'status' => Response::HTTP_OK,
            'msg' => 'update customer successed',
            'data' => $customer,
        ];
        return response([$response, 200]);
    }
}
