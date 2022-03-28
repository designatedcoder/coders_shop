<?php

namespace App\Models\Coupons;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'couponable_id', 'couponable_type'];

    public function couponable() {
        return $this->morphTo();
    }

    public static function findByCode($code) {
        return self::where('code', $code)->first();
    }

    public function discount($order) {
        return $this->couponable()->discount($order);
    }
}
