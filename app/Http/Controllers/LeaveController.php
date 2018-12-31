<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
// use App\Leave;

class LeaveController extends Controller
{
    public function applyLeave(Request $request){

      $leave = new Leave([
          'type'      => $request->typeOfLeave,
          'startDate' => $request->startDate,
          'endDate'   => $request->endDate,
          'reliever'  => $request->reliever
      ]);

      $leave->save();

    }

    public function leaveHistory($id){
      $history = Leave::where('id', $id)->get();
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
    public function calculate_days($id, Request $request){
      $start = $request->startDate;
      $end = $request->endDate;
      $reliever = $request->reliever;

      $beginday=date('2019/01/02');
      $lastday=date('2019/01/22');

      $nr_work_days = $this->getWorkingDays($beginday,$lastday);
      echo $nr_work_days;
    }

    public function getWorkingDays($startDate, $endDate){
      $begin=strtotime($startDate);
      $end=strtotime($endDate);

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
        return $working_days;
      }
  }

}
