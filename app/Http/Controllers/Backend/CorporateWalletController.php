<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Payment;
use App\Models\WalletHistory;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CorporateWalletController extends Controller
{
    public function getCorporateWallet()
    {
        $user = auth()->user();

        return response()->json([
            'wallet' => $user->wallet,
            'success' => true
        ]);
    }

    public function addToWallet(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1'
        ]);

        $user = auth()->user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized: Please login first.'
            ], 401);
        }

        DB::beginTransaction();

        try {
            $user->wallet = ($user->wallet ?? 0) + $request->amount;
            $user->save();

            $walletHistory = WalletHistory::create([
                'user_id'      => $user->id,
                'from_user_id' => $user->id,
                'type'         => 'credit',
                'amount'       => $request->amount,
                'description'  => 'Added to Corporate Wallet'
            ]);

            Payment::create([
                'type'           => 'Corporate Wallet',
                'subtotal'       => $request->amount,
                'coupon'         => $request->coupon ?? null,
                'discount'       => $request->discount ?? 0.00,
                'discount_type'  => $request->discount_type ?? null,
                'total'          => $request->amount,
                'order_id'       => $walletHistory->id,
                'transaction_id' => $request->razorpay_payment_id ?? null,
                'payment_status' => $request->payment_status ?? 'Paid',
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Amount added to wallet successfully.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('AddToWallet Error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'request' => $request->all()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Something went wrong while adding amount to wallet. Please try again later.'
            ]);
        }
    }

    public function addToEmployeeWallet(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1'
        ]);

        $employee = User::find($request->id);
        $corporate = auth()->user();

        if (!$employee || $employee->corporate_id != $corporate->id) {
            return response()->json(['success' => false, 'message' => 'Invalid employee']);
        }

        if ($corporate->wallet < $request->amount) {
            return response()->json(['success' => false, 'message' => 'Insufficient corporate balance']);
        }

        DB::beginTransaction();
        try {
            // Deduct from corporate
            $corporate->wallet -= $request->amount;
            $corporate->save();

            // Log debit from corporate
            WalletHistory::create([
                'user_id' => $request->id,
                'from_user_id' => $corporate->id,
                'type' => 'debit',
                'amount' => $request->amount,
                'description' => 'Transferred to employee: ' . $employee->name
            ]);

            // Credit employee
            $employee->wallet += $request->amount;
            $employee->save();

            // Log credit to employee
            WalletHistory::create([
                'user_id' => $employee->id,
                'from_user_id' => $corporate->id,
                'type' => 'credit',
                'amount' => $request->amount,
                'description' => 'Received from corporate: ' . $corporate->name
            ]);

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Amount added successfully.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Something went wrong.']);
        }
    }
    public function history(Request $request)
    {
        $userId = $request->user_id;

        $history = WalletHistory::where('user_id', $userId)->where('type', 'credit')
            ->get()
            ->map(function ($entry) {
                return [
                    'amount' => $entry->amount,
                    'type' => $entry->type,
                    'note' => $entry->description,
                    'date' => $entry->created_at->format('d M, Y h:i A'),
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $history
        ]);
    }

    public function index()
    {
        return view('backend.superadmin.corporates.wallet.index');
    }

    public function getWalletHistory(Request $request)
    {
        $userId = $request->user_id ?? auth()->id();

        $history = WalletHistory::where('user_id', $userId)->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $history
        ]);
    }
}
