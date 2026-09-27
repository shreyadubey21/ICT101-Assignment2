<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?> | Paws &amp; Polish Pet Grooming</title>
    <link rel="icon" href="images/logo.svg">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Fredoka:wght@500;600&family=Nunito:wght@400;700&display=swap">
    <link rel="stylesheet" href="css/style.css">
    <script src="js/script.js"></script>
</head>
<body>

<header>
    <div class="container header-row">
        <a href="index.php" class="logo">
            <img src="images/logo.svg" alt="Paws and Polish logo" width="45" height="45">
            <span>Paws &amp; Polish</span>
        </a>

        <nav>
            <a href="index.php">Home</a>
            <a href="services.php">Services</a>
            <a href="booking.php">Book</a>
            <a href="feedback.php">Feedback</a>
            <?php if (isset($_SESSION['user_id'])) { ?>
                <a href="account.php">My Account</a>
                <a href="logout.php">Log out</a>
            <?php } else { ?>
                <a href="login.php">Log in</a>
                <a href="register.php" class="nav-button">Register</a>
            <?php } ?>
        </nav>

        <form action="search.php" method="get" class="search-box">
            <input type="text" name="keyword" placeholder="Search services..." aria-label="Search">
            <button type="submit">Search</button>
        </form>
    </div>
</header>

<main>
