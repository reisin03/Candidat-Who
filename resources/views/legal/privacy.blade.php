@extends('layouts.guest')
@section('title', 'Privacy Policy')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-shield-alt me-2"></i>Privacy Policy</h4>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-muted">Last updated: {{ now()->format('F j, Y') }}</small>
                    </div>

                    <h5>1. Information We Collect</h5>
                    <p>We collect information you provide directly to us, such as when you register for an account, submit feedback, or contact us for support. This includes:</p>
                    <ul>
                        <li>Personal information (name, email address)</li>
                        <li>Identification documents for verification purposes</li>
                        <li>Profile pictures and other uploaded content</li>
                        <li>Feedback and comments you submit</li>
                    </ul>

                    <h5>2. How We Use Your Information</h5>
                    <p>We use the information we collect to:</p>
                    <ul>
                        <li>Verify your identity and maintain account security</li>
                        <li>Provide and improve our services</li>
                        <li>Communicate with you about your account and our services</li>
                        <li>Moderate content and ensure compliance with our terms</li>
                        <li>Respond to your feedback and support requests</li>
                    </ul>

                    <h5>3. Information Sharing and Disclosure</h5>
                    <p>We do not sell, trade, or otherwise transfer your personal information to third parties without your consent, except as described in this policy:</p>
                    <ul>
                        <li>With service providers who assist us in operating our platform</li>
                        <li>When required by law or to protect our rights</li>
                        <li>In connection with a business transfer or merger</li>
                        <li>Publicly available information about officials and candidates</li>
                    </ul>

                    <h5>4. Data Security</h5>
                    <p>We implement appropriate technical and organizational measures to protect your personal information against unauthorized access, alteration, disclosure, or destruction. However, no method of transmission over the internet is 100% secure.</p>

                    <h5>5. Data Retention</h5>
                    <p>We retain your personal information for as long as necessary to provide our services and fulfill the purposes outlined in this policy, unless a longer retention period is required by law.</p>

                    <h5>6. Your Rights</h5>
                    <p>You have the right to:</p>
                    <ul>
                        <li>Access and update your personal information</li>
                        <li>Request deletion of your account and associated data</li>
                        <li>Object to or restrict certain processing of your information</li>
                        <li>Data portability for information you have provided</li>
                    </ul>

                    <h5>7. Cookies and Tracking</h5>
                    <p>We may use cookies and similar technologies to enhance your experience on our platform, remember your preferences, and analyze site usage.</p>

                    <h5>8. Third-Party Links</h5>
                    <p>Our platform may contain links to third-party websites. We are not responsible for the privacy practices of these external sites.</p>

                    <h5>9. Children's Privacy</h5>
                    <p>Our services are not intended for children under 13. We do not knowingly collect personal information from children under 13.</p>

                    <h5>10. Changes to This Policy</h5>
                    <p>We may update this privacy policy from time to time. We will notify you of any material changes by posting the new policy on this page.</p>

                    <h5>11. Contact Us</h5>
                    <p>If you have any questions about this privacy policy, please contact us through the feedback system or system administrator.</p>

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