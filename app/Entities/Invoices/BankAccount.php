<?php

namespace App\Entities\Invoices;

use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    protected $fillable = ['name', 'number', 'account_name', 'description'];
}
