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
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            margin: 0;
            padding: 20px;
            min-height: 100vh;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
            padding: 40px;
        }

        /* Header Section */
        .header-section {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #f0f0f0;
        }

        .header-section h1 {
            color: #2c3e50;
            font-size: 28px;
            font-weight: 600;
            margin: 0 0 10px 0;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
        }

        .header-section .subtitle {
            color: #7f8c8d;
            font-size: 15px;
            margin: 0;
        }

        /* Progress Steps */
        .progress-steps {
            display: flex;
            justify-content: space-between;
            margin-bottom: 35px;
            position: relative;
        }

        .progress-steps::before {
            content: '';
            position: absolute;
            top: 20px;
            left: 10%;
            right: 10%;
            height: 3px;
            background: #e0e0e0;
            z-index: 0;
        }

        .step {
            flex: 1;
            text-align: center;
            position: relative;
            z-index: 1;
        }

        .step-circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #e0e0e0;
            color: #95a5a6;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 10px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .step.active .step-circle {
            background: #667eea;
            color: white;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        }

        .step.completed .step-circle {
            background: #10b981;
            color: white;
        }

        .step-label {
            font-size: 13px;
            color: #7f8c8d;
            font-weight: 500;
        }

        .step.active .step-label {
            color: #2c3e50;
            font-weight: 600;
        }

        /* Camera Section */
        .camera-section {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 25px;
        }

        .camera-wrapper {
            position: relative;
            max-width: 640px;
            margin: 0 auto;
            border-radius: 12px;
            overflow: hidden;
            background: #000;
        }

        video, canvas {
            width: 100%;
            height: auto;
            display: block;
            border-radius: 12px;
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
            width: 280px;
            height: 350px;
            border: 3px dashed rgba(102, 126, 234, 0.6);
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
            padding: 12px 20px;
            border-radius: 8px;
            margin: 15px 0;
            font-size: 14px;
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
            gap: 12px;
            justify-content: center;
            flex-wrap: wrap;
            margin-top: 20px;
        }

        .btn {
            padding: 12px 28px;
            border: none;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            min-width: 160px;
            justify-content: center;
        }

        .btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            transform: none !important;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .btn-primary:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
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
            color: #667eea;
            border: 2px solid #667eea;
        }

        .btn-outline:hover:not(:disabled) {
            background: #667eea;
            color: white;
            transform: translateY(-2px);
        }

        /* Guidelines */
        .guidelines {
            background: white;
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            padding: 20px;
            margin-top: 25px;
        }

        .guidelines h3 {
            color: #2c3e50;
            font-size: 16px;
            margin: 0 0 15px 0;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .guidelines ul {
            margin: 0;
            padding-left: 25px;
            color: #555;
        }

        .guidelines li {
            margin-bottom: 10px;
            line-height: 1.6;
            font-size: 14px;
        }

        /* Navigation */
        .navigation {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 2px solid #f0f0f0;
            text-align: center;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .container {
                padding: 25px 20px;
            }

            .header-section h1 {
                font-size: 22px;
            }

            .progress-steps {
                flex-direction: column;
                gap: 15px;
            }

            .progress-steps::before {
                display: none;
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
            width: 40px;
            height: 40px;
            border: 4px solid #f3f3f3;
            border-top: 4px solid #667eea;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 20px auto;
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

        <!-- Progress Steps -->
        <div class="progress-steps">
            <div class="step active" id="step1">
                <div class="step-circle">1</div>
                <div class="step-label">Aktifkan Kamera</div>
            </div>
            <div class="step" id="step2">
                <div class="step-circle">2</div>
                <div class="step-label">Ambil Foto</div>
            </div>
            <div class="step" id="step3">
                <div class="step-circle">3</div>
                <div class="step-label">Konfirmasi</div>
            </div>
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
                <li><strong>Pencahayaan:</strong> Pastikan ruangan memiliki pencahayaan yang cukup dan wajah Anda tidak terlalu gelap atau terang</li>
                <li><strong>Posisi Wajah:</strong> Posisikan wajah tepat di tengah kamera dan hadap langsung ke depan</li>
                <li><strong>Jarak:</strong> Jaga jarak sekitar 30-50 cm dari kamera untuk hasil optimal</li>
                <li><strong>Aksesoris:</strong> Lepas masker, kacamata hitam, atau topi yang menutupi wajah</li>
                <li><strong>Ekspresi:</strong> Gunakan ekspresi wajah netral dan pastikan mata terlihat jelas</li>
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

        // Update progress steps
        function updateStep(stepNumber) {
            document.querySelectorAll('.step').forEach((step, index) => {
                if (index < stepNumber - 1) {
                    step.classList.add('completed');
                    step.classList.remove('active');
                } else if (index === stepNumber - 1) {
                    step.classList.add('active');
                    step.classList.remove('completed');
                } else {
                    step.classList.remove('active', 'completed');
                }
            });
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
                updateStep(2);
                
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
            updateStep(3);
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
            updateStep(2);
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