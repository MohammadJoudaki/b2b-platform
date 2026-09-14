{{-- resources/views/layouts/guest.blade.php --}}
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'هامسان ساز بازار') }}</title>

    {{-- Tailwind CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    {{-- Vazirmatn Font --}}
    <link href="https://cdn.jsdelivr.net/gh/rastikerdar/vazirmatn@v33.003/Vazirmatn-font-face.css" rel="stylesheet" type="text/css" />

    <style>
        * {
            font-family: 'Vazirmatn', Tahoma, sans-serif;
        }
        body {
            background: linear-gradient(135deg, #0a0e1a 0%, #121828 100%);
            min-height: 100vh;
        }
        .gold-gradient {
            background: linear-gradient(135deg, #d4a847, #f0d080);
        }
        .gold-text {
            color: #d4a847;
        }
        .auth-card {
            background: #121828;
            border: 1px solid rgba(212, 168, 71, 0.2);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
        }
        .auth-input {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(212, 168, 71, 0.2);
            color: #ffffff;
            transition: all 0.3s;
        }
        .auth-input:focus {
            border-color: #d4a847;
            box-shadow: 0 0 0 3px rgba(212, 168, 71, 0.1);
            background: rgba(255, 255, 255, 0.05);
            outline: none;
        }
        .auth-input::placeholder {
            color: #4a5568;
        }
        .auth-btn {
            background: linear-gradient(135deg, #d4a847, #f0d080);
            color: #0a0e1a;
            transition: all 0.3s;
        }
        .auth-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(212, 168, 71, 0.4);
        }
        .gold-divider {
            height: 2px;
            background: linear-gradient(90deg, transparent, #d4a847, transparent);
        }
    </style>
</head>
<body class="antialiased">
    <div class="min-h-screen flex flex-col justify-center items-center py-8 px-4">

        {{-- لوگو و عنوان --}}
        <div class="text-center mb-8">
            <!-- <div class="inline-flex items-center justify-center w-20 h-20 rounded-2xl gold-gradient mb-4 shadow-2xl">
                <i class="fas fa-music text-3xl text-gray-900"></i>
            </div> -->
            <h1 class="text-2xl font-bold gold-text mb-1">هامسان ساز بازار</h1>
            <p class="text-gray-500 text-sm">پلتفرم تخصصی تجارت B2B</p>
        </div>

        {{-- کارت Auth --}}
        <div class="auth-card w-full max-w-md rounded-2xl px-8 py-8">
            {{ $slot }}
        </div>

        {{-- فوتر --}}
        <p class="mt-8 text-xs text-gray-600">
            © {{ date('Y') }} هامسان ساز بازار — تمامی حقوق محفوظ است
        </p>
    </div>
</body>
</html>
