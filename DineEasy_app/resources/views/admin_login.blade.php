<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Login | DineEasy</title>
  @vite(['resources/css/app.css','resources/js/app.js'])
  <style>
    .login-container {
      max-width: 420px;
      margin: 6rem auto;
      background: #fff;
      border-radius: 18px;
      box-shadow: 0 5px 20px rgba(0,0,0,0.1);
      padding: 2rem;
      text-align: center;
    }
    .login-container h2 {
      color: #3f51b5;
      margin-bottom: 1.5rem;
    }
    .login-container input {
      width: 100%;
      padding: 0.8rem;
      margin: 0.5rem 0;
      border-radius: 10px;
      border: 1px solid #ccc;
      font-size: 1rem;
    }
    .login-container button {
      width: 100%;
      margin-top: 1rem;
      background: linear-gradient(90deg, #3f51b5, #7e57c2);
      color: white;
      border: none;
      padding: 0.8rem;
      border-radius: 25px;
      font-weight: 600;
      cursor: pointer;
      transition: 0.3s ease;
    }
    .login-container button:hover {
      background: linear-gradient(90deg, #283593, #512da8);
    }
  </style>
</head>
<body>

  <header>DineEasy Admin Panel</header>

  <div class="login-container">
    <h2>Admin Login</h2>

    @if(session('error'))
      <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ route('admin.login.submit') }}">
      @csrf
      <input type="email" name="email" placeholder="Email" required>
      <input type="password" name="password" placeholder="Password" required>
      <button type="submit">Login</button>
    </form>

    <p style="margin-top:15px;">
      <a href="{{ url('/') }}" style="color:#3f51b5;text-decoration:none;">← Back to Kiosk</a>
    </p>
  </div>

  <footer>© 2025 DineEasy</footer>

</body>
</html>
