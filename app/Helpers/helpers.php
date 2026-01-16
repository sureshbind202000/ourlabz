<?php



use App\Models\Booking;

use App\Models\DoctorConsultationLog;

use App\Models\Module;

use App\Models\NotificationMessage;

use App\Models\Payment;

use App\Models\TrackBookingLog;

use Illuminate\Support\Facades\Auth;

use App\Models\User;

use App\Models\Coupon;

use Carbon\Carbon;

use App\Models\UserModulePermission;

use App\Notifications\UserNotification;

use Illuminate\Support\HtmlString;

use Illuminate\Support\Str;



// Notification Helper

if (!function_exists('sendNotification')) {

    /**

     * Send a notification using templates (from notification_messages table).

     *

     * @param int|array|null $userIds  Single user ID, array of IDs, or null (Auth user)

     * @param string $notificationFor  Template key (e.g. 'lab-registration')

     * @param array $params            Dynamic replacements ['lab_name' => 'XYZ Lab']

     * @return void

     */

    //     function sendNotification($userIds = null, string $notificationFor, array $params = [])

    //     {

    //         $template = NotificationMessage::where('slug', $notificationFor)->first();

    //         if (!$template) {

    //             return;
//         }



    //         // Replace placeholders dynamically

    //         $message = $template->message;

    //         foreach ($params as $key => $value) {

    //             $message = str_replace('{{' . $key . '}}', $value, $message);
//         }



    //         $userIds = $userIds ?? Auth::id();

    //         $userIds = is_array($userIds) ? $userIds : [$userIds];



    //         $users = User::whereIn('id', $userIds)->get();



    //         foreach ($users as $user) {

    //             $user->notify(new UserNotification($message, $template->link));
//         }
//     }


    /**
     * Send notification with optional custom URL
     *
     * @param int|array|null $userIds
     * @param string $notificationFor
     * @param array $params
     * @param string|null $customUrl
     */
    function sendNotification(
        $userIds = null,
        string $notificationFor,
        array $params = [],
        string $customUrl = null
    ) {
        $template = NotificationMessage::where('slug', $notificationFor)->first();
        if (!$template) {
            return;
        }

        $userIds = $userIds ?? Auth::id();
        $userIds = is_array($userIds) ? $userIds : [$userIds];

        $users = User::whereIn('id', $userIds)->get();

        foreach ($users as $user) {

            // Auto inject user_id if not present
            $params['user_id'] = $params['user_id'] ?? $user->id;

            /* ---------------- MESSAGE ---------------- */
            $message = $template->message;
            foreach ($params as $key => $value) {
                $message = str_replace('{{' . $key . '}}', $value, $message);
            }

            /* ---------------- LINK ---------------- */
            // Priority:
            // 1️⃣ Custom URL (if provided)
            // 2️⃣ Template URL
            $link = $customUrl ?? $template->link;

            // Replace placeholders in link
            if ($link) {
                foreach ($params as $key => $value) {
                    $link = str_replace('{{' . $key . '}}', $value, $link);
                }
            }

            $user->notify(new UserNotification($message, $link));
        }
    }

}

function getBookingStatusBadge($status)
{

    switch ($status) {

        case 'Pending':

            return new HtmlString('<span class="badge badge-subtle-warning text-dark">Pending</span>');

        case 'Confirmed':

            return new HtmlString('<span class="badge badge-subtle-success">Confirmed</span>');

        case 'Cancelled':

            return new HtmlString('<span class="badge badge-subtle-danger">Cancelled</span>');

        case 'Completed':

            return new HtmlString('<span class="badge badge-subtle-success">Completed</span>');

        case 'In Progress':
            return new HtmlString('<span class="badge badge-subtle-info">In Progress</span>');

        default:

            return new HtmlString('<span class="badge badge-subtle-secondary">Unknown</span>');
    }
}



function getPaymentBadge($paymentStatus)
{

    switch ($paymentStatus) {

        case 'Paid':

            return new HtmlString('<span class="badge badge-subtle-success">Paid</span>');

        case 'Unpaid':

            return new HtmlString('<span class="badge badge-subtle-danger">Unpaid</span>');

        case 'Partial':

            return new HtmlString('<span class="badge badge-subtle-warning text-dark">Partially Paid</span>');

        default:

            return new HtmlString('<span class="badge badge-subtle-secondary">Unknown</span>');
    }
}



function getSampleStatus($status)
{

    switch ($status) {

        case 0:

            return new HtmlString('<span class="badge badge-subtle-warning text-dark">Not Collected</span>');

        case 1:

            return new HtmlString('<span class="badge badge-subtle-info">Collected</span>');

        case 2:

            return new HtmlString('<span class="badge badge-subtle-success">Submitted</span>');

        case 3:

            return new HtmlString('<span class="badge badge-subtle-success">Accepted</span>');

        case 4:

            return new HtmlString('<span class="badge badge-subtle-danger">Rejected</span>');

        case 5:

            return new HtmlString('<span class="badge badge-subtle-danger">Collection Rejected By Phlebotomist</span>');

        default:

            return new HtmlString('<span class="badge badge-subtle-secondary">Unknown</span>');
    }
}



function logBookingActivity($booking_id, $action, $description = null)
{

    TrackBookingLog::create([

        'booking_id' => $booking_id,

        'action' => $action,

        'description' => $description,

        'performed_by' => auth()->id(),

    ]);
}



if (!function_exists('formatCount')) {

    function formatCount($number)
    {

        return $number >= 1000 ? number_format($number / 1000, 1) . 'k' : $number;
    }
}



function generateUniqueOrderId(): string
{

    do {

        $bookingDate = now()->format('Ymd');

        $randomString = strtoupper(Str::random(6));

        $orderId = "ORD-{$bookingDate}-{$randomString}";
    } while (Booking::where('order_id', $orderId)->exists());



    return $orderId;
}





function generateDoctorBookingOrderId(): string
{

    do {

        $bookingDate = now()->format('Ymd');

        $randomString = strtoupper(Str::random(6));

        $orderId = "ORD-{$bookingDate}-{$randomString}";
    } while (Payment::where('order_id', $orderId)->exists());



    return $orderId;
}



function logConsultationActivity($consultation_id, $user_id, $action, $description = null)
{
    // Get the latest log for this consultation
    $lastLog = \App\Models\DoctorConsultationLog::where('consultation_id', $consultation_id)
        ->latest()
        ->first();

    // Only create a new log if the last action is different
    if (!$lastLog || $lastLog->action !== $action) {
        \App\Models\DoctorConsultationLog::create([
            'consultation_id' => $consultation_id,
            'user_id' => $user_id,
            'action' => $action,
            'description' => $description,
        ]);
    }
}




if (!function_exists('has_permission')) {

    function has_permission($slug, $type = 'view', $role_id = null)
    {

        if (!auth()->check())
            return false;



        $user = auth()->user();

        $userId = $user->id;



        // Use the provided role_id or fallback to the user's role

        $roleId = $role_id ?? $user->role;



        // Find the module with slug and role (in case multiple same slugs for different roles)

        $module = Module::where('slug', $slug)

            ->where('role_id', $roleId)

            ->first();



        if (!$module)
            return false;



        $permission = UserModulePermission::where('user_id', $userId)

            ->where('module_id', $module->id)

            ->first();



        if (!$permission)
            return false;



        return match ($type) {

            'view' => $permission->can_view,

            'create' => $permission->can_create,

            'edit' => $permission->can_edit,

            'delete' => $permission->can_delete,

            default => false,
        };
    }
}

// Coupon Function
if (!function_exists('getActiveCoupons')) {

    /**
     * Get active coupons filtered by multiple "Applicable For" types and optional limit per type.
     *
     * @param array $types Example: ['products', 'lab_tests', 'doctors']
     * @param int|null $limit Limit total number of coupons
     * @param bool $random Whether to pick coupons randomly
     * @return \Illuminate\Database\Eloquent\Collection
     */
    function getActiveCoupons(array $types = [], $limit = null, bool $random = false)
    {
        $now = Carbon::now();

        $coupons = Coupon::query()
            ->where('is_active', 1)
            ->where(function ($query) use ($now) {
                $query->whereNull('start_date')->orWhere('start_date', '<=', $now);
            })
            ->where(function ($query) use ($now) {
                $query->whereNull('end_date')->orWhere('end_date', '>=', $now);
            });

        // Filter by multiple applicable types
        if (!empty($types)) {
            $coupons->where(function ($q) use ($types) {
                foreach ($types as $type) {
                    switch ($type) {
                        case 'products':
                            $q->orWhere('for_products', 1);
                            break;
                        case 'lab_tests':
                            $q->orWhere('for_lab_tests', 1);
                            break;
                        case 'doctors':
                            $q->orWhere('for_doctors', 1);
                            break;
                    }
                }
            });
        }

        // Apply random ordering if requested
        if ($random) {
            $coupons->inRandomOrder();
        } else {
            $coupons->orderBy('created_at', 'desc');
        }

        // Apply limit if set
        if ($limit) {
            $coupons->limit($limit);
        }

        return $coupons->get();
    }
}
