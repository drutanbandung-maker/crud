@extends('layout')

@section('styles')
<style>
  .profile-header { background: linear-gradient(135deg,#667eea 0%,#764ba2 100%); color:white; padding:3rem 1rem; border-radius:12px; margin-bottom:2rem; }
  .avatar-box { width:120px; height:120px; border-radius:12px; overflow:hidden; border:4px solid rgba(255,255,255,0.2); display:inline-block; }
  .avatar-box img { width:100%; height:100%; object-fit:cover; }
  .card { border:none; box-shadow:0 2px 8px rgba(0,0,0,0.08); border-radius:12px; }
  .card-header { background:#f8f9fa; border-radius:12px 12px 0 0; border:none; font-weight:600; }
  .form-control, .form-select { border-radius:8px; border:1px solid #e0e0e0; }
  .form-control:focus, .form-select:focus { border-color:#667eea; box-shadow:0 0 0 0.2rem rgba(102,126,234,0.15); }
  .btn-primary { background:#667eea; border:none; border-radius:8px; }
  .btn-primary:hover { background:#5568d3; }
</style>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        
        <!-- Profile Header with Avatar -->
        <div class="profile-header">
            <div class="d-flex align-items-end gap-3">
                <div class="avatar-box">
                    @if($user->avatar)
                        <img src="{{ asset('storage/'.$user->avatar) }}" alt="{{ $user->name }}">
                    @else
                        <div style="width:100%; height:100%; background:#667eea; display:flex; align-items:center; justify-content:center; font-size:48px;">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                    @endif
                </div>
                <div>
                    <h2 class="mb-0">{{ $user->name }}</h2>
                    <p class="mb-0 text-white-50">{{ $user->email }}</p>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Update Profile Card -->
        <div class="card mb-4">
            <div class="card-header">
                <i class="bi bi-pencil-square"></i> Update Profil
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('profile.updateProfile') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-500">Nomor Telepon</label>
                            <input type="text" name="phone" class="form-control" value="{{ $user->phone }}" placeholder="+62 812 3456 7890">
                            @error('phone')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-500">Ganti Avatar</label>
                            <input type="file" name="avatar" class="form-control" accept="image/*">
                            @error('avatar')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary btn-submit" data-loading-text="Memperbarui...">
                            <i class="bi bi-check-circle"></i> Perbarui Profil
                        </button>
                        <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Change Password Card -->
        <div class="card">
            <div class="card-header">
                <i class="bi bi-lock"></i> Ubah Password
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('profile.updatePassword') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-500">Password Saat Ini</label>
                        <input type="password" name="current_password" class="form-control" placeholder="Masukkan password saat ini" required>
                        @error('current_password')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-500">Password Baru</label>
                            <input type="password" name="password" class="form-control" placeholder="Min. 6 karakter" required>
                            @error('password')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-500">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password baru" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-submit" data-loading-text="Memperbarui...">
                        <i class="bi bi-check-circle"></i> Ubah Password
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection
