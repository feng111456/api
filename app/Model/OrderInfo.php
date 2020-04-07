<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class OrderInfo extends Model
{
    protected $table    = 'order_info';
    protected $primaryKey = 'info_id';
    public $timestamps = false;
    //protected $fillable = ['name'];//允许被批量赋值
    protected $guarded = [];//不允许被批量赋值
}
