<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceProduct extends Model
{
    protected $fillable=['invoice_id','product_id','qty','order_price','rate','complete_work_order','incomplete_work_order'];

    public function product(){
        return $this->belongsTo(Product::class);
    }
    public function invoice(){
        return $this->belongsTo(Invoice::class);
    }

    public function completeWorkOrder(){
        return $this->hasOne(CompleteWorkOrder::class);
    }
}
