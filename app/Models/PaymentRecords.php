<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentRecords extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_email',
        'Payment_platform',
        'reference',
        'amount',
        'fees',
    ];
}
