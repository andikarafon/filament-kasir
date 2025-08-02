<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    //wajib untuk kolom yang bisa diisi
    protected $fillable = [
        'name',
        'note',
        'date_expense',
        'amount',
    ];
}
