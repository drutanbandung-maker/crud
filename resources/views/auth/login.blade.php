@extends('layout')

@section('styles')
<style>
    body { background: linear-gradient(135deg,#6dd5ed 0%,#2193b0 100%); min-height:100vh; }
    .auth-card { max-width:420px; margin:6vh auto; }
    .brand { width:72px; height:72px; border-radius:12px; display:inline-flex; align-items:center; justify-content:center; background:rgba(255,255,255,0.12); }
    .form-icon { width:20px; height:20px; opacity:.7 }
</style>
@endsection

@section('content')
<div class="auth-card">
    <div class="card shadow-lg">
        <div class="card-body p-4">
            <div class="text-center mb-3">
                <div class="brand mx-auto mb-2">
                    <!-- simple SVG logo -->
                    <svg class="form-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M3 12L12 3l9 9" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M21 21H3v-6h18v6z" fill="white" opacity="0.12"/>
                    </svg>
                </div>
                <h4 class="mb-0">Masuk ke akun Anda</h4>
                <p class="text-muted small">Masukkan email dan password untuk melanjutkan</p>
            </div>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form method="POST" action="{{ route('login.post') }}" novalidate>
                @csrf

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white"><svg class="form-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3 8l9 6 9-6" stroke="#6c757d" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
                        <input type="email" name="email" value="{{ old('email') }}" class="form-control" required autofocus autocomplete="email">
                    </div>
                    @error('email')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white"><svg class="form-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 15v2" stroke="#6c757d" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/><rect x="6" y="11" width="12" height="6" rx="2" stroke="#6c757d" stroke-width="1.2"/></svg></span>
                        <input type="password" name="password" class="form-control" required autocomplete="current-password">
                    </div>
                    @error('password')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <a href="{{ route('register') }}" class="text-decoration-none">Belum punya akun? Daftar</a>
                    <button type="submit" class="btn btn-primary btn-submit" data-loading-text="Masuk...">Masuk</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
