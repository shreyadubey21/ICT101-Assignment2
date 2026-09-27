<?php
include "db.php";
$page_title = "Forgot password";

$message = "";
$success = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, trim($_POST['username']));
    $email    = mysqli_real_escape_string($conn, trim($_POST['email']));
    $new_password = $_POST['new_password'];

    // Check that the username and email belong to the same account
    $result = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username' AND email = '$email'");

    if (mysqli_num_rows($result) == 1) {
        // Save the new password (hashed)
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        mysqli_query($conn, "UPDATE users SET password = '$hashed_password' WHERE username = '$username'");
        $success = true;
    } else {
        $message = "We couldn't find an account with that username and email.";
    }
}

include "header.php";
?>

<section class="container">
    <h1>Reset your password</h1>

    <?php if ($success) { ?>
        <p class="success">Your password has been changed. You can now <a href="login.php">log in</a>.</p>
    <?php } else { ?>

        <p>Enter your username and the email you registered with, then choose a new password.</p>

        <?php if ($message != "") { ?>
            <p class="error-box"><?php echo $message; ?></p>
        <?php } ?>

        <form action="forgot-password.php" method="post" class="form-box" onsubmit="return validateForgot()">
            <label for="username">Username</label>
            <input type="text" id="username" name="username">

            <label for="email">Email</label>
            <input type="text" id="email" name="email">

            <label for="new_password">New password (at least 8 characters, with a number)</label>
            <input type="password" id="new_password" name="new_password">

            <label for="confirm_password">Confirm new password</label>
            <input type="password" id="confirm_password" name="confirm_password">

            <p id="forgot-error" class="error"></p>
            <button type="submit" class="button">Reset password</button>
        </form>
    <?php } ?>
</section>

<?php include "footer.php"; ?>
