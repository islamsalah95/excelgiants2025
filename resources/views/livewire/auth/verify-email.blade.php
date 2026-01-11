<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Verify Email</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body text-center">

                    <p>Please verify your email address by clicking the link sent to your email.</p>

                    @if (session('status') === 'verification-link-sent')
                        <div class="alert alert-success">
                            A new verification link has been sent.
                        </div>
                    @endif

                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <button class="btn btn-primary w-100 mb-2">
                            Resend verification email
                        </button>
                    </form>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="btn btn-link text-danger">
                            Log out
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
