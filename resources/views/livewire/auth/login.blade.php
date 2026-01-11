<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap (optional) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-5">

                <div class="card shadow-sm">
                    <div class="card-body">

                        <h4 class="text-center mb-4">Login</h4>

                        {{-- Session Status --}}
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif

                        {{-- Validation Errors --}}
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login.store') }}">
                            @csrf

                            {{-- Email --}}
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" value="{{ old('email') }}"
                                    required autofocus>
                            </div>

                            {{-- Password --}}
                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>

                            {{-- Remember --}}
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                    {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remember">
                                    Remember me
                                </label>
                            </div>

                            {{-- Forgot Password --}}
                            @if (Route::has('password.request'))
                                <div class="mb-3 text-end">
                                    <a href="{{ route('password.request') }}" class="text-decoration-none">
                                        Forgot your password?
                                    </a>
                                </div>
                            @endif

                            {{-- Submit --}}
                            <button type="submit" class="btn btn-primary w-100">
                                Login
                            </button>
                        </form>

                        {{-- Register --}}
                        @if (Route::has('register'))
                            <div class="text-center mt-3">
                                <span>Don't have an account?</span>
                                <a href="{{ route('register') }}">Sign up</a>
                            </div>
                        @endif

                    </div>
                </div>

            </div>
        </div>
    </div>

</body>

</html>
