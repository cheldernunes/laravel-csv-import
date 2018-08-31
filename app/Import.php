<?php

namespace Csvimport;

use Illuminate\Database\Eloquent\Model;

class Import extends Model
{
    protected $table='imports';

    protected $fillable = ['user_id','filename','status', 'mapping'];
}
