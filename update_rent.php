<?php
include 'config.php';

$borrow_id = $_POST['borrow_id'];
$user_id = $_POST['user_id'];
$admin_id = $_POST['admin_id'];
$borrow_date = $_POST['borrow_date'];
$return_date = $_POST['return_date'];
$status = $_POST['status'];

// Validasi tanggal
$current_date = date('Y-m-d');
if ($borrow_date !== $current_date) {
    echo "Error : Periksa kembali Tanggal Pengembalian dan Tanggal Peminjaman. Tanggal Pengembalian tidak boleh sebelum Tanggal Peminjaman dan Tanggal Peminjaman harus tanggal sekarang.";
    exit();
}

if ($return_date < $borrow_date) {
    echo "Error : Periksa kembali Tanggal Pengembalian dan Tanggal Peminjaman.Tanggal Pengembalian tidak boleh sebelum Tanggal Peminjaman dan Tanggal Peminjaman harus tanggal sekarang.";
    exit();
}

try {
    $stmt = $conn->prepare("UPDATE book_borrowing SET ID_User = ?, ID_Admin = ?, Borrow_Date = ?, Return_Date = ?, Status = ? WHERE Borrow_ID = ?");
    $stmt->bind_param("iisssi", $user_id, $admin_id, $borrow_date, $return_date, $status, $borrow_id);
    $stmt->execute();
    echo "Rental record updated successfully!";
} catch (Exception $e) {
    echo "Failed to update rental record: " . $e->getMessage();
}

$conn->close();
?>
