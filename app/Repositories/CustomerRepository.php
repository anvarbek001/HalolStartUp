<?php

namespace App\Repositories;

use App\Models\Customer;

class CustomerRepository
{
    public function findCustomer($email)
    {
        return Customer::where('email', $email)->first();
    }
}
