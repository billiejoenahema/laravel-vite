<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use function in_array;

/**
 * App\Models\Notice
 *
 * @property int $id
 * @property string $title タイトル
 * @property string $content 内容
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read bool $is_read
 * @property-read array $read_notice_ids
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 * @method static \Database\Factories\NoticeFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Notice newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Notice newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Notice onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Notice query()
 * @method static \Illuminate\Database\Eloquent\Builder|Notice search($request)
 * @method static \Illuminate\Database\Eloquent\Builder|Notice whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notice whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notice whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notice whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notice whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notice withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Notice withoutTrashed()
 * @mixin \Eloquent
 */
class Notice extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * 複数代入可能な属性
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'content',
    ];

    /**
     * モデルの配列フォームに追加するアクセサ
     *
     * @var array
     */
    protected $appends = [
        'is_read',
    ];

    /** @var array ソート対象カラム */
    public const SORTABLE_COLUMNS = [
        'id',
        'title',
        'content',
        'gender',
        'created_at',
        'updated_at',
    ];

    /** @var string デフォルトのソート対象カラム */
    public const DEFAULT_SORT_COLUMN = 'id';

    /**
     * このお知らせに属するユーザー
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'notice_reads', 'notice_id', 'user_id')->withPivot('created_at');
    }

    /**
     * このお知らせが既読かどうかを示すアクセサ
     */
    public function getIsReadAttribute(): bool
    {
        return in_array($this->id, $this->read_notice_ids, true);
    }

    /**
     * 既読のお知らせID配列を取得するアクセサ
     */
    public function getReadNoticeIdsAttribute(): array
    {
        return auth()->user()->notices->pluck('id')->toArray();
    }

    /**
     * 検索条件
     *
     * @param Builder|Notice $query
     * @param Request $request
     */
    public function scopeSearch($query, $request): Builder|self
    {
        // 未読のお知らせ
        if ($request['unread_only'] === 'true') {
            $query->whereNotIn('id', $this->read_notice_ids);
        }

        return $query;
    }
}
