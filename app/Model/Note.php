<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{

    public function color()
    {
        return $this->belongsTo(Color::class);
    }

    public function font_awesome()
    {
        return $this->belongsTo(FontAwesome::class);
    }

}