<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Hash;
use Auth;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function clients()
    {
        return view('builds');
    }

    public function trainerlist(){

        $trainers = DB::connection('mysql2')
        ->table('trainer as t')
        ->select('t.*', 'studios.name as sName')
        ->leftJoin('studios', 't.studio', '=', 'studios.id')
        ->get();

        if (Auth::user()->type == "manager") {

            $resStudio = DB::connection('mysql2')->table('trainer')->where('email', Auth::user()->email)->first()->studio;
            $trainers = DB::connection('mysql2')
                ->table('trainer as t')
                ->select('t.*', 'studios.name as sName')
                ->leftJoin('studios', 't.studio', '=', 'studios.id')
                ->where('studios.id', $resStudio)
                ->get();
        }

        foreach($trainers as $trainer){

            //get user type
            $trainer->type = DB::table('users')->where('email', $trainer->email)->first()->type;

            if ($trainer->shift === '00') $trainer->shift = 'week even / day';
                else if ($trainer->shift === '10') $trainer->shift = 'week odd / day';
                    else if ($trainer->shift === '01') $trainer->shift = 'week even / night';
                        else if ($trainer->shift === "11") $trainer->shift = 'week odd / night';
                            else $trainer->shift = 'not set';
        }

       // dd($trainers);

        return view('trainers', compact('trainers'));
    }

    public function schedule(){

        //get user name
        $username = Auth::user()->name;

        $useremail = Auth::user()->email;

        //get studio name
        $sid = DB::connection('mysql2')->table('trainer')->where('email',$useremail )->first()->studio;
        $sname = DB::connection('mysql2')->table('studios')->where('id', $sid)->first()->name;

        $date = date('m/d/Y h:i:s a', time());

        $y = date('Y');
        $m = date('m');
        $M = date('F');
        $d = date('d');

        $ndays = cal_days_in_month(CAL_GREGORIAN, $m, $y);

        //dd($number);

        $selectMonths = '';
        for ($i = 0; $i < 12; $i++) {
            $time = strtotime(sprintf('%d months', $i));
            $label = date('F', $time);
            $value = date('n', $time);
            $selectMonths .= "<option value='$value'>$label</option>";
        }


        //get trainers for that studio id
        $trNames = DB::connection('mysql2')->table('trainer')->where('studio',$sid)->get();
        $trFinal = array();
        foreach($trNames as $tname){
            $tRes = DB::table('users')->where('email', $tname->email)->first();
            if ($tRes && ($tRes->type !== "admin")){
                $trFinal[] = ["name" => $tRes->name, "job" => $tRes->type];
            }
        }

        return view('schedule', compact('ndays','username', 'sname', 'y','M', 'm', 'trFinal', 'selectMonths'));

    }

    public function genpassword(){

        $res = DB::connection('mysql2')->table('trainer')->orderBy('email','ASC')->get();

        foreach ($res as $r){
            $password = Hash::make($r->pass);

            DB::table('users')->where('email',$r->email)->update(['password' => $password]);
        }
        //dd($res);
    }

    public function addtrainer(Request $request)
    {

        if ( $request->input('name') && $request->input('email') && $request->input('password') && $request->input('phone') && $request->input('studio') && $request->input('type')) {

            $name = $request->input('name');
            $email = $request->input('email');
            $password = $request->input('password');
            $phone = $request->input('phone');
            $studio = $request->input('studio');
            $profile = "https://i.pinimg.com/originals/36/4a/14/364a14fc75497607b506069b6fc3cb15.jpg";
            $type = $request->input('type');

            $passwordHash = Hash::make($password);
            //$type = 'trainer';


            if ( $request->input('id') ) {
                $id = $request->input('id');
                $uemail = DB::connection('mysql2')->table('trainer')->where('id', $id)->first()->email;
                DB::connection('mysql2')->table('trainer')->where('id', $id)->update(['name' => $name, 'email' => $email, 'pass' => $password, 'phone' => $phone, 'studio' => $studio, 'mymodels' => '', 'profile' => $profile]);

                //update user into laravel app
                DB::table('users')->where('email',$uemail)->update(['name' => $name, 'type' => $type, 'password' => $passwordHash]);
            } else {
                DB::connection('mysql2')->table('trainer')->insert(['name' => $name, 'email' => $email, 'pass' => $password, 'phone' => $phone, 'studio' => $studio, 'mymodels' => '', 'profile' => $profile]);
                //insert user into laravel app
                DB::table('users')->insert(['name' => $name, 'email' => $email, 'type' => $type, 'password' => $passwordHash]);
            }



            return redirect('admin/trainerlist');

        }

        if (Auth::user()->type == "manager") {
            $resStudio = DB::connection('mysql2')->table('trainer')->where('email', Auth::user()->email)->first()->studio;
            $studios = DB::connection('mysql2')->table('studios')->select('id','name')->where('id', $resStudio)->get();
        } else {
            $studios = DB::connection('mysql2')->table('studios')->select('id','name')->get();
        }

        $type = ["manager" => "Manager", "trainer" => "Support", "trainer1" => "Trainer initial"];

        return view('addtrainer', compact('studios', 'type'));
    }

    public function edittrainer($id){

        $trainer = DB::connection('mysql2')->table('trainer')->where('id', $id)->first();

        if (Auth::user()->type == "manager") {
            $resStudio = DB::connection('mysql2')->table('trainer')->where('email', Auth::user()->email)->first()->studio;
            $studios = DB::connection('mysql2')->table('studios')->select('id','name')->where('id', $resStudio)->get();
        } else {
            $studios = DB::connection('mysql2')->table('studios')->select('id','name')->get();
        }

        //$studios = DB::connection('mysql2')->table('studios')->select('id','name')->get();

        $type = ["manager" => "Manager", "trainer" => "Support", "trainer1" => "Trainer initial"];

        return view('edittrainer', compact('trainer', 'studios', 'type'));


    }

    public function shiftreport($date = null){

        $uType = Auth::user()->type;
        $uName = Auth::user()->name;
        $uEmail = Auth::user()->email;

        $trRes = array();

        $tday = ($date) ? $date : Carbon::now()->format('Y-m-d');

        //$tday = Carbon::now()->format('Y-m-d');
        $tmrw = Carbon::parse($tday)->add(1, 'day')->format('Y-m-d');

        $yday = Carbon::parse($tday)->sub(1, 'day')->format('Y-m-d');

        $studios = DB::connection('mysql2')->table('studios')->get();

        if ($uType == "trainer") {
            $mySId = DB::connection('mysql2')->table('trainer')->where('email', $uEmail)->first()->studio;

            $trRes = DB::connection('mysql2')
                ->table('trainer_shift_report')
                ->select('trainer.id', 'trainer.name', 'trainer_shift_report.date', 'trainer_shift_report.end_date')
                ->leftJoin('trainer','trainer_shift_report.trainer_id','=','trainer.id')
                ->where('studio', $mySId)
                ->whereDate('trainer_shift_report.created_at', Carbon::today())
                ->get();

            $inShift = DB::connection('mysql2')
                ->table('model_shift_report')
                ->select('model_shift_report.*','studios.name as studioName')
                ->leftJoin('studios','model_shift_report.studio','=','studios.id')
                ->whereDate('model_shift_report.created_at', $tday)
                ->where('studios.id', $mySId)
                ->get();

        } else {

            $inShift = DB::connection('mysql2')
                ->table('model_shift_report')
                ->select('model_shift_report.*','studios.name as studioName')
                ->leftJoin('studios','model_shift_report.studio','=','studios.id')
                ->whereDate('model_shift_report.created_at', $tday)
                ->get();

        }



        foreach($inShift as $shift){
            $shift->support = implode(',',json_decode(($shift->support),true));
            $shift->arrival_time = Carbon::createFromTimestamp($shift->arrival_time, 'Europe/Bucharest')->format('H:i:s');
            $shift->login_time = Carbon::createFromTimestamp($shift->login_time, 'Europe/Bucharest')->format('H:i:s');
            $shift->pre_login_time = gmdate('H:i:s', $shift->pre_login_time);
            $shift->login_time_period_before = gmdate('H:m:s', $shift->login_time_period_before);
            $shift->login_time_period_after =  $shift->login_time_period_after ? gmdate('H:i:s', $shift->login_time_period_after) : '';
            $shift->total_time_shift_w = $shift->total_time_shift_w ? gmdate('H:i:s', $shift->total_time_shift_w) : '';
            //$shift->logout_time = $shift->logout_time ? Carbon::createFromTimestamp($shift->logout_time, 'Europe/Bucharest')->format('H:i:s') : '';
            $shift->logout_time = $shift->logout_time ? Carbon::createFromTimestamp($shift->logout_time, 'Europe/Bucharest')->format('H:i:s') : '';
            $shift->total_break_time_shift = $shift->total_break_time_shift ? gmdate('H:i:s', $shift->total_break_time_shift) : '';

        }

        return view('shiftreport', compact('tday', 'inShift', 'studios', 'tmrw', 'yday','trRes'));

    }

    public function shiftreport1($date = null){

        $uType = Auth::user()->type;
        $uName = Auth::user()->name;
        $uEmail = Auth::user()->email;

        $trRes = array();

        $tday = ($date) ? $date : Carbon::now()->format('Y-m-d');

        //$tday = Carbon::now()->format('Y-m-d');
        $tmrw = Carbon::parse($tday)->add(1, 'day')->format('Y-m-d');

        $yday = Carbon::parse($tday)->sub(1, 'day')->format('Y-m-d');

        $studios = DB::connection('mysql2')->table('studios')->get();

        if ( ($uType == "trainer") || ($uType == "manager") ) {
            $mySId = DB::connection('mysql2')->table('trainer')->where('email', $uEmail)->first()->studio;

            $trRes = DB::connection('mysql2')
                ->table('trainer_shift_report')
                ->select('trainer.id', 'trainer.name', 'trainer_shift_report.date', 'trainer_shift_report.end_date')
                ->leftJoin('trainer','trainer_shift_report.trainer_id','=','trainer.id')
                ->where('studio', $mySId)
                ->whereDate('trainer_shift_report.created_at', $tday)
                ->get();

            $inShift = DB::connection('mysql2')
                ->table('model_shift_report')
                ->select('model_shift_report.*','studios.name as studioName', 'trainer_shift_report.date as trainer_shift')
                ->leftJoin('studios','model_shift_report.studio','=','studios.id')
                ->leftJoin('trainer_shift_report','model_shift_report.support_main_id','=','trainer_shift_report.trainer_id')
                ->whereDate('trainer_shift_report.created_at', $tday)
                ->whereDate('model_shift_report.created_at', $tday)
                ->where('studios.id', $mySId)
                ->get();

        } else {

            $trRes = DB::connection('mysql2')
                ->table('trainer_shift_report')
                ->select('trainer.id', 'trainer.name', 'trainer_shift_report.date', 'trainer_shift_report.end_date')
                ->leftJoin('trainer','trainer_shift_report.trainer_id','=','trainer.id')
                ->whereDate('trainer_shift_report.created_at', $tday)
                ->get();

            $inShift = DB::connection('mysql2')
                ->table('model_shift_report')
                ->select('model_shift_report.*','studios.name as studioName', 'trainer_shift_report.date as trainer_shift')
                ->leftJoin('studios','model_shift_report.studio','=','studios.id')
                ->leftJoin('trainer_shift_report','model_shift_report.support_main_id','=','trainer_shift_report.trainer_id')
                ->whereDate('trainer_shift_report.created_at', $tday)
                ->whereDate('model_shift_report.created_at', $tday)
                ->get();

        }



        foreach($inShift as $shift){
            $shift->support = implode(',',json_decode(($shift->support),true));
            $shift->arrival_time = Carbon::createFromTimestamp($shift->arrival_time, 'Europe/Bucharest')->format('H:i:s');
            $shift->login_time = Carbon::createFromTimestamp($shift->login_time, 'Europe/Bucharest')->format('H:i:s');
            $shift->pre_login_time = gmdate('H:i:s', $shift->pre_login_time);
            $shift->login_time_period_before = gmdate('H:m:s', $shift->login_time_period_before);
            $shift->login_time_period_after =  $shift->login_time_period_after ? gmdate('H:i:s', $shift->login_time_period_after) : '';
            $shift->total_time_shift_w = $shift->total_time_shift_w ? gmdate('H:i:s', $shift->total_time_shift_w) : '';
            //$shift->logout_time = $shift->logout_time ? Carbon::createFromTimestamp($shift->logout_time, 'Europe/Bucharest')->format('H:i:s') : '';
            $shift->logout_time = $shift->logout_time ? Carbon::createFromTimestamp($shift->logout_time, 'Europe/Bucharest')->format('H:i:s') : '';
            $shift->total_break_time_shift = $shift->total_break_time_shift ? gmdate('H:i:s', $shift->total_break_time_shift) : '';
            $hour = date('H', strtotime($shift->trainer_shift));
            $shift->trainer_shift =  ( ($hour > 7) && ($hour < 19) ) ? 'T1' : 'T2';

        }

        

        return view('shiftreport1', compact('tday', 'inShift', 'studios', 'tmrw', 'yday','trRes'));

    }

    public function shiftdetails($id){

        $inShift = DB::connection('mysql2')
            ->table('model_shift_report')
            ->select('model_shift_report.*','studios.name as studioName', 'trainer_shift_report.date as trainer_shift', 'trainer_shift_report.end_date as trainer_end_date')
            ->leftJoin('studios','model_shift_report.studio','=','studios.id')
            ->leftJoin('trainer_shift_report','model_shift_report.support_main_id','=','trainer_shift_report.trainer_id')
            ->where('model_shift_report.id', $id)
            ->first();

        $resTrainerShift = DB::connection('mysql2')
            ->table('trainer_shift_report')
            ->select('trainer_shift_report.*', 'trainer.name as t_name')
            ->leftJoin('trainer','trainer_shift_report.trainer_id', '=','trainer.id')
            ->where('trainer_shift_report.model_shift_id', $id)
            ->get();

        $modeShiftWarnings = DB::connection('mysql2')->table('task_shift_report')->where('model_shift_id', $id)->get();

        foreach($modeShiftWarnings as $warning) {
            if ($warning->name == "BREAKALERT") $warning->name = "Break over 60 min";
            if ($warning->name == "AVERAGE") $warning->name = "Average under 35$";
            if ($warning->name == "TOTALBREAK") $warning->name = "Break over 240 min";
            if ($warning->name == "OVERTIME") $warning->name = "Online time over 8h";
        }

        $trainers = json_decode(($inShift->support),true);

        $inShift->support = implode(',',$trainers);
        $inShift->arrival_time = Carbon::createFromTimestamp($inShift->arrival_time, 'Europe/Bucharest')->format('H:i:s');
        $inShift->login_time = Carbon::createFromTimestamp($inShift->login_time, 'Europe/Bucharest')->format('H:i:s');
        $inShift->pre_login_time = gmdate('H:i:s', $inShift->pre_login_time);
        $inShift->login_time_period_before = gmdate('H:m:s', $inShift->login_time_period_before);
        $inShift->login_time_period_after =  $inShift->login_time_period_after ? gmdate('H:i:s', $inShift->login_time_period_after) : '';
        $inShift->total_time_shift_w = $inShift->total_time_shift_w ? gmdate('H:i:s', $inShift->total_time_shift_w) : '';
        $inShift->logout_time = $inShift->logout_time ? Carbon::createFromTimestamp($inShift->logout_time, 'Europe/Bucharest')->format('H:i:s') : '';
        $inShift->total_break_time_shift = $inShift->total_break_time_shift ? gmdate('H:i:s', $inShift->total_break_time_shift) : '';

        $hour = date('H', strtotime($inShift->trainer_shift));
        $inShift->trainer_shift_name =  ( ($hour > 7) && ($hour < 19) ) ? 'T1' : 'T2';

        return view('shiftdetails', compact('id','inShift', 'resTrainerShift','modeShiftWarnings'));
    }

    
    public function edittrainermodels($id){

        $trainer = DB::connection('mysql2')->table('trainer')->where('id', $id)->first();
        $allmodels = array();

        if ($trainer) {
            $mymodels = explode(',', $trainer->mymodels);
            $models = DB::connection('mysql2')->table('sync_models')->where('studio', $trainer->studio)->pluck('sync_Modelname')->toArray();

            foreach($models as $mod){
                    $trainers = DB::connection('mysql2')->table('trainer')->select('name','mymodels')->get();
                    $notfound = 1;
                    foreach($trainers as $tr){
                         $my_mod = explode(',', $tr->mymodels);
                         if (in_array($mod, $my_mod))  {
                            if (array_key_exists($mod,$allmodels)) {
                                //array_push($allmodels[$mod], $tr->name);
                                $allmodels[$mod] = $tr->name;
                            }
                             else $allmodels[$mod] = $tr->name;
                            $notfound = 0;
                         }
                    }
                    if ($notfound) $allmodels[$mod] = 'Free';
            }

            $studio = DB::connection('mysql2')->table('studios')->where('id', $trainer->studio)->select('name')->first();

        } else return redirect('admin/trainerlist');

        return view('edittrainermodels', compact('trainer', 'allmodels', 'mymodels','studio'));


    }

    public function ajaxAdminData(Request $request){

        $msg = 'fail';

        if ( $request->input('modelname')  &&   $request->input('getshifttimeline') ){
            $model = $request->input('modelname');
            $dataSel = $request->input('getshifttimeline');

            //$dueDateTime = Carbon::createFromFormat('Y-m-d', $dataSel, 'Europe/Bucharest')->format('Y-m-d'); 
            $dueDateTime = Carbon::createFromFormat('Y-m-d', $dataSel, 'Europe/Bucharest'); 
            $nextDay = Carbon::createFromFormat('Y-m-d', $dataSel, 'Europe/Bucharest')->addDay()->format('Y-m-d'); 
            $prevDay = Carbon::createFromFormat('Y-m-d', $dataSel, 'Europe/Bucharest')->subDay()->format('Y-m-d'); 

            $resShiftTime = DB::connection('mysql2')->table('models_timestamp')
            ->where('modelname', $model)
            ->whereBetween('date', [$prevDay, $nextDay])
            ->orderBy('status_start','asc')
            ->get();

            return $resShiftTime;

        }

        if ( $request->input('trainer') ) {
            $id = $request->input('trainer');
            $models = $request->input('mymodels') ? $request->input('mymodels') : '';

            $trainer = DB::connection('mysql2')->table('trainer')->where('id', $id)->first();

            if ($trainer) {
                DB::connection('mysql2')->table('trainer')->where('id', $id)->update(['mymodels' => $models]);
                $msg = 'success';
            }  

            return $msg; 

        }

        if ( $request->input('trainer_id') && $request->input('shift') ) {

            $id = $request->input('trainer_id');
            $shift = $request->input('shift');
            DB::connection('mysql2')->table('trainer')->where('id', $id)->update(['shift' => $shift]);
            $msg = 'success';

            return $msg; 

        }


    }

    public function timetable($id){

        $trainer = DB::connection('mysql2')->table('trainer')->where('id', $id)->first();

        if ($trainer->shift === '00') $trainer->shiftName = 'week even / day';
        else if ($trainer->shift === '10') $trainer->shiftName = 'week odd / day';
            else if ($trainer->shift === '01') $trainer->shiftName = 'week even / night';
                else if ($trainer->shift === "11") $trainer->shiftName = 'week odd / night';
                    else $trainer->shiftName = 'not set';


        return view('timetable', compact('trainer'));
    }

}
