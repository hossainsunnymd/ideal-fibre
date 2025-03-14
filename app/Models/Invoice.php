<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable=['total','customer_id','total_work_order','created_by'];

    public function customer(){
        return $this->belongsTo(Customer::class);
    }

    public function invoiceProducts(){
        return $this->hasMany(InvoiceProduct::class);
    }
}
