<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>XP Game Reviews</title>
  <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/gameList.css">
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<div class="navigation-bar">
        <div class="nav-shell">
            <ul>
                <li class="game-logo">
                    <img src=../images/1.svg alt="XP Review Logo"/>
                </li>
                <div id="title">
                    XP Reviews: Games List
                </div>
                <div class="nav-toggle">
                    <li class="link">
                        <a href="HomePage.php"> Home </a>
                    </li>
                    <li class="link">
                        <a href="gameList.php"> Game List </a>
                    </li>
                    <li class="link">
                        <a href="addReview.php">Add Review</a>
                    </li>
                </div>
            </ul>
            <button class="menu-button">
                <div class="bar1"></div>
                <div class="bar2"></div>
                <div class="bar3"></div>
            </button>
        </div>
    </div>
</body>
<?php

require_once('config.inc.php');
$mysqli = new mysqli(HOST, USER, PASSWORD, DB, PORT);

$SQL = "SELECT * FROM GameNames ORDER BY Game";

echo "<div id='pageBody'>";

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

if ($result = $mysqli->query($SQL)) {
    while ($obj = $result->fetch_object()) {
        $gameName = $obj->Game;
        $publisher = $obj->Publisher;
        $imagePath = $obj->CoverImageData;

        // Query for Average Score
        $SQLAvg = "SELECT AVG(Score) AS AverageScore FROM Reviews WHERE Game = '$gameName'";
        $resultAvg = $mysqli->query($SQLAvg);

        $averageScore = 0; 
        if ($resultAvg) {
            $row = $resultAvg->fetch_assoc();
            if (!is_null($row['AverageScore'])) {
                $averageScore = round($row['AverageScore']); 
            }
        } else {
            echo "<p>Error calculating average score for $gameName</p>";
        }


        echo "<div class='games'>";
        echo "<a href='game-info.php?game=" . urlencode($gameName) . "' style='text-decoration: none; color: white; display: block; height: 100%;'>";
        echo "<p class = 'nameText'> " . $gameName . "</p>";
        echo "<img src='" . $imagePath . "' alt='" . $gameName . " Image' class='game-image'/>";
        echo "<p> " . $publisher . "</p>";
        echo "<p class='average-score-box'>" . $averageScore . "</p>"; 
        echo "</a>"; 
        echo "</div>";
    }
    $result->free_result();
}

echo "<div id='footer'>";
echo "<footer><a href='addReview.php'><p>Add Your Own Review</p></a></footer>";
echo "</div>";
echo "</div>";

?>




<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>