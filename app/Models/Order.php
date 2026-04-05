<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model {
    
    use SoftDeletes;

    protected $table = 'orders';

    protected $fillable = [
        'uuid',
        'user_id',
        'payment_status',
        'payment_url',
        'payment_token',
        'payment_value',
        'payment_date'
    ];
}
