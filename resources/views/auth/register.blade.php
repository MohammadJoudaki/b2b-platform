{{-- resources/views/auth/register.blade.php --}}
<x-guest-layout>
    <div class="text-center mb-8">
        <h1 class="text-xl font-bold text-white mb-2">ایجاد حساب کاربری</h1>
        <div class="gold-divider w-24 mx-auto my-3"></div>
        <p class="text-gray-500 text-sm">برای شروع، اطلاعات خود را وارد کنید</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        {{-- Name --}}
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-400 mb-2">
                <i class="fas fa-user ml-1 gold-text"></i>
                نام و نام خانوادگی
            </label>
            <input id="name"
                   type="text"
                   name="name"
                   value="{{ old('name') }}"
                   required
                   autofocus
                   placeholder="نام کامل شما"
                   class="auth-input w-full px-4 py-3 rounded-lg" />
            @error('name')
                <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

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
                   placeholder="example@email.com"
                   class="auth-input w-full px-4 py-3 rounded-lg" />
            @error('email')
                <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
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
                   autocomplete="new-password"
                   placeholder="حداقل ۸ کاراکتر"
                   class="auth-input w-full px-4 py-3 rounded-lg" />
            @error('password')
                <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        {{-- Password Confirmation --}}
        <div class="mb-6">
            <label for="password_confirmation" class="block text-sm font-medium text-gray-400 mb-2">
                <i class="fas fa-lock ml-1 gold-text"></i>
                تکرار رمز عبور
            </label>
            <input id="password_confirmation"
                   type="password"
                   name="password_confirmation"
                   required
                   placeholder="رمز عبور را دوباره وارد کنید"
                   class="auth-input w-full px-4 py-3 rounded-lg" />
        </div>

        {{-- Submit --}}
        <button type="submit"
                class="auth-btn w-full py-3 rounded-lg font-bold text-sm flex items-center justify-center gap-2">
            <i class="fas fa-user-plus"></i>
            ایجاد حساب
        </button>
    </form>

    {{-- Login Link --}}
    <div class="mt-6 pt-6 text-center" style="border-top: 1px solid rgba(212, 168, 71, 0.15);">
        <p class="text-sm text-gray-500">
            قبلاً ثبت‌نام کرده‌اید؟
            <a href="{{ route('login') }}" class="gold-text hover:text-amber-300 font-medium mr-1 transition">
                وارد شوید
            </a>
        </p>
    </div>
</x-guest-layout>
