{{-- resources/views/components/frontend/navbar.blade.php --}}
<nav class="navbar">
    <div class="container">
        <div class="navbar-inner">

            {{-- Brand --}}
            <a href="{{ route('home') }}" class="navbar-brand">
                <div class="navbar-brand-icon">
                    <i class="fas fa-music"></i>
                </div>
                <span>{{ __('common.brand') }}</span>
            </a>

            {{-- Menu --}}
            <ul class="navbar-menu">
                <li>
                    <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">
                        {{ __('common.nav.home') }}
                    </a>
                </li>
                <li><a href="#services">{{ __('common.nav.services') }}</a></li>
                <li><a href="#projects">{{ __('common.nav.projects') }}</a></li>
                <li><a href="#why-us">{{ __('common.nav.about') }}</a></li>
                <li><a href="#contact">{{ __('common.nav.contact') }}</a></li>
            </ul>

            {{-- Actions --}}
            <div class="navbar-actions">

                {{-- Language Switcher --}}
                @if(app()->getLocale() === 'fa')
                    <a href="{{ route('lang.switch', 'en') }}" class="lang-btn" title="English">
                        <i class="fas fa-globe"></i>
                        <span>EN</span>
                    </a>
                @else
                    <a href="{{ route('lang.switch', 'fa') }}" class="lang-btn" title="فارسی">
                        <i class="fas fa-globe"></i>
                        <span>FA</span>
                    </a>
                @endif

                @auth
                    {{-- ============================================ --}}
                    {{-- User Dropdown (Logged In) --}}
                    {{-- ============================================ --}}
                    <div class="user-dropdown" id="userDropdown">

                        {{-- Dropdown Toggle --}}
                        <button type="button" class="user-dropdown-toggle" onclick="toggleUserDropdown(event)">
                            <img src="{{ auth()->user()->getAvatarUrl() }}"
                                 alt="{{ auth()->user()->getDisplayName() }}"
                                 class="user-avatar">
                            <div class="user-info">
                                <span class="user-name">{{ auth()->user()->getDisplayName() }}</span>
                                <span class="user-role">
                                    @if(auth()->user()->isSeller())
                                        {{ __('فروشنده') }}
                                    @elseif(auth()->user()->isCompany())
                                        {{ __('شرکت') }}
                                    @else
                                        {{ __('مدیر') }}
                                    @endif
                                </span>
                            </div>
                            <i class="fas fa-chevron-down dropdown-arrow"></i>
                        </button>

                        {{-- Dropdown Menu --}}
                        <div class="user-dropdown-menu" id="userDropdownMenu">

                            {{-- Header --}}
                            <div class="dropdown-header">
                                <img src="{{ auth()->user()->getAvatarUrl() }}"
                                     alt="{{ auth()->user()->getDisplayName() }}"
                                     class="dropdown-header-avatar">
                                <div class="dropdown-header-info">
                                    <div class="dropdown-header-name">{{ auth()->user()->getDisplayName() }}</div>
                                    <div class="dropdown-header-email">{{ auth()->user()->email }}</div>
                                </div>
                            </div>

                            {{-- Menu Items --}}
                            <div class="dropdown-body">

                                {{-- Dashboard --}}
                                <a href="{{ route(auth()->user()->getRolePrefix() . '.dashboard') }}" class="dropdown-item">
                                    <span class="dropdown-item-icon">
                                        <i class="fas fa-tachometer-alt"></i>
                                    </span>
                                    <span class="dropdown-item-text">{{ __('داشبورد من') }}</span>
                                </a>

                                {{-- Messages --}}
                                @php
                                    $unreadMessages = \App\Models\Message::where('receiver_id', auth()->id())
                                        ->where('is_read', false)
                                        ->count();
                                @endphp
                                <a href="#" class="dropdown-item" onclick="openChatFromDropdown(event)">
                                    <span class="dropdown-item-icon">
                                        <i class="fas fa-comments"></i>
                                    </span>
                                    <span class="dropdown-item-text">{{ __('پیام‌ها') }}</span>
                                    @if($unreadMessages > 0)
                                        <span class="dropdown-badge badge-danger">{{ $unreadMessages }}</span>
                                    @endif
                                </a>

                                {{-- Notifications --}}
                                @php
                                    $unreadNotifications = \App\Models\Notification::where('user_id', auth()->id())
                                        ->where('is_read', false)
                                        ->count();
                                @endphp
                                <a href="#" class="dropdown-item" onclick="openNotificationsFromDropdown(event)">
                                    <span class="dropdown-item-icon">
                                        <i class="fas fa-bell"></i>
                                    </span>
                                    <span class="dropdown-item-text">{{ __('اعلان‌ها') }}</span>
                                    @if($unreadNotifications > 0)
                                        <span class="dropdown-badge badge-gold">{{ $unreadNotifications }}</span>
                                    @endif
                                </a>

                                {{-- Profile --}}
                                <a href="{{ route(auth()->user()->getRolePrefix() . '.profile.edit') }}" class="dropdown-item">
                                    <span class="dropdown-item-icon">
                                        <i class="fas fa-user"></i>
                                    </span>
                                    <span class="dropdown-item-text">{{ __('پروفایل من') }}</span>
                                </a>

                                {{-- Settings --}}
                                <a href="#" class="dropdown-item">
                                    <span class="dropdown-item-icon">
                                        <i class="fas fa-cog"></i>
                                    </span>
                                    <span class="dropdown-item-text">{{ __('تنظیمات') }}</span>
                                </a>

                            </div>

                            {{-- Divider --}}
                            <div class="dropdown-divider"></div>

                            {{-- Logout --}}
                            <form method="POST" action="{{ route('logout') }}" class="dropdown-logout-form">
                                @csrf
                                <button type="submit" class="dropdown-item dropdown-logout">
                                    <span class="dropdown-item-icon">
                                        <i class="fas fa-sign-out-alt"></i>
                                    </span>
                                    <span class="dropdown-item-text">{{ __('خروج از حساب') }}</span>
                                </button>
                            </form>

                        </div>
                    </div>
                @else
                    {{-- Guest --}}
                    <button type="button" class="btn btn-outline" onclick="openLoginModal('seller')">
                        <i class="fas fa-sign-in-alt"></i>
                        {{ __('common.nav.login') }}
                    </button>
                    <a href="{{ route('register') }}" class="btn btn-gold">
                        <i class="fas fa-user-plus"></i>
                        {{ __('common.nav.register') }}
                    </a>
                @endauth
            </div>

        </div>
    </div>
</nav>

{{-- ============================================ --}}
{{-- Navbar Styles --}}
{{-- ============================================ --}}
<style>
    /* Base Navbar */
    .navbar {
        background: rgba(10, 14, 26, 0.95);
        backdrop-filter: blur(10px);
        border-bottom: 1px solid rgba(212, 168, 71, 0.15);
        position: sticky;
        top: 0;
        z-index: 1000;
        padding: 12px 0;
    }

    .navbar-inner {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
    }

    .navbar-brand {
        display: flex;
        align-items: center;
        gap: 10px;
        font-weight: 700;
        font-size: 1.05rem;
        color: #d4a847;
        text-decoration: none;
        flex-shrink: 0;
    }

    .navbar-brand-icon {
        width: 42px;
        height: 42px;
        border-radius: 12px;
        background: linear-gradient(135deg, #d4a847, #f0d080);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #0a0e1a;
        font-size: 1.2rem;
    }

    .navbar-menu {
        display: flex;
        gap: 25px;
        align-items: center;
        margin: 0;
        padding: 0;
        list-style: none;
        flex: 1;
        justify-content: center;
    }

    .navbar-menu li {
        white-space: nowrap;
    }

    .navbar-menu a {
        color: #8892b0;
        font-size: 0.88rem;
        font-weight: 500;
        transition: color 0.3s;
        position: relative;
        padding: 5px 0;
        text-decoration: none;
    }

    .navbar-menu a:hover,
    .navbar-menu a.active {
        color: #d4a847;
    }

    .navbar-menu a::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 2px;
        background: #d4a847;
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
        flex-shrink: 0;
    }

    .lang-btn {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: rgba(212, 168, 71, 0.1);
        border: 1px solid rgba(212, 168, 71, 0.3);
        color: #d4a847;
        padding: 8px 14px;
        border-radius: 8px;
        font-size: 0.8rem;
        font-weight: 600;
        transition: all 0.3s;
        text-decoration: none;
        font-family: inherit;
        cursor: pointer;
    }

    .lang-btn:hover {
        background: #d4a847;
        color: #0a0e1a;
        transform: translateY(-2px);
    }

    /* ============================================ */
    /* User Dropdown */
    /* ============================================ */
    .user-dropdown {
        position: relative;
    }

    .user-dropdown-toggle {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 6px 12px 6px 6px;
        background: rgba(212, 168, 71, 0.08);
        border: 1px solid rgba(212, 168, 71, 0.2);
        border-radius: 50px;
        cursor: pointer;
        transition: all 0.3s;
        font-family: inherit;
        color: #ffffff;
    }

    .user-dropdown-toggle:hover {
        background: rgba(212, 168, 71, 0.15);
        border-color: #d4a847;
    }

    .user-avatar {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        border: 2px solid #d4a847;
        object-fit: cover;
    }

    .user-info {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        line-height: 1.2;
    }

    .user-name {
        font-size: 0.82rem;
        font-weight: 700;
        color: #ffffff;
    }

    .user-role {
        font-size: 0.7rem;
        color: #d4a847;
        font-weight: 500;
    }

    .dropdown-arrow {
        color: #d4a847;
        font-size: 0.75rem;
        transition: transform 0.3s;
    }

    .user-dropdown.open .dropdown-arrow {
        transform: rotate(180deg);
    }

    /* Dropdown Menu */
    .user-dropdown-menu {
        position: absolute;
        top: calc(100% + 12px);
        left: 0;
        min-width: 280px;
        background: #121828;
        border: 1px solid rgba(212, 168, 71, 0.3);
        border-radius: 16px;
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.5);
        padding: 8px;
        z-index: 1001;
        opacity: 0;
        visibility: hidden;
        transform: translateY(-10px);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        overflow: hidden;
    }

    .user-dropdown.open .user-dropdown-menu {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }

    /* Dropdown Header */
    .dropdown-header {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px;
        background: rgba(212, 168, 71, 0.05);
        border-radius: 12px;
        margin-bottom: 8px;
    }

    .dropdown-header-avatar {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        border: 2px solid #d4a847;
        object-fit: cover;
    }

    .dropdown-header-info {
        flex: 1;
        min-width: 0;
    }

    .dropdown-header-name {
        font-size: 0.9rem;
        font-weight: 700;
        color: #ffffff;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .dropdown-header-email {
        font-size: 0.75rem;
        color: #8892b0;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        direction: ltr;
        text-align: right;
    }

    /* Dropdown Body */
    .dropdown-body {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }

    .dropdown-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 12px;
        border-radius: 10px;
        color: #cbd5e0;
        font-size: 0.85rem;
        text-decoration: none;
        transition: all 0.25s;
        background: transparent;
        border: none;
        font-family: inherit;
        cursor: pointer;
        width: 100%;
        text-align: right;
    }

    .dropdown-item:hover {
        background: rgba(212, 168, 71, 0.1);
        color: #d4a847;
        transform: translateX(-3px);
    }

    .dropdown-item-icon {
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(212, 168, 71, 0.08);
        border-radius: 8px;
        color: #d4a847;
        font-size: 0.85rem;
        flex-shrink: 0;
    }

    .dropdown-item:hover .dropdown-item-icon {
        background: #d4a847;
        color: #0a0e1a;
    }

    .dropdown-item-text {
        flex: 1;
        text-align: right;
    }

    /* Badges */
    .dropdown-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 22px;
        height: 22px;
        padding: 0 6px;
        border-radius: 11px;
        font-size: 0.7rem;
        font-weight: 700;
        color: #ffffff;
        flex-shrink: 0;
    }

    .badge-danger {
        background: #ef4444;
        box-shadow: 0 0 10px rgba(239, 68, 68, 0.4);
    }

    .badge-gold {
        background: #d4a847;
        color: #0a0e1a;
        box-shadow: 0 0 10px rgba(212, 168, 71, 0.4);
    }

    /* Divider */
    .dropdown-divider {
        height: 1px;
        background: rgba(212, 168, 71, 0.15);
        margin: 8px 4px;
    }

    /* Logout */
    .dropdown-logout-form {
        margin: 0;
    }

    .dropdown-logout:hover {
        background: rgba(239, 68, 68, 0.1);
        color: #ef4444;
    }

    .dropdown-logout:hover .dropdown-item-icon {
        background: #ef4444;
        color: #ffffff;
    }

    /* Responsive */
    @media (max-width: 992px) {
        .navbar-menu {
            display: none;
        }
    }

    @media (max-width: 576px) {
        .user-info {
            display: none;
        }

        .user-dropdown-menu {
            min-width: 260px;
            left: -100px;
        }
    }
</style>

{{-- ============================================ --}}
{{-- Navbar Scripts --}}
{{-- ============================================ --}}
<script>
    // ============================================
    // User Dropdown
    // ============================================
    function toggleUserDropdown(event) {
        event.stopPropagation();
        const dropdown = document.getElementById('userDropdown');
        if (dropdown) {
            dropdown.classList.toggle('open');
        }
    }

    // بستن Dropdown با کلیک بیرون
    document.addEventListener('click', function(event) {
        const dropdown = document.getElementById('userDropdown');
        if (dropdown && !dropdown.contains(event.target)) {
            dropdown.classList.remove('open');
        }
    });

    // بستن Dropdown با Escape
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            const dropdown = document.getElementById('userDropdown');
            if (dropdown) {
                dropdown.classList.remove('open');
            }
        }
    });

    // ============================================
    // Handlers (placeholder)
    // ============================================
    function openChatFromDropdown(event) {
        event.preventDefault();
        // TODO: باز کردن چت
        alert('سیستم چت به زودی...');
    }

    function openNotificationsFromDropdown(event) {
        event.preventDefault();
        // TODO: باز کردن اعلان‌ها
        alert('صفحه اعلان‌ها به زودی...');
    }
</script>
