<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UploadedFile extends Model {
  use HasFactory;

  protected $fillable = ['filename'];
}
