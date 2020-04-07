<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class GoodsInfo extends Model
{
    protected $table    = 'goods_info';
    protected $primaryKey = 'id';
    public $timestamps = false;
    //protected $fillable = ['name'];//允许被批量赋值
    protected $guarded = [];//不允许被批量赋值
}
