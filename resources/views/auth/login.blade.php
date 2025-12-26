<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Product Management System</title>
    @if(Storage::disk('public')->exists('images/favicon.png'))
        <link rel="icon" type="image/png" href="{{ Storage::url('images/favicon.png') }}">
    @else
        <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    @endif
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <div class="login-logo-container">
                @if(Storage::disk('public')->exists('images/logo.png'))
                <a href="{{ route('home') }}"><img src="{{ Storage::url('images/logo.png') }}" alt="Logo" class="login-logo"></a>
                @elseif(Storage::disk('public')->exists('images/logo.jpg'))
                    <a href="{{ route('home') }}"><img src="{{ Storage::url('images/logo.jpg') }}" alt="Logo" class="login-logo"></a>
                @else
                    <a href="{{ route('home') }}"><img src="{{ asset('images/logo.jpg') }}" alt="Logo" class="login-logo"></a>
                @endif
            </div>
            <h1 class="login-title">Admin Login</h1>
            <p class="login-subtitle">Product Management System</p>

            @if ($errors->any())
                <div class="alert alert-error">
                    <ul class="error-list">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login.submit') }}" class="login-form">
                @csrf

                <div class="form-group">
                    <label for="email" class="form-label">Email Address</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        class="form-input @error('email') input-error @enderror" 
                        value="{{ old('email') }}" 
                        required 
                        autofocus
                        placeholder="Enter your email"
                    >
                    @error('email')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        class="form-input @error('password') input-error @enderror" 
                        required
                        placeholder="Enter your password"
                    >
                    @error('password')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="checkbox-label">
                        <input type="checkbox" name="remember" class="checkbox-input">
                        <span class="checkbox-text">Remember me</span>
                    </label>
                </div>

                <button type="submit" class="btn btn-primary btn-block">Login</button>
            </form>
        </div>
    </div>
</body>
</html>

