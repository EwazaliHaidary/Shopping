<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = Customer::query();
        $query->when($request->query('name'),function ($q, $name) {
            $q->where('name', 'like', "%{$name}%");
        });

        $query->when($request->query('phone'), function ($q, $phone) {
            $q->where('phone', 'like', "%{$phone}%");
        });

          // Searching
    $query->when($request->query('search'), function ($q, $search) {
        $q->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%")
              ->orWhere('phone', 'like', "%{$search}%");
            });
        });
        
        $customers = $query->paginate(10);
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
