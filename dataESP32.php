<?php
    // Koneksi ke database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "iot-air-quality-db";

    // Membuat koneksi
    $konek = mysqli_connect($servername, $username, $password, $dbname);
    // Memeriksa koneksi
    if (!$konek) {
        die("Koneksi gagal: " . mysqli_connect_error());
    }
    // Mengecek apakah ada data yang dikirimkan dari ESP32
    if (isset($_GET['NO2']) && isset($_GET['PM10']) && isset($_GET['CO']) && isset($_GET['CO2'])) {
        // Membaca data yang dikirim dari ESP32
        $NO2 = $_GET['NO2'];
        $PM10 = $_GET['PM10'];
        $CO = $_GET['CO'];
        $CO2 = $_GET['CO2'];

        // Melakukan sanitasi pada data untuk mencegah serangan injeksi SQL
        $NO2 = mysqli_real_escape_string($konek, $NO2);
        $PM10 = mysqli_real_escape_string($konek, $PM10);
        $CO = mysqli_real_escape_string($konek, $CO);
        $CO2 = mysqli_real_escape_string($konek, $CO2);
        
        //auto increament = 1 atau mengembalikan id = 1 apabila dikosongkan
        mysqli_query ($konek, "ALTER TABLE `tb-dataarea` AUTO_INCREMENT = 1");

        // Menyimpan data ke tabel tb-dataarea
        $sql = "INSERT INTO `tb-dataarea` (NO2, PM10, CO, CO2) VALUES ('.$NO2.', '.$PM10.', '.$CO.', '.$CO2.')";

        if (mysqli_query($konek, $sql)) {
            echo "Successful Sending";
        } else {
            echo "Failed Sending: " . mysqli_error($konek);
        }
    } else {
        echo "Invalid data";
    }
    // Menutup koneksi ke database
    mysqli_close($konek);
?>


<!--
//koneksi ke database
$konek = mysqli_connect ("localhost", "root", "", "iot-air-quality-db");

//baca data yang dikirim  oleh esp32
$NO2 = $_GET['NO2'];
$PM10 = $_GET['PM10'];
$CO = $_GET['CO'];
$CO2 = $_GET['CO2'];

//auto increament = 1 atau mengembalikan id = 1 apabila dikosongkan
mysqli_query ($konek, "ALTER TABLE `tb-dataarea` AUTO_INCREMENT = 1");
//simpan data sensor ke tabel db-dataarea
$simpan = mysqli_query ($konek, "INSERT INTO `tb-dataarea`(NO2, PM10, CO, CO2) VALUES ('$NO2', '$PM10', '$CO', '$CO2')");
//uji simpan untuk memberikan respon
if ($simpan){
    echo "Successfull Sending";
}else{
    echo "Failed Sending";} 
-->