<?php
// Database Connection
$host = "localhost";
$user = "root";
$pass = "";
$db = "booking_db";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("DB connection error: " . $conn->connect_error);
}

// Process Form Submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['customer_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone_number'];
    $date = $_POST['booking_date'];
    $room = $_POST['room_type'];
    $promo = trim($_POST['promo_code']);
    
    // Handle services array and calculation
    $services_arr = isset($_POST['services']) ? $_POST['services'] : [];
    $services_str = implode(",", $services_arr);
    
    $total_fee = 0;
    foreach ($services_arr as $service) {
        if ($service == "Projector") $total_fee += 10;
        if ($service == "Catering") $total_fee += 20;
        if ($service == "Whiteboard") $total_fee += 5;
    }
    
    $discount = 0;
    if ($promo === "BOOK2026") {
        $discount = $total_fee * 0.05;
    }
    $final_payment = $total_fee - $discount;

    // Insert using Prepared Statement
    $stmt = $conn->prepare("INSERT INTO bookings (customer_name, email, phone_number, booking_date, room_type, services, promo_code) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $name, $email, $phone, $date, $room, $services_str, $promo);
    $stmt->execute();
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Booking Summary</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body class="bg-light pb-5">
    <div class="container mt-5">
        <?php if ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
        <!-- Booking Summary -->
        <div class="card shadow mb-4">
            <div class="card-header bg-success text-white">
                <h4 class="mb-0">Booking Summary</h4>
            </div>
            <div class="card-body">
                <p><strong>Name:</strong> <?= htmlspecialchars($name) ?></p>
                <p><strong>Email:</strong> <?= htmlspecialchars($email) ?></p>
                <p><strong>Phone:</strong> <?= htmlspecialchars($phone) ?></p>
                <p><strong>Date:</strong> <?= htmlspecialchars($date) ?></p>
                <p><strong>Room:</strong> <?= htmlspecialchars($room) ?></p>
                <p><strong>Services:</strong></p>
                <ul>
                    <?php foreach ($services_arr as $srv): ?>
                        <li><?= htmlspecialchars($srv) ?></li>
                    <?php endforeach; ?>
                </ul>
                <p><strong>Total Fee:</strong> RM<?= number_format($total_fee, 2) ?></p>
                <p><strong>Discount:</strong> RM<?= number_format($discount, 2) ?></p>
                <p><strong>Final Payment:</strong> RM<?= number_format($final_payment, 2) ?></p>
            </div>
        </div>
        <?php endif; ?>

        <!-- All Booking Records -->
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">All Booking Records</h4>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Date</th>
                            <th>Room</th>
                            <th>Services</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $result = $conn->query("SELECT * FROM bookings ORDER BY created_at DESC");
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['customer_name']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['phone_number']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['booking_date']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['room_type']) . "</td>";
                            
                            echo "<td>";
                            $db_services = explode(",", $row['services']);
                            foreach ($db_services as $s) {
                                if(!empty($s)) echo htmlspecialchars($s) . "<br>";
                            }
                            echo "</td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>