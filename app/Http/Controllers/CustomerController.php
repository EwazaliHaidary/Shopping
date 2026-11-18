<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Http\Resources\CustomerResource;
use App\Models\Customer;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::all();

        return CustomerResource::collection($customers);
    }

    public function store(StoreCustomerRequest $request)
    {
        $data = $request->validated();

        $customer = Customer::create($data);

        return response()->json([
            "message" => "موفقانه یک مشتری اضافه شد",
            "data" => new CustomerResource($customer)
        ], 201);
    }

    public function show(string $id)
    {
        $customer = Customer::findOrFail($id);

        return new CustomerResource($customer);
    }

    public function update(UpdateCustomerRequest $request, string $id)
    {
        $customer = Customer::findOrFail($id);

        $data = $request->validated();

        $customer->update($data);

        return response()->json([
            "message" => "ویرایش موفقانه انجام شد",
            "data" => new CustomerResource($customer)
        ], 200);
    }

    public function destroy(string $id)
    {
        $customer = Customer::findOrFail($id);

        $customer->delete();

        return response()->json([
            "message" => "حذف موفقانه انجام شد"
        ], 200);
    }
}
