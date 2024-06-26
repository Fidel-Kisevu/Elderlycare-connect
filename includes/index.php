<?php include '../includes/index-header.php'; ?>



<?php
require_once '../includes/authenticate.php';
require_once '../includes/db_connection.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elderly Care Connect</title>
    <link rel="stylesheet" href="../css/index.css">
</head>

<body>
    <div class="container-index">
        <h1>Welcome to Elderly Care Connect</h1>
        <h2></h2>
        <?php
        // Retrieve and display elderly profiles created by the logged-in user
        $profiles = $db->profiles->find();

        foreach ($profiles as $profile) {
            echo '<div class="profile">';
            // Base64 encode the image data and set it as the src attribute
            $imageData = base64_encode($profile['pictureData']->getData());
            $imageSrc = 'data:' . $profile['pictureMimeType'] . ';base64,' . $imageData;
            echo '<img src="' . $imageSrc . '" alt="' . $profile['name'] . '">';
            echo '<h3>' . $profile['name'] . '</h3>';
            echo '<p>' . $profile['summary'] . '</p>';
            echo '<a href="../pages/profile.php?id=' . $profile['_id'] . '">View Full Profile</a>';
            echo '</div>';
        }
        ?>
        <form id="paymentForm">
            <div class="form-submit">
                <button type="submit" onclick="payWithPaystack()"> Donate </button>
            </div>
        </form>
        <?php
        if (isset($_GET['logout'])) {
            // Call the logout function
            logout();
        }
        ?>
        <?php
        if (!isLoggedIn()) {
            echo '<p>Have an elderly who needs help? Create profile</p>';
            echo '<a href="./pages/login.php">here</a>';
        } else {
            echo '<a href="./pages/homepage.php">View my created profiles </a>';
            echo '<a href="?logout=true">Logout</a>';
        }
        ?>

        <?php include '../includes/donation.php'; ?>

        <script src="https://js.paystack.co/v1/inline.js"></script>
</body>

</html>
