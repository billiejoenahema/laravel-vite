<?php

namespace App\Models;

use Attribute;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
 * @mixin \Eloquent
 */
class Customer extends Model
{
    use HasFactory;

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
     * 紐づくユーザーを取得
     *
     * @return BelongsTo
     *
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * メールアドレスの取得
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function email(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->user->email,
        );
    }

    /**
     * 指定のカラムでソートするスコープ
     *
     * @param Builder|Customer $query
     * @param string $column
     * @param string $order
     * @return Builder|Customer
     */
    public function scopeSortByColumn($query, $column, $order): Builder|Customer
    {
        $columns = [
            'id',
            'name',
            'gender',
            'phone',
            'pref',
        ];
        if (in_array($column, $columns, false)) {
            $query->orderByRaw("{$column} is null asc")->orderBy($column, $order);
        }

        return $query;
    }
}
