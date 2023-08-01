<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Customer\IndexRequest;
use App\Http\Requests\Api\Customer\SaveAvatarRequest;
use App\Http\Requests\Api\Customer\SaveRequest;
use App\Http\Resources\Api\CustomerResource;
use App\Models\Customer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
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

        // 検索
        $query->searchCondition($request);

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
     * @param Customer $customer
     */
    public function update(SaveRequest $request, Customer $customer): JsonResponse
    {
        $data = $request->all();

        // アイコンは更新しない
        unset($data['avatar']);

        DB::transaction(function () use ($data, $customer) {
            $customer->fill($data)->save();
        });

        return response()->json(['message' => '更新しました'], Response::HTTP_OK);
    }

    /**
     * 指定顧客のアイコンを更新する。
     *
     * @param SaveAvatarRequest $request
     * @param Customer $customer
     */
    public function updateAvatar(SaveAvatarRequest $request, Customer $customer): JsonResponse
    {
        $avatar = $request->file('avatar');
        // 既存のアイコン画像を削除する
        if ($customer->avatar && $customer->avatar !== Customer::DEFAULT_AVATAR) {
            Storage::disk('s3')->delete($customer->avatar);
        }
        // 画像をS3のlaravel-viteバケットに保存する
        $path = Storage::disk('s3')->putFile('/', $avatar);

        DB::transaction(function () use ($customer, $path) {
            $customer->avatar = $path;
            $customer->save();
        });

        return response()->json(['message' => '更新しました'], Response::HTTP_OK);
    }

    /**
     * 指定顧客のアイコンを削除する。
     *
     * @param Customer $customer
     */
    public function deleteAvatar(Customer $customer): JsonResponse
    {
        // 既存のアイコン画像を削除する
        if ($customer->avatar && $customer->avatar !== Customer::DEFAULT_AVATAR) {
            Storage::disk('s3')->delete($customer->avatar);
        }

        DB::transaction(function () use ($customer) {
            $customer->avatar = null;
            $customer->save();
        });

        return response()->json(['message' => '削除しました'], Response::HTTP_OK);
    }

    /**
     * 指定顧客を削除する。
     */
    public function destroy(Customer $customer): JsonResponse
    {
        $customer->delete();

        return response()->json(['message' => '削除しました'], Response::HTTP_OK);
    }
}
