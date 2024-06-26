<?php
require 'C:\xampp\htdocs\fyp\login\config.php';

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Connect to MySQL database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "dermawan";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $database);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieve search keyword from the form
    if (isset($_POST['search_keyword'])) {
        $search_keyword = $_POST['search_keyword'];

        // Construct and execute MySQL query
        $sql = "SELECT * FROM hospital WHERE address LIKE '%$search_keyword%'";
        $result = $conn->query($sql);

        // Store retrieved data in a PHP variable
        $search_results = $result->fetch_all(MYSQLI_ASSOC);
    }

    // Close MySQL connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--favicon-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="style.css">
    <title>Find Your Blood Donation Centre</title>
    <style>
         #banner img{
            position: absolute;
            height: 320px;
            width: 50%;
            margin-left: 25%;
            margin-right: auto;
            margin-top: 5%;

        }
    </style>
</head>

<body>
    <header>
        <a href="/fyp/index.php"><i class="fa fa-arrow-left" style="font-size:36px" id="backbtn"></i></a>
    </header>
    
    <main>

    <section id="banner">
        <img src="images/hospitaltitle.png" class="banner-image" >
        </section>
        
        <section id="search">
           <form method="post" action="hospital.php">
            <h3 style="text-decoration: underline; font-size: 2em;">Search Blood Donation Centre Based on State or City in Malaysia</h3>
                <div class="search-container">
                    <input type="text" name="search_keyword" class="search-bar"
                        placeholder="e.g. Selangor, Melaka, Putrajaya, Kuala Lumpur">
                    <button type="submit" class="search-button"><i class="fa fa-search"></i></button>
                </div>
            </form>
        </section>
        
        </main>
        <!-- Footer Section -->
        <footer>
            <p>&copy; 2024 Dermawan Darah. All rights reserved.</p>
        </footer>
    
</body>

</html>