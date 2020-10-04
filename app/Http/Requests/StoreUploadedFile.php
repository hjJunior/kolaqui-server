<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUploadedFile extends FormRequest {
  public function authorize() {
    return true;
  }

  public function rules() {
    return [
      'file' => 'required|file|mimes:html,htm'
    ];
  }
}
