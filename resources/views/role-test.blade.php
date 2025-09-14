<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Role Test - User Type Determination</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .role-info {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
            margin: 20px 0;
        }
        .status {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 3px;
            font-weight: bold;
            margin: 5px 0;
        }
        .admin { background: #d4edda; color: #155724; }
        .user { background: #cce5ff; color: #004085; }
        .guest { background: #f8d7da; color: #721c24; }
        .authenticated { background: #d1ecf1; color: #0c5460; }
        .not-authenticated { background: #f5c6cb; color: #721c24; }
        h1 { color: #333; }
        h2 { color: #666; margin-top: 30px; }
        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #eee;
        }
        .info-row:last-child {
            border-bottom: none;
        }
        .label {
            font-weight: bold;
            color: #555;
        }
        .value {
            color: #333;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>User Role Determination Test</h1>
        
        <div class="role-info">
            <h2>Authentication Status</h2>
            <div class="info-row">
                <span class="label">Authenticated:</span>
                <span class="status {{ $roleInfo['authenticated'] ? 'authenticated' : 'not-authenticated' }}">
                    {{ $roleInfo['authenticated'] ? 'Yes' : 'No' }}
                </span>
            </div>
            
            @if($roleInfo['authenticated'])
                <div class="info-row">
                    <span class="label">Guard:</span>
                    <span class="value">{{ $roleInfo['guard'] ?? 'Unknown' }}</span>
                </div>
            @endif
        </div>

        <div class="role-info">
            <h2>User Role Information</h2>
            <div class="info-row">
                <span class="label">Is Admin:</span>
                <span class="status {{ $roleInfo['is_admin'] ? 'admin' : 'guest' }}">
                    {{ $roleInfo['is_admin'] ? 'Yes' : 'No' }}
                </span>
            </div>
            
            <div class="info-row">
                <span class="label">Is User:</span>
                <span class="status {{ $roleInfo['is_user'] ? 'user' : 'guest' }}">
                    {{ $roleInfo['is_user'] ? 'Yes' : 'No' }}
                </span>
            </div>
            
            <div class="info-row">
                <span class="label">Role:</span>
                <span class="value">{{ $roleInfo['role'] ?? 'None' }}</span>
            </div>
            
            <div class="info-row">
                <span class="label">Display Type:</span>
                <span class="status {{ strtolower($roleInfo['display_type']) }}">
                    {{ $roleInfo['display_type'] }}
                </span>
            </div>
        </div>

        @if($roleInfo['authenticated'])
            <div class="role-info">
                <h2>User Details</h2>
                <div class="info-row">
                    <span class="label">Name:</span>
                    <span class="value">{{ $roleInfo['name'] ?? 'Not available' }}</span>
                </div>
                
                <div class="info-row">
                    <span class="label">Email:</span>
                    <span class="value">{{ $roleInfo['email'] ?? 'Not available' }}</span>
                </div>
            </div>
        @endif

        <div class="role-info">
            <h2>Test Actions</h2>
            <p>You can test the role-based access by visiting these URLs:</p>
            <ul>
                <li><a href="/test-roles/admin-only">Admin Only Access</a> (requires admin role)</li>
                <li><a href="/test-roles/user-only">User Only Access</a> (requires user role)</li>
                <li><a href="/test-roles/api">API Test</a> (JSON response with role info)</li>
            </ul>
        </div>

        <div style="margin-top: 30px; text-align: center;">
            <a href="/" style="color: #007bff; text-decoration: none;">← Back to Home</a>
        </div>
    </div>
</body>
</html>