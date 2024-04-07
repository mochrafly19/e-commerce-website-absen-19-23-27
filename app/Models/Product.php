<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'type',
        'thumbnail',
        'gambar',
        'link',
        'price',
    ];

    public function likes()
    {
        return $this->hasMany(ProductLike::class);
    }
    
    public function comments()
    {
        return $this->hasMany(ProductComment::class); // Ubah ProductComment sesuai dengan nama model komentar yang Anda buat
    }
    
    public function user()
    {
        return $this->belongsTo(User::class); // Anda mungkin memiliki relasi untuk menautkan produk ke pengguna yang membuatnya
    }
    
}
