<?php

namespace App\Traits;
use Illuminate\Support\Str;

trait PrintsName
{
    public function getLimitedName30Attribute()
    {
        if (strlen($this->name) <= 30) return $this->name;
        return Str::limit($this->name, 30); 
    }

        public function getLimitedName20Attribute()
    {
        if (strlen($this->name) <= 30) return $this->name;
        return Str::limit($this->name, 30); 
    }
}
