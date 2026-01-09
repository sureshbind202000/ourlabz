<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\ContactInquiry;
use App\Models\Newsletter;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ContactController extends Controller
{
    // index
    public function index()
    {
        $contact = Contact::first();
        return view('backend.website.contact.list', compact('contact'));
    }

    // Update
    public function update(Request $request, $id)
    {

        DB::beginTransaction();

        try {

            $contact = Contact::findOrFail($id);

            $validated = $request->validate([
                'about'          => 'nullable|string',
                'office_address' => 'nullable|string',
                'phone'          => 'required|array',
                'phone.*'        => 'nullable|string|max:20',
                'email'          => 'required|array',
                'email.*'        => 'nullable|email|max:255',
            ]);

            $contact->about = $request->about;
            $contact->office_address = $request->office_address;
            $contact->facebook = $request->facebook;
            $contact->twitter = $request->twitter;
            $contact->linkedin = $request->linkedin;
            $contact->youtube = $request->youtube;
            $contact->map_address = $request->map_address;
            $contact->phone = array_filter($request->phone);
            $contact->email = array_filter($request->email);

            $contact->save();

            DB::commit();

            return response()->json([
                'success' => "Contact information updated successfully!",
                'data' => $contact
            ]);
        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'error' => "Failed to update contact information: " . $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        // Honeypot hidden field bot protection
        if (!empty($request->website)) {
            return response()->json(['error' => 'Bot detected'], 403);
        }

        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $inquiry = ContactInquiry::create($validated);
        $admin = User::where('role', 0)->first();
        sendNotification(
            $admin->id,
            'contact-enquiry-notification',
            [
                'name' => $inquiry->name,
                'email' => $inquiry->email,
                'subject'  => $inquiry->subject,
                'message'  => $inquiry->message,
                'date'    => Carbon::now()->format('d M Y, h:i A'),
            ]
        );

        return response()->json([
            'success' => 'Your message has been sent successfully!'
        ]);
    }

    public function enquiries()
    {
        $enquiries = ContactInquiry::orderBy('id', 'DESC')->get();
        return view('backend.website.contact.enquiry', compact('enquiries'));
    }

    public function enquiryDelete($id)
    {
        $enquiry = ContactInquiry::findOrFail($id);
        $enquiry->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Enquiry deleted successfully'
        ]);
    }

    // Newsletter Section ========================
    public function storeNewsletter(Request $request)
    {
        if (!empty($request->website)) {
            return response()->json(['error' => 'Bot detected'], 403);
        }

        $validated = $request->validate([
            'email' => 'required|email|unique:newsletters,email|max:255',
        ]);

        $newsletter = Newsletter::create([
            'email' => $request->email,
            'ip_address' => $request->ip(),
        ]);

        $admin = User::where('role', 0)->first();

        sendNotification(
            $admin->id,
            'newsletter-notification',
            [
                'email' => $newsletter->email,
                'date'  => now()->format('d M Y, h:i A'),
            ]
        );

        return response()->json([
            'success' => 'Newsletter subscribed successfully!'
        ]);
    }


    public function newsletters()
    {
        $newsletters = Newsletter::orderBy('id', 'DESC')->get();
        return view('backend.website.contact.newsletter', compact('newsletters'));
    }

    public function newsletterDelete($id)
    {
        $newsletter = Newsletter::findOrFail($id);
        $newsletter->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Newsletter email deleted successfully'
        ]);
    }
}
