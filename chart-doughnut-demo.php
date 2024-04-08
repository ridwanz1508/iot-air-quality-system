<?php 
    //membuat koneksi ke database
    $conn = mysqli_connect ("localhost", "root", "", "iot-air-quality-db");
    // Memeriksa koneksi
    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    // Query untuk mengambil data terbaru dari tabel
    $query = "SELECT * FROM `tb-dataarea` ORDER BY id DESC LIMIT 1";
    $result = $conn->query($query);

    $data = array();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $pm10 = $row['PM10'];
        $no2 = $row['NO2'];
        $co2 = $row['CO'];
        $co = $row['CO2'];

    // Membuat array data berdasarkan kondisi
    $data = array(
        'Baik' => 0,
        'Sedang' => 0,
        'Tidak Sehat' => 0
    );

    if ($pm10 > 150 || $no2 > 565 || $co2 > 536 || $co > 10) {
        $data['Tidak Sehat'] = 100;
    } elseif (($pm10 >= 101 && $pm10 <= 150) || ($no2 >= 282 && $no2 <= 565) || ($co2 >= 447 && $co2 <= 536) || ($co >= 5 && $co <= 10)) {
        $data['Sedang'] = 100;
    } else {
        $data['Baik'] = 100;
    }
}
// Mengirimkan data dalam format JSON
header('Content-Type: application/json');
echo json_encode($data);
$conn->close();
