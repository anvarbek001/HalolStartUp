<?php

namespace App\Repositories;

use App\Models\Customer;

class CustomerRepository
{
    public function findCustomer($email)
    {
        return Customer::where('email', $email)->first();
    }

    public function customerCreate(array $data)
    {
        return  Customer::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'password' => $data['password'],
        ]);
    }
}
