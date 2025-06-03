<style>

    * {
      box-sizing: border-box;
      font-family: 'Montserrat', sans-serif;
      margin: 0;
      padding: 0;
    }

    body {
      display: flex;
      height: 100vh;
    }

    .ImageContainer {
      width: 50%;
    }

    .left img {
      width: 100%;
      height: calc(100% - 60px);
      object-fit: cover;
    }

    .right {
      width: 50%;
      padding: 60px 80px;
      display: flex;
      flex-direction: column;
      justify-content: center;
      background: #fff;
      margin-top: -15%;
    }

    input[type="email"],
    input[type="password"] {
      width: 100%;
      padding: 20px 16px;
      border: 1px solid #f2f2f2;
      background-color: #f2f2f2;
      border-radius: 15px;
      font-size: 14px;
      margin-bottom: 20px;
    }

    .label[for="email"],
    .label[for="password"] {
      font-size: 15px;
      font-weight: 600;
      color: #000;
      margin-bottom: 6px;
      display: block;
    }

    .block.mt-4{
        
    }

    .text-2xl.font-bold.mb-6{
        margin-bottom: 34px;
    }

    .ms-3{
      background: #3C2EFF;
      color: #fff;
      font-size: 16px;
      font-weight: 600;
      border: none;
      width: 100%;
      border-radius: 6px;
      cursor: pointer;
      font-size: 14px;
      padding: 20px 16px;
    }

    .container{
        width: 100%;
        display: flex;
    }


</style>

<div class="ImageContainer">
    <img src="/img/extra/Picture1.png" alt="Badminton Image" class="left"/>
</div>

<!-- Session Status -->
<x-auth-session-status class="mb-4" :status="session('status')" />

<form method="POST" action="{{ route('login') }}" class="right">
    @csrf

    <div style="display: flex; flex-direction: row; align-items: center; width: 100%; margin-bottom: 34px;">
        <h1 class="text-2xl font-bold mb-6" style="margin-bottom: 0; align-self: center;">{{ __('LOG IN ACCOUNT') }}</h1>
        <a href="{{ route('index') }}" class="text-sm text-gray-600 hover:text-gray-900 underline mb-4" style="margin-left: auto; color: #3C2EFF; text-decoration: underline; align-self: center;">
            {{ __('Back to Home') }}
        </a>
    </div>

    <!-- Email Address -->
    <x-input-label for="email" :value="__('ENTER YOUR EMAIL ADDRESS')" class="label" />
    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
    <x-input-error :messages="$errors->get('email')" class="mt-2" />

    <!-- Password -->
    <x-input-label for="password" :value="__('ENTER YOUR PASSWORD')" class="label" />
    <x-text-input id="password" class="block mt-1 w-full"
                    type="password"
                    name="password"
                    required autocomplete="current-password" />
    <x-input-error :messages="$errors->get('password')" class="mt-2" />

    <x-primary-button class="ms-3">
        {{ __('LOG IN') }}
    </x-primary-button>

    <!-- Sign Up Option -->
    <div class="signup-option">
        <span>Don't have an account?</span>
        <a href="{{ route('register') }}" class="signup-link">Sign Up</a>
    </div>

    <!-- Remember Me & Forgot Password -->
    <div class="remember-forgot-container">
        <div class="remember-me-block">
            <label for="remember_me" class="remember-label">
                <input id="remember_me" type="checkbox" class="remember-checkbox" name="remember">
                <span class="remember-text">{{ __('Remember me') }}</span>
            </label>
        </div>
        <div class="forgot-password-block">
            @if (Route::has('password.request'))
                <a class="forgot-password-link" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif
        </div>
    </div>

    <style>
    .signup-option {
        margin-top: 24px;
        text-align: center;
        font-size: 15px;
    }
    .signup-link {
        color: #3C2EFF;
        text-decoration: underline;
        margin-left: 6px;
        font-weight: 600;
        transition: color 0.2s;
    }
    .signup-link:hover {
        color: #2a22b8;
    }

    .remember-forgot-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 24px;
        margin-bottom: 10px;
    }

    .remember-me-block {
        display: flex;
        align-items: center;
    }

    .remember-label {
        display: flex;
        align-items: center;
        cursor: pointer;
    }

    .remember-checkbox {
        accent-color: #3C2EFF;
        width: 18px;
        height: 18px;
        margin-right: 8px;
    }

    .remember-text {
        font-size: 14px;
        color: #333;
    }

    .forgot-password-block {
        display: flex;
        align-items: center;
    }

    .forgot-password-link {
        font-size: 14px;
        color: #3C2EFF;
        text-decoration: underline;
        transition: color 0.2s;
    }

    .forgot-password-link:hover {
        color: #2a22b8;
    }
    </style>
</form>