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

    // Check if a hospital has been selected
    if (isset($_POST['selected_hospital'])) {
        // Retrieve selected hospital ID from the form
        $selected_hospital_id = $_POST['selected_hospital'];

        // Construct and execute MySQL query to retrieve detailed information about the selected hospital
        $sql = "SELECT * FROM hospital WHERE id = $selected_hospital_id";
        $result = $conn->query($sql);

        // Store retrieved data in a PHP variable
        $_SESSION['selected_hospital_details'] = $result->fetch_assoc();
    }

    // Retrieve search keyword from the form
    if (isset($_POST['search_keyword'])) {
        $search_keyword = $_POST['search_keyword'];

        // Construct and execute MySQL query
        $sql = "SELECT * FROM hospital WHERE address LIKE '%$search_keyword%'";
        $result = $conn->query($sql);

        // Store retrieved data in a PHP variable
        $_SESSION['search_results'] = $result->fetch_all(MYSQLI_ASSOC);
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
    <link rel="stylesheet" href="styleHosp.css">
    <title>Blood Donation Centre Found</title>
    
</head>

<body>
    <header>
        <a href="/fyp/index.php"><i class="fa fa-arrow-left" style="font-size:36px" id="backbtn"></i></a>
    </header>
    <main>
        <section id="listH">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="search-container">
                    <input type="text" name="search_keyword" class="search-bar"
                        placeholder="e.g. Selangor, Melaka, Putrajaya, Kuala Lumpur">
                    <button type="submit" class="search-button"><i class="fa fa-search"></i></button>
                </div>
            </form>

            <div id="searchResults">
                <h2 class="search-h2">Blood Centre Results</h2>
                <ul>
                    <?php
                    if (!empty($_SESSION['search_results'])) {
                        // Loop through each search result and display them in list items
                        foreach ($_SESSION['search_results'] as $result) {
                            echo "<li class='search-list'>";
                            echo "<form method='post' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "'>";
                            echo "<input type='hidden' name='selected_hospital' value='" . $result['id'] . "'>";
                            echo "<button type='submit' class='hospital-button' onclick='scrollToDetail()'><span>" . $result['name'] . "</span></button>";
                            echo "</form>";
                            echo "</li>";
                        }
                    } else {
                        // If no search results found, display a message
                        echo "<li>No results found</li>";
                    }
                    ?>
                </ul>
            </div>
        </section>


        <!-- Detail section -->
        <section id="detail">
            <div class="detail_section">
                <h2 class="detail-h2">Blood Donation Centre's Details</h2>
                <table>
                    <tr>
                        <th colspan="3">
                            <?php
                            // Display the name of the selected hospital
                            if (!empty($_SESSION['selected_hospital_details'])) {
                                echo $_SESSION['selected_hospital_details']["name"];
                            } else {
                                echo "Name not found";
                            }
                            ?>
                        </th>
                    </tr>
                    <tr>
                        <th rowspan="8">
                            <?php
                            // Display the image of the selected hospital
                            if (!empty($_SESSION['selected_hospital_details'])) {
                                echo '<img src="' . $_SESSION['selected_hospital_details']["img"] . '" alt="Hospital Image">';
                            } else {
                                echo "Image not found";
                            }
                            ?>
                        </th>
                        <th>Address:</th>
                        <th>Phone Number:</th>
                    </tr>
                    <tr>
                        <td>
                            <?php
                            // Display the address of the selected hospital
                            if (!empty($_SESSION['selected_hospital_details'])) {
                                echo $_SESSION['selected_hospital_details']["address"];
                            } else {
                                echo "Address not found";
                            }
                            ?>
                        </td>
                        <td>
                            <?php
                            // Display the phone number of the selected hospital
                            if (!empty($_SESSION['selected_hospital_details'])) {
                                echo $_SESSION['selected_hospital_details']["phone"];
                            } else {
                                echo "Phone number not found";
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <th>Fax:</th>
                        <th>Email:</th>
                    </tr>
                    <tr>
                        <td>
                            <?php
                            // Display the fax number of the selected hospital
                            if (!empty($_SESSION['selected_hospital_details'])) {
                                echo $_SESSION['selected_hospital_details']["fax"];
                            } else {
                                echo "Fax not found";
                            }
                            ?>
                        </td>
                        <td>
                            <?php
                            // Display the email of the selected hospital
                            if (!empty($_SESSION['selected_hospital_details'])) {
                                echo $_SESSION['selected_hospital_details']["email"];
                            } else {
                                echo "Email not found";
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <th>Website:</th>
                        <th>Operating Time:</th>
                    </tr>
                    <tr>
                        <td>
                            <?php
                            // Display the website of the selected hospital
                            if (!empty($_SESSION['selected_hospital_details'])) {
                                echo $_SESSION['selected_hospital_details']["website"];
                            } else {
                                echo "Website not found";
                            }
                            ?>
                        </td>
                        <td>
                            <?php
                            // Display the operating time of the selected hospital
                            if (!empty($_SESSION['selected_hospital_details'])) {
                                echo $_SESSION['selected_hospital_details']["ot"];
                            } else {
                                echo "Operating Time not found";
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <th colspan="3" style="text-align: center">Background Details:</th>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <?php
                            // Display the background details of the selected hospital
                            if (!empty($_SESSION['selected_hospital_details'])) {
                                echo $_SESSION['selected_hospital_details']["details"];
                            } else {
                                echo "Details not found";
                            }
                            ?>
                        </td>
                    </tr>
                </table>
            </div>
        </section>
        <section id="maparea">
            <!-- Map section -->
            <div class="map_section">
                <h2>Track Your Blood Donation Center</h2>
                <div class="map-container">
                    <?php
                    // Retrieve and display the map URL of the selected hospital
                    if (!empty($_SESSION['selected_hospital_details'])) {
                        // Assuming $_SESSION['selected_hospital_details'] contains database results
                        $map_url = $_SESSION['selected_hospital_details']["url"];
                        // Output the retrieved iframe link
                        echo $map_url;
                    } else {
                        echo "Map URL not found";
                    }
                    ?>
                </div>
            </div>
        </section>
        <!-- Footer Section -->
        <footer>
            <p>&copy; 2024 Dermawan Darah. All rights reserved.</p>
        </footer>
    </main>

    <!-- JavaScript for handling click event on search-list list items -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const hospitalButtons = document.querySelectorAll(".hospital-button");
            hospitalButtons.forEach(button => {
                button.addEventListener("click", function () {
                    this.closest("form").submit();
                });
            });
        });

        
    </script>
</body>

</html>