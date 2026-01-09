<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingBarcode extends Model
{
    protected $fillable = [
        'booking_id',
        'booking_patient_id',
        'test_ids',
        'barcode_text',
        'barcode_image_path',
    ];
}
