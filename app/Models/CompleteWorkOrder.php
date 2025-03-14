<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompleteWorkOrder extends Model
{
    protected $fillable = [

        'work_order',
        'delivered_work_order',
        'pending_work_order',
        'delivered_by',
        'invoice_id',
        'product_id'
    ];
    public function invoice(){
        return $this->belongsTo(Invoice::class);
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }
}
