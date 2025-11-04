<?php session_start(); ?>
<!DOCTYPE html>
<html lang="id">

<head>
  <!-- ... (head sama seperti daftar.php, hanya ganti title) ... -->
  <title>Login - Polibatam</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/9.2.0/mdb.min.css" rel="stylesheet" />
  <style>
    /* ... (style sama seperti sebelumnya) ... */
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #3B4BAF;
      margin: 0;
      padding: 0;
    }

    .card {
      border-radius: 20px;
      background-color: #ffffff;
      color: #333;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    }

    .card-body {
      padding: 2.5rem;
    }

    img {
      width: 80px;
      margin-bottom: 15px;
    }

    h4 {
      font-weight: 600;
      color: #3B4BAF;
      margin-bottom: 30px;
    }

    .form-outline input {
      border-radius: 10px;
      background-color: #f9f9f9;
    }

    .btn-login {
      background-color: #3B4BAF;
      color: white;
      font-weight: 500;
      border-radius: 10px;
      width: 100%;
      transition: 0.3s;
    }

    .btn-login:hover {
      background-color: #2f3d8f;
    }

    .register-link {
      color: #3B4BAF;
      font-size: 0.9rem;
      text-decoration: none;
    }

    .register-link:hover {
      text-decoration: underline;
    }

    .login-container {
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .small-text {
      color: #666;
      font-size: 0.85rem;
      margin-top: 15px;
    }
  </style>
</head>

<body>
  <section class="login-container">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-11 col-md-8 col-lg-5">
          <div class="card">
            <div class="card-body text-center">
              <img src="rkm/image/poltek.png" alt="Logo Polibatam">
              <h4>Login</h4>

              <!-- Tampilkan Pesan Error atau Sukses -->
              <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                  <?php echo $_SESSION['error'];
                  unset($_SESSION['error']); ?>
                  <button type="button" class="btn-close" data-mdb-dismiss="alert" aria-label="Close"></button>
                </div>
              <?php endif; ?>
              <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                  <?php echo $_SESSION['success'];
                  unset($_SESSION['success']); ?>
                  <button type="button" class="btn-close" data-mdb-dismiss="alert" aria-label="Close"></button>
                </div>
              <?php endif; ?>

              <form action="proses_login.php" method="POST">
                <div class="form-outline mb-4">
                  <input type="text" id="username" name="username" class="form-control form-control-lg" required />
                  <label class="form-label" for="username">Username (NIK/NIM)</label>
                </div>

                <div class="form-outline mb-4">
                  <input type="password" id="password" name="password" class="form-control form-control-lg" required />
                  <label class="form-label" for="password">Password</label>
                </div>

                <button type="submit" class="btn btn-login btn-lg">Login</button>

                <p class="mt-3 mb-0">
                  Belum punya akun? <a href="daftar.php" class="register-link">Daftar di sini</a>
                </p>
              </form>

              <p class="small-text mt-4">&copy; 2025 Polibatam | Sistem Absensi Otomatis</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/9.2.0/mdb.umd.min.js"></script>
</body>

</html>