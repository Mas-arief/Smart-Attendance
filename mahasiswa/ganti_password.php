<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ganti Password — Bootstrap</title>

    <!-- Bootstrap CSS (v5) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons (opsional, untuk icon mata) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background: #f8fafc;
        }

        .card {
            max-width: 520px;
            margin: 48px auto;
        }
    </style>
</head>

<body>
    <main class="container">
        <div class="card shadow-sm">
            <div class="card-body p-4">
                <h5 class="card-title mb-3">Ganti Password</h5>
                <p class="text-muted small">Masukkan password baru dan konfirmasi password baru.</p>

                <form id="changePasswordForm" novalidate>
                    <div class="mb-3">
                        <label for="newPassword" class="form-label">Password baru</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="newPassword" minlength="8" required aria-describedby="newPasswordHelp">
                            <button type="button" class="btn btn-outline-secondary" id="toggleNew" aria-label="Tampilkan password">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                        <div id="newPasswordHelp" class="form-text">Minimal 8 karakter.</div>
                        <div class="invalid-feedback">Password harus minimal 8 karakter.</div>
                    </div>

                    <div class="mb-3">
                        <label for="confirmPassword" class="form-label">Konfirmasi password baru</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="confirmPassword" required aria-describedby="confirmHelp">
                            <button type="button" class="btn btn-outline-secondary" id="toggleConfirm" aria-label="Tampilkan konfirmasi password">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                        <div id="confirmHelp" class="form-text">Ketik ulang password baru.</div>
                        <div class="invalid-feedback" id="confirmFeedback">Password tidak cocok.</div>
                    </div>

                    <div class="d-grid">
                        <button id="submitBtn" class="btn btn-primary" type="submit">Simpan perubahan</button>
                    </div>
                </form>

                <div class="alert alert-success mt-3 d-none" id="successAlert" role="alert">
                    Password berhasil diubah.
                </div>

            </div>
        </div>
    </main>

    <!-- Bootstrap JS (bundle includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Elemen
        const form = document.getElementById('changePasswordForm');
        const newPwd = document.getElementById('newPassword');
        const confirmPwd = document.getElementById('confirmPassword');
        const confirmFeedback = document.getElementById('confirmFeedback');
        const successAlert = document.getElementById('successAlert');
        const toggleNew = document.getElementById('toggleNew');
        const toggleConfirm = document.getElementById('toggleConfirm');

        // Toggle visibility
        function toggleVisibility(input, btn) {
            if (input.type === 'password') {
                input.type = 'text';
                btn.querySelector('i').classList.remove('bi-eye');
                btn.querySelector('i').classList.add('bi-eye-slash');
                btn.setAttribute('aria-pressed', 'true');
            } else {
                input.type = 'password';
                btn.querySelector('i').classList.remove('bi-eye-slash');
                btn.querySelector('i').classList.add('bi-eye');
                btn.setAttribute('aria-pressed', 'false');
            }
        }

        toggleNew.addEventListener('click', () => toggleVisibility(newPwd, toggleNew));
        toggleConfirm.addEventListener('click', () => toggleVisibility(confirmPwd, toggleConfirm));

        // Validasi matching
        function validateMatch() {
            // Reset custom validity
            confirmPwd.classList.remove('is-invalid');
            confirmFeedback.textContent = 'Password tidak cocok.';

            if (confirmPwd.value === '') return false;
            if (newPwd.value !== confirmPwd.value) {
                confirmPwd.classList.add('is-invalid');
                return false;
            }
            return true;
        }

        // Event listeners
        newPwd.addEventListener('input', () => {
            // check minlength
            if (newPwd.value.length >= parseInt(newPwd.getAttribute('minlength'))) {
                newPwd.classList.remove('is-invalid');
            } else {
                newPwd.classList.add('is-invalid');
            }
            // re-validate match
            validateMatch();
        });

        confirmPwd.addEventListener('input', () => {
            validateMatch();
        });

        form.addEventListener('submit', (e) => {
            e.preventDefault();
            // Basic validity
            const minLenOk = newPwd.value.length >= parseInt(newPwd.getAttribute('minlength'));
            const matchOk = newPwd.value === confirmPwd.value;

            if (!minLenOk) {
                newPwd.classList.add('is-invalid');
            }
            if (!matchOk) {
                confirmPwd.classList.add('is-invalid');
                confirmFeedback.textContent = 'Password tidak cocok.';
            }

            if (minLenOk && matchOk) {
                // --- Di sini lakukan request ke server (fetch/ajax) untuk ganti password ---
                // Contoh: fetch('/api/change-password', { method: 'POST', body: JSON.stringify({ password: newPwd.value }) })
                // Untuk demo, hanya tampilkan pesan sukses.
                successAlert.classList.remove('d-none');
                // reset form
                form.reset();
                // sembunyikan pesan setelah 3 detik
                setTimeout(() => successAlert.classList.add('d-none'), 3000);
            }
        });
    </script>
</body>

</html>