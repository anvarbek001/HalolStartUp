<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerRegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Models\Customer;
use App\Repositories\CustomerRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Validators\ValidationException;

class CustomerController extends Controller
{
    public function register(CustomerRegisterRequest $request, CustomerRepository $customRepo)
    {
        $email = $customRepo->findCustomer($request->email);
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

    public function login(LoginRequest $request, CustomerRepository $customRepo)
    {
        $customer = $customRepo->findCustomer($request->email);
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
