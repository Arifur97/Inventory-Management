<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employee;
use App\HrmSetting;
use App\Attendance;
use App\StatusAttendance;
use Auth;
use DB;
use App\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Carbon;

class AttendanceController extends Controller
{
    public function index(Request $request){
        $role = Role::find(Auth::user()->role_id);
        if($role->hasPermissionTo('attendance')) {
            $lims_employee_list = Employee::where('is_active', true)->get();
            $lims_hrm_setting_data = HrmSetting::latest()->first();
            $general_setting = DB::table('general_settings')->latest()->first();

            if($request->input('starting_date')) {
                $starting_date = $request->input('starting_date');
                $ending_date = $request->input('ending_date');
            } else {
                $starting_date = date("Y-m-d", strtotime(date('Y-m-d', strtotime('-1 year', strtotime(date('Y-m-d') )))));
                $ending_date = date("Y-m-d");
            }
            $permissions = Role::findByName($role->name)->permissions;
            foreach ($permissions as $permission) $all_permission[] = $permission->name;
            if(empty($all_permission)) $all_permission[] = 'dummy text';


            if($request->input('employee_id')) $employee_id = $request->input('employee_id');
            else $employee_id = null;

            if($request->input('user_id')) $user_id = $request->input('user_id');
            else $user_id = null;

            if($request->input('status')) $status = $request->input('status');
            else $status = null;

            if(Auth::user()->role_id > 2 && $general_setting->staff_access == 'own'){
                $lims_attendance_all = Attendance::with('employee', 'user')
                    ->join('status_attendance', 'status_attendance.id', '=', 'attendances.status')
                    ->whereDate('created_at', '>=', $starting_date)
                    ->whereDate('created_at', '<=', $ending_date)
                    ->where('user_id', Auth::id())
                    ->when($status != null, function ($q) use ($status) {
                        return $q->where('status', $status);
                    })
                    ->orderBy('id', 'desc')
                    ->get(['attendances.*', 'status_attendance.name as status']);
            }else{
                $lims_attendance_all = Attendance::with('employee', 'user')
                    ->join('status_attendance', 'status_attendance.id', '=', 'attendances.status')
                    ->whereDate('created_at', '>=', $starting_date)
                    ->whereDate('created_at', '<=', $ending_date)
                    ->when($user_id != null, function ($q) use ($user_id) {
                        return $q->where('user_id', $user_id);
                    })
                    ->when($employee_id != null, function ($q) use ($employee_id) {
                        return $q->where('employee_id', $employee_id);
                    })
                    ->when($status != null, function ($q) use ($status) {
                        return $q->where('status', $status);
                    })
                    ->orderBy('attendances.id', 'desc')
                    ->get(['attendances.*', 'status_attendance.name as status']);
            }

            $lims_employee_list = Employee::where('is_active', true)->get();
            $lims_user_list     = User::where('is_active', true)->get();
            $lims_status_attendence_list = StatusAttendance::all();

            return view('attendance.index', compact('lims_employee_list', 'lims_hrm_setting_data', 'lims_attendance_all', 'employee_id', 'lims_employee_list','status', 'lims_user_list', 'user_id', 'lims_status_attendence_list', 'starting_date', 'ending_date', 'all_permission'));
        }
        else return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }



    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $employee_id =  $data['employee_id'];
        $lims_hrm_setting_data = HrmSetting::latest()->first();
        $checkin = $lims_hrm_setting_data->checkin;
        foreach ($employee_id as $id) {
            $data['date'] = date('Y-m-d', strtotime(str_replace('/', '-', $data['date'])));
            $data['user_id'] = Auth::id();
            $lims_attendance_data = Attendance::whereDate('date', $data['date'])->where('employee_id', $id)->first();
            if(!$lims_attendance_data){
                $data['employee_id'] = $id;
                $diff = strtotime($checkin) - strtotime($data['checkin']);
                if($diff >= 0)
                    $data['status'] = 1;
                else
                    $data['status'] = 2;
                Attendance::create($data);
            }
        }
        return redirect()->back()->with('message', 'Attendance created successfully');
        //return date('h:i:s a', strtotime($data['from_time']));
    }



    public function setCheckin() {
        $lastAttendance = Attendance::where('user_id', '=', auth()->user()->id)->latest()->first();
        if($lastAttendance->status == 2) {
            $attendance = new Attendance();
            $attendance->date           = Carbon::now()->toDateString();
            $attendance->date_checkout  = NULL;
            $attendance->employee_id    = auth()->user()->id;
            $attendance->user_id        = auth()->user()->id;
            $attendance->checkin        = Carbon::now()->format('h:ia');
            $attendance->checkout       = '';
            $attendance->time           = '';
            $attendance->status         = 1;
            $attendance->save();

            return redirect()->back()->with('message', 'Clock-In Successfully, ' . Carbon::now()->toDateString() . ', ' . Carbon::now()->format('h:ia'));
        }
        return redirect()->back()->with('message', 'Sorry, You already Clock-In.');
    }

    public function setCheckout(Request $request){
        $lastAttendance = Attendance::where('user_id', '=', auth()->user()->id)->latest()->first();
        if($lastAttendance->status == 1) {
            $lastAttendance->status = 2;
            $lastAttendance->date_checkout = Carbon::now()->toDateString();
            $lastAttendance->checkout = Carbon::now()->format('h:ia');
            $checkinTimestamp = date('Y-m-d H:i:s', strtotime("$lastAttendance->date $lastAttendance->checkin"));
            $lastAttendanceCheckout = Carbon::parse($checkinTimestamp)->diffInMinutes(Carbon::now()->format('Y-m-d H:i:s'));
            $lastAttendance->time = number_format(($lastAttendanceCheckout / 60), 2);
            $lastAttendance->note = $request->note;

            $lastAttendance->update();

            return redirect()->back()->with('clock_out', 'Clcok-Out Successfully, ' . Carbon::now()->toDateString() . ', ' . Carbon::now()->format('h:ia'));
        }
        return redirect()->back()->with('clock_out', 'Sorry, You already Clock-Out.');
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }

    public function deleteBySelection(Request $request)
    {
        $attendance_id = $request['attendanceIdArray'];
        foreach ($attendance_id as $id) {
            $lims_attendance_data = Attendance::find($id);
            $lims_attendance_data->delete();
        }
        return 'Attendance deleted successfully!';
    }

    public function destroy($id)
    {
        $lims_attendance_data = Attendance::find($id);
        $lims_attendance_data->delete();
        return redirect()->back()->with('not_permitted', 'Attendance deleted successfully');
    }
}
