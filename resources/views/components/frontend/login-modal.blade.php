{{-- resources/views/components/frontend/login-modal.blade.php --}}
<div id="loginModal" class="modal-overlay" style="display: none;">
    <div class="modal-content">

        {{-- Close Button --}}
        <button class="modal-close" onclick="closeLoginModal()">
            <i class="fas fa-times"></i>
        </button>

        {{-- Header --}}
        <div class="modal-header">
            <div class="modal-icon">
                <i class="fas fa-sign-in-alt"></i>
            </div>
            <h2 class="modal-title">{{ __('ورود به سیستم') }}</h2>
            <p class="modal-subtitle">{{ __('نوع دسترسی خود را انتخاب کنید') }}</p>
        </div>

        {{-- Role Tabs --}}
        <div class="role-tabs">
            <button type="button" class="role-tab active" data-role="seller" onclick="selectRole('seller')">
                <i class="fas fa-store"></i>
                <span>{{ __('فروشنده') }}</span>
            </button>
            <button type="button" class="role-tab" data-role="company" onclick="selectRole('company')">
                <i class="fas fa-building"></i>
                <span>{{ __('شرکت') }}</span>
            </button>
        </div>

        {{-- Login Form --}}
        <form id="modalLoginForm" method="POST" action="{{ route('login') }}" class="modal-form">
            @csrf

            {{-- Hidden Role --}}
            <input type="hidden" name="login_role" id="loginRole" value="seller">

            {{-- Error Display --}}
            <div id="modalErrors" class="modal-errors" style="display: none;"></div>

            {{-- Phone (Seller only) --}}
            <div class="form-group" id="phoneGroup">
                <label for="modal_phone">
                    <i class="fas fa-phone gold-text"></i>
                    {{ __('شماره تلفن') }}
                </label>
                <input type="tel"
                       id="modal_phone"
                       name="phone"
                       autocomplete="tel"
                       placeholder="09123456789"
                       maxlength="11"
                       style="direction: ltr; text-align: left; letter-spacing: 2px;">
                <small class="form-hint">
                    <i class="fas fa-info-circle"></i>
                    {{ __('شماره تلفنی که با آن ثبت‌نام کرده‌اید') }}
                </small>
            </div>

            {{-- Unique Code (Company only) --}}
            <div class="form-group" id="codeGroup" style="display: none;">
                <label for="modal_unique_code">
                    <i class="fas fa-id-card gold-text"></i>
                    {{ __('شناسه شرکت') }}
                </label>
                <input type="text"
                       id="modal_unique_code"
                       name="unique_code"
                       placeholder="HSC-XXXXXXXX"
                       style="direction: ltr; text-align: left; letter-spacing: 1px; text-transform: uppercase;">
                <small class="form-hint">
                    <i class="fas fa-info-circle"></i>
                    {{ __('شناسه یکتای شرکت که هنگام ثبت‌نام دریافت کرده‌اید') }}
                </small>
            </div>

            {{-- Password --}}
            <div class="form-group">
                <label for="modal_password">
                    <i class="fas fa-lock gold-text"></i>
                    {{ __('رمز عبور') }}
                </label>
                <div class="password-wrapper">
                    <input type="password"
                           id="modal_password"
                           name="password"
                           required
                           autocomplete="current-password"
                           placeholder="••••••••">
                    <button type="button" class="password-toggle" onclick="togglePassword()">
                        <i class="fas fa-eye" id="passwordEye"></i>
                    </button>
                </div>
            </div>

            {{-- Remember --}}
            <div class="form-options">
                <label class="remember-check">
                    <input type="checkbox" name="remember">
                    <span>{{ __('مرا به خاطر بسپار') }}</span>
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="forgot-link">
                        {{ __('فراموشی رمز؟') }}
                    </a>
                @endif
            </div>

            {{-- Submit --}}
            <button type="submit" class="modal-submit">
                <i class="fas fa-sign-in-alt"></i>
                <span id="submitText">{{ __('ورود به عنوان فروشنده') }}</span>
            </button>
        </form>

        {{-- Register Link --}}
        <div class="modal-footer">
            <p>
                {{ __('حساب کاربری ندارید؟') }}
                <a href="{{ route('register') }}">{{ __('ثبت‌نام کنید') }}</a>
            </p>
        </div>

    </div>
</div>

{{-- Styles --}}
<style>
    /* Modal Overlay */
    .modal-overlay {
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(0, 0, 0, 0.85);
        backdrop-filter: blur(8px);
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
        animation: fadeIn 0.3s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    .modal-content {
        background: #121828;
        border: 1px solid rgba(212, 168, 71, 0.3);
        border-radius: 20px;
        padding: 40px 35px 30px;
        width: 100%;
        max-width: 440px;
        position: relative;
        animation: slideUp 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        max-height: 90vh;
        overflow-y: auto;
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .modal-close {
        position: absolute;
        top: 15px;
        left: 15px;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: rgba(212, 168, 71, 0.1);
        border: 1px solid rgba(212, 168, 71, 0.3);
        color: #d4a847;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s;
        font-size: 0.9rem;
    }

    .modal-close:hover {
        background: #d4a847;
        color: #0a0e1a;
        transform: rotate(90deg);
    }

    .modal-header {
        text-align: center;
        margin-bottom: 25px;
    }

    .modal-icon {
        width: 60px;
        height: 60px;
        margin: 0 auto 15px;
        border-radius: 16px;
        background: linear-gradient(135deg, #d4a847, #f0d080);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #0a0e1a;
        font-size: 1.5rem;
    }

    .modal-title {
        font-size: 1.4rem;
        font-weight: 800;
        color: #ffffff;
        margin-bottom: 8px;
    }

    .modal-subtitle {
        color: #8892b0;
        font-size: 0.88rem;
    }

    .role-tabs {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
        margin-bottom: 25px;
        background: rgba(255, 255, 255, 0.03);
        padding: 6px;
        border-radius: 14px;
        border: 1px solid rgba(212, 168, 71, 0.15);
    }

    .role-tab {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 6px;
        padding: 14px 10px;
        background: transparent;
        border: none;
        color: #8892b0;
        font-family: inherit;
        font-size: 0.85rem;
        font-weight: 600;
        cursor: pointer;
        border-radius: 10px;
        transition: all 0.3s;
    }

    .role-tab i {
        font-size: 1.2rem;
    }

    .role-tab:hover {
        color: #d4a847;
        background: rgba(212, 168, 71, 0.05);
    }

    .role-tab.active {
        background: linear-gradient(135deg, #d4a847, #f0d080);
        color: #0a0e1a;
        box-shadow: 0 4px 15px rgba(212, 168, 71, 0.3);
    }

    .modal-form {
        display: flex;
        flex-direction: column;
        gap: 18px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .form-group label {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.85rem;
        font-weight: 600;
        color: #cbd5e0;
    }

    .form-group label i {
        font-size: 0.8rem;
    }

    .gold-text {
        color: #d4a847;
    }

    .form-group input {
        width: 100%;
        padding: 12px 16px;
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(212, 168, 71, 0.2);
        border-radius: 10px;
        color: #ffffff;
        font-family: inherit;
        font-size: 0.9rem;
        transition: all 0.3s;
    }

    .form-group input:focus {
        outline: none;
        border-color: #d4a847;
        background: rgba(255, 255, 255, 0.05);
        box-shadow: 0 0 0 3px rgba(212, 168, 71, 0.1);
    }

    .form-group input::placeholder {
        color: #4a5568;
    }

    .form-hint {
        display: flex;
        align-items: center;
        gap: 5px;
        color: #6b7280;
        font-size: 0.75rem;
        margin-top: 2px;
    }

    .form-hint i {
        color: #d4a847;
        font-size: 0.7rem;
    }

    .password-wrapper {
        position: relative;
    }

    .password-toggle {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        background: transparent;
        border: none;
        color: #8892b0;
        cursor: pointer;
        padding: 5px;
        transition: color 0.3s;
    }

    .password-toggle:hover {
        color: #d4a847;
    }

    .form-options {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        font-size: 0.82rem;
    }

    .remember-check {
        display: flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        color: #8892b0;
    }

    .remember-check input[type="checkbox"] {
        width: 16px;
        height: 16px;
        accent-color: #d4a847;
        cursor: pointer;
    }

    .forgot-link {
        color: #d4a847;
        text-decoration: none;
        transition: color 0.3s;
    }

    .forgot-link:hover {
        color: #f0d080;
    }

    .modal-submit {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 14px 20px;
        background: linear-gradient(135deg, #d4a847, #f0d080);
        color: #0a0e1a;
        border: none;
        border-radius: 10px;
        font-family: inherit;
        font-size: 0.95rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s;
        margin-top: 5px;
    }

    .modal-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(212, 168, 71, 0.4);
    }

    .modal-submit:active {
        transform: translateY(0);
    }

    .modal-submit.loading {
        pointer-events: none;
        opacity: 0.7;
    }

    .modal-submit.loading::after {
        content: '';
        width: 16px;
        height: 16px;
        border: 2px solid #0a0e1a;
        border-top-color: transparent;
        border-radius: 50%;
        animation: spin 0.6s linear infinite;
        margin-right: 8px;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    .modal-footer {
        text-align: center;
        margin-top: 20px;
        padding-top: 20px;
        border-top: 1px solid rgba(212, 168, 71, 0.1);
    }

    .modal-footer p {
        color: #8892b0;
        font-size: 0.85rem;
    }

    .modal-footer a {
        color: #d4a847;
        text-decoration: none;
        font-weight: 600;
        transition: color 0.3s;
    }

    .modal-footer a:hover {
        color: #f0d080;
    }

    .modal-errors {
        background: rgba(239, 68, 68, 0.1);
        border: 1px solid rgba(239, 68, 68, 0.3);
        border-radius: 10px;
        padding: 12px 15px;
        color: #ef4444;
        font-size: 0.85rem;
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 5px;
    }

    @media (max-width: 576px) {
        .modal-content {
            padding: 30px 22px 25px;
        }

        .modal-title {
            font-size: 1.2rem;
        }

        .role-tab {
            font-size: 0.8rem;
            padding: 12px 8px;
        }
    }
</style>

{{-- Scripts --}}
<script>
    // ============================================
    // Modal Login
    // ============================================

    function openLoginModal(role = 'seller') {
        const modal = document.getElementById('loginModal');
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
        selectRole(role);

        // پاک کردن خطاها
        const errorBox = document.getElementById('modalErrors');
        errorBox.style.display = 'none';
        errorBox.innerHTML = '';
    }

    function closeLoginModal() {
        const modal = document.getElementById('loginModal');
        modal.style.display = 'none';
        document.body.style.overflow = '';

        const errorBox = document.getElementById('modalErrors');
        errorBox.style.display = 'none';
    }

    function selectRole(role) {
        // به‌روزرسانی دکمه‌ها
        document.querySelectorAll('.role-tab').forEach(tab => {
            tab.classList.remove('active');
            if (tab.dataset.role === role) {
                tab.classList.add('active');
            }
        });

        // به‌روزرسانی input hidden
        document.getElementById('loginRole').value = role;

        // نمایش/مخفی کردن فیلدها
        const phoneGroup = document.getElementById('phoneGroup');
        const codeGroup = document.getElementById('codeGroup');
        const phoneInput = document.getElementById('modal_phone');
        const codeInput = document.getElementById('modal_unique_code');

        if (role === 'seller') {
            phoneGroup.style.display = 'flex';
            codeGroup.style.display = 'none';
            phoneInput.required = true;
            codeInput.required = false;
            codeInput.value = '';
            document.getElementById('submitText').textContent = '{{ __('ورود به عنوان فروشنده') }}';
        } else {
            phoneGroup.style.display = 'none';
            codeGroup.style.display = 'flex';
            phoneInput.required = false;
            codeInput.required = true;
            phoneInput.value = '';
            document.getElementById('submitText').textContent = '{{ __('ورود به عنوان شرکت') }}';
        }

        // پاک کردن خطاها
        const errorBox = document.getElementById('modalErrors');
        errorBox.style.display = 'none';
    }

    function togglePassword() {
        const input = document.getElementById('modal_password');
        const eye = document.getElementById('passwordEye');

        if (input.type === 'password') {
            input.type = 'text';
            eye.classList.remove('fa-eye');
            eye.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            eye.classList.add('fa-eye');
            eye.classList.remove('fa-eye-slash');
        }
    }

    // ============================================
    // Form Submit با AJAX
    // ============================================

    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('modalLoginForm');

        if (form) {
            form.addEventListener('submit', async function(e) {
                e.preventDefault();

                const submitBtn = form.querySelector('.modal-submit');
                const errorBox = document.getElementById('modalErrors');
                const submitText = document.getElementById('submitText');
                const currentRole = document.getElementById('loginRole').value;

                // نشان دادن Loading
                submitBtn.classList.add('loading');
                submitText.textContent = '{{ __('در حال ورود...') }}';
                errorBox.style.display = 'none';

                try {
                    const formData = new FormData(form);
                    const response = await fetch(form.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json',
                        },
                        credentials: 'same-origin',
                    });

                    const data = await response.json();

                    if (response.ok && data.success) {
                        window.location.href = data.redirect || '/';
                    } else {
                        submitBtn.classList.remove('loading');

                        let errorMessage = '';
                        if (data.errors) {
                            const messages = Object.values(data.errors).flat();
                            errorMessage = messages.join('<br>');
                        } else if (data.message) {
                            errorMessage = data.message;
                        } else {
                            errorMessage = '{{ __('خطایی رخ داد، لطفاً دوباره تلاش کنید.') }}';
                        }

                        errorBox.innerHTML = '<i class="fas fa-exclamation-circle"></i> <span>' + errorMessage + '</span>';
                        errorBox.style.display = 'flex';

                        // بازگرداندن متن دکمه
                        if (currentRole === 'seller') {
                            submitText.textContent = '{{ __('ورود به عنوان فروشنده') }}';
                        } else {
                            submitText.textContent = '{{ __('ورود به عنوان شرکت') }}';
                        }
                    }
                } catch (error) {
                    submitBtn.classList.remove('loading');
                    errorBox.innerHTML = '<i class="fas fa-exclamation-circle"></i> <span>{{ __('خطای شبکه، لطفاً دوباره تلاش کنید.') }}</span>';
                    errorBox.style.display = 'flex';

                    if (currentRole === 'seller') {
                        submitText.textContent = '{{ __('ورود به عنوان فروشنده') }}';
                    } else {
                        submitText.textContent = '{{ __('ورود به عنوان شرکت') }}';
                    }
                }
            });
        }

        // بستن با Escape
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const modal = document.getElementById('loginModal');
                if (modal && modal.style.display === 'flex') {
                    closeLoginModal();
                }
            }
        });

        // بستن با کلیک بیرون
        document.getElementById('loginModal')?.addEventListener('click', function(e) {
            if (e.target === this) {
                closeLoginModal();
            }
        });
    });
</script>
