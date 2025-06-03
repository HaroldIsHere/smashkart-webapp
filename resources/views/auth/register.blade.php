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

    .left {
      width: 100%;
      height: 100vh;
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
      margin-top: 8=70px%;
    }

    input[type="email"],
    input[type="password"],
    input[type="text"] {
      width: 100%;
      padding: 20px 16px;
      border: 1px solid #f2f2f2;
      background-color: #f2f2f2;
      border-radius: 15px;
      font-size: 14px;
      margin-bottom: 20px;
    }

    label,
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

    .ms-4, .ms-3, .register-btn {
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
      margin-left: 16px;
    }

    .ms-4.register-btn {
      
    }

    .container{
        width: 100%;
        display: flex;
    }

    .already-registered-container {
        display: flex;
        justify-content: center;
        margin-top: 24px;
    }
    .already-registered-link {
        color: #3C2EFF;
        text-decoration: underline;
        font-size: 15px;
        font-weight: 600;
        transition: color 0.2s;
    }
    .already-registered-link:hover {
        color: #2a22b8;
    }
</style>

<div class="ImageContainer">
    <img src="/img/extra/Picture1.png" alt="Badminton Image" class="left"/>
</div>

<form method="POST" action="{{ route('register') }}" class="right">
    @csrf

    <h1 class="text-2xl font-bold mb-6"> {{ __('CREATE AN ACCOUNT') }}</h1>
    <style>
        .text-2xl.font-bold.mb-6 {
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 1.5rem;
        }
    </style>

    <!-- Name -->
    <div>
        <label for="name">{{ __('Name') }}</label>
        <input id="name" class="block mt-1 w-full" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" />
        <x-input-error :messages="$errors->get('name')" class="mt-2" />
    </div>

    <!-- Email Address -->
    <div class="mt-4">
        <label for="email">{{ __('Email') }}</label>
        <input id="email" class="block mt-1 w-full" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" />
        <x-input-error :messages="$errors->get('email')" class="mt-2" />
    </div>

    <!-- Password -->
    <div class="mt-4">
        <label for="password">{{ __('Password') }}</label>
        <input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
        <x-input-error :messages="$errors->get('password')" class="mt-2" />
    </div>

    <!-- Confirm Password -->
    <div class="mt-4">
        <label for="password_confirmation">{{ __('Confirm Password') }}</label>
        <input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
    </div>

    <button type="submit" class="ms-4 register-btn">
        {{ __('Register') }}
    </button>

    <div class="already-registered-container">
        <a class="already-registered-link" href="{{ route('login') }}">
            {{ __('Already registered? Sign In') }}
        </a>
    </div>
</form>
