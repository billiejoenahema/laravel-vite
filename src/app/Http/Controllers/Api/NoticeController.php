<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\NoticeResource;
use App\Models\Notice;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class NoticeController extends Controller
{
    private const PER_PAGE = 20;

    /**
     * お知らせ一覧を取得する。
     */
    public function index(): AnonymousResourceCollection
    {
        $query = Notice::query();

        $notices = $query->paginate(self::PER_PAGE);

        return NoticeResource::collection($notices);
    }

    /**
     * お知らせを新規登録する。
     * @param Request $request
     */
    public function store(Request $request): NoticeResource
    {
        $data = $request->all();

        $notice = DB::transaction(static function () use ($data) {
            return Notice::create($data);
        });

        return new NoticeResource($notice);
    }

    /**
     * 指定のお知らせを取得する。
     * @param Notice $notice
     */
    public function show(Notice $notice): NoticeResource
    {
        return new NoticeResource($notice);
    }

    /**
     * 指定のお知らせを更新する。
     * @param Request $request
     * @param Notice $notice
     */
    public function update(Request $request, Notice $notice): JsonResponse
    {
        $data = $request->all();

        DB::transaction(static function () use ($data, $notice) {
            $notice->fill($data)->save();
        });

        return response()->json('success', Response::HTTP_OK);
    }

    /**
     * 指定のお知らせを削除する。
     */
    public function destroy(Notice $notice): JsonResponse
    {
        $notice->delete();

        return response()->json('success', Response::HTTP_OK);
    }
}
