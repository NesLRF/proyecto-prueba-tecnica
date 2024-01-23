<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AppointmentController extends Controller
{
    public $data = ["active_appointment" => false];

    public function validateAppointment(Request $request)
    {
        $this->validateCurp($request);
        try {
            $current_date = Carbon::now();

            $get_user = User::with('appointments')->where('curp', $request["curp"])->first();

            if(empty($get_user)){
                $get_user = $this->createUser($request["curp"]);
            }
            
            $this->checkAppointments($get_user->appointments, $current_date);

            $this->data["user"] = $get_user;
            $data = $this->data;

            return view('appointment.show', compact('data'));
        } catch (\Throwable $th) {
            Log::info("Error al verificar la CURP");
            report($th);
            return back()->with([
                "status" => "400",
                "notify" => "danger",
                "message" => "Ocurrió un error desconocido!",
            ]);
        }
    }

    public function createUser($current_curp)
    {
        try {
            DB::beginTransaction();
                $user = User::create([
                    'curp' => $current_curp,
                ]);
            DB::commit();

            return $user->with('appointments')->first();
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::info("Error al registrar CURP");
            report($th);
        }
    }

    public function validateCurp($curp)
    {
        $curp->validate([
            'curp' => ['required', 'min:18', 'max:18']
        ],
        [
            'curp.required' => 'El CURP es requerido',
            'curp.min' => 'El CURP debe tener mínimo 18 caracteres',
            'curp.max' => 'El CURP debe tener máximo 18 caracteres',
        ]);
    }

    public function appointmentCreate(Request $request)
    {
        $request->validate([
            'curp' => ['required', 'min:18', 'max:18'],
            'name' => ['required', 'max:50'],
            'email' => ['required', 'email'],
            'date' => 'required',
            'hour' => 'required'
        ],
        [
            'curp.required' => 'El CURP es requerido',
            'curp.min' => 'El CURP debe tener mínimo 18 caracteres',
            'curp.max' => 'El CURP debe tener máximo 18 caracteres',
            'name.required' => 'El campo Nombre es requerido',
            'name.max' => 'El campo Nombre debe tener máximo 50 caracteres',
            'email.required' => 'El campo Email es requerido',
            'email.email' => 'El campo Email debe contar con la estructura de un email',
            'date.required' => 'El campo Fecha es requerido',
            'hour.required' => 'El campo Hora es requerido',
        ]);
        
        try {
            $current_date = Carbon::now();

            $date_format = (new Carbon($request["date"]))->format('Y-m-d '.$request["hour"].':s');

            if($date_format < $current_date){
                return back()->with([
                    "status" => "400",
                    "notify" => "danger",
                    "message" => "La fecha seleccionada no es válida, debe ser mayor!",
                ]);
            }

            $get_user = User::with('appointments')->where('curp', $request["curp"])->first();

            $this->checkAppointments($get_user->appointments, $current_date);

            if(!$this->data["active_appointment"]){
                DB::beginTransaction();
                    if(!$get_user->name){
                        $get_user->name = $request["name"];
                        $get_user->email = $request["email"];
                        $get_user->save();
                    }
    
                    Appointment::create([
                        'user_id' => $get_user->id,
                        'day' => $date_format,
                    ]);
                DB::commit();
            }

            $get_user = $get_user->with('appointments')->first();
            $this->data = ["active_appointment" => false];
            $this->checkAppointments($get_user->appointments, $current_date);

            $this->data["user"] = $get_user;
            $data = $this->data;

            
            return view('appointment.show', compact('data'))->with([
                "status" => "200",
                "notify" => "success",
                "message" => "Registro exitoso",
            ]);
        } catch (\Throwable $th) {
            Log::info("Error al registrar cita");
            report($th);
            return back()->with([
                "status" => "400",
                "notify" => "danger",
                "message" => "Ocurrió un error desconocido!",
            ]);
        }
    }

    public function checkAppointments($current_user_appointment, $current_date)
    {
        if(!empty($current_user_appointment)){
            foreach ($current_user_appointment as $key => $user_appointment) {
                $most_recent_appointment_date = (new Carbon($user_appointment->day));

                if($current_date < $most_recent_appointment_date){
                    $this->data["active_appointment"] = true;
                    $this->data["most_recent_appointment_day"] = ucfirst($most_recent_appointment_date->dayName). " ". $most_recent_appointment_date->format('d'). " de ". ucfirst($most_recent_appointment_date->monthName) ." ". $most_recent_appointment_date->format('g:i A');
                }else{
                    $this->data["appointment_day_history"][$key] = ucfirst($most_recent_appointment_date->dayName). " ". $most_recent_appointment_date->format('d'). " de ". ucfirst($most_recent_appointment_date->monthName) ." ". $most_recent_appointment_date->format('g:i A');
                }
            }
        }
    }

    public function curpData($curp)
    {
        $get_user = User::with('appointments')->where('curp', $curp)->first();

        return view('appointment.create', compact('get_user'));
    }

    public function appointmentDelete(Request $request)
    {
        try {
            DB::beginTransaction();
                $active_appointment = $request["curp"]->appointments->first();
                $active_appointment->delete();
                $active_appointment->save();
            DB::commit();

            return redirect('/')->with([
                "status" => "200",
                "notify" => "success",
                "message" => "Cita cancelada exitosamente!",
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::info("Error al eliminar cita");
            report($th);
            return back()->with([
                "status" => "400",
                "notify" => "danger",
                "message" => "Ocurrió un error desconocido!",
            ]);
        }
    }
}