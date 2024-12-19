<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
  use HasFactory;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'user_id',
      'description',
      'type',
      'province',
      'regency',
      'subdistrict',
      'village',
      'voting',
      'viewers',
      'image',
      'statement',
  ];

  /**
   * The attributes that should be cast to native types.
   *
   * @var array
   */
  protected $casts = [
      'voting' => 'array',
      'viewers' => 'integer',
      'statement' => 'boolean',
  ];

  /**
   * Define the relationship with the User model.
   */
  public function User()
  {
      return $this->belongsTo(User::class);
  }

  public function Response()
  {
      return $this->hasOne(Response::class);
  }

  public function Comment()
    {
        return $this->hasMany(Comment::class, 'report_id', 'id');
    }
}
