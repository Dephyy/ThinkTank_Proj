<?php

require __DIR__ . "/vendor/autoload.php";

$client = new Google\Client;

$client->setClientID("114939517340-q6q506u2ijblohf6a0m5sinfvvhkptek.apps.googleusercontent.com");
$client->setClientSecret("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");
$client->setRedirectUri("http://localhost/Thinktank/home.php");

$client->addScope("email");
$client->addScope("profile");

$url = $client->createAuthUrl();

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Sign Up</title>
</head>
<header>
    <nav>
        <div class="logo">
            ThinkTank
        </div>
        <ul>
            <li><a href="index.html">Home</a></li>
            <li><a href="features.html">Features</a></li>
            <li><a href="aboutus.html">About Us</a></li>
            <li><a href="contactus.html">Contact Us</a></li>
        </ul>
    </nav>
</header>
<body>
    <div class="container">
        <div class="form-section">
            <h1 class="form-title">Sign Up</h1>
            <!-- Notification area for errors -->
            <div id="error-message" style="color: red; display: none;"></div>

            <form id="signup-form" method="POST">
                <label for="username">Full Name</label>
                <input type="text" id="username" name="username" placeholder="Enter your full name" required>

                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required>

                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required>

                <label for="confirm-password">Confirm Password</label>
                <input type="password" id="confirm-password" placeholder="Confirm your password" required>

                <button type="submit" class="submit-button">Sign Up</button>

                <div class="google-signin">
                    <button type="button" onclick="location.href="<?= $url ?>"" class="google-button" >Sign up with Google</button>
                    <a href="<?= $url ?>" class="google-button">Sign in with Google</a>
                    
                </div>

                <p class="prompt">Already have an account? <a href="login.html">Log in here</a></p>
            </form>
        </div>
    </div>
</body>
</html>
