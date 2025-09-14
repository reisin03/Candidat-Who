@extends('layouts.guest')
@section('title', 'Terms and Conditions')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-file-contract me-2"></i>Terms and Conditions</h4>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-muted">Last updated: {{ now()->format('F j, Y') }}</small>
                    </div>

                    <h5>1. Acceptance of Terms</h5>
                    <p>By registering for and using CandidatWho, you agree to be bound by these Terms and Conditions. If you do not agree to these terms, please do not use our service.</p>

                    <h5>2. Service Description</h5>
                    <p>CandidatWho is a platform designed to provide information about barangay officials, running candidates, and SK (Sangguniang Kabataan) officials. The platform allows users to view official profiles, provide feedback, and stay informed about local governance.</p>

                    <h5>3. User Registration and Verification</h5>
                    <ul>
                        <li>Users must provide accurate and truthful information during registration</li>
                        <li>A valid government-issued ID must be submitted for verification</li>
                        <li>Account access is granted only after admin verification and approval</li>
                        <li>Users are responsible for maintaining the confidentiality of their account credentials</li>
                        <li>False information or fraudulent documents may result in account termination</li>
                    </ul>

                    <h5>4. Acceptable Use</h5>
                    <ul>
                        <li>Users must not post offensive, defamatory, or inappropriate content</li>
                        <li>Respect the privacy and dignity of officials and other users</li>
                        <li>Do not attempt to circumvent security measures or verification processes</li>
                        <li>Use the platform only for its intended purpose of civic engagement</li>
                    </ul>

                    <h5>5. Privacy and Data Protection</h5>
                    <p>Your personal information and uploaded documents are handled according to our <a href="{{ route('legal.privacy') }}" target="_blank">Privacy Policy</a>. We implement appropriate security measures to protect your data and use it only for verification and platform functionality.</p>

                    <h5>6. Feedback and Content</h5>
                    <ul>
                        <li>Feedback should be constructive and relevant to official performance</li>
                        <li>We reserve the right to moderate and remove inappropriate content</li>
                        <li>Users are responsible for the content they submit</li>
                    </ul>

                    <h5>7. Account Termination</h5>
                    <p>We reserve the right to suspend or terminate accounts that violate these terms, provide false information, or engage in inappropriate behavior.</p>

                    <h5>8. Limitation of Liability</h5>
                    <p>CandidatWho is provided "as is" without warranties. We are not liable for any damages arising from the use of our platform.</p>

                    <h5>9. Changes to Terms</h5>
                    <p>We may update these terms periodically. Continued use of the platform constitutes acceptance of any changes.</p>

                    <h5>10. Contact Information</h5>
                    <p>For questions about these terms, please contact the system administrator through the feedback system.</p>

                    <div class="text-center mt-4">
                        <a href="{{ route('user.register') }}" class="btn btn-primary me-2">
                            <i class="fas fa-arrow-left me-1"></i>Back to Registration
                        </a>
                        <button onclick="window.close()" class="btn btn-secondary">
                            <i class="fas fa-times me-1"></i>Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection