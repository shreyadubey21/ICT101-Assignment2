<?php
include "db.php";
$page_title = "Home";
include "header.php";

// Get the 3 newest reviews to show on the home page
$result = mysqli_query($conn, "SELECT * FROM feedback WHERE type = 'Feedback' ORDER BY created_at DESC LIMIT 3");
?>

<section class="hero">
    <div class="container hero-row">
        <div>
            <h1>Clean coats, calm pets, happy tails.</h1>
            <p>Gentle grooming, health checks, day care and training for dogs and cats in Surry Hills. Book your appointment online in minutes.</p>
            <a href="booking.php" class="button">Book an appointment</a>
            <a href="services.php" class="button button-outline">View services</a>
        </div>
        <img src="images/hero-dog.svg" alt="A happy dog having a bubble bath" class="hero-image">
    </div>
</section>

<section class="container">
    <h2>Our services</h2>
    <div class="cards">
        <a href="services.php?category=Grooming" class="card">
            <img src="images/grooming.svg" alt="" width="60" height="60">
            <h3>Grooming</h3>
            <p>Baths, haircuts, nail trims and more.</p>
        </a>
        <a href="services.php?category=Health Care" class="card">
            <img src="images/health.svg" alt="" width="60" height="60">
            <h3>Health Care</h3>
            <p>Flea treatments, teeth brushing and health checks.</p>
        </a>
        <a href="services.php?category=Boarding %26 Walking" class="card">
            <img src="images/boarding.svg" alt="" width="60" height="60">
            <h3>Boarding &amp; Walking</h3>
            <p>Day care, overnight stays and dog walks.</p>
        </a>
        <a href="services.php?category=Training" class="card">
            <img src="images/training.svg" alt="" width="60" height="60">
            <h3>Training</h3>
            <p>Obedience sessions and puppy classes.</p>
        </a>
    </div>
</section>

<section class="container">
    <h2>What our customers say</h2>
    <div class="cards">
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <div class="review">
                <p class="stars"><?php echo str_repeat("★", $row['rating']); ?></p>
                <p><?php echo htmlspecialchars($row['message']); ?></p>
                <p><strong><?php echo htmlspecialchars($row['name']); ?></strong></p>
            </div>
        <?php } ?>
    </div>
</section>

<section class="about">
    <div class="container hero-row">
        <div>
            <h2>About us</h2>
            <p>Paws &amp; Polish is a small team of qualified groomers and a dog trainer. We take our time with every pet, use gentle products and quiet dryers, and always tell you if we notice anything unusual, like a skin problem or sore ear.</p>
            <p>Create a free account to save your pet's profile, book appointments and manage your bookings online.</p>
        </div>
        <img src="images/groomer-station.svg" alt="Our grooming room with a bath and dryer" class="about-image">
    </div>
</section>

<?php include "footer.php"; ?>
