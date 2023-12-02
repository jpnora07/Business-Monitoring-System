<!DOCTYPE html>
<html>

<head>
    <title>Checkout Page</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* styles.css */
        .outer-table {
            width: 325px;
            border-spacing: 0;
            border-collapse: collapse;
            margin: 0 auto;
        }

        .header-table {
            width: 100%;
            border-spacing: 0;
            border-collapse: collapse;
            color: white;
            background-color: grey;
        }

        .header-table th {
            width: 30%;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table td {
            width: 30.9%;
            border: 1px solid white;
            padding: 8px;
            text-align: center;
        }

        .inner-div {
            width: 100%;
            height: 300px;
            overflow: auto;
        }

        /* Your additional styles can go here */
    </style>
</head>
<?php
                            // Your PHP code for fetching and displaying data
                            $servername = "localhost";
                            $username = "root";
                            $password = "";
                            $dbname = "bms_database";

                            $conn = new mysqli($servername, $username, $password, $dbname);

                            if ($conn->connect_error) {
                                die("Connection failed: " . $conn->connect_error);
                            }

                            $requestData = json_decode(file_get_contents("php://input"), true);
                            $selectedDate = $requestData['selectedDate']; // The selected date received from the frontend
                            $timestamp = strtotime($selectedDate);
                            $monthText = date('F d, Y', $timestamp);

                            // Perform a database query based on the selected date
                            $sql = "SELECT * FROM inventory WHERE DATE(timestamp) = '$selectedDate'";
                            $result = $conn->query($sql);
                            
                            $conn->close();
                            ?>
<body>
    <div class="center-container">
        <div class="scroll-table">
            <table class="outer-table">
                <tr>

                    <table class="header-table">
                        <tr style="color:white;background-color:grey">
                            <th style="width:30%"><?php echo $monthText; ?></th>
                        </tr>
                    </table>

                </tr>
                <tr>

                    <table class="header-table">
                        <tr style="color:white;background-color:grey">
                            <th style="width:30%">QUANTITY</th>
                            <th style="width:40%">OFFERS</th>
                            <th style="width:30%">PRICE</th>
                        </tr>
                    </table>

                </tr>
                <tr>
                    <div class="inner-div">
                        <table class="data-table">
                            <?php
                            $total = 0;
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr ><td style=width:30.9%>" . $row["quantity"] . "</td><td style=width:40.9%>" . $row["offer_name"] . "</td><td>PHP " . $row["total_per_qty"] . "</td></tr>";
                                    $total += $row["total_per_qty"];
                                }
                            } else {
                                echo "<tr><td colspan='3'>No data found</td></tr>";
                            }
                            ?>
                        </table>
                    </div>
                </tr>
                <tr>

                    <table class="header-table">
                        <tr style="color:white;background-color:grey">
                            <th style="width:30%">TOTAL: PHP <?php echo $total; ?></th>
                        </tr>
                    </table>

                </tr>
            </table>
        </div>
    </div>
    <div class="button-container">
    <button class="image-button_check" onclick="goBack()"></button>
  </div>
  <script>
    function goBack() {
        window.location.href = "options.php"; // Go back to the previous page
        }
  </script>
</body>


</html>