<?php

namespace App\Http\Controllers;

use App\Models\Customer;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::query()
            ->orderBy('id')
            ->get();

        return view('customers.list', compact('customers'));
    }
}
