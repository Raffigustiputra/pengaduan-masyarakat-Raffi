<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff_provinces extends Model
{
  use HasFactory;

  protected $fillable = [
      'user_id',
      'province',
  ];

  /**
   * Get the user that owns the model.
   */
  public function User()
  {
      return $this->belongsTo(User::class);
  }
}
