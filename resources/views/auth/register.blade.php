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
                    <svg class="form-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M3 12L12 3l9 9" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M21 21H3v-6h18v6z" fill="white" opacity="0.12"/>
                    </svg>
                </div>
                <h4 class="mb-0">Buat Akun Baru</h4>
                <p class="text-muted small">Masukkan data untuk membuat akun</p>
            </div>

            <form method="POST" action="{{ route('register.post') }}" novalidate>
                @csrf

                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="form-control" required autofocus>
                    @error('name')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="form-control" required>
                    @error('email')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required>
                    @error('password')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <a href="{{ route('login') }}" class="text-decoration-none">Sudah punya akun? Masuk</a>
                    <button type="submit" class="btn btn-primary btn-submit" data-loading-text="Daftar...">Daftar</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
