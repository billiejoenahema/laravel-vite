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
    /**
     * お知らせ一覧を取得する。
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $query = Notice::query();

        // 検索
        $query->search($request);

        $notices = $query->paginate($request->per_page);

        return NoticeResource::collection($notices);
    }

    /**
     * お知らせを新規登録する。
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
     */
    public function show(Notice $notice): NoticeResource
    {
        $notice->load('users');
        $userId = auth()->id();
        // 未読なら既読にする
        $notice->users()->syncWithoutDetaching([$userId]);

        return new NoticeResource($notice);
    }

    /**
     * 指定のお知らせを更新する。
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
     * お知らせをすべて既読にする。
     */
    public function setAllRead(): JsonResponse
    {
        DB::transaction(static function () {
            $user = auth()->user();
            // 既読のお知らせID配列
            $readNoticeIds = $user->notices->pluck('id');
            // 未読のお知らせID配列
            $noticeIds = Notice::whereNotIn('id', $readNoticeIds)->pluck('id');
            // 既読にする
            $user->notices()->attach($noticeIds);
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
