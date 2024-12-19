<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Response extends Model
{
  use HasFactory;

  /**
   * The table associated with the model.
   *
   * @var string
   */
  protected $table = 'responses';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'report_id',
      'staff_id',
      'response_status',
  ];

  /**
   * The attributes that should be cast.
   *
   * @var array
   */
  protected $casts = [
      'response_status' => 'string',
  ];

  /**
   * Get the report associated with the response.
   */
  public function Report()
  {
      return $this->belongsTo(Report::class, 'report_id', 'id');
  }

  public function Progres()
  {
      return $this->hasMany(Response_progress::class);
  }

  public function Staff()
  {
      return $this->belongsTo(User::class, 'staff_id', 'id');
  }
}
