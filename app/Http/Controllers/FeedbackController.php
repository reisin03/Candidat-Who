<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;
use App\Models\Poll;
use App\Models\PollOption;

class FeedbackController extends Controller
{
    // Show all feedback (for admin)
    public function index()
    {
        $feedbacks = Feedback::with(['user', 'feedbackable'])->latest()->paginate(20);
        return view('admin.feedback.index', compact('feedbacks'));
    }

    // Show feedback form
    public function create()
    {
        $polls = Poll::with('options')->get(); // Load polls with their options
        return view('feedback.create', compact('polls'));
    }

    // Store feedback
    public function store(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
            'subject' => 'nullable|string|max:255',
            'rating'  => 'nullable|integer|min:1|max:5',
            'poll_option_id' => 'nullable|exists:poll_options,id',
        ]);

        // Save feedback
        Feedback::create([
            'user_id' => auth()->check() ? auth()->id() : null, // Allow anonymous feedback
            'feedbackable_type' => $request->feedbackable_type, // e.g., Official::class
            'feedbackable_id'   => $request->feedbackable_id,   // the official's ID
            'subject'           => $request->subject,
            'message'           => $request->message,
            'rating'            => $request->rating,
            'poll_option_id'    => $request->poll_option_id, // optional
        ]);

        // Handle poll vote if selected
        if ($request->poll_option_id) {
            $option = PollOption::find($request->poll_option_id);
            $option->increment('votes'); // Increase vote count by 1
        }

        return redirect()->back()->with('success', 'Thank you for your feedback!');
    }
}
