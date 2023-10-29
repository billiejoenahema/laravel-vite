<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
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
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\NoticeRead> $reads
 * @property-read int|null $reads_count
 * @method static \Database\Factories\NoticeFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Notice newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Notice newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Notice onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Notice query()
 * @method static \Illuminate\Database\Eloquent\Builder|Notice whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notice whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notice whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notice whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notice whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notice withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Notice withoutTrashed()
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|Notice searchCondition($request)
 * @mixin \Eloquent
 */
class Notice extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $table = 'notices';

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

    /** @var array ソート可能なカラムリスト */
    public const SORTABLE_COLUMNS = [
        'id',
        'title',
        'content',
        'gender',
        'created_at',
        'updated_at',
    ];

    /**
     * このお知らせに属するユーザー
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'notice_reads', 'notice_id', 'user_id')->withPivot('created_at');
    }

    /**
     * このお知らせが既読かどうか
     */
    protected function isRead(): Attribute
    {
        $user = auth()->user();
        $readNoticeIds = $user->notices->pluck('id')->toArray();

        return Attribute::make(
            get: fn () => in_array($this->id, $readNoticeIds, true),
        );
    }

    /**
     * 検索条件
     *
     * @param Builder|Notice $query
     * @param Request $request
     * @return Builder|Notice
     */
    public function scopeSearchCondition($query, $request): Builder|self
    {
        // 未読のお知らせ
        if ($request['unread_only'] === 'true') {
            $user = auth()->user();
            // 既読のお知らせID
            $readNoticeIds = $user->notices->pluck('id')->toArray();

            $query->whereNotIn('id', $readNoticeIds);
        }

        return $query;
    }
}
