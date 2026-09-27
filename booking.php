<?php
include "db.php";
$page_title = "Book an appointment";

// Customers must log in before they can book
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
$user_id = $_SESSION['user_id'];
$message = "";
$confirmation = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pet_id       = (int) $_POST['pet_id'];
    $service_id   = (int) $_POST['service_id'];
    $booking_date = mysqli_real_escape_string($conn, $_POST['booking_date']);
    $booking_time = mysqli_real_escape_string($conn, $_POST['booking_time']);
    $notes        = mysqli_real_escape_string($conn, trim($_POST['notes']));

    if ($pet_id == 0 || $service_id == 0 || $booking_date == "" || $booking_time == "") {
        $message = "Please choose a pet, a service, a date and a time.";
    } elseif ($booking_date <= date("Y-m-d")) {
        $message = "Please choose a date from tomorrow onwards.";
    } elseif (date("w", strtotime($booking_date)) == 0) {
        $message = "Sorry, we are closed on Sundays. Please choose another day.";
    } else {
        // Save the booking
        $sql = "INSERT INTO bookings (user_id, pet_id, service_id, booking_date, booking_time, notes, status)
                VALUES ($user_id, $pet_id, $service_id, '$booking_date', '$booking_time', '$notes', 'Confirmed')";
        mysqli_query($conn, $sql);
        $new_id = mysqli_insert_id($conn);

        // Get the full details of the new booking to show the confirmation
        $confirmation = mysqli_fetch_assoc(mysqli_query($conn,
            "SELECT bookings.*, services.service_name, services.price, pets.pet_name
             FROM bookings
             JOIN services ON bookings.service_id = services.service_id
             JOIN pets ON bookings.pet_id = pets.pet_id
             WHERE booking_id = $new_id"));
    }
}

// Lists for the drop-down menus
$pets = mysqli_query($conn, "SELECT * FROM pets WHERE user_id = $user_id");
$services = mysqli_query($conn, "SELECT * FROM services ORDER BY category, service_name");

// If the customer came from the Services page, pre-select that service
$chosen_service = 0;
if (isset($_GET['service'])) {
    $chosen_service = (int) $_GET['service'];
}

include "header.php";
?>

<section class="container">
    <?php if ($confirmation) { ?>

        <h1>Booking confirmed!</h1>
        <div class="confirmation">
            <p>Your booking number is <strong>#<?php echo $confirmation['booking_id']; ?></strong></p>
            <p><strong>Service:</strong> <?php echo $confirmation['service_name']; ?> ($<?php echo $confirmation['price']; ?>)</p>
            <p><strong>Pet:</strong> <?php echo htmlspecialchars($confirmation['pet_name']); ?></p>
            <p><strong>Date:</strong> <?php echo $confirmation['booking_date']; ?> at <?php echo $confirmation['booking_time']; ?></p>
            <p>Please show your booking number when you arrive. You can see or cancel your bookings on your <a href="account.php">account page</a>.</p>
        </div>

    <?php } else { ?>

        <h1>Book an appointment</h1>
        <p>We are open Monday to Saturday. Choose your pet, a service and a time.</p>

        <?php if ($message != "") { ?>
            <p class="error-box"><?php echo $message; ?></p>
        <?php } ?>

        <?php if (mysqli_num_rows($pets) == 0) { ?>
            <p class="error-box">You need to add a pet first. Go to <a href="account.php">My Account</a> to add your pet.</p>
        <?php } else { ?>

            <form action="booking.php" method="post" class="form-box" onsubmit="return validateBooking()">
                <label for="pet_id">Your pet</label>
                <select id="pet_id" name="pet_id">
                    <option value="">-- Choose a pet --</option>
                    <?php while ($pet = mysqli_fetch_assoc($pets)) { ?>
                        <option value="<?php echo $pet['pet_id']; ?>"><?php echo htmlspecialchars($pet['pet_name']); ?></option>
                    <?php } ?>
                </select>

                <label for="service_id">Service</label>
                <select id="service_id" name="service_id">
                    <option value="">-- Choose a service --</option>
                    <?php while ($service = mysqli_fetch_assoc($services)) { ?>
                        <option value="<?php echo $service['service_id']; ?>" <?php if ($service['service_id'] == $chosen_service) echo "selected"; ?>>
                            <?php echo $service['service_name']; ?> ($<?php echo $service['price']; ?>)
                        </option>
                    <?php } ?>
                </select>

                <label for="booking_date">Date</label>
                <input type="date" id="booking_date" name="booking_date">

                <label for="booking_time">Time</label>
                <select id="booking_time" name="booking_time">
                    <option value="">-- Choose a time --</option>
                    <option>9:00 am</option>
                    <option>10:00 am</option>
                    <option>11:00 am</option>
                    <option>12:00 pm</option>
                    <option>1:00 pm</option>
                    <option>2:00 pm</option>
                    <option>3:00 pm</option>
                    <option>4:00 pm</option>
                </select>

                <label for="notes">Notes for the groomer (optional)</label>
                <textarea id="notes" name="notes" rows="3"></textarea>

                <p id="booking-error" class="error"></p>
                <button type="submit" class="button">Confirm booking</button>
            </form>
        <?php } ?>

    <?php } ?>
</section>

<?php include "footer.php"; ?>
