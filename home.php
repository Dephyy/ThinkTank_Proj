<?php

require __DIR__ . "/vendor/autoload.php";

$client = new Google\Client;

$client->setClientID("114939517340-q6q506u2ijblohf6a0m5sinfvvhkptek.apps.googleusercontent.com");
$client->setClientSecret("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");
$client->setRedirectUri("http://localhost/Thinktank/home.php");
if ( ! isset($_GET["code"])) {

    exit("Login failed");

}

$token = $client->fetchAccessTokenWithAuthCode($_GET["code"]);

$client->setAccessToken($token["access_token"]);

$oauth = new Google\Service\Oauth2($client);

$userinfo = $oauth->userinfo->get();

var_dump(
    $userinfo->email,
    $userinfo->familyName,
    $userinfo->givenName,
    $userinfo->name
);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Document</title>
</head>
<header>
    <nav>
        <div class="logo">
            ThinkTank
        </div>
        <ul>
            <li><a href="features.html">Features</a></li>
            <li><a href="aboutus.html">About Us</a></li>
            <li><a href="contactus.html">Contact Us</a></li>
        </ul>
    </nav>
</header>
<body>
    <div class="container">
        <div class="sidebar">
            <div class="sidebar-section">
                <h3><a href="home.html">Home</a></h3>
                <h3><a href="popular.html">Popular</a></h3>
                <h3><a href="explore.html">Explore</a></h3>
                <hr>
            </div>
            <div class="sidebar-section">
                <h3><a href="dashboard.html">Dashboard</a></h3>
                <h3><a href="submit_idea.html">Submit Ideas</a></h3>
                <hr>
            </div>
            
            <div class="sidebar-section">
                <h3><a href="aboutus.html">About ThinkTank</a></h3>
                <h3><a href="contactus.html">Contact Us</a></h3>
                <hr>
            </div>
            <div class="sidebar-section">
                <h3><a href="login.html">Logout</a></h3>
                
            </div>
        </div>
    
        <div class="main-content">
            <h1>Trending Ideas</h1>
            <div class="ideas-grid">
                <div class="idea-card">
                    <a href="WIP.html">
                        <img src="idea-image1.jpg" alt="Idea 1" class="idea-image">
                        <h2 class="idea-title">Idea Title 1</h2>
                        <p class="idea-description">Description of the first trending idea.</p>
                    </a>
                    <div class="idea-actions">
                        <button class="vote-button upvote-btn">▲ Upvote</button>
                        <span class="vote-count">12</span>
                        <button class="vote-button downvote-btn">▼ Downvote</button>
                    </div>
                    <input type="text" class="comment-input" placeholder="Add a comment...">
                </div>
                <div class="idea-card">
                    <a href="WIP.html">
                        <img src="idea-image2.jpg" alt="Idea 2" class="idea-image">
                        <h2 class="idea-title">Idea Title 2</h2>
                        <p class="idea-description">Description of the second trending idea.</p>
                    </a>
                    <div class="idea-actions">
                        <button class="vote-button upvote-btn">▲ Upvote</button>
                        <span class="vote-count">8</span>
                        <button class="vote-button downvote-btn">▼ Downvote</button>
                    </div>
                    <input type="text" class="comment-input" placeholder="Add a comment...">
                </div>
                <div class="idea-card">
                    <a href="WIP.html">
                        <img src="idea-image3.jpg" alt="Idea 3" class="idea-image">
                        <h2 class="idea-title">Idea Title 3</h2>
                        <p class="idea-description">Description of the third trending idea.</p>
                    </a>
                    <div class="idea-actions">
                        <button class="vote-button upvote-btn">▲ Upvote</button>
                        <span class="vote-count">5</span>
                        <button class="vote-button downvote-btn">▼ Downvote</button>
                    </div>
                    <input type="text" class="comment-input" placeholder="Add a comment...">
                </div>
                <!-- Add more idea cards as needed -->
            </div>
        </div>
    </div>
</body>
</html>