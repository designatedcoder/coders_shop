<?php

namespace App\Models\Coupons;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FixedValueCoupon extends Model
{
    use HasFactory;

    protected $fillable = ['value'];

    public function discount($order) {
        return $this->value;
    }
}
