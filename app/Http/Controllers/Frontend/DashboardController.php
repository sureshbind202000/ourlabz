<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    
    public function support_ticket()
    {
        return view('frontend.support_ticket');
    }
    
    public function payment_method()
    {
        return view('frontend.payment_method');
    }
    
    public function user_notification()
    {
        return view('frontend.user_notification');
    }
    
    public function user_setting()
    {
        return view('frontend.user_setting');
    }

    public function add_address()
    {
        return view('frontend.add_address');
    }
    public function ticket_detail()
    {
        return view('frontend.ticket_detail');
    }
   
}
