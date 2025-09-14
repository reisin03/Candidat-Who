@extends('layouts.app')

@section('title', 'Feedback & Poll')

@section('content')
<div class="container mt-5">
    <h2>Submit Your Feedback</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('feedback.store') }}" method="POST">
        @csrf

        <!-- Subject -->
        <div class="mb-3">
            <label for="subject" class="form-label">Subject (optional)</label>
            <input type="text" class="form-control" id="subject" name="subject" value="{{ old('subject') }}">
        </div>

        <!-- Message -->
        <div class="mb-3">
            <label for="message" class="form-label">Message</label>
            <textarea class="form-control" id="message" name="message" rows="4" required>{{ old('message') }}</textarea>
        </div>

        <!-- Rating -->
        <div class="mb-3">
            <label class="form-label">Rating (optional)</label>
            <select class="form-select" name="rating">
                <option value="">Select rating</option>
                @for ($i = 1; $i <= 5; $i++)
                    <option value="{{ $i }}" {{ old('rating') == $i ? 'selected' : '' }}>{{ $i }}</option>
                @endfor
            </select>
        </div>

        <!-- Poll -->
        @if($polls->count())
        <div class="mb-3">
            <label class="form-label">Poll (optional)</label>
            @foreach($polls as $poll)
                <p class="fw-bold">{{ $poll->question }}</p>
                @foreach($poll->options as $option)
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="poll_option_id" id="option{{ $option->id }}" value="{{ $option->id }}" {{ old('poll_option_id') == $option->id ? 'checked' : '' }}>
                        <label class="form-check-label" for="option{{ $option->id }}">{{ $option->option_text }}</label>
                    </div>
                @endforeach
            @endforeach
        </div>
        @endif

        <button type="submit" class="btn btn-primary">Submit Feedback</button>
    </form>
</div>
@endsection
