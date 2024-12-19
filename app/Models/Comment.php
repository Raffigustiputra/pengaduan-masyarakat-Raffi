<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
  use HasFactory;

  /**
   * The table associated with the model.
   *
   * @var string
   */
  protected $table = 'comments';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'report_id',
      'user_id',
      'comment',
  ];

  /**
   * Get the report associated with the comment.
   */
  public function User()
  {
      return $this->belongsTo(User::class, 'user_id', 'id');
  }
}
