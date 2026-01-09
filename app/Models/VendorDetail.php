<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VendorDetail extends Model
{
    protected $fillable = [
        'vendor_id',
        'company_name',
        'company_reg_no',
        'business_type',
        'tin',
        'establishment_year',
        'business_license',
        'iso_certifications',
        'environmental_certificates',
        'msds_document',
        'import_export_license',
        'primary_categories',
        'subcategories',
        'custom_equipment_manufacturing',
        'oem_odm_capabilities',
        'moq',
        'lead_time_days',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'vendor_id');
    }
}
