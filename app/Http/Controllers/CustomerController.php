<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerRegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Models\Customer;
use App\Repositories\CustomerRepository;
use App\Services\CustomerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Validators\ValidationException;

class CustomerController extends Controller
{
    public function register(CustomerRegisterRequest $request, CustomerService $service)
    {
        $customer = $service->customerRegister($request);
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
