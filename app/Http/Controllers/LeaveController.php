<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\LeaveApplication;
use App\Holidays;
use DB;
use Mail;

class LeaveController extends Controller
{
    public function applyLeave($id, Request $request){

      $nr_work_days = $this->calculate_days($id, $request->startDate, $request->endDate);

      $leave = new LeaveApplication([
          'type'        => $request->type,
          'startDate'   => $request->startDate,
          'endDate'     => $request->endDate,
          'reliever'    => $request->reliever,
          'leave_days'  => ". $this->calculate_days($id, $request->startDate, $request->endDate) ."

      ]);

      $leave->save();
      // $nr_work_days;
      return $this->prepareResult(1, $leave, [],"Success");
    }

    public function leaveHistory($id){
      $history = LeaveApplication::where('id', $id)->get();
      return $history;
    }

    public function employees_departments($id, Request $request){
      $department = User::where('id', $id)->value('department');
      $employees = User::where('department', $department)->where('active',1)->get();

      return $this->prepareResult(1, $employees, [],"Success");
    }

    public function employees(){
      $employees = User::where('active',1)->get();

      return $this->prepareResult(1, $employees, [],"Success");
    }

    private function prepareResult($status, $data, $errors,$msg)
    {
        if ($errors == null) {
            return ['status' => $status,'payload'=> $data,'message' => $msg];
        } else {
            return ['status' => $status, 'message' => $msg,'errors' => $errors];
        }
    }

    // calculate days
    public function calculate_days($id, $start, $end){

      $beginday=date($start);
      $lastday=date($end);

      $nr_work_days = $this->getWorkingDays($beginday,$lastday);
      return $nr_work_days;
    }

    public function getWorkingDays($startDate, $endDate){
      $begin=strtotime($startDate);
      $end=strtotime($endDate);
      // print_r($startDate);
      if($begin>$end){
        echo "startdate is in the future! <br />";
        return 0;
      }else{
        $no_days=0;
        $weekends=0;
        while($begin<=$end){
          $no_days++; // no of days in the given interval
          $what_day=date("N",$begin);
          if($what_day>5) { // 6 and 7 are weekend days
                $weekends++;
          };
          $begin+=86400; // +1 day
        };

        $working_days=$no_days-$weekends;

        echo $working_days;

        // $holiday_dates = DB::table('holidays')
        //                 ->select('holiday_date')
        //                 ->get();
        // foreach ($holiday_dates as $value) {
        //   $holidays = array();
        //   $y = date("Y");
        //   $values = "2019/".$value->holiday_date;
        //   // $values = $y."/".$value->holiday_date;
        //   $r = array_push($holidays, $values);
        //   // print_r($value);
        //   //Subtract the holidays
        //   foreach($holidays as $holiday){
        //     // print_r($holiday);
        //     $time_stamp=strtotime($holiday);
        //     // print_r($time_stamp);
        //     //If the holiday doesn't fall in weekend
        //     if ($startDate <= $time_stamp && $time_stamp <= $endDate && date("N",$time_stamp) != 6 && date("N",$time_stamp) != 7)
        //         $working_days--;
        //         // print_r ($working_days);
        //                 return $working_days;
        //   }
        // }

      }
  }
  public function mail()
  {
     $name = 'Krunal';
     Mail::to('mageto.denis@gmail.com')->send(new SendMailable($name));

     return 'Email was sent';
  }
}
