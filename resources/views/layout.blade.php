<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CRUD Laravel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    @yield('styles')
</head>
<body>
    @unless(request()->routeIs('login') || request()->routeIs('register'))
    <nav class="navbar navbar-expand-lg navbar-light bg-light mb-3">
        <div class="container">
            <a class="navbar-brand" href="#">CRUD Laravel</a>
            <div class="ms-auto">
                @if(auth()->check())
                    <div class="d-inline me-2 align-middle text-end">
                        @php $wallet = auth()->user()->wallet ?? null; @endphp
                        <a href="{{ route('wallet.show') }}" class="btn btn-sm btn-outline-success">
                            Coins: <span class="badge bg-warning text-dark">{{ $wallet ? $wallet->coins : 0 }}</span>
                        </a>
                    </div>
                    <div class="dropdown d-inline">
                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ auth()->user()->name }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                            <li><a class="dropdown-item" href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li><a class="dropdown-item" href="{{ route('profile.show') }}">Profil</a></li>
                            <li><a class="dropdown-item" href="{{ route('wallet.show') }}">Wallet</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="btn btn-sm btn-outline-primary me-1">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-sm btn-primary">Register</a>
                @endif
            </div>
        </div>
    </nav>
    @endunless

    <div class="container">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function(){
        // Track clicked submit button per form so we can show loading state
        document.querySelectorAll('form').forEach(function(form){
            form.addEventListener('click', function(e){
                var target = e.target;
                if(!target) return;
                if((target.tagName === 'BUTTON' && target.type === 'submit') || (target.tagName === 'INPUT' && target.type === 'submit')){
                    form._clickedButton = target;
                }
            });

            form.addEventListener('submit', function(){
                var btn = form._clickedButton || form.querySelector('button[type="submit"], input[type="submit"]');
                if(!btn) return;
                // prevent double submission
                btn.disabled = true;
                var loadingText = btn.getAttribute('data-loading-text') || 'Loading...';
                // save original
                if(!btn._origHtml) btn._origHtml = btn.innerHTML;
                btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>' + loadingText;
            });
        });
    });
    </script>
    @yield('scripts')
</body>
</html>
