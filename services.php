<?php
include "db.php";
$page_title = "Services";
include "header.php";

// If the customer clicked a category button, only show that category
if (isset($_GET['category'])) {
    $category = mysqli_real_escape_string($conn, $_GET['category']);
    $sql = "SELECT * FROM services WHERE category = '$category' ORDER BY price";
} else {
    $category = "";
    $sql = "SELECT * FROM services ORDER BY category, price";
}
$result = mysqli_query($conn, $sql);
?>

<section class="container">
    <h1>Our Services</h1>
    <p>All prices are per pet and include GST.</p>

    <div class="filters">
        <a href="services.php">All</a>
        <a href="services.php?category=Grooming">Grooming</a>
        <a href="services.php?category=Health Care">Health Care</a>
        <a href="services.php?category=Boarding %26 Walking">Boarding &amp; Walking</a>
        <a href="services.php?category=Training">Training</a>
    </div>

    <table>
        <tr>
            <th>Service</th>
            <th class="hide-mobile">Category</th>
            <th class="hide-mobile">Description</th>
            <th>Price</th>
            <th></th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><strong><?php echo $row['service_name']; ?></strong></td>
                <td class="hide-mobile"><?php echo $row['category']; ?></td>
                <td class="hide-mobile"><?php echo $row['description']; ?></td>
                <td>$<?php echo $row['price']; ?></td>
                <td><a href="booking.php?service=<?php echo $row['service_id']; ?>" class="button button-small">Request</a></td>
            </tr>
        <?php } ?>
    </table>

    <?php if (mysqli_num_rows($result) == 0) { ?>
        <p>No services found in this category.</p>
    <?php } ?>
</section>

<?php include "footer.php"; ?>
