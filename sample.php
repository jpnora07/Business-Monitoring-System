<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "bms_database";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } else
{
    echo "connection success.";
}    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $postData = json_decode(file_get_contents("php://input"), true);
    $selectedValues = $postData['selectedValues'];
    if (isset($postData['selectedValues'])) {
            $selectedValues = $postData['selectedValues'];

            foreach ($selectedValues as $item) {
                $offer_id = $item['id'];
                $quantity = $item['selectedQty'];
                $name = $item['name'];
                $totalPrice = $item['total'];

                $sql = "INSERT INTO inventory (offer_id, quantity, offer_name, total_per_qty) 
                        VALUES ('$offer_id', '$quantity', '$name', '$totalPrice')";
                        
            }

        } else {
            echo "No data received.";
        }
    echo "No data received.";
        
    }

    $conn->close();
    ?>
