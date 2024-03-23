<?php

namespace App\Traits;

trait HasScope
{
    public function scopeSearch($query, $type)
    {
        return $query->when(request()->search, function($search) use($type){
            $search = $search->where($type, 'like', '%'. request()->search. '%');
        });
    }
}
