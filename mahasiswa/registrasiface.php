<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'mahasiswa') {
    header("Location: ../login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Wajah - Mahasiswa</title>

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />

    <!-- MDB UI Kit -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/9.2.0/mdb.min.css" rel="stylesheet" />

    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #0E2F80;
            margin: 0;
            padding: 20px;
            min-height: 100vh;
        }

        .container {
            max-width: 700px;
            margin: 0 auto;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
            padding: 30px;
        }

        /* Header Section */
        .header-section {
            text-align: center;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f0f0f0;
        }

        .header-section h1 {
            color: #2c3e50;
            font-size: 24px;
            font-weight: 600;
            margin: 0 0 8px 0;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .header-section .subtitle {
            color: #7f8c8d;
            font-size: 14px;
            margin: 0;
        }

        /* Camera Section */
        .camera-section {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .camera-wrapper {
            position: relative;
            max-width: 500px;
            margin: 0 auto;
            border-radius: 10px;
            overflow: hidden;
            background: #000;
        }

        video {
            width: 100%;
            height: auto;
            display: block;
            border-radius: 10px;
            transform: scaleX(-1);
        }

        canvas {
            width: 100%;
            height: auto;
            display: block;
            border-radius: 10px;
        }

        #preview {
            display: none;
        }

        /* Face Detection Overlay */
        .face-overlay {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 240px;
            height: 300px;
            border: 3px dashed rgba(14, 47, 128, 0.6);
            border-radius: 50%;
            pointer-events: none;
            display: none;
        }

        .face-overlay.active {
            display: block;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 0.6; }
            50% { opacity: 1; }
        }

        /* Status Messages */
        .status-message {
            text-align: center;
            padding: 10px 16px;
            border-radius: 8px;
            margin: 12px 0;
            font-size: 13px;
            font-weight: 500;
            display: none;
        }

        .status-message.info {
            background: #e3f2fd;
            color: #1976d2;
            border-left: 4px solid #1976d2;
            display: block;
        }

        .status-message.success {
            background: #e8f5e9;
            color: #2e7d32;
            border-left: 4px solid #2e7d32;
        }

        .status-message.warning {
            background: #fff3e0;
            color: #e65100;
            border-left: 4px solid #e65100;
        }

        /* Buttons */
        .action-buttons {
            display: flex;
            gap: 10px;
            justify-content: center;
            flex-wrap: wrap;
            margin-top: 18px;
        }

        .btn {
            padding: 10px 24px;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            min-width: 140px;
            justify-content: center;
        }

        .btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            transform: none !important;
        }

        .btn-primary {
            background: #0E2F80;
            color: white;
        }

        .btn-primary:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(14, 47, 128, 0.4);
            background: #0a2460;
        }

        .btn-success {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
        }

        .btn-success:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
        }

        .btn-secondary {
            background: #6c757d;
            color: white;
        }

        .btn-secondary:hover:not(:disabled) {
            background: #5a6268;
            transform: translateY(-2px);
        }

        .btn-outline {
            background: white;
            color: #0E2F80;
            border: 2px solid #0E2F80;
        }

        .btn-outline:hover:not(:disabled) {
            background: #0E2F80;
            color: white;
            transform: translateY(-2px);
        }

        /* Guidelines */
        .guidelines {
            background: white;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            padding: 18px;
            margin-top: 20px;
        }

        .guidelines h3 {
            color: #2c3e50;
            font-size: 15px;
            margin: 0 0 12px 0;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .guidelines ul {
            margin: 0;
            padding-left: 22px;
            color: #555;
        }

        .guidelines li {
            margin-bottom: 8px;
            line-height: 1.5;
            font-size: 13px;
        }

        /* Navigation */
        .navigation {
            margin-top: 25px;
            padding-top: 18px;
            border-top: 2px solid #f0f0f0;
            text-align: center;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .container {
                padding: 20px 16px;
            }

            .header-section h1 {
                font-size: 20px;
            }

            .action-buttons {
                flex-direction: column;
            }

            .btn {
                width: 100%;
            }
        }

        /* Loading Spinner */
        .spinner {
            display: none;
            width: 35px;
            height: 35px;
            border: 4px solid #f3f3f3;
            border-top: 4px solid #0E2F80;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 15px auto;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .spinner.active {
            display: block;
        }
    </style>
</head>

<body>

    <div class="container">
        <!-- Header -->
        <div class="header-section">
            <h1>
                <i class="fas fa-user-circle"></i>
                Registrasi Wajah Mahasiswa
            </h1>
            <p class="subtitle">Sistem Absensi Berbasis Pengenalan Wajah</p>
        </div>

        <!-- Status Message -->
        <div class="status-message info" id="statusMsg">
            <i class="fas fa-info-circle"></i> Klik tombol "Aktifkan Kamera" untuk memulai proses registrasi
        </div>

        <!-- Camera Section -->
        <div class="camera-section">
            <div class="camera-wrapper">
                <video id="video" autoplay playsinline></video>
                <canvas id="preview" width="640" height="480"></canvas>
                <div class="face-overlay" id="faceOverlay"></div>
            </div>
            <div class="spinner" id="loadingSpinner"></div>
        </div>

        <!-- Action Buttons -->
        <div class="action-buttons">
            <button id="startBtn" class="btn btn-primary">
                <i class="fas fa-video"></i> Aktifkan Kamera
            </button>
            <button id="captureBtn" class="btn btn-primary" disabled>
                <i class="fas fa-camera"></i> Ambil Foto
            </button>
            <button id="retakeBtn" class="btn btn-outline" style="display: none;">
                <i class="fas fa-redo"></i> Ambil Ulang
            </button>
            <button id="saveBtn" class="btn btn-success" disabled>
                <i class="fas fa-check-circle"></i> Simpan & Daftar
            </button>
        </div>

        <!-- Guidelines -->
        <div class="guidelines">
            <h3>
                <i class="fas fa-lightbulb"></i> Panduan Registrasi
            </h3>
            <ul>
                <li><strong>Pencahayaan:</strong> Pastikan ruangan memiliki pencahayaan yang cukup</li>
                <li><strong>Posisi Wajah:</strong> Posisikan wajah tepat di tengah kamera</li>
                <li><strong>Jarak:</strong> Jaga jarak sekitar 30-50 cm dari kamera</li>
                <li><strong>Aksesoris:</strong> Lepas masker, kacamata hitam, atau topi</li>
                <li><strong>Ekspresi:</strong> Gunakan ekspresi wajah netral</li>
            </ul>
        </div>

        <!-- Navigation -->
        <div class="navigation">
            <a href="dashboard.php" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
            </a>
        </div>
    </div>

    <!-- Script -->
    <script>
        const video = document.getElementById('video');
        const canvas = document.getElementById('preview');
        const startBtn = document.getElementById('startBtn');
        const captureBtn = document.getElementById('captureBtn');
        const retakeBtn = document.getElementById('retakeBtn');
        const saveBtn = document.getElementById('saveBtn');
        const statusMsg = document.getElementById('statusMsg');
        const faceOverlay = document.getElementById('faceOverlay');
        const loadingSpinner = document.getElementById('loadingSpinner');
        const context = canvas.getContext('2d');
        let stream;

        // Update status message
        function updateStatus(message, type = 'info') {
            statusMsg.className = `status-message ${type}`;
            statusMsg.innerHTML = `<i class="fas fa-${type === 'success' ? 'check-circle' : type === 'warning' ? 'exclamation-triangle' : 'info-circle'}"></i> ${message}`;
            statusMsg.style.display = 'block';
        }

        // Start camera
        startBtn.addEventListener('click', async () => {
            try {
                loadingSpinner.classList.add('active');
                updateStatus('Mengakses kamera...', 'info');
                
                stream = await navigator.mediaDevices.getUserMedia({ 
                    video: { 
                        width: { ideal: 640 },
                        height: { ideal: 480 },
                        facingMode: 'user'
                    } 
                });
                
                video.srcObject = stream;
                video.style.display = 'block';
                canvas.style.display = 'none';
                faceOverlay.classList.add('active');
                
                startBtn.disabled = true;
                captureBtn.disabled = false;
                retakeBtn.style.display = 'none';
                saveBtn.disabled = true;
                
                loadingSpinner.classList.remove('active');
                updateStatus('Kamera aktif! Posisikan wajah Anda di dalam area oval dan klik "Ambil Foto"', 'success');
                
            } catch (err) {
                loadingSpinner.classList.remove('active');
                updateStatus('Gagal mengakses kamera. Pastikan Anda telah memberikan izin akses kamera.', 'warning');
                console.error('Camera error:', err);
            }
        });

        // Capture photo
        captureBtn.addEventListener('click', () => {
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            context.drawImage(video, 0, 0, canvas.width, canvas.height);
            
            video.style.display = 'none';
            canvas.style.display = 'block';
            faceOverlay.classList.remove('active');
            
            captureBtn.disabled = true;
            retakeBtn.style.display = 'inline-flex';
            saveBtn.disabled = false;
            
            updateStatus('Foto berhasil diambil! Periksa hasil foto dan klik "Simpan & Daftar" jika sudah sesuai', 'success');
        });

        // Retake photo
        retakeBtn.addEventListener('click', () => {
            video.style.display = 'block';
            canvas.style.display = 'none';
            faceOverlay.classList.add('active');
            
            captureBtn.disabled = false;
            retakeBtn.style.display = 'none';
            saveBtn.disabled = true;
            
            updateStatus('Silakan ambil foto ulang. Posisikan wajah Anda dengan baik', 'info');
        });

        // Save registration
        saveBtn.addEventListener('click', () => {
            loadingSpinner.classList.add('active');
            updateStatus('Menyimpan data registrasi...', 'info');
            
            const imageData = canvas.toDataURL('image/png');
            
            // Simulate saving process
            setTimeout(() => {
                loadingSpinner.classList.remove('active');
                updateStatus('Registrasi wajah berhasil disimpan! Anda akan dialihkan ke dashboard...', 'success');
                
                // Stop camera
                if (stream) {
                    stream.getTracks().forEach(track => track.stop());
                }
                
                console.log('Image data saved:', imageData);
                
                // Redirect after 2 seconds
                setTimeout(() => {
                    // window.location.href = 'dashboard.php';
                    alert('Registrasi berhasil! (Demo mode - redirect dinonaktifkan)');
                }, 2000);
            }, 1500);
        });

        // Cleanup on page unload
        window.addEventListener('beforeunload', () => {
            if (stream) {
                stream.getTracks().forEach(track => track.stop());
            }
        });
    </script>

</body>

</html>