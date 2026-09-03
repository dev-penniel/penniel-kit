<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contacts extends Model
{
  protected $fillable = [
    'names',
    'email',
    'phone',
    'company',
    'job_title',
    'notes'
  ];
}
