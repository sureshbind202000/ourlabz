<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'role',
        'corporate_id',
        'lab_user_role',
        'user_id',
        'lab_id',
        'username',
        'name',
        'email',
        'phone',
        'gender',
        'date_of_birth',
        'age',
        'blood_group',
        'password',
        'show_password',
        'profile',
        'terms_condition',
        'subscribe',
        'designation',
        'status',
        'refering_id',
        'is_online',
        'latitude',
        'longitude',
        'location',
        'refering_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function coupons()
    {
        return $this->belongsToMany(Coupon::class, 'coupon_user')
            ->withPivot('used_count', 'order_id')
            ->withTimestamps();
    }

    public function user_details()
    {
        return $this->hasOne(UserDetails::class, 'user_id');
    }

    public function user_addresses()
    {
        return $this->hasMany(UserAddress::class, 'user_id');
    }
    public function payment_methods()
    {
        return $this->hasMany(PaymentMethod::class, 'user_id');
    }

    public function doctor_details()
    {
        return $this->hasOne(DoctorDetails::class, 'doctor_id');
    }

    public function doctor_operating_hours()
    {
        return $this->hasMany(DoctorOperatingHour::class, 'doctor_id');
    }

    // Relationship: User has one medical info record
    public function medical_information()
    {
        return $this->hasOne(UserMedicalInformation::class, 'user_id');
    }

    // Relationship: User has one booking preference record
    public function booking_preference()
    {
        return $this->hasOne(UserBookingPreference::class, 'user_id');
    }

    // Relationship: User has one insurance/payment record
    public function insurance_payment()
    {
        return $this->hasOne(UserInsurancePayment::class, 'user_id');
    }

    // Relationship: User has one documents record
    public function documents()
    {
        return $this->hasOne(UserDocuments::class, 'user_id');
    }

    // Cascade delete related models
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($user) {
            // Delete profile image
            if ($user->profile && file_exists(public_path($user->profile))) {
                unlink(public_path($user->profile));
            }

            // Delete related records and their files
            if ($user->documents) {
                if ($user->documents->id_proof && file_exists(public_path($user->documents->id_proof))) {
                    unlink(public_path($user->documents->id_proof));
                }

                if ($user->documents->insurance_card && file_exists(public_path($user->documents->insurance_card))) {
                    unlink(public_path($user->documents->insurance_card));
                }

                if ($user->documents->doctor_prescription && file_exists(public_path($user->documents->doctor_prescription))) {
                    unlink(public_path($user->documents->doctor_prescription));
                }

                $user->documents()->delete();
            }

            // Delete doctor documents and related records
            if ($user->doctor_details) {
                if ($user->doctor_details->medical_license && file_exists(public_path($user->doctor_details->medical_license))) {
                    unlink(public_path($user->doctor_details->medical_license));
                }

                if ($user->doctor_details->medical_degree_certificate && file_exists(public_path($user->doctor_details->medical_degree_certificate))) {
                    unlink(public_path($user->doctor_details->medical_degree_certificate));
                }

                if ($user->doctor_details->id_proof && file_exists(public_path($user->doctor_details->id_proof))) {
                    unlink(public_path($user->doctor_details->id_proof));
                }

                $user->doctor_details()->delete();
            }

            if ($user->corporate_details) {
                if ($user->corporate_details->company_reg_cert && file_exists(public_path($user->corporate_details->company_reg_cert))) {
                    unlink(public_path($user->corporate_details->company_reg_cert));
                }

                if ($user->corporate_details->employee_list && file_exists(public_path($user->corporate_details->employee_list))) {
                    unlink(public_path($user->corporate_details->employee_list));
                }

                if ($user->corporate_details->authorization_letter && file_exists(public_path($user->corporate_details->authorization_letter))) {
                    unlink(public_path($user->corporate_details->authorization_letter));
                }

                $user->corporate_details()->delete();
            }

            // Delete doctor operating hours
            $user->doctor_operating_hours()->delete();

            $user->user_details()->delete();
            $user->medical_information()->delete();
            $user->booking_preference()->delete();
            $user->insurance_payment()->delete();
        });
    }

    public function corporate_details()
    {
        return $this->hasOne(CorporateDetail::class, 'corporate_id', 'user_id');
    }

    public function doctor_reviews()
    {
        return $this->hasMany(DoctorReview::class, 'doctor_id');
    }

    public function vendor_details()
    {
        return $this->hasOne(VendorDetail::class, 'vendor_id');
    }
    public function operating_hours()
    {
        return $this->hasMany(DoctorOperatingHour::class, 'doctor_id');
    }

    public function modulePermissions()
    {
        return $this->hasMany(UserModulePermission::class);
    }

    public function lab()
    {
        return $this->belongsTo(lab::class, 'lab_id', 'lab_id');
    }
}
