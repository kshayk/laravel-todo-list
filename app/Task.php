<?php
/**
 * Created by PhpStorm.
 * User: shay
 * Date: 10/27/18
 * Time: 11:25 AM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $table = 'tasks';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'status'
    ];

}
