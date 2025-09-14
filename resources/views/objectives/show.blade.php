@extends('layouts.user')

@section('title', 'Objectives - Candidat.Who?')

@section('content')
<div class="container">
    <!-- Page Header -->
    <div class="text-center mb-5">
        <h1 class="fw-bold text-primary">Our Objectives</h1>
        <p class="text-muted">
            Learn more about the goals and mission of Candidat.Who? in promoting transparency and awareness.
        </p>
    </div>

    <!-- Objectives Cards -->
    <div class="row g-4">
        <div class="col-md-6">
            <div class="card shadow-sm h-100 border-0">
                <div class="card-body">
                    <h5 class="card-title fw-bold">Promote Informed Voting</h5>
                    <p class="card-text">
                        Provide accurate and accessible information about candidates and officials, helping citizens make 
                        well-informed decisions during elections.
                    </p>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card shadow-sm h-100 border-0">
                <div class="card-body">
                    <h5 class="card-title fw-bold">Increase Transparency</h5>
                    <p class="card-text">
                        Foster transparency in local governance by showcasing candidates’ profiles, platforms, and achievements.
                    </p>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card shadow-sm h-100 border-0">
                <div class="card-body">
                    <h5 class="card-title fw-bold">Encourage Civic Engagement</h5>
                    <p class="card-text">
                        Motivate the community to actively participate in discussions and decision-making processes that affect the barangay.
                    </p>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card shadow-sm h-100 border-0">
                <div class="card-body">
                    <h5 class="card-title fw-bold">Support Democratic Processes</h5>
                    <p class="card-text">
                        Uphold democratic values by ensuring that every voter has the resources needed to understand their choices.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Closing Statement -->
    <div class="mt-5 p-4 bg-primary text-white border rounded text-center">
        <h4 class="fw-bold">Together, let's build a stronger community.</h4>
        <p class="mb-0">
            Your participation is the foundation of a better future for our barangay.
        </p>
    </div>
</div>
@endsection