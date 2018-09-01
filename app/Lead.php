<?php

namespace Csvimport;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    public $fillable = ['name','email','document','employee','occupation','phone','city','state','country','status',
    'stage','deal_title', 'deal_value','conversion_count','last_conversion','domain','url'];

}
