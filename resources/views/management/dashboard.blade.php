<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>œ«‘»Ê—œ „œÌ—Ì </title>
    <style>
        body { font-family: Tahoma; background: #0a0e1a; color: #fff; display: flex; align-items: center; justify-content: center; min-height: 100vh; margin: 0; }
        .card { background: #121828; border: 1px solid rgba(212, 168, 71, 0.3); border-radius: 16px; padding: 40px; text-align: center; max-width: 500px; }
        h1 { color: #d4a847; }
        p { color: #8892b0; line-height: 2; }
        .btn { display: inline-block; margin-top: 20px; background: #d4a847; color: #0a0e1a; padding: 10px 25px; border-radius: 8px; text-decoration: none; font-weight: bold; border: none; cursor: pointer; }
    </style>
</head>
<body>
    <div class="card">
        <h1>Å‰· „œÌ—Ì </h1>
        <p>ŒÊ‘ ¬„œÌœ <strong>{{ auth()->user()->getDisplayName() }}</strong></p>
        <p>‰ﬁ‘: <strong>{{ auth()->user()->role }}</strong></p>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn">Œ—ÊÃ</button>
        </form>
    </div>
</body>
</html>