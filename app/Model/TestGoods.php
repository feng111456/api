<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TestGoods extends Model
{
    protected $table    = 'goods';
    protected $primaryKey = 'goods_id';
    public $timestamps = false;
    //protected $fillable = ['name'];//允许被批量赋值
    protected $guarded = [];//不允许被批量赋值
}
