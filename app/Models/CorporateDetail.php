<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CorporateDetail extends Model
{
    protected $fillable = [
        'corporate_id',
        'company_name',
        'company_reg_no',
        'industry_type',
        'company_size',
        'establishment_year',
        'website_url',
        'no_of_emp_for_test',
        'on_site_test',
        'home_sample_collection',
        'frequency_of_testing',
        'billing_contact_name',
        'billing_contact_email',
        'company_gst',
        'prefer_payment_method',
        'bank_account_no',
        'ifsc',
        'subscription_plan',
        'company_reg_cert',
        'employee_list',
        'authorization_letter',
        'corporate_package_id',
        'status',
    ];

    protected $casts = [
        'corporate_package_id' => 'array',
    ];

    public function getCorporatePackages()
    {
        return CorporatePackage::whereIn('id', $this->corporate_package_id ?? [])->get();
    }

    public function corporateAdmin()
    {
        return $this->belongsTo(User::class, 'corporate_id', 'id')
            ->where('role', 4);
    }
}
