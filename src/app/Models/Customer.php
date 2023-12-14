<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\Gender;
use App\Enums\Prefecture;
use App\Http\Requests\Api\Customer\IndexRequest;
use Carbon\Carbon;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use function in_array;

/**
 * App\Models\Customer
 *
 * @property string $id ULID
 * @property int|null $user_id ユーザーID
 * @property string|null $name 氏名
 * @property string|null $name_kana ふりがな
 * @property string|null $phone 電話番号
 * @property string|null $gender 性別
 * @property string|null $birth_date 生年月日
 * @property string|null $postal_code 郵便番号
 * @property int|null $pref 都道府県
 * @property string|null $city 市区町村
 * @property string|null $street 番地
 * @property string|null $avatar アイコン画像URL
 * @property string|null $note 備考
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $user
 * @method static \Database\Factories\CustomerFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Customer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Customer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Customer onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Customer query()
 * @method static \Illuminate\Database\Eloquent\Builder|Customer search($request)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer sort($request)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereBirthDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereNameKana($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer wherePostalCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer wherePref($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereStreet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Customer withoutTrashed()
 * @mixin \Eloquent
 */
class Customer extends Model
{
    use HasFactory;

    // HasUlids という trait を使うと、主キーを ULID としてよしなに扱ってくれます。
    // ULIDの自動生成やオートインクリメント関連の誤爆防止などをしてくれます。
    use \Illuminate\Database\Eloquent\Concerns\HasUlids;
    use SoftDeletes;

    /** デフォルトアイコン */
    public const DEFAULT_AVATAR = 'default-avatar.png';

    /**
     * 複数代入可能な属性
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'name_kana',
        'phone',
        'gender',
        'birth_date',
        'postal_code',
        'pref',
        'city',
        'street',
        'avatar',
        'note',
    ];

    /**
     * モデルの配列フォームに追加するアクセサ
     *
     * @var array
     */
    protected $appends = [
        'address',
        'age',
        'gender_value',
        'pref_value',
    ];

    /** @var array ソート対象カラム */
    public const SORTABLE_COLUMNS = [
        'id',
        'name',
        'age',
        'gender',
        'phone',
        'birth_date',
        'pref',
        'created_at',
        'updated_at',
    ];

    /** @var string デフォルトのソート対象カラム */
    public const DEFAULT_SORT_COLUMN = 'id';

    /**
     * 所有するユーザー
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 所有するユーザーのメールアドレスを取得
     */
    protected function email(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->user->email,
        );
    }

    /**
     * 性別を取得
     */
    protected function genderValue(): Attribute
    {
        return Attribute::make(
            get: fn () => Gender::tryFrom($this->gender)?->text(),
        );
    }

    /**
     * 都道府県名を取得
     */
    protected function prefValue(): Attribute
    {
        return Attribute::make(
            get: fn () => Prefecture::tryFrom((int) $this->pref)?->text(),
        );
    }

    /**
     * 住所を取得
     */
    protected function address(): Attribute
    {
        $postalCode = $this->postal_code ? '〒' . mb_substr($this->postal_code, 0, 3) . '-' . mb_substr($this->postal_code, 3) . ' ' : '';

        return Attribute::make(
            get: fn () => $postalCode . Prefecture::tryFrom((int) $this->pref)?->text() . $this->city . $this->street,
        );
    }

    /**
     * 生年月日から現在の年齢を取得
     */
    protected function age(): Attribute
    {
        return Attribute::make(
            get: fn () => now()->diffInYears($this->birth_date),
        );
    }

    /**
     * 登録日を操作
     */
    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => Carbon::parse($value)->format('Y/m/d H:i:s'),
        );
    }

    /**
     * 更新日を操作
     */
    protected function updatedAt(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => Carbon::parse($value)->format('Y/m/d H:i:s'),
        );
    }

    /**
     * 検索条件
     *
     * @param Builder|Customer $query
     * @param IndexRequest $request
     */
    public function scopeSearch($query, $request): Builder|self
    {
        if ($request['search_value.is_deleted']) {
            $query->onlyTrashed();
        }
        if ($request['search_value.name']) {
            $query->where('name', 'like', "%{$request['search_value.name']}%");
        }
        if ($request['search_value.name_kana']) {
            $query->where('name_kana', 'like', "%{$request['search_value.name_kana']}%");
        }
        if ($request['search_value.gender']) {
            $query->where('gender', 'like', "%{$request['search_value.gender']}%");
        }
        if ($request['search_value.phone']) {
            $query->where('phone', 'like', "%{$request['search_value.phone']}%");
        }
        if ($request['search_value.postal_code']) {
            $query->where('postal_code', 'like', "%{$request['search_value.postal_code']}%");
        }
        if ($request['search_value.pref']) {
            $query->where('pref', 'like', $request['search_value.pref']);
        }
        if ($request['search_value.age_from']) {
            $date = $request->getBirthDateValueByAgeFrom();
            $query->whereDate('birth_date', '<=', $date);
        }
        if ($request['search_value.age_to']) {
            $date = $request->getBirthDateValueByAgeTo();
            $query->whereDate('birth_date', '>=', $date);
        }

        return $query;
    }

    /**
     * 指定のカラムでソートするスコープ
     *
     * @param Builder|Customer $query
     * @param IndexRequest $request
     */
    public function scopeSort($query, $request): Builder|self
    {
        $column = $request->getSortColumn();
        $order = $request->getSortDirection();

        if ($column === 'age') {
            // 生年月日でソートするためソート方向を反転させる
            $order = $order === 'asc' ? 'desc' : 'asc';
            $query->orderByRaw('birth_date is null asc')->orderBy('birth_date', $order);

            return $query;
        }
        if (in_array($column, self::SORTABLE_COLUMNS, false)) {
            $query->orderBy($column, $order);
        } else {
            $query->orderBy(self::DEFAULT_SORT_COLUMN, 'asc');
        }

        return $query;
    }
}
