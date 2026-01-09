<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReferedTest extends Model
{
    protected $fillable = [
        'refered_by_id',
        'refered_lab_id',
        'refered_test_id',
        'note',
        'status',
    ];


    // Relation with Lab
    public function lab()
    {
        return $this->belongsTo(Lab::class, 'refered_lab_id', 'lab_id');
    }

    // Relation with BookingTest
    public function test()
    {
        return $this->belongsTo(BookingTest::class, 'refered_test_id');
    }

    public function patient()
    {
        return $this->hasOneThrough(
            BookingPatient::class,   // Final target model
            BookingTest::class,      // Intermediate model
            'id',                    // Foreign key on BookingTest
            'id',                    // Foreign key on BookingPatient
            'refered_test_id',       // Local key on ReferedTest
            'booking_patient_id'     // Local key on BookingTest
        );
    }
}
