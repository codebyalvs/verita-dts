<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Enter Verification Code</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Enter Verification Code</div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <p>A verification code has been sent to your email address. Please enter the code below to reset your password.</p>

                        <form method="POST" action="{{ route('password.verify.code') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="code" class="form-label">Verification Code</label>
                                <input type="text" class="form-control @error('code') is-invalid @enderror" id="code" name="code" required autofocus>
                                @error('code')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">Verify</button>
                        </form>

                        <hr>

                        <form method="POST" action="{{ route('password.resend.code') }}">
                            @csrf
                            <p class="mt-3">
                                <strong>Didn't receive the email?</strong>
                                <button type="submit" class="btn btn-link p-0 m-0 align-baseline">Resend Code</button>.
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
