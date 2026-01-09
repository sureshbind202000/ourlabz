<?php

namespace App\Http\Controllers\Backend\Agreement;

use App\Http\Controllers\Controller;
use App\Models\Agreement;
use App\Models\AgreementSignature;
use App\Models\AgreementTarget;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class AgreementSignatureController extends Controller
{
    // Show all agreements
    public function index()
    {
        return view('backend.superadmin.agreements.sign_index');
    }

    public function list()
    {
        $user = Auth::user();

        $roleTargetMap = [
            2 => 'lab',
            3 => 'doctor',
            5 => 'vendor',
        ];

        $targetType = $roleTargetMap[$user->role] ?? null;

        if (!$targetType) {
            $agreements = collect();
        } else {
            $agreements = Agreement::with(['targets', 'creator', 'signatures'])
                ->where('status', 'active')
                ->where(function ($q) use ($user, $targetType) {
                    $q->where('target_type', 'all') // everyone
                        ->orWhereHas('targets', function ($query) use ($user) {
                            $query->where('target_id', $user->id); // specific users
                        })
                        ->orWhereHas('targets', function ($query) use ($targetType) {
                            $query->where('target_id', 'all') // all users of this role
                                ->where('target_type', $targetType);
                        });
                })
                ->latest()
                ->get();
        }

        $data = $agreements->map(function ($agreement) use ($user) {
            $signedByUser = $agreement->signatures->contains('user_id', $user->id);

            return [
                'id' => $agreement->id,
                'title' => ucwords($agreement->title),
                'status' => ucfirst($agreement->status),
                'date' => $agreement->created_at->format('d M Y'),
                'createdBy' => $agreement->creator ? $agreement->creator->name : 'N/A',
                'signed' => $signedByUser ? 'Signed' : 'Pending'
            ];
        });

        return response()->json($data);
    }





   public function show($id)
{
    $user = Auth::user();

    // Map user role to target_type
    $roleMap = [
        2 => 'lab',
        3 => 'doctor',
        5 => 'vendor',
    ];
    $userTargetType = $roleMap[$user->role] ?? null;

    // Fetch agreement for the user
    $agreement = Agreement::with(['targets.user', 'signatures.user'])
        ->where('id', $id)
        ->where(function ($query) use ($user, $userTargetType) {
            $query->where('target_type', 'all') // everyone can view
                ->orWhereHas('targets', function ($targetQuery) use ($user) {
                    // specific users
                    $targetQuery->where('target_id', $user->id);
                })
                ->orWhereHas('targets', function ($targetQuery) use ($userTargetType) {
                    // all users of a role
                    $targetQuery->where('target_type', $userTargetType)
                        ->where('target_id', 'all');
                });
        })
        ->firstOrFail();

    // Prepare targets data
    $targets = $agreement->targets->map(function ($t) {
        return [
            'id' => $t->target_id,
            'name' => $t->user ? $t->user->name . ' (ID: ' . $t->user->user_id . ')' : $t->target_id
        ];
    });

    // Prepare only the authenticated user's signature
    $authSignature = $agreement->signatures
        ->where('user_id', $user->id)
        ->map(function ($s) {
            return [
                'user_id' => $s->user_id,
                'user_name' => $s->user ? $s->user->name : 'Unknown',
                'signed_at' => $s->signed_at ? \Carbon\Carbon::parse($s->signed_at)->format('d F Y h:i A') : '-',
                'signature' => $s->signature
            ];
        })
        ->first(); // only one signature or null

    return response()->json([
        'agreement' => [
            'id' => $agreement->id,
            'title' => ucwords($agreement->title),
            'description' => $agreement->description,
            'status' => ucwords($agreement->status),
            'activated_at' => $agreement->activated_at ? \Carbon\Carbon::parse($agreement->activated_at)->format('d F Y') : '-',
            'created_by' => $agreement->creator ? ucwords($agreement->creator->name) : 'Unknown',
            'created_at' => $agreement->created_at ? $agreement->created_at->format('d F Y') : '-',
            'updated_by' => $agreement->updater ? ucwords($agreement->updater->name) : '-',
            'updated_at' => $agreement->updated_at ? $agreement->updated_at->format('d F Y') : '-',
            'signature' => $authSignature // only auth user signature
        ]
    ]);
}





    public function signAgreement(Request $request, $id)
    {
        $request->validate([
            'signature' => 'required'
        ]);

        $user = Auth::user();

        $agreement = Agreement::findOrFail($id);

        // Allow signing if:
        // 1) target_type is 'all' OR
        // 2) user is a target in AgreementTarget
        if ($agreement->target_type !== 'all') {
            $isTarget = AgreementTarget::where('agreement_id', $id)
                ->where('target_id', $user->id)
                ->exists();

            if (!$isTarget) {
                return response()->json(['message' => 'You are not authorized to sign this agreement.'], 403);
            }
        }

        // Prepare folder
        $folderPath = public_path('signatures');
        if (!File::exists($folderPath)) {
            File::makeDirectory($folderPath, 0777, true);
        }

        // Decode image
        $imageData = str_replace(['data:image/png;base64,', ' '], ['', '+'], $request->signature);
        $fileName = uniqid('sign_') . '.png';
        $filePath = $folderPath . '/' . $fileName;
        File::put($filePath, base64_decode($imageData));

        // Save to DB
        $publicPath = 'signatures/' . $fileName;

        AgreementSignature::updateOrCreate(
            [
                'agreement_id' => $id,
                'user_id' => $user->id,
            ],
            [
                'signature' => $publicPath,
                'signed_at' => now(),
                'ip_address' => $request->ip(),
                'sign_lat' => $request->input('sign_lat'),
                'sign_long' => $request->input('sign_long'),
            ]
        );

        return response()->json(['message' => 'Signature saved successfully!']);
    }
}
