<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LeaveApplication extends Model
{
  use Notifiable, SoftDeletes;

  protected $dates = ['deleted_at'];

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'type', 'startDate', 'endDate', 'reliever','HOD','HR','MD'
  ];
}
