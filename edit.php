<?php
$conn = new mysqli("localhost", "root", "", "booking_db");

// 1. Dapatkan data sedia ada berdasarkan ID
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM bookings WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    
    // Pecahkan servis kepada array untuk tandakan checkbox nanti
    $services_arr = explode(",", $row['services']);
}

// 2. Proses apabila borang Edit dihantar
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $update_id = $_POST['id'];
    $name = $_POST['customer_name'];
    $phone = $_POST['phone_number'];
    
    // Ambil array perkhidmatan baru dan jadikan string
    $new_services = isset($_POST['services']) ? implode(",", $_POST['services']) : "";

    $update_stmt = $conn->prepare("UPDATE bookings SET customer_name = ?, phone_number = ?, services = ? WHERE id = ?");
    $update_stmt->bind_param("sssi", $name, $phone, $new_services, $update_id);
    
    if ($update_stmt->execute()) {
        header("Location: process.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Booking</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body class="bg-light container mt-5">
    <div class="card shadow">
        <div class="card-header bg-warning"><h4>Edit Booking</h4></div>
        <div class="card-body">
            <form action="edit.php?id=<?= $id ?>" method="POST">
                <!-- Hidden input untuk hantar ID ke POST -->
                <input type="hidden" name="id" value="<?= $row['id'] ?>">
                
                <div class="mb-3">
                    <label>Customer Name</label>
                    <input type="text" name="customer_name" class="form-control" value="<?= htmlspecialchars($row['customer_name']) ?>" required>
                </div>
                <div class="mb-3">
                    <label>Phone Number</label>
                    <input type="text" name="phone_number" class="form-control" value="<?= htmlspecialchars($row['phone_number']) ?>" required>
                </div>
                <div class="mb-3">
                    <label>Additional Services</label><br>
                    <input type="checkbox" name="services[]" value="Projector" <?= in_array("Projector", $services_arr) ? 'checked' : '' ?>> Projector<br>
                    <input type="checkbox" name="services[]" value="Catering" <?= in_array("Catering", $services_arr) ? 'checked' : '' ?>> Catering<br>
                    <input type="checkbox" name="services[]" value="Whiteboard" <?= in_array("Whiteboard", $services_arr) ? 'checked' : '' ?>> Whiteboard
                </div>
                <button type="submit" class="btn btn-primary">Update Data</button>
            </form>
        </div>
    </div>
</body>
</html>