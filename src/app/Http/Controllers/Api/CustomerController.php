<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Customer\IndexRequest;
use App\Http\Requests\Api\Customer\SaveRequest;
use App\Http\Resources\Api\CustomerResource;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class CustomerController extends Controller
{
    private const PER_PAGE = 10;

    /**
     * 顧客一覧を取得する。
     * @param IndexRequest $request
     * @return AnonymousResourceCollection
     */
    public function index(IndexRequest $request): AnonymousResourceCollection
    {
        $query = Customer::query()->with(['user']);

        $direction = $request->getSortDirection();
        $column = $request->getSortColumn();

        // ソート
        $query->sortByColumn($column, $direction);

        $customers = $query->paginate(self::PER_PAGE);

        return CustomerResource::collection($customers);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * 指定の顧客を取得する。
     * @param Customer $customer
     * @return CustomerResource
     */
    public function show(Customer $customer): CustomerResource
    {
        $customer->load(['user']);

        return new CustomerResource($customer);
    }

    /**
     * 指定の顧客を更新する。
     *
     * @param SaveRequest $request
     */
    public function update(SaveRequest $request, Customer $customer)
    {
        $data = $request->all();

        DB::transaction(function () use ($data, $customer) {
            $customer->fill($data)->save();
        });

        return response()->json(Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
