<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LeaveApplication extends Model
{
  use SoftDeletes;

  protected $dates = ['deleted_at'];
  protected $table = 'leave_application';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'type', 'startDate', 'endDate', 'reliever','leave_days','HOD','HR','MD'
  ];
}
