<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\NoticeRead
 *
 * @property int $id
 * @property int $user_id ユーザーID
 * @property int $notice_id おしらせID
 * @property string|null $read_at 既読日時
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|NoticeRead newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NoticeRead newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NoticeRead onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|NoticeRead query()
 * @method static \Illuminate\Database\Eloquent\Builder|NoticeRead whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NoticeRead whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NoticeRead whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NoticeRead whereNoticeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NoticeRead whereReadAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NoticeRead whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NoticeRead whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NoticeRead withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|NoticeRead withoutTrashed()
 * @mixin \Eloquent
 */
class NoticeRead extends Model
{
    use HasFactory;
    use SoftDeletes;
}
