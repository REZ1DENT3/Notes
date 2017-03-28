<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class FontAwesome extends Model
{

    public function notes()
    {
        return $this->hasMany(Note::class);
    }

}
