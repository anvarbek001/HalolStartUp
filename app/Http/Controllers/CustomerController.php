<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Validators\ValidationException;

class CustomerController extends Controller
{
    public function register(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:customers,email',
            'phone' => 'nullable|max:20',
            'password' => 'required|min:6|confirmed'
        ]);

        if ($validate->fails()) {
            return response()->json([
                'success' => false,
                'message' => "Ma'lumotlar kiritishda xatolik.",
                'errors' => $validate->getMessageBag()
            ], 422);
        }

        $email = Customer::where('email', $request->email)->first();
        if ($email) {
            return response()->json([
                'success' => false,
                'message' => "Bunday email oldin ro'yxatdan o'tgan.",
            ], 422);
        }

        $customer = Customer::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);

        $token = $customer->createToken('mobile-app')->plainTextToken;
        return response()->json([
            'success' => true,
            'message' => "Ro'yxatdan muvaffaqiyatli o'tdingiz",
            'token' => $token,
            'customer' => $customer,

        ], 201);
    }

    public function login(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6'
        ]);

        if ($validate->fails()) {
            return response()->json([
                'success' => false,
                'message' => "Ma'lumotlar xatolik.Login yoki parol xato.",
                'error' => $validate->errors()
            ], 422);
        }

        $customer = Customer::where('email', $request->email)->first();
        if (!$customer || !Hash::check($request->password, $customer->password)) {
            throw ValidationException::withMessages([
                response()->json([
                    'success' => false,
                    'message'  => 'Login yoki parol xato',
                ]),
            ]);
            return;
        }

        $customer->tokens()->delete();
        $token = $customer->createToken('mobile-app')->plainTextToken;

        return response()->json([
            'success' => true,
            'message'  => 'Muvaffaqiyatli kirdingiz',
            'token'    => $token,
            'customer' => $customer,
        ]);
    }

    public function profile(Request $request)
    {
        return response()->json([
            'customer' => $request->user(),
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Muvaffaqiyatli chiqdingiz',
        ]);
    }
}
