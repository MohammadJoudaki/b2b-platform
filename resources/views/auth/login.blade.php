{{-- resources/views/auth/login.blade.php --}}
<x-guest-layout>
    <div class="text-center mb-8">
        <h1 class="text-xl font-bold text-white mb-2">ورود به سیستم</h1>
        <div class="gold-divider w-24 mx-auto my-3"></div>
        <p class="text-gray-500 text-sm">لطفاً اطلاعات حساب خود را وارد کنید</p>
    </div>

    {{-- Session Status --}}
    @if (session('status'))
        <div class="mb-4 p-3 rounded-lg text-sm" style="background: rgba(34, 197, 94, 0.1); border: 1px solid rgba(34, 197, 94, 0.3); color: #22c55e;">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        {{-- Email --}}
        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-400 mb-2">
                <i class="fas fa-envelope ml-1 gold-text"></i>
                ایمیل
            </label>
            <input id="email"
                   type="email"
                   name="email"
                   value="{{ old('email') }}"
                   required
                   autofocus
                   placeholder="admin@hamsansaz.com"
                   class="auth-input w-full px-4 py-3 rounded-lg" />
            @error('email')
                <p class="mt-2 text-sm text-red-500">
                    <i class="fas fa-exclamation-circle ml-1"></i>
                    {{ $message }}
                </p>
            @enderror
        </div>

        {{-- Password --}}
        <div class="mb-4">
            <label for="password" class="block text-sm font-medium text-gray-400 mb-2">
                <i class="fas fa-lock ml-1 gold-text"></i>
                رمز عبور
            </label>
            <input id="password"
                   type="password"
                   name="password"
                   required
                   autocomplete="current-password"
                   placeholder="••••••••"
                   class="auth-input w-full px-4 py-3 rounded-lg" />
            @error('password')
                <p class="mt-2 text-sm text-red-500">
                    <i class="fas fa-exclamation-circle ml-1"></i>
                    {{ $message }}
                </p>
            @enderror
        </div>

        {{-- Remember & Forgot --}}
        <div class="flex items-center justify-between mb-6">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me"
                       type="checkbox"
                       name="remember"
                       class="w-4 h-4 rounded border-gray-600 bg-transparent text-amber-500 focus:ring-amber-500" />
                <span class="mr-2 text-sm text-gray-400">مرا به خاطر بسپار</span>
            </label>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}"
                   class="text-sm gold-text hover:text-amber-300 transition">
                    فراموشی رمز عبور؟
                </a>
            @endif
        </div>

        {{-- Submit Button --}}
        <button type="submit"
                class="auth-btn w-full py-3 rounded-lg font-bold text-sm flex items-center justify-center gap-2">
            <i class="fas fa-sign-in-alt"></i>
            ورود به حساب
        </button>
    </form>

    {{-- Register Link --}}
    @if (Route::has('register'))
        <div class="mt-6 pt-6 text-center" style="border-top: 1px solid rgba(212, 168, 71, 0.15);">
            <p class="text-sm text-gray-500">
                حساب کاربری ندارید؟
                <a href="{{ route('register') }}" class="gold-text hover:text-amber-300 font-medium mr-1 transition">
                    ثبت‌نام کنید
                </a>
            </p>
        </div>
    @endif
</x-guest-layout>
