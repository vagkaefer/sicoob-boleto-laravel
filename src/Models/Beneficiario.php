<?php

namespace VagKaefer\Sicoob\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Beneficiario extends Model
{
  use HasFactory;

  // Disable Laravel's mass assignment protection
  protected $guarded = [];
}
