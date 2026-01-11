<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Two Factor Authentication</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow-sm">
                <div class="card-body">

                    <h4 class="text-center mb-4">Authentication Code</h4>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('two-factor.login.store') }}">
                        @csrf

                        <div class="mb-3">
                            <label>Authentication Code</label>
                            <input type="text" name="code" class="form-control" required autofocus>
                        </div>

                        <div class="mb-3">
                            <label>Recovery Code (optional)</label>
                            <input type="text" name="recovery_code" class="form-control">
                        </div>

                        <button class="btn btn-primary w-100">Continue</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
