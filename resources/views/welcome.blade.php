<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choose Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex align-items-center justify-content-center vh-100 bg-light">
    <div class="text-center">
        <h1 class="mb-4">Welcome to Candidat-Who</h1>
        <p class="mb-4">Please choose how you want to log in:</p>

        <div class="d-flex justify-content-center gap-3">
            <a href="{{ url('/admin/login') }}" class="btn btn-danger btn-lg px-4">Admin</a>
            <a href="{{ url('/login') }}" class="btn btn-primary btn-lg px-4">User</a>
        </div>
    </div>
</body>
</html>
