<?php


namespace App\Models\Traits;


trait Uuid
{


    public  static function boot()
    {
        parent::boot(); // TODO: Change the autogenerated stub

        static::creating(function ($obj){
            $obj->id = \Ramsey\Uuid\Uuid::uuid4();
        });
    }
}
