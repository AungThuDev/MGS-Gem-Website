<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['name','type','buy_date','sell_date','length','width','height','weight','origin','description','image'];

    public function images()
    {
        return $this->hasMany(Image::class);
    }
}
