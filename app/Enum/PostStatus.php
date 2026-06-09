<?php

namespace App\Enum;

enum PostStatus:string
{
    case Published = 'published';
    case Draft = 'draft';
    case Archived = 'archived';
  



    public  function  getLabel(): string  {
        return match($this){
            self::Draft => 'Draft',
            self::Published =>'Published',
self::Archived => 'Archived'
        };
    }


    public function   getColor(): string{
  
return match($this) {
    self::Draft =>'gray',
    self::Published => 'green',
    self::Archived =>'red',
};

    }
}
