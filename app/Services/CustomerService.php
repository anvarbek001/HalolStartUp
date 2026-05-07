<?php

namespace App\Services;

use App\Repositories\CustomerRepository;
use Exception;
use Illuminate\Support\Facades\Hash;

class CustomerService
{
    public function __construct(protected CustomerRepository $customRepo) {}
    public function customerRegister($request)
    {
        $email = $this->customRepo->findCustomer($request->email);
        if ($email) {
            throw new Exception("Bunday email oldin ro'yxatdan o'tgan");
        }

        return $this->customRepo->customerCreate([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);
    }
}
