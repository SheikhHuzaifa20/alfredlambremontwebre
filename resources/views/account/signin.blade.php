@extends('layouts.main')

@section('title', 'Login')

@section('content')

    <section class="auth-page">
        <div class="container">

            <div class="auth-wrapper">

                <div class="auth-card">

                    <div class="auth-header">
                        <span class="auth-eyebrow">WELCOME BACK</span>

                        <h1>Login</h1>

                        <p>
                            Sign in to access your account and manage your information.
                        </p>
                    </div>


                    <form method="POST" action="{{ route('login') }}" class="auth-form">

                        @csrf


                        {{-- Email --}}
                        <div class="auth-group">

                            <label for="email">
                                Email Address
                            </label>

                            <input type="email" id="email" name="email" value="{{ old('email') }}"
                                placeholder="Enter your email address" class="@error('email') auth-input-error @enderror"
                                required autofocus>

                            @error('email')
                                <div class="auth-error">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        {{-- Password --}}
                        <div class="auth-group">

                            <label for="password">
                                Password
                            </label>

                            <input type="password" id="password" name="password" placeholder="Enter your password"
                                class="@error('password') auth-input-error @enderror" required>

                            @error('password')
                                <div class="auth-error">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        {{-- Remember + Forgot --}}
                        <div class="auth-options">

                            <label class="remember-me">

                                <input type="checkbox" name="remember">

                                <span>
                                    Remember me
                                </span>

                            </label>


                            {{-- <a href="{{ url('password/reset') }}" class="forgot-password">

                                Forgot password?

                            </a> --}}

                        </div>


                        <button type="submit" class="auth-btn">

                            Login

                        </button>

                    </form>


                    <div class="auth-divider">
                        <span></span>
                        <p>Don't have an account?</p>
                        <span></span>
                    </div>


                    <div class="auth-footer">

                        <a href="{{ route('signup') }}">

                            Create an account

                        </a>

                    </div>

                </div>

            </div>

        </div>
    </section>

@endsection
@section('css')

<style>

/* =========================================================
   ACCOUNT PAGES
========================================================= */

.auth-page {
    background: #10172c;
    min-height: calc(100vh - 120px);
    padding: 90px 20px;
    position: relative;
}


/* Center wrapper */

.auth-wrapper {
    display: flex;
    justify-content: center;
    align-items: center;
}


/* Main Card */

.auth-card {
    width: 100%;
    max-width: 560px;

    background: #141c32;

    border: 1px solid rgba(190, 157, 76, 0.35);

    padding: 55px 50px;

    position: relative;

    box-shadow:
        0 25px 70px rgba(0, 0, 0, 0.35);
}


/* Gold top line */

.auth-card::before {

    content: "";

    position: absolute;

    top: 0;
    left: 50%;

    transform: translateX(-50%);

    width: 80px;
    height: 2px;

    background: #b89a55;

}


/* =========================================================
   HEADER
========================================================= */

.auth-header {

    text-align: center;

    margin-bottom: 40px;

}


.auth-eyebrow {

    display: block;

    color: #b89a55;

    font-size: 11px;

    letter-spacing: 3px;

    font-weight: 600;

    margin-bottom: 15px;

}


.auth-header h1 {

    color: #e7e2d7 !important;

    font-size: 46px !important;

    line-height: 1.2 !important;

    font-weight: 400 !important;

    margin: 0 0 15px !important;

    letter-spacing: -1px;

}


.auth-header p {

    color: #aaa9ad;

    font-size: 15px;

    line-height: 1.7;

    margin: 0 auto;

    max-width: 390px;

}


/* =========================================================
   FORM
========================================================= */

.auth-form {

    width: 100%;

}


.auth-group {

    margin-bottom: 22px;

}


.auth-group label {

    display: block;

    color: #d7d2c7;

    font-size: 12px;

    letter-spacing: 1.3px;

    text-transform: uppercase;

    margin-bottom: 10px;

}


/* Inputs */

.auth-group input {

    width: 100% !important;

    height: 54px !important;

    padding: 0 18px !important;

    background: #0e1528 !important;

    border: 1px solid #30384b !important;

    border-radius: 0 !important;

    color: #ffffff !important;

    font-size: 14px !important;

    font-family: inherit !important;

    box-shadow: none !important;

    transition: all 0.3s ease;

}


.auth-group input::placeholder {

    color: #697084;

    opacity: 1;

}


/* Input Focus */

.auth-group input:focus {

    outline: none !important;

    border-color: #b89a55 !important;

    box-shadow:
        0 0 0 3px rgba(184, 154, 85, 0.08) !important;

}


/* Validation */

.auth-input-error {

    border-color: #d86c6c !important;

}


.auth-error {

    color: #e68181;

    font-size: 12px;

    margin-top: 8px;

}


/* =========================================================
   REMEMBER + FORGOT
========================================================= */

.auth-options {

    display: flex;

    justify-content: space-between;

    align-items: center;

    margin: 5px 0 28px;

}


.remember-me {

    display: flex;

    align-items: center;

    gap: 8px;

    color: #bcb9b2;

    font-size: 13px;

    cursor: pointer;

    margin: 0;

}


.remember-me input {

    width: 15px !important;

    height: 15px !important;

    accent-color: #b89a55;

}


.forgot-password {

    color: #b89a55;

    font-size: 13px;

    text-decoration: none;

    transition: 0.3s;

}


.forgot-password:hover {

    color: #e0c77f;

    text-decoration: none;

}


/* =========================================================
   BUTTON
========================================================= */

.auth-btn {

    width: 100% !important;

    height: 56px;

    background: transparent !important;

    border: 1px solid #b89a55 !important;

    border-radius: 0 !important;

    color: #d8bd72 !important;

    font-size: 12px !important;

    letter-spacing: 2.5px;

    text-transform: uppercase;

    font-weight: 600;

    cursor: pointer;

    transition: all 0.3s ease;

}


.auth-btn:hover {

    background: #b89a55 !important;

    color: #10172c !important;

    border-color: #b89a55 !important;

}


/* =========================================================
   DIVIDER
========================================================= */

.auth-divider {

    display: flex;

    align-items: center;

    gap: 15px;

    margin: 35px 0 25px;

}


.auth-divider span {

    height: 1px;

    flex: 1;

    background: #2d3446;

}


.auth-divider p {

    margin: 0;

    color: #898b93;

    font-size: 12px;

    white-space: nowrap;

}


/* =========================================================
   FOOTER
========================================================= */

.auth-footer {

    text-align: center;

}


.auth-footer a {

    color: #d8bd72;

    text-decoration: none;

    font-size: 13px;

    letter-spacing: 0.5px;

    transition: 0.3s;

}


.auth-footer a:hover {

    color: #ffffff;

    text-decoration: none;

}


/* =========================================================
   MOBILE
========================================================= */

@media (max-width: 767px) {

    .auth-page {

        padding: 50px 15px;

    }


    .auth-card {

        padding: 40px 25px;

    }


    .auth-header h1 {

        font-size: 36px !important;

    }


    .auth-options {

        flex-direction: column;

        align-items: flex-start;

        gap: 15px;

    }

}

</style>

@endsection