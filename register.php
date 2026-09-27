<?php
include "db.php";
$page_title = "Register";

$message = "";
$success = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = mysqli_real_escape_string($conn, trim($_POST['full_name']));
    $username  = mysqli_real_escape_string($conn, trim($_POST['username']));
    $email     = mysqli_real_escape_string($conn, trim($_POST['email']));
    $phone     = mysqli_real_escape_string($conn, trim($_POST['phone']));
    $password  = $_POST['password'];
    $confirm   = $_POST['confirm_password'];

    // Check the form again in PHP (in case JavaScript is turned off)
    if ($full_name == "" || $username == "" || $email == "" || $phone == "" || $password == "") {
        $message = "Please fill in all the fields.";
    } elseif ($password != $confirm) {
        $message = "The two passwords do not match.";
    } else {
        // Check if the username is already taken
        $check = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");

        if (mysqli_num_rows($check) > 0) {
            $message = "Sorry, that username is already taken. Please choose another one.";
        } else {
            // Save the new customer. The password is hashed so it is never stored as plain text.
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO users (full_name, username, email, phone, password)
                    VALUES ('$full_name', '$username', '$email', '$phone', '$hashed_password')";
            mysqli_query($conn, $sql);
            $success = true;
        }
    }
}

include "header.php";
?>

<section class="container">
    <h1>Create an account</h1>

    <?php if ($success) { ?>
        <p class="success">Your account has been created! You can now <a href="login.php">log in</a>.</p>
    <?php } else { ?>

        <?php if ($message != "") { ?>
            <p class="error-box"><?php echo $message; ?></p>
        <?php } ?>

        <form action="register.php" method="post" class="form-box" onsubmit="return validateRegister()">
            <label for="full_name">Full name</label>
            <input type="text" id="full_name" name="full_name">

            <label for="username">Username</label>
            <input type="text" id="username" name="username">

            <label for="email">Email</label>
            <input type="text" id="email" name="email">

            <label for="phone">Phone number</label>
            <input type="text" id="phone" name="phone" placeholder="e.g. 0412345678">

            <label for="password">Password (at least 8 characters, with a number)</label>
            <input type="password" id="password" name="password">

            <label for="confirm_password">Confirm password</label>
            <input type="password" id="confirm_password" name="confirm_password">

            <p id="register-error" class="error"></p>
            <button type="submit" class="button">Create account</button>

            <p>Already have an account? <a href="login.php">Log in</a></p>
            <p class="small">Privacy: we only use your details to manage your bookings. We never share them with anyone else.</p>
        </form>
    <?php } ?>
</section>

<?php include "footer.php"; ?>
