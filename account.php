<?php
include "db.php";
$page_title = "My Account";

// Only logged-in customers can see this page
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
$user_id = $_SESSION['user_id'];
$message = "";

// 1. Update customer details
if (isset($_POST['update_details'])) {
    $full_name = mysqli_real_escape_string($conn, trim($_POST['full_name']));
    $email     = mysqli_real_escape_string($conn, trim($_POST['email']));
    $phone     = mysqli_real_escape_string($conn, trim($_POST['phone']));

    mysqli_query($conn, "UPDATE users SET full_name = '$full_name', email = '$email', phone = '$phone' WHERE user_id = $user_id");
    $_SESSION['full_name'] = $_POST['full_name'];
    $message = "Your details have been updated.";
}

// 2. Add a pet profile
if (isset($_POST['add_pet'])) {
    $pet_name   = mysqli_real_escape_string($conn, trim($_POST['pet_name']));
    $pet_type   = mysqli_real_escape_string($conn, $_POST['pet_type']);
    $breed      = mysqli_real_escape_string($conn, trim($_POST['breed']));
    $care_notes = mysqli_real_escape_string($conn, trim($_POST['care_notes']));

    mysqli_query($conn, "INSERT INTO pets (user_id, pet_name, pet_type, breed, care_notes)
                         VALUES ($user_id, '$pet_name', '$pet_type', '$breed', '$care_notes')");
    $message = "Your pet has been added.";
}

// 3. Cancel a booking (only if it belongs to this customer)
if (isset($_GET['cancel'])) {
    $booking_id = (int) $_GET['cancel'];
    mysqli_query($conn, "UPDATE bookings SET status = 'Cancelled' WHERE booking_id = $booking_id AND user_id = $user_id");
    $message = "Your booking has been cancelled.";
}

// Get this customer's details, pets and bookings
$user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE user_id = $user_id"));
$pets = mysqli_query($conn, "SELECT * FROM pets WHERE user_id = $user_id");
$bookings = mysqli_query($conn, "SELECT bookings.*, services.service_name, pets.pet_name
                                 FROM bookings
                                 JOIN services ON bookings.service_id = services.service_id
                                 JOIN pets ON bookings.pet_id = pets.pet_id
                                 WHERE bookings.user_id = $user_id
                                 ORDER BY booking_date");

include "header.php";
?>

<section class="container">
    <h1>Welcome, <?php echo htmlspecialchars($user['full_name']); ?></h1>

    <?php if ($message != "") { ?>
        <p class="success"><?php echo $message; ?></p>
    <?php } ?>

    <h2>My bookings</h2>
    <?php if (mysqli_num_rows($bookings) == 0) { ?>
        <p>You have no bookings yet. <a href="booking.php">Book an appointment</a>.</p>
    <?php } else { ?>
        <table>
            <tr>
                <th>Booking no.</th>
                <th>Date</th>
                <th class="hide-mobile">Time</th>
                <th>Service</th>
                <th class="hide-mobile">Pet</th>
                <th>Status</th>
                <th></th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($bookings)) { ?>
                <tr>
                    <td>#<?php echo $row['booking_id']; ?></td>
                    <td><?php echo $row['booking_date']; ?></td>
                    <td class="hide-mobile"><?php echo $row['booking_time']; ?></td>
                    <td><?php echo $row['service_name']; ?></td>
                    <td class="hide-mobile"><?php echo htmlspecialchars($row['pet_name']); ?></td>
                    <td><?php echo $row['status']; ?></td>
                    <td>
                        <?php if ($row['status'] == "Confirmed") { ?>
                            <a href="account.php?cancel=<?php echo $row['booking_id']; ?>" onclick="return confirm('Cancel this booking?')">Cancel</a>
                        <?php } ?>
                    </td>
                </tr>
            <?php } ?>
        </table>
    <?php } ?>

    <div class="two-columns">
        <div>
            <h2>My pets</h2>
            <?php while ($pet = mysqli_fetch_assoc($pets)) { ?>
                <div class="pet-card">
                    <h3><?php echo htmlspecialchars($pet['pet_name']); ?></h3>
                    <p><?php echo htmlspecialchars($pet['pet_type'] . " - " . $pet['breed']); ?></p>
                    <?php if ($pet['care_notes'] != "") { ?>
                        <p><em>Care notes: <?php echo htmlspecialchars($pet['care_notes']); ?></em></p>
                    <?php } ?>
                </div>
            <?php } ?>

            <form action="account.php" method="post" class="form-box" onsubmit="return validatePet()">
                <h3>Add a pet</h3>
                <label for="pet_name">Pet name</label>
                <input type="text" id="pet_name" name="pet_name">

                <label for="pet_type">Type</label>
                <select id="pet_type" name="pet_type">
                    <option>Dog</option>
                    <option>Cat</option>
                    <option>Other</option>
                </select>

                <label for="breed">Breed</label>
                <input type="text" id="breed" name="breed">

                <label for="care_notes">Care notes (allergies, fears, etc.)</label>
                <input type="text" id="care_notes" name="care_notes">

                <p id="pet-error" class="error"></p>
                <button type="submit" name="add_pet" value="1" class="button">Add pet</button>
            </form>
        </div>

        <div>
            <h2>My details</h2>
            <form action="account.php" method="post" class="form-box" onsubmit="return validateDetails()">
                <label for="full_name">Full name</label>
                <input type="text" id="full_name" name="full_name" value="<?php echo htmlspecialchars($user['full_name']); ?>">

                <label for="email">Email</label>
                <input type="text" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>">

                <label for="phone">Phone number</label>
                <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>">

                <p>Username: <strong><?php echo htmlspecialchars($user['username']); ?></strong></p>

                <p id="details-error" class="error"></p>
                <button type="submit" name="update_details" value="1" class="button">Save changes</button>
            </form>
        </div>
    </div>
</section>

<?php include "footer.php"; ?>
