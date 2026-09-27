<?php
include "db.php";
$page_title = "Search";
include "header.php";

$keyword = "";
$result = false;

// Search the services table for the keyword the customer typed
if (isset($_GET['keyword']) && trim($_GET['keyword']) != "") {
    $keyword = trim($_GET['keyword']);
    $safe_keyword = mysqli_real_escape_string($conn, $keyword);
    $sql = "SELECT * FROM services
            WHERE service_name LIKE '%$safe_keyword%'
               OR description LIKE '%$safe_keyword%'
               OR category LIKE '%$safe_keyword%'";
    $result = mysqli_query($conn, $sql);
}
?>

<section class="container">
    <h1>Search</h1>

    <form action="search.php" method="get" class="form-box" onsubmit="return validateSearch()">
        <label for="keyword">Search for a service</label>
        <input type="text" id="keyword" name="keyword" value="<?php echo htmlspecialchars($keyword); ?>" placeholder="e.g. nail, puppy, cat">
        <p id="search-error" class="error"></p>
        <button type="submit" class="button">Search</button>
    </form>

    <?php if ($result) { ?>
        <h2><?php echo mysqli_num_rows($result); ?> result(s) for "<?php echo htmlspecialchars($keyword); ?>"</h2>

        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <div class="result">
                <h3><?php echo $row['service_name']; ?> - $<?php echo $row['price']; ?></h3>
                <p><?php echo $row['description']; ?> (<?php echo $row['category']; ?>)</p>
                <a href="booking.php?service=<?php echo $row['service_id']; ?>">Request this service</a>
            </div>
        <?php } ?>

        <?php if (mysqli_num_rows($result) == 0) { ?>
            <p>Sorry, nothing matched. Try another word, or <a href="services.php">see all services</a>.</p>
        <?php } ?>
    <?php } ?>
</section>

<?php include "footer.php"; ?>
