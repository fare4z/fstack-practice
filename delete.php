<?php
$conn = new mysqli("localhost", "root", "", "booking_db");

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Gunakan Prepared Statement untuk keselamatan
    $stmt = $conn->prepare("DELETE FROM bookings WHERE id = ?");
    $stmt->bind_param("i", $id); // 'i' bermaksud integer
    
    if ($stmt->execute()) {
        header("Location: process.php"); // Bawa pengguna kembali ke jadual
        exit();
    } else {
        echo "Ralat memadam rekod.";
    }
}
?>