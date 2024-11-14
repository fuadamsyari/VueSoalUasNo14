<?php
// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "uas";

$conn = new mysqli($servername, $username, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fungsi untuk mendapatkan data kendaraan dari database
function getKendaraans()
{
    global $conn;
    $result = $conn->query("SELECT * FROM kendaraan");
    $kendaraans = array();
    while ($row = $result->fetch_assoc()) {
        $kendaraans[] = $row;
    }
    return $kendaraans;
}

// Fungsi untuk menambahkan data kendaraan ke database
function addKendaraan($data)
{
    global $conn;
    $nama_mobil = $data['nama_mobil'];
    $merk = $data['merk'];
    $warna = $data['warna'];
    $nopol = $data['nopol'];
    $harga = $data['harga'];

    $stmt = $conn->prepare("INSERT INTO kendaraan (nama_mobil, merk, warna, nopol, harga) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssi", $nama_mobil, $merk, $warna, $nopol, $harga);
    $stmt->execute();
    $stmt->close();
}

// Fungsi untuk menghapus data kendaraan dari database
function deleteKendaraan($id)
{
    global $conn;
    $stmt = $conn->prepare("DELETE FROM kendaraan WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

// Tindakan yang akan dilakukan berdasarkan parameter "action"
if (isset($_GET['action'])) {
    header('Content-Type: application/json');
    switch ($_GET['action']) {
        case 'get_kendaraans':
            echo json_encode(getKendaraans());
            break;
        case 'add_kendaraan':
            $data = json_decode(file_get_contents("php://input"), true);
            addKendaraan($data);
            break;
        case 'delete_kendaraan':
            $id = $_GET['id'];
            deleteKendaraan($id);
            break;
    }
}

$conn->close();
