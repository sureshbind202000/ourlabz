<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Booking;
use App\Models\LabReview;
use App\Models\DoctorReview;
use App\Models\DoctorConsultation;
use App\Models\CorporateDetail;
use App\Models\Product;
use App\Models\ProductVarient;
use App\Models\ProductReview;
use App\Models\Order;
use App\Models\OrderItem;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    // Dashboard
    public function index()
    {
        $role = auth()->user()->role;


        if ($role === 0) {
            // Total counts
            $totalUsers = User::where('role', 1)->where('corporate_id', null)->count();
            $totalLabs = User::where('role', 2)->where('lab_user_role', 1)->count();
            $totalDoctors = User::where('role', 3)->count();
            $totalCorporates = User::where('role', 4)->count();
            $totalVendors = User::where('role', 5)->count();

            // Function to generate weekly data and growth
            $generateStats = function ($role, $extraCondition = null) {
                $weekly = [];
                for ($i = 6; $i >= 0; $i--) {
                    $date = Carbon::today()->subDays($i);

                    $query = User::where('role', $role);
                    if ($extraCondition) {
                        $extraCondition($query);
                    }

                    $weekly[] = [
                        'day' => $date->format('D'),
                        'count' => (clone $query)->whereDate('created_at', $date)->count(),
                    ];
                }

                $queryThisWeek = User::where('role', $role);
                $queryLastWeek = User::where('role', $role);

                if ($extraCondition) {
                    $extraCondition($queryThisWeek);
                    $extraCondition($queryLastWeek);
                }

                $thisWeek = $queryThisWeek
                    ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                    ->count();

                $lastWeek = $queryLastWeek
                    ->whereBetween('created_at', [Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()])
                    ->count();

                $growth = $lastWeek > 0 ? (($thisWeek - $lastWeek) / $lastWeek) * 100 : 0;

                return ['weekly' => $weekly, 'growth' => $growth];
            };

            $userStats = $generateStats(1);
            $labStats = $generateStats(2, fn($q) => $q->where('lab_user_role', 1));
            $doctorStats = $generateStats(3);
            $corporateStats = $generateStats(4);
            $vendorStats = $generateStats(5);

            return view('backend.superadmin.dashboard', [
                'totalUsers' => $totalUsers,
                'totalLabs' => $totalLabs,
                'totalDoctors' => $totalDoctors,
                'totalCorporates' => $totalCorporates,
                'totalVendors' => $totalVendors,

                'weeklyUserData' => $userStats['weekly'],
                'weeklyLabData' => $labStats['weekly'],
                'weeklyDoctorData' => $doctorStats['weekly'],
                'weeklyCorporateData' => $corporateStats['weekly'],
                'weeklyVendorData' => $vendorStats['weekly'],

                'userGrowth' => $userStats['growth'],
                'labGrowth' => $labStats['growth'],
                'doctorGrowth' => $doctorStats['growth'],
                'corporateGrowth' => $corporateStats['growth'],
                'vendorGrowth' => $vendorStats['growth'],
            ]);
        }

        if ($role === 2) {

            $user = auth()->user();
            $labId = $user->lab_id;

            // Status counts
            $statusCounts = [
                'pending' => Booking::where('status', 'Pending')->where('lab_id', $labId)->count(),
                'confirmed' => Booking::where('status', 'Confirmed')->where('lab_id', $labId)->count(),
                'cancelled' => Booking::where('status', 'Cancelled')->where('lab_id', $labId)->count(),
                'completed' => Booking::where('status', 'Completed')->where('lab_id', $labId)->count(),
                'in-progress' => Booking::where('status', 'In Progress')->where('lab_id', $labId)->count(),
                'emergency' => Booking::where('is_emergency', 1)->where('lab_id', $labId)->count(),
                'unread' => Booking::where('is_read', 0)->where('lab_id', $labId)->count(),
            ];

            // Staff counts
            $staffCounts = [
                'admin' => User::where('lab_user_role', 1)->where('lab_id', $labId)->count(),
                'manager' => User::where('lab_user_role', 2)->where('lab_id', $labId)->count(),
                'technician' => User::where('lab_user_role', 3)->where('lab_id', $labId)->count(),
                'phlebotomist' => User::where('lab_user_role', 4)->where('lab_id', $labId)->count(),
                'doctor' => User::where('lab_user_role', 5)->where('lab_id', $labId)->count(),
            ];

            // Reviews and notifications
            $reviewCount = LabReview::where('lab_id', $labId)->count();
            $newNotificationCount = $user->unreadNotifications()->count();

            // --- New: Monthly bookings chart data ---
            $bookingsPerMonth = Booking::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
                ->where('lab_id', $labId)
                ->whereYear('created_at', Carbon::now()->year)
                ->groupBy('month')
                ->pluck('total', 'month')
                ->toArray();

            // Fill missing months with 0
            $chartData = [];
            for ($m = 1; $m <= 12; $m++) {
                $chartData[] = $bookingsPerMonth[$m] ?? 0;
            }

            return view('backend.superadmin.labs.dashboard', compact(
                'statusCounts',
                'staffCounts',
                'reviewCount',
                'newNotificationCount',
                'chartData'
            ));
        }

        if ($role === 3) {
            $doctor = auth()->user();
            $docId = $doctor->user_id;

            $statusCounts = [
                'confirmed' => DoctorConsultation::where('status', 0)->where('doctor_id', $docId)->count(),
                'completed' => DoctorConsultation::where('status', 1)->where('doctor_id', $docId)->count(),
                'cancelled' => DoctorConsultation::where('status', 2)->where('doctor_id', $docId)->count(),
            ];

            $reviewCount = DoctorReview::where('doctor_id', $doctor->id)->count();
            $newNotificationCount = $doctor->unreadNotifications()->count();

            $bookingsPerMonth = DoctorConsultation::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
                ->where('doctor_id', $docId)
                ->whereYear('created_at', Carbon::now()->year)
                ->groupBy('month')
                ->pluck('total', 'month')
                ->toArray();

            $chartData = [];
            for ($m = 1; $m <= 12; $m++) {
                $chartData[] = $bookingsPerMonth[$m] ?? 0;
            }

            return view('backend.superadmin.doctors.dashboard', compact(
                'statusCounts',
                'reviewCount',
                'newNotificationCount',
                'chartData'
            ));
        }

        if ($role === 4) {
            $corpAdmin = auth()->user();

            $employees = User::where('corporate_id', $corpAdmin->id)->count();

            $corporate = CorporateDetail::where('corporate_id', $corpAdmin->user_id)->first();
            $pendingPackages = 0;
            $purchasedPackages = 0;

            if ($corporate) {
                $packages = $corporate->getCorporatePackages();
                $pendingPackages = $packages->where('status', 0)->count();
                $purchasedPackages = $packages->where('status', 1)->count();
            }

            return view('backend.superadmin.corporates.dashboard', compact(
                'employees',
                'corporate',
                'pendingPackages',
                'purchasedPackages'
            ));
        }

        // Vendor Dashboard
        if ($role === 5) {

            $vendor = auth()->user();

            // Vendor details
            $vendorDetail = $vendor->vendor_details;

            // Vendor products
            $products = Product::where('vendor_id', $vendor->id)->get();
            $productIds = $products->pluck('id');

            // Product variants & reviews
            $productVariants = ProductVarient::whereIn('product_id', $productIds)->count();
            $reviewCount = ProductReview::whereIn('product_id', $productIds)->count();

            // Notifications
            $newNotificationCount = $vendor->unreadNotifications()->count();

            // ✅ Get all orders that belong to this vendor (via order_items)
            $vendorOrderIds = Order::where('vendor_id', $vendor->id)
                ->pluck('id')
                ->unique()
                ->toArray();

            // ✅ Order status counts (based on orders table)
            $statusCounts = [
                'pending'    => OrderItem::whereIn('order_id', $vendorOrderIds)->where('status', 'Pending')->count(),
                'processing' => OrderItem::whereIn('order_id', $vendorOrderIds)->where('status', 'Processing')->count(),
                'on_hold'    => OrderItem::whereIn('order_id', $vendorOrderIds)->where('status', 'On hold')->count(),
                'cancelled'  => OrderItem::whereIn('order_id', $vendorOrderIds)->where('status', 'Cancelled')->count(),
                'completed'  => OrderItem::whereIn('order_id', $vendorOrderIds)->where('status', 'Completed')->count(),
            ];

            // ✅ Chart Data: monthly order count for this vendor
            $chartData = Order::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
                ->whereIn('id', $vendorOrderIds)
                ->groupBy('month')
                ->pluck('total', 'month')
                ->toArray();

            // Fill missing months with zeros
            $chartData = array_replace(array_fill(1, 12, 0), $chartData);
            $chartData = array_values($chartData);

            return view('backend.superadmin.vendor.dashboard', compact(
                'vendor',
                'vendorDetail',
                'products',
                'productVariants',
                'reviewCount',
                'newNotificationCount',
                'statusCounts',
                'chartData'
            ));
        }




        return abort(403, 'Unauthorized access.');
    }
}
