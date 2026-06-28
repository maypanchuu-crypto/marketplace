<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'vendor_status',
        'shop_name',
        'shop_description',
        'shop_phone',
        'payment_slip',
        'last_login_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'payment_slip',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'role' => 'string',
        'vendor_status' => 'string',
        'shop_name' => 'string',
        'shop_description' => 'string',
        'shop_phone' => 'string',
        'payment_slip' => 'string',
        'last_login_at' => 'timestamp',
    ];

    public function wallet()
{
    return $this->hasOne(Wallet::class);
}

public function buyerTransactions()
{
    return $this->hasMany(QrTransaction::class, 'buyer_id');
}

public function vendorTransactions()
{
    return $this->hasMany(QrTransaction::class, 'vendor_id');
}
}
