<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class lab extends Model
{
    protected $fillable = [
        'lab_id',
        'lab_name',
        'lab_registration_no',
        'accreditation_details',
        'lab_type',
        'year_of_establishment',
        'primary_contact_name',
        'phone',
        'alternate_phone',
        'landline',
        'email',
        'website_url',
        'street_address',
        'city',
        'state',
        'country',
        'postal_code',
        'google_map_location',
        'latitude',
        'longitude',
        'list_of_test_available',
        'sample_collection',
        'home_sample_collection',
        'tat_for_reports',
        'insurance_partner_accepted',
        'lab_license',
        'doctor_license',
        'signatory_doctor_details',
        'lab_logo',
        'lab_description',
        'certification_type',
        'certification',
        'slug',
    ];

    protected $casts = [
        'list_of_test_available' => 'array',
        'lab_type' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($lab) {
            // Delete related users
            $lab->users()->each(function ($user) {
                $user->delete();
            });
            // Delete lab operating hours
            $lab->operating_hours()->delete();
            // Delete images
            foreach (['lab_logo', 'lab_license', 'doctor_license', 'accreditation_details'] as $fileField) {
                if ($lab->$fileField && File::exists(public_path($lab->$fileField))) {
                    File::delete(public_path($lab->$fileField));
                }
            }
        });
    }

    public function users()
    {
        return $this->hasMany(User::class, 'lab_id', 'lab_id');
    }

    public function slider()
    {
        return $this->hasMany(LabSlider::class, 'lab_id', 'lab_id');
    }
    public function gallery()
    {
        return $this->hasMany(LabGallery::class, 'lab_id', 'lab_id');
    }

    public function lab_tests()
    {
        return $this->hasMany(LabTest::class, 'lab_id', 'lab_id');
    }

    public function lab_facilities()
    {
        return Facility::whereIn('facility', $this->lab_type)->get();
    }

    public function operating_hours()
    {
        return $this->hasMany(LabOperatingHour::class, 'lab_id', 'lab_id');
    }
}
