<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductLike extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_id', // ID produk yang dilike
        'user_id',    // ID pengguna yang melakukan like (jika ada)
    ];
    public function product()
{
    return $this->belongsTo(Product::class);
}
public function user()
{
    return $this->belongsTo(User::class);
}
public static $rules = [
    'product_id' => 'required|exists:products,id',
    'user_id' => 'required|exists:users,id',
];

    
}
