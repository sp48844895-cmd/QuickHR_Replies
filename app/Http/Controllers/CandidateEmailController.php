<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\CandidateResponseMail;

class CandidateEmailController extends Controller
{
    /**
     * Display the form for sending candidate emails
     */
    public function index()
    {
        return view('candidate-form');
    }

    /**
     * Preview the email before sending
     */
    public function preview(Request $request)
    {
        $validated = $request->validate([
            'status' => 'required|in:selected,rejected',
            'candidate_name' => 'required|string|max:255',
            'candidate_email' => 'required|email',
            'position' => 'required|string|max:255',
        ]);

        $preview = true;
        $subject = $validated['status'] === 'selected' 
            ? 'Congratulations! You have been selected'
            : 'Thank you for your application';

        return view('candidate-form', compact('validated', 'preview', 'subject'));
    }

    /**
     * Send the email to the candidate
     */
    public function send(Request $request)
    {
        $validated = $request->validate([
            'status' => 'required|in:selected,rejected',
            'candidate_name' => 'required|string|max:255',
            'candidate_email' => 'required|email',
            'position' => 'required|string|max:255',
        ]);

        try {
            // Send email using the Mailable class
            Mail::to($validated['candidate_email'])
                ->send(new CandidateResponseMail(
                    $validated['status'],
                    $validated['candidate_name'],
                    $validated['position']
                ));

            return redirect()
                ->route('candidate.form')
                ->with('success', 'Email sent successfully to ' . $validated['candidate_email']);
        } catch (\Exception $e) {
            return redirect()
                ->route('candidate.form')
                ->withInput()
                ->with('error', 'Failed to send email: ' . $e->getMessage());
        }
    }
}

