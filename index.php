<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room Booking Form</title>
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Room Booking Form</h4>
            </div>
            <div class="card-body">
                <form action="process.php" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Customer Name</label>
                        <input type="text" name="customer_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phone Number</label>
                        <input type="text" name="phone_number" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Booking Date</label>
                        <input type="date" name="booking_date" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Room Type</label>
                        <select name="room_type" class="form-select" required>
                            <option value="">Select Room</option>
                            <option value="Small">Small</option>
                            <option value="Medium">Medium</option>
                            <option value="Large">Large</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Additional Services</label><br>
                        <input type="checkbox" name="services[]" value="Projector" class="form-check-input"> Projector (RM10)<br>
                        <input type="checkbox" name="services[]" value="Catering" class="form-check-input"> Catering (RM20)<br>
                        <input type="checkbox" name="services[]" value="Whiteboard" class="form-check-input"> Whiteboard (RM5)
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Promo Code</label>
                        <input type="text" name="promo_code" class="form-control" placeholder="Optional">
                    </div>
                    <button type="submit" class="btn btn-success">Submit Booking</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>