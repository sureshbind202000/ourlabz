<?php

namespace App\Http\Controllers\Backend\Agreement;

use App\Http\Controllers\Controller;
use App\Models\Agreement;
use App\Models\AgreementTarget;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\ValidationException;

class AgreementController extends Controller
{
    // Show all agreements
    public function index()
    {
        return view('backend.superadmin.agreements.index');
    }

    // Store Agreement
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            // ✅ Validate input
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'agreement_type' => 'required|in:policy,commission,general',
                'target_type' => 'required|in:all,vendor,doctor',
                'target_ids' => 'nullable|array',
            ]);

            // ✅ Create Agreement
            $agreement = Agreement::create([
                'title' => $validated['title'],
                'description' => $validated['description'] ?? null,
                'agreement_type' => $validated['agreement_type'],
                'target_type' => $validated['target_type'],
                'status' => $request->status,
                'created_by' => Auth::id(),
            ]);

            // ✅ Create related targets
            if ($validated['target_type'] !== 'all' && !empty($validated['target_ids'])) {
                foreach ($validated['target_ids'] as $targetId) {
                    AgreementTarget::create([
                        'agreement_id' => $agreement->id,
                        'target_id' => $targetId,
                        'commission_on' => $request->commission_on ?? null,
                        'commission_type' => $request->commission_type ?? null,
                        'commission' => $request->commission ?? null,
                    ]);
                }
            }

            DB::commit();

            return response()->json([
                'success' => 'Agreement created successfully!',
                'data' => $agreement
            ]);
        } catch (ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Validation failed!',
                'message' => $e->validator->errors()->first()
            ], 422);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Something went wrong!',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getUsers($type)
    {
        $users = collect();

        switch ($type) {
            case 'vendor':
                $users = User::where('role', 5)->select('id', 'name', 'user_id')->get();
                break;
            case 'doctor':
                $users = User::where('role', 3)->select('id', 'name', 'user_id')->get();
                break;
            case 'lab':
                $users = User::where('role', 2)->select('id', 'name', 'user_id')->get();
                break;
        }

        return response()->json($users);
    }

    public function list()
    {
        $agreements = Agreement::with('creator')->latest()->get();

        $data = $agreements->map(function ($agreement, $index) {
            return [
                'id' => $agreement->id,
                'title' => $agreement->title,
                'type' => ucfirst($agreement->agreement_type),
                'target' => ucfirst($agreement->target_type),
                'status' => ucfirst($agreement->status),
                'date' => $agreement->created_at->format('d M Y'),
                'createdBy' => $agreement->creator ? $agreement->creator->name : 'N/A',
            ];
        });

        return response()->json($data);
    }

    // Edit Agreement
    public function edit($id)
    {
        // Fetch agreement with targets
        $agreement = Agreement::with('targets')->findOrFail($id);

        // Get target_ids as array
        $targetIds = $agreement->targets->pluck('target_id')->toArray();

        $commissionData = null;
        if ($agreement->target_type === 'vendor' && $agreement->targets->count() > 0) {
            $firstTarget = $agreement->targets->first();
            $commissionData = [
                'commission_on'   => $firstTarget->commission_on,
                'commission_type' => $firstTarget->commission_type,
                'commission'      => $firstTarget->commission,
            ];
        }

        return response()->json([
            'agreement' => [
                'id' => $agreement->id,
                'title' => $agreement->title,
                'description' => $agreement->description,
                'agreement_type' => $agreement->agreement_type,
                'target_type' => $agreement->target_type,
                'status' => $agreement->status,
                'target_ids' => $targetIds,
                'commission' => $commissionData
            ]
        ]);
    }

    // Update Agreement
    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'agreement_type' => 'required|in:policy,commission,general',
                'target_type' => 'required|in:all,vendor,doctor,lab',
                'target_ids' => 'nullable|array',
                'status' => 'required|in:draft,active',
            ]);

            $agreement = Agreement::findOrFail($id);
            $activated_at = null;
            if ($validated['status'] == 'active') {
                $activated_at = now();
            }

            $agreement->update([
                'title' => $validated['title'],
                'description' => $validated['description'] ?? null,
                'agreement_type' => $validated['agreement_type'],
                'target_type' => $validated['target_type'],
                'status' => $validated['status'],
                'updated_by' => Auth::id(),
                'activated_at' => $activated_at,
            ]);

            AgreementTarget::where('agreement_id', $agreement->id)->delete();

            if ($validated['target_type'] !== 'all' && !empty($validated['target_ids'])) {
                foreach ($validated['target_ids'] as $targetId) {
                    AgreementTarget::create([
                        'agreement_id' => $agreement->id,
                        'target_id' => $targetId,
                        'commission_on' => $request->commission_on ?? null,
                        'commission_type' => $request->commission_type ?? null,
                        'commission' => $request->commission ?? null,
                    ]);
                }
            }

            DB::commit();

            return response()->json([
                'success' => 'Agreement updated successfully!',
                'data' => $agreement
            ]);
        } catch (ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Validation failed!',
                'message' => $e->validator->errors()->first()
            ], 422);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Something went wrong!',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $agreement = Agreement::with(['targets', 'signatures'])->findOrFail($id);

            // Delete related targets first
            if ($agreement->targets->count() > 0) {
                $agreement->targets()->delete();
            }

            // Delete related signature images from public folder
            if ($agreement->signatures->count() > 0) {
                foreach ($agreement->signatures as $signature) {
                    $filePath = public_path($signature->signature);
                    if (File::exists($filePath)) {
                        File::delete($filePath);
                    }
                }
                // Delete signature records from DB
                $agreement->signatures()->delete();
            }

            // Delete the agreement
            $agreement->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Agreement and related signatures deleted successfully.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Failed to delete agreement: ' . $e->getMessage()
            ], 500);
        }
    }



    public function show($id)
    {
        $agreement = Agreement::with(['targets', 'signatures.user'])->findOrFail($id);

        $targets = $agreement->targets->map(function ($t) {
            return [
                'id' => $t->target_id,
                'name' => $t->user ? $t->user->name . ' (ID: ' . $t->user->user_id . ')' : $t->target_id
            ];
        });

        $signatures = $agreement->signatures->map(function ($s) {
            return [
                'user_name' => $s->user ? $s->user->name : 'Unknown',
                'signed_at' => $s->signed_at,
                'signature' => $s->signature
            ];
        });

        return response()->json([
            'agreement' => [
                'id' => $agreement->id,
                'title' => ucwords($agreement->title),
                'description' => $agreement->description,
                'agreement_type' => ucwords($agreement->agreement_type),
                'target_type' => ucwords($agreement->target_type),
                'status' => ucwords($agreement->status),
                'activated_at' => $agreement->activated_at ? $agreement->activated_at->format('d F Y') : null,
                'created_by' => ucwords($agreement->creator->name ?? 'Unknown'),
                'created_at' => $agreement->created_at ? $agreement->created_at->format('d F Y') : null,
                'updated_by' => ucwords($agreement->updater->name ?? '-'), // assuming you have updater relation
                'updated_at' => $agreement->updated_at ? $agreement->updated_at->format('d F Y') : null,
                'targets' => $targets,
                'signatures' => $signatures
            ]
        ]);
    }
}
