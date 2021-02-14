<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Product extends Model
{
    use HasFactory, SoftDeletes;
    protected $primaryKey = 'id';
    protected $table = 'products';
    protected $casts = ['has_notification' => 'boolean'];
    protected $fillable =
        ['name',
        'slug',
        'quantity',
        'size',
        'color',
        'price',
        'has_notification',
        'category_id',
        'notification_quantity'];

    public function transactions() {
        return $this->hasMany(Transaction::class);
    }
}
