<?php

namespace VagKaefer\Sicoob\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use VagKaefer\Sicoob\Traits\UsesUuid;

class SicoobBoleto extends Model
{
  use HasFactory;
  use UsesUuid; //Comment if you doesn't uses uuid

  // Disable Laravel's mass assignment protection
  protected $guarded = [];
}
