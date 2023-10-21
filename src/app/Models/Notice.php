<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

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
        return $this->belongsToMany(User::class)->withPivot('read_at', );
    }
}
