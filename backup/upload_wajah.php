<?php
header('Content-Type: application/json');
include 'koneksi.php'; // file koneksi ke MySQL

$data = json_decode(file_get_contents("php://input"));

if (!$data || empty($data->image) || empty($data->nim) || empty($data->nama)) {
  echo json_encode(["message" => "Data tidak lengkap."]);
  exit;
}

$nim = $data->nim;
$nama = $data->nama;
$image = $data->image;

// Decode base64
$image = str_replace('data:image/png;base64,', '', $image);
$image = str_replace(' ', '+', $image);
$imageData = base64_decode($image);

// Buat folder uploads jika belum ada
if (!file_exists('uploads')) {
  mkdir('uploads', 0777, true);
}

// Nama file
$fileName = 'uploads/' . $nim . '_' . time() . '.png';

// Simpan file
if (file_put_contents($fileName, $imageData)) {
  // Simpan ke database
  $query = "INSERT INTO registrasi_wajah (nim, nama, foto_path) VALUES ('$nim', '$nama', '$fileName')";
  if (mysqli_query($conn, $query)) {
    echo json_encode(["message" => "Registrasi wajah berhasil disimpan!"]);
  } else {
    echo json_encode(["message" => "Gagal menyimpan ke database."]);
  }
} else {
  echo json_encode(["message" => "Gagal menyimpan gambar."]);
}
?>
