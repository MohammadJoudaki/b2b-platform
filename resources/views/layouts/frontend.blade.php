{{-- resources/views/layouts/frontend.blade.php --}}
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'fa' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'هامسان ساز بازار | پلتفرم تخصصی تجارت B2B')</title>
    <meta name="description" content="@yield('description', 'پلتفرم تخصصی خرید و فروش  ')">

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    {{-- Vazirmatn Font --}}
    <link href="https://cdn.jsdelivr.net/gh/rastikerdar/vazirmatn@v33.003/Vazirmatn-font-face.css" rel="stylesheet" type="text/css" />

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Vazirmatn', Tahoma, sans-serif;
        }

        :root {
            --gold: #d4a847;
            --gold-light: #f0d080;
            --dark-bg: #0a0e1a;
            --dark-card: #121828;
            --dark-card-hover: #1a2238;
            --text-light: #ffffff;
            --text-muted: #8892b0;
            --border-gold: rgba(212, 168, 71, 0.2);
        }

        body {
            background: var(--dark-bg);
            color: var(--text-light);
            line-height: 1.7;
            overflow-x: hidden;
        }

        a { text-decoration: none; color: inherit; }
        ul { list-style: none; }
        img { max-width: 100%; display: block; }

        /* ============ Container ============ */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* ============ Navbar ============ */
        .navbar {
            background: rgba(10, 14, 26, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--border-gold);
            position: sticky;
            top: 0;
            z-index: 1000;
            padding: 15px 0;
        }

        .navbar-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 700;
            font-size: 1.2rem;
            color: var(--gold);
        }

        .navbar-brand-icon {
            width: 45px;
            height: 45px;
            border-radius: 12px;
            background: linear-gradient(135deg, var(--gold), var(--gold-light));
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--dark-bg);
            font-size: 1.3rem;
        }

        .navbar-menu {
            display: flex;
            gap: 30px;
            align-items: center;
        }

        .navbar-menu a {
            color: var(--text-muted);
            font-size: 0.9rem;
            font-weight: 500;
            transition: color 0.3s;
            position: relative;
        }

        .navbar-menu a:hover,
        .navbar-menu a.active {
            color: var(--gold);
        }

        .navbar-menu a::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            right: 0;
            height: 2px;
            background: var(--gold);
            transform: scaleX(0);
            transition: transform 0.3s;
        }

        .navbar-menu a:hover::after,
        .navbar-menu a.active::after {
            transform: scaleX(1);
        }

        .navbar-actions {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 22px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.88rem;
            cursor: pointer;
            transition: all 0.3s;
            border: none;
            font-family: inherit;
        }

        .btn-gold {
            background: linear-gradient(135deg, var(--gold), var(--gold-light));
            color: var(--dark-bg);
        }

        .btn-gold:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(212, 168, 71, 0.4);
        }

        .btn-outline {
            background: transparent;
            border: 1px solid var(--gold);
            color: var(--gold);
        }

        .btn-outline:hover {
            background: var(--gold);
            color: var(--dark-bg);
        }

        /* ============ Hero ============ */
        .hero {
            padding: 100px 0 80px;
            position: relative;
            overflow: hidden;
            background: radial-gradient(circle at 20% 30%, rgba(212, 168, 71, 0.08) 0%, transparent 50%),
                        radial-gradient(circle at 80% 70%, rgba(212, 168, 71, 0.05) 0%, transparent 50%);
        }

        .hero-content {
            max-width: 700px;
            margin: 0 auto;
            text-align: center;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(212, 168, 71, 0.1);
            border: 1px solid var(--border-gold);
            color: var(--gold);
            padding: 8px 18px;
            border-radius: 50px;
            font-size: 0.82rem;
            font-weight: 600;
            margin-bottom: 25px;
        }

        .hero-title {
            font-size: clamp(2rem, 5vw, 3.5rem);
            font-weight: 800;
            line-height: 1.3;
            margin-bottom: 20px;
            color: var(--text-light);
        }

        .hero-title .gold {
            color: var(--gold);
        }

        .hero-description {
            color: var(--text-muted);
            font-size: 1.05rem;
            line-height: 2;
            margin-bottom: 35px;
        }

        .hero-actions {
            display: flex;
            gap: 12px;
            justify-content: center;
            flex-wrap: wrap;
        }

        /* ============ Section ============ */
        .section {
            padding: 80px 0;
        }

        .section-header {
            text-align: center;
            margin-bottom: 60px;
        }

        .section-subtitle {
            color: var(--gold);
            font-size: 0.85rem;
            font-weight: 600;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-bottom: 10px;
        }

        .section-title {
            font-size: clamp(1.5rem, 3.5vw, 2.3rem);
            font-weight: 800;
            color: var(--text-light);
            margin-bottom: 15px;
        }

        .section-divider {
            width: 80px;
            height: 3px;
            background: linear-gradient(90deg, transparent, var(--gold), transparent);
            margin: 0 auto 20px;
        }

        .section-description {
            color: var(--text-muted);
            max-width: 600px;
            margin: 0 auto;
            font-size: 0.95rem;
        }

        /* ============ Services Cards ============ */
        .services-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 25px;
        }

        .service-card {
            background: var(--dark-card);
            border: 1px solid var(--border-gold);
            border-radius: 16px;
            padding: 35px 25px;
            transition: all 0.4s;
            position: relative;
            overflow: hidden;
        }

        .service-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--gold), var(--gold-light));
            transform: scaleX(0);
            transition: transform 0.4s;
        }

        .service-card:hover {
            transform: translateY(-8px);
            border-color: var(--gold);
            box-shadow: 0 20px 50px rgba(212, 168, 71, 0.15);
        }

        .service-card:hover::before {
            transform: scaleX(1);
        }

        .service-icon {
            width: 65px;
            height: 65px;
            border-radius: 16px;
            background: rgba(212, 168, 71, 0.1);
            border: 1px solid var(--border-gold);
            color: var(--gold);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.6rem;
            margin-bottom: 22px;
            transition: all 0.4s;
        }

        .service-card:hover .service-icon {
            background: var(--gold);
            color: var(--dark-bg);
            transform: scale(1.1) rotate(-8deg);
        }

        .service-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--text-light);
            margin-bottom: 12px;
            transition: color 0.3s;
        }

        .service-card:hover .service-title {
            color: var(--gold);
        }

        .service-description {
            color: var(--text-muted);
            font-size: 0.88rem;
            line-height: 1.9;
        }

        /* ============ Stats ============ */
        .stats-section {
            background: linear-gradient(135deg, rgba(212, 168, 71, 0.05), rgba(212, 168, 71, 0.02));
            border-top: 1px solid var(--border-gold);
            border-bottom: 1px solid var(--border-gold);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 30px;
        }

        .stat-item {
            text-align: center;
            padding: 20px;
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: rgba(212, 168, 71, 0.1);
            border: 1px solid var(--border-gold);
            color: var(--gold);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin: 0 auto 15px;
        }

        .stat-number {
            font-size: 2.2rem;
            font-weight: 800;
            color: var(--gold);
            margin-bottom: 8px;
        }

        .stat-label {
            color: var(--text-muted);
            font-size: 0.88rem;
        }

        /* ============ Projects ============ */
        .projects-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 25px;
        }

        .project-card {
            background: var(--dark-card);
            border: 1px solid var(--border-gold);
            border-radius: 16px;
            overflow: hidden;
            transition: all 0.4s;
        }

        .project-card:hover {
            transform: translateY(-8px);
            border-color: var(--gold);
            box-shadow: 0 20px 50px rgba(212, 168, 71, 0.15);
        }

        .project-image {
            height: 200px;
            background: linear-gradient(135deg, rgba(212, 168, 71, 0.1), rgba(212, 168, 71, 0.05));
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--gold);
            font-size: 3rem;
            position: relative;
            overflow: hidden;
        }

        .project-image::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, transparent, rgba(10, 14, 26, 0.8));
        }

        .project-image i {
            position: relative;
            z-index: 2;
        }

        .project-body {
            padding: 25px;
        }

        .project-category {
            color: var(--gold);
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 10px;
        }

        .project-title {
            font-size: 1.05rem;
            font-weight: 700;
            color: var(--text-light);
            margin-bottom: 12px;
            transition: color 0.3s;
        }

        .project-card:hover .project-title {
            color: var(--gold);
        }

        .project-description {
            color: var(--text-muted);
            font-size: 0.85rem;
            line-height: 1.8;
        }

        /* ============ Why Us ============ */
        .why-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 25px;
        }

        .why-item {
            background: var(--dark-card);
            border: 1px solid var(--border-gold);
            border-radius: 16px;
            padding: 30px 25px;
            text-align: center;
            transition: all 0.4s;
        }

        .why-item:hover {
            transform: translateY(-6px);
            border-color: var(--gold);
        }

        .why-icon {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            background: rgba(212, 168, 71, 0.1);
            border: 2px solid var(--border-gold);
            color: var(--gold);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.7rem;
            margin: 0 auto 20px;
            transition: all 0.4s;
        }

        .why-item:hover .why-icon {
            background: var(--gold);
            color: var(--dark-bg);
            transform: rotate(360deg);
        }

        .why-title {
            font-size: 1rem;
            font-weight: 700;
            color: var(--text-light);
            margin-bottom: 10px;
        }

        .why-description {
            color: var(--text-muted);
            font-size: 0.85rem;
            line-height: 1.8;
        }

        /* ============ CTA ============ */
        .cta-section {
            background: linear-gradient(135deg, rgba(212, 168, 71, 0.08), rgba(212, 168, 71, 0.02));
            border: 1px solid var(--border-gold);
            border-radius: 24px;
            padding: 60px 40px;
            text-align: center;
            margin: 60px 0;
            position: relative;
            overflow: hidden;
        }

        .cta-section::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 4px;
            background: linear-gradient(90deg, transparent, var(--gold), transparent);
        }

        .cta-title {
            font-size: clamp(1.5rem, 3vw, 2rem);
            font-weight: 800;
            color: var(--text-light);
            margin-bottom: 15px;
        }

        .cta-description {
            color: var(--text-muted);
            max-width: 600px;
            margin: 0 auto 30px;
            line-height: 1.9;
        }

        .cta-actions {
            display: flex;
            gap: 12px;
            justify-content: center;
            flex-wrap: wrap;
        }

        /* ============ Footer ============ */
        .footer {
            background: #060912;
            border-top: 1px solid var(--border-gold);
            padding: 60px 0 30px;
            margin-top: 80px;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr;
            gap: 40px;
            margin-bottom: 40px;
        }

        .footer-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            color: var(--gold);
            font-weight: 700;
            font-size: 1.1rem;
            margin-bottom: 15px;
        }

        .footer-brand-icon {
            width: 45px;
            height: 45px;
            border-radius: 12px;
            background: linear-gradient(135deg, var(--gold), var(--gold-light));
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--dark-bg);
            font-size: 1.2rem;
        }

        .footer-description {
            color: var(--text-muted);
            font-size: 0.85rem;
            line-height: 1.9;
            margin-bottom: 20px;
        }

        .footer-social {
            display: flex;
            gap: 10px;
        }

        .footer-social a {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: rgba(212, 168, 71, 0.1);
            border: 1px solid var(--border-gold);
            color: var(--gold);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
        }

        .footer-social a:hover {
            background: var(--gold);
            color: var(--dark-bg);
            transform: translateY(-3px);
        }

        .footer-title {
            font-size: 0.95rem;
            font-weight: 700;
            color: var(--text-light);
            margin-bottom: 20px;
        }

        .footer-links {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .footer-links a {
            color: var(--text-muted);
            font-size: 0.85rem;
            transition: color 0.3s;
        }

        .footer-links a:hover {
            color: var(--gold);
        }

        .footer-bottom {
            border-top: 1px solid rgba(212, 168, 71, 0.1);
            padding-top: 25px;
            text-align: center;
            color: var(--text-muted);
            font-size: 0.82rem;
        }

        /* ============ Responsive ============ */
        @media (max-width: 992px) {
            .navbar-menu { display: none; }
            .footer-grid { grid-template-columns: 1fr 1fr; }
        }

        @media (max-width: 768px) {
            .hero { padding: 60px 0 50px; }
            .section { padding: 60px 0; }
            .footer-grid { grid-template-columns: 1fr; }
            .cta-section { padding: 40px 25px; }
        }
    </style>

    @stack('styles')
</head>
<body>

    {{-- Navbar --}}
    @include('components.frontend.navbar')

    {{-- Main Content --}}
    <main>
        @yield('content')
    </main>

      {{-- Footer --}}
    @include('components.frontend.footer')

    {{-- Login Modal --}}
    @include('components.frontend.login-modal')

    @stack('scripts')
</body>
</html>
