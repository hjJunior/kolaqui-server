<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Nova\Actions\Actionable;

class UploadedFile extends Model {
  use HasFactory, Notifiable, Actionable;

  protected $fillable = ['filename'];

  public function routeNotificationForDiscord() {
    return  '762450560459735040';
  }
}
