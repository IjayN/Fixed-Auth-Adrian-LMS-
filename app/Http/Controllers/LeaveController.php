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
}
