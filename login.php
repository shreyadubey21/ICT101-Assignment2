<?php
include "db.php";
$page_title = "Log in";

$login_failed = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, trim($_POST['username']));
    $password = $_POST['password'];

    // Find the user with this username
    $result = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
    $user = mysqli_fetch_assoc($result);

    // Check the password they typed against the hashed password we stored
    if ($user && password_verify($password, $user['password'])) {
        // Correct! Remember who is logged in, then go to their account page
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['full_name'] = $user['full_name'];
        header("Location: account.php");
        exit();
    } else {
        $login_failed = true;
    }
}

include "header.php";
?>

<section class="container">
    <h1>Log in</h1>

    <?php if ($login_failed) { ?>
        <p class="error-box">
            Wrong username or password.<br>
            Don't have an account yet? <a href="register.php">Register here</a>.
        </p>
    <?php } ?>

    <form action="login.php" method="post" class="form-box" onsubmit="return validateLogin()">
        <label for="username">Username</label>
        <input type="text" id="username" name="username">

        <label for="password">Password</label>
        <input type="password" id="password" name="password">

        <p id="login-error" class="error"></p>
        <button type="submit" class="button">Log in</button>

        <p><a href="forgot-password.php">Forgot your password?</a></p>
        <p>New customer? <a href="register.php">Create an account</a></p>
    </form>
</section>

<?php include "footer.php"; ?>
