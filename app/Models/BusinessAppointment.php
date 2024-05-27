<?php



namespace App\Models;



use App\Http\Resources\BusinessResource;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;



class BusinessAppointment extends Model

{

    use HasFactory;

    use SoftDeletes;



    public $timestamps = false;

    protected $table = 'business_appointment';

    public $guarded = ["id"];



    public function user()

    {

        return $this->belongsTo(User::class, 'user_id', 'id');

    }



    public function business()

    {

        return $this->belongsTo(Business::class, 'business_id', 'id');

    }



    public function subService()

    {

        return $this->belongsTo(SubService::class, 'sub_services_id', 'id');

    }



    public function businessSubService()

    {

        return $this->belongsTo(BusinessSubServices::class, 'business_sub_services_id', 'id');

    }



    public function businessTeamMember()

    {

        return $this->belongsTo(BusinessTeamMember::class, 'business_team_members_id', 'id');

    }



    public function payment()

    {

        return $this->hasOne(AppointmentPayment::class, 'appointment_id', 'id');

    }

    public function appointmentPayment()

    {

        return $this->belongsTo(AppointmentPayment::class, 'id', 'appointment_id');

    }

    public function userAddress()

    {

        return $this->belongsTo(UserAddress::class, 'user_id', 'user_id');

    }



    public static function getAppointment($business_id)

    {

        $query = BusinessAppointment::with(['user', 'business', 'subService', 'businessSubService', 'businessTeamMember', 'appointmentPayment'])->where('business_id', $business_id)->orderBy('appointment_date', 'DESC')->paginate(10);

        return $query;

    }



    public static function listAppointment($business_id)

    {

        $query = BusinessAppointment::with(['user', 'business', 'subService', 'businessSubService', 'businessTeamMember'])->where('business_id', $business_id)->get();

        return $query;

    }



    public static function listAllAppointmentCount($business_id)

    {

        $query = BusinessAppointment::where('business_id', $business_id)->count();

        return $query;

    }



    public static function allAppointmentList($userId)

    {

        $query = BusinessAppointment::with(['business'])->orderBy('id', 'desc')->where('user_id', $userId)->get();

        return $query;

    }



    public static function createAppointment($array)

    {

        $query = BusinessAppointment::create($array);

        return $query;

    }



    public static function deleteAppointment($id)

    {

        $query = BusinessAppointment::find($id)->delete();

        return $query;

    }



    public static function updateAppointment($id, $array)

    {

        $query = BusinessAppointment::find($id)->update($array);

        return $query;

    }

    public static function getAppointmentsByDate($date, $businessId)

    {

        $query = BusinessAppointment::with(['user', 'business', 'subService', 'businessSubService', 'businessTeamMember'])->where('business_id', $businessId)->whereDate('appointment_date', $date)->get();

        return $query;

    }



    public static function getAppointmentsById($id)

    {

        $query = BusinessAppointment::with(['user', 'business', 'subService', 'businessSubService', 'businessTeamMember', 'payment'])->where('id', $id)->first();

        return $query;

    }

    public static function getAppointmentsByIdBusiness($id)
    {
        $query = BusinessAppointment::select('business_appointment.*','appointment_payment.appointment_id','appointment_payment.total_amount as price')->with(['business'])
        ->join('appointment_payment', function ($join) {
            $join->on('appointment_payment.appointment_id', '=', 'business_appointment.id');
        })
        ->orderBy('business_appointment.id', 'desc')
        ->where('business_appointment.id', $id)
        ->first();
        return $query;
    }

    public static function listAppointmentInSuperAdmin($name, $mobile, $business, $subService, $businessSubService, $businessTeamMember, $appointmentDate, $appointmentTime)

    {

        $query = BusinessAppointment::with(['user', 'business', 'subService', 'businessSubService', 'businessTeamMember', 'userAddress']);

        if ($name != "") {

            $query->whereHas('user', function ($q) use ($name) {

                $q->where('name', 'like', '%' . $name . '%');

            });

        }

        if ($mobile != "") {

            $query->whereHas('user', function ($q) use ($mobile) {

                $q->where('mobile', 'like', '%' . $mobile . '%');

            });

        }



        if ($business != "") {

            $query->whereHas('business', function ($q) use ($business) {

                $q->where('id', $business);

            });

        }



        if ($subService != "") {

            $query->whereHas('subService', function ($q) use ($subService) {

                $q->where('id', $subService);

            });

        }



        if ($businessSubService != "") {

            $query->whereHas('businessSubService', function ($q) use ($businessSubService) {

                $q->where('id', $businessSubService);

            });

        }



        if ($businessTeamMember != "") {

            $query->whereHas('businessTeamMember', function ($q) use ($businessTeamMember) {

                $q->where('id', $businessTeamMember);

            });

        }



        if ($appointmentDate != "") {

            $query->where('appointment_date', $appointmentDate);

        }



        if ($appointmentTime != "") {

            $query->where('appointment_time', $appointmentTime);

        }



        $query->where('appointment_status', 'Confirm');



        return $query->paginate(10);

    }



    public static function listAllAppointmentInSuperAdmin()

    {

        $query = BusinessAppointment::with(['user', 'business', 'subService', 'businessSubService', 'businessTeamMember', 'userAddress'])->where('appointment_status', 'Confirm')->get();

        return $query;

    }



    public static function canceleAppointmentListInSuperAdmin()

    {

        $query = BusinessAppointment::with(['user', 'business', 'subService', 'businessSubService'])->where('appointment_status', 'Cancel')->get();

        return $query;

    }



    public static function canceleAppointmentListSearchInSuperAdmin($name, $mobile, $business, $subService, $businessSubService, $businessTeamMember, $appointmentDate, $appointmentTime)

    {

        $query = BusinessAppointment::with(['user', 'business', 'subService', 'businessSubService', 'businessTeamMember', 'userAddress']);

        if ($name != "") {

            $query->whereHas('user', function ($q) use ($name) {

                $q->where('name', 'like', '%' . $name . '%');

            });

        }

        if ($mobile != "") {

            $query->whereHas('user', function ($q) use ($mobile) {

                $q->where('mobile', 'like', '%' . $mobile . '%');

            });

        }



        if ($business != "") {

            $query->whereHas('business', function ($q) use ($business) {

                $q->where('id', $business);

            });

        }



        if ($subService != "") {

            $query->whereHas('subService', function ($q) use ($subService) {

                $q->where('id', $subService);

            });

        }



        if ($businessSubService != "") {

            $query->whereHas('businessSubService', function ($q) use ($businessSubService) {

                $q->where('id', $businessSubService);

            });

        }



        if ($businessTeamMember != "") {

            $query->whereHas('businessTeamMember', function ($q) use ($businessTeamMember) {

                $q->where('id', $businessTeamMember);

            });

        }



        if ($appointmentDate != "") {

            $query->where('appointment_date', $appointmentDate);

        }



        if ($appointmentTime != "") {

            $query->where('appointment_time', $appointmentTime);

        }



        return $query->where('appointment_status', 'Cancel')->paginate(10);

    }



    public static function getTotalAppointmentOfUser($userId)

    {

        $query = BusinessAppointment::where('user_id', $userId)->count();

        return $query;

    }



    public static function getCancelAppointmentOfUser($userId)

    {

        $query = BusinessAppointment::where('user_id', $userId)->where('appointment_status', 'Cancel')->count();

        return $query;

    }



    public static function getTotalAppointment()

    {

        $query = BusinessAppointment::count();

        return $query;

    }

    public static function listAllAppointment()

    {

        $query = BusinessAppointment::with(['business'])->where('appointment_status', 'Confirm')->get();

        return $query;

    }

    public static function getAppointmentTeamMemberWise($teamMemberId)

    {

        $query = BusinessAppointment::select('appointment_date', 'appointment_time')->where('business_team_members_id', $teamMemberId)->where('appointment_status', 'Confirm')->get();

        return $query;

    }



    public static function checkDateAndTimeSlotAppointment($teamMemberId, $appointmentDate, $appointmentTime)

    {

        $query = BusinessAppointment::where('business_team_members_id', $teamMemberId)->where('appointment_date', $appointmentDate)->where('appointment_time', $appointmentTime)->where('appointment_status', 'Confirm')->first();

        return $query;

    }

    public static function getBusinessWiseAppointments($id)

    {

        

        $query = BusinessAppointment::where('business_id', $id)->get();

        return $query;

    }

}

