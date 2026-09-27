<?php
include "db.php";
$page_title = "Feedback";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name     = mysqli_real_escape_string($conn, trim($_POST['name']));
    $email    = mysqli_real_escape_string($conn, trim($_POST['email']));
    $type     = mysqli_real_escape_string($conn, $_POST['type']);
    $rating   = (int) $_POST['rating'];
    $feedback = mysqli_real_escape_string($conn, trim($_POST['message']));

    if ($name == "" || $email == "" || $rating < 1 || $rating > 5 || $feedback == "") {
        $message = "Please fill in all the fields.";
    } else {
        // Save the feedback or suggestion
        mysqli_query($conn, "INSERT INTO feedback (name, email, type, rating, message)
                             VALUES ('$name', '$email', '$type', $rating, '$feedback')");
        $message = "Thank you! Your " . strtolower($type) . " has been sent.";
    }
}

// Show the latest feedback (emails are kept private and not shown)
$all_feedback = mysqli_query($conn, "SELECT * FROM feedback ORDER BY created_at DESC LIMIT 6");

include "header.php";
?>

<section class="container">
    <h1>Feedback &amp; Suggestions</h1>
    <p>Tell us how your pet's visit went, or share an idea to help us improve.</p>

    <?php if ($message != "") { ?>
        <p class="success"><?php echo $message; ?></p>
    <?php } ?>

    <form action="feedback.php" method="post" class="form-box" onsubmit="return validateFeedback()">
        <label for="name">Your name</label>
        <input type="text" id="name" name="name">

        <label for="email">Email (not shown publicly)</label>
        <input type="text" id="email" name="email">

        <label>This is a:</label>
        <div class="radio-row">
            <label><input type="radio" name="type" value="Feedback" checked> Feedback</label>
            <label><input type="radio" name="type" value="Suggestion"> Suggestion</label>
        </div>

        <label for="rating">Rating</label>
        <select id="rating" name="rating">
            <option value="">-- Choose a rating --</option>
            <option value="5">★★★★★ Excellent</option>
            <option value="4">★★★★ Good</option>
            <option value="3">★★★ OK</option>
            <option value="2">★★ Poor</option>
            <option value="1">★ Very poor</option>
        </select>

        <label for="message">Your message</label>
        <textarea id="message" name="message" rows="4"></textarea>

        <p id="feedback-error" class="error"></p>
        <button type="submit" class="button">Send</button>
    </form>

    <h2>Recent feedback</h2>
    <div class="cards">
        <?php while ($row = mysqli_fetch_assoc($all_feedback)) { ?>
            <div class="review">
                <p class="stars"><?php echo str_repeat("★", $row['rating']); ?></p>
                <p><?php echo htmlspecialchars($row['message']); ?></p>
                <p><strong><?php echo htmlspecialchars($row['name']); ?></strong> (<?php echo htmlspecialchars($row['type']); ?>)</p>
            </div>
        <?php } ?>
    </div>
</section>

<?php include "footer.php"; ?>
