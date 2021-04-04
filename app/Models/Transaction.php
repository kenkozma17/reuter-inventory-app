<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $fillable = ['customer_name', 'quantity', 'previous_quantity', 'transaction_number', 'comments', 'type', 'product_id'];
    protected $appends = array('date', 'new_quantity');

    public function getDateAttribute() {
        $date = Carbon::parse($this->created_at);
        return $date->toDayDateTimeString();
    }

    public function getNewQuantityAttribute() {
        if($this->type === 'increase') {
            return $this->previous_quantity + $this->quantity;
        }
        return $this->previous_quantity - $this->quantity;
    }

    public function product() {
        return $this->belongsTo(Product::class);
    }
}
