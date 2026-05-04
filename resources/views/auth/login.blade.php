<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <style>
        body {
            margin: 0;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: Arial;

            background: url("{{ asset('images/bg.jpg') }}") no-repeat center center;
            background-size: cover;
            position: relative;
        }

        /* 🔥 overlay على الباكجروند */
        body::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.55);
            backdrop-filter: blur(3px);
        }

        .login-box {
            position: relative;
            width: 420px;
            background: rgba(255, 255, 255, 0.95);
            padding: 35px;
            border-radius: 16px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.4);
            z-index: 2;
        }

        /* 🔥 اللوجو أكبر */
        .logo-box {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo-box img {
            width: 140px;
        }

        .form-control {
            height: 48px;
            border-radius: 10px;
        }

        .btn-login {
            width: 100%;
            height: 48px;
            border-radius: 10px;
            background: #0d6efd;
            color: white;
            font-weight: bold;
            font-size: 16px;
        }

        .btn-login:hover {
            background: #084298;
        }

        .icon {
            position: absolute;
            margin-left: 12px;
            margin-top: 14px;
            color: #888;
        }

        .input-group {
            position: relative;
        }

        .input-group input {
            padding-left: 40px;
        }

        .error {
            color: red;
            font-size: 14px;
            text-align: center;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>

    <div class="login-box">

        @if($errors->any())
            <div class="error">{{ $errors->first() }}</div>
        @endif

        <!-- 🔥 Logo كبير -->
     <div class="logo-box">
    <img src="{{ asset('images/logo.png') }}" alt="Logo">

    <!-- اسم السيستم -->
    <h5 class="system-name">EduTrack-System</h5>
</div>

        <form method="POST" action="/login">
            @csrf

            <!-- Username -->
            <div class="mb-3 input-group">
                <i class="fas fa-user icon"></i>
                <input type="text" name="username" class="form-control" placeholder="Username">
            </div>

            <!-- Password -->
            <div class="mb-3 input-group">
                <i class="fas fa-lock icon"></i>
                <input type="password" name="password" class="form-control" placeholder="Password">
            </div>

            <button type="submit" class="btn btn-login">
                Login
            </button>
        </form>

    </div>

</body>

</html>