<?php

namespace App\Models;

use App\Enums\Gender;
use App\Enums\Prefecture;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Customer
 *
 * @property int $id
 * @property int|null $user_id ユーザーID
 * @property string|null $name 氏名
 * @property string|null $name_kana ふりがな
 * @property string|null $phone 電話番号
 * @property string|null $gender 性別
 * @property string|null $birth_date 生年月日
 * @property string|null $postal_code 郵便番号
 * @property string|null $pref 都道府県
 * @property string|null $city 市区町村
 * @property string|null $street 番地
 * @property string|null $avatar アイコン画像URL
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Customer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Customer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Customer query()
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereBirthDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereNameKana($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer wherePostalCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer wherePref($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereStreet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereUserId($value)
 * @property-read \App\Models\User|null $user
 * @method static \Database\Factories\CustomerFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Customer sortByColumn($column, $order)
 * @property string $id ULID
 * @method static \Illuminate\Database\Eloquent\Builder|Customer onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereUlid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Customer withoutTrashed()
 * @mixin \Eloquent
 */
class Customer extends Model
{
    use HasFactory;
    use SoftDeletes;

    // HasUlids という trait を使うと、主キーを ULID としてよしなに扱ってくれます。
    // ULIDの自動生成やオートインクリメント関連の誤爆防止などをしてくれます。
    use \Illuminate\Database\Eloquent\Concerns\HasUlids;

    public $table = 'customers';
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
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

    /**
     * 所有するユーザー
     *
     * @return BelongsTo
     *
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
     * 郵便番号を操作
     */
    protected function postalCodeWithHyphen(): Attribute
    {
        return Attribute::make(
            get: fn () => substr($this->postal_code, 0, 3) . "-" . substr($this->postal_code, 3),
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
            get: fn () => Prefecture::tryFrom($this->pref)?->text(),
        );
    }

    /**
     * 住所を取得
     */
    protected function address(): Attribute
    {
        return Attribute::make(
            get: fn () => '〒' . $this->postal_code_with_hyphen . ' ' .  Prefecture::tryFrom($this->pref)?->text() . $this->city . $this->street,
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
     * 指定のカラムでソートするスコープ
     *
     * @param Builder|Customer $query
     * @param string $column
     * @param string $order
     */
    public function scopeSortByColumn($query, $column, $order): Builder|Customer
    {
        $columns = [
            'id',
            'name',
            'gender',
            'phone',
            'birth_date',
            'pref',
        ];
        if (in_array($column, $columns, false)) {
            $query->orderByRaw("{$column} is null asc")->orderBy($column, $order);
        }

        return $query;
    }
}
