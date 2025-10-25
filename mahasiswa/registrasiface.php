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
            font-family: 'Poppins', sans-serif;
            background-color: #f5f6fa;
            margin: 0;
            padding: 0;
        }

        .container {
            margin-top: 120px;
            max-width: 800px;
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            padding: 30px 40px;
            text-align: center;
        }

        h3 {
            color: #0E2F80;
            font-weight: 700;
        }

        p {
            color: #555;
            font-size: 15px;
        }

        #camera-container {
            margin-top: 25px;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            gap: 15px;
        }

        video,
        canvas {
            border-radius: 10px;
            width: 100%;
            max-width: 480px;
            background-color: #000;
        }

        #preview {
            display: none;
        }

        .btn-custom {
            background-color: #0E2F80;
            color: #fff;
            border-radius: 8px;
            font-weight: 500;
            transition: 0.3s;
        }

        .btn-custom:hover {
            background-color: #0c2461;
            transform: translateY(-2px);
        }

        .btn-back {
            background-color: #6c757d;
            color: #fff;
            border-radius: 8px;
            font-weight: 500;
            transition: 0.3s;
        }

        .btn-back:hover {
            background-color: #5a6268;
            transform: translateY(-2px);
        }

        .button-group {
            display: flex;
            justify-content: center;
            gap: 15px;
            flex-wrap: wrap;
            margin-top: 15px;
        }

        .info-box {
            background-color: #eaf0ff;
            border-left: 4px solid #0E2F80;
            padding: 15px;
            border-radius: 8px;
            font-size: 14px;
            text-align: left;
            margin-top: 20px;
            color: #333;
        }

        .back-container {
            text-align: center;
            margin-top: 25px;
        }
    </style>
</head>

<body>

    <div class="container">
        <h3><i class="fas fa-camera"></i> Registrasi Wajah Mahasiswa</h3>
        <p>Pastikan wajah Anda terlihat jelas di depan kamera untuk proses registrasi.</p>

        <div id="camera-container">
            <video id="video" autoplay></video>
            <canvas id="preview"></canvas>
        </div>

        <div class="button-group">
            <button id="startBtn" class="btn btn-custom"><i class="fa-solid fa-play"></i> Mulai Kamera</button>
            <button id="captureBtn" class="btn btn-custom" disabled><i class="fa-solid fa-camera"></i> Ambil Gambar</button>
            <button id="saveBtn" class="btn btn-success" disabled><i class="fa-solid fa-check"></i> Simpan Registrasi</button>
        </div>

        <div class="info-box">
            <strong>Tips:</strong>
            <ul style="margin: 8px 0 0 20px;">
                <li>Pastikan pencahayaan cukup dan wajah menghadap kamera.</li>
                <li>Hindari penggunaan masker atau kacamata gelap.</li>
                <li>Registrasi wajah ini akan digunakan untuk sistem absensi otomatis.</li>
            </ul>
        </div>

        <!-- Tombol Kembali -->
        <div class="back-container">
            <a href="navside.php" class="btn btn-back"><i class="fa-solid fa-arrow-left"></i> Kembali ke Rekap Absensi</a>
        </div>
    </div>

    <!-- Script -->
    <script>
        const video = document.getElementById('video');
        const canvas = document.getElementById('preview');
        const startBtn = document.getElementById('startBtn');
        const captureBtn = document.getElementById('captureBtn');
        const saveBtn = document.getElementById('saveBtn');
        const context = canvas.getContext('2d');
        let stream;

        // Mulai kamera
        startBtn.addEventListener('click', async () => {
            try {
                stream = await navigator.mediaDevices.getUserMedia({ video: true });
                video.srcObject = stream;
                captureBtn.disabled = false;
            } catch (err) {
                alert('Gagal mengakses kamera. Pastikan izin kamera diaktifkan.');
                console.error(err);
            }
        });

        // Ambil gambar dari video
        captureBtn.addEventListener('click', () => {
            canvas.style.display = 'block';
            context.drawImage(video, 0, 0, canvas.width, canvas.height);
            saveBtn.disabled = false;
        });

        // Simpan hasil registrasi (simulasi)
        saveBtn.addEventListener('click', () => {
            const imageData = canvas.toDataURL('image/png');
            alert('Wajah berhasil diregistrasi!');
            console.log('Data gambar:', imageData);
        });
    </script>

</body>

</html>
