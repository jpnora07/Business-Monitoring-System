<!DOCTYPE html>
<html>

<head>
    <title>Checkout Page</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "bms_database";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $postData = json_decode(file_get_contents("php://input"), true);
        if (isset($postData['selectedValues'])) {
            $selectedValues = $postData['selectedValues'];
        
            foreach ($selectedValues as $item) {
                $offer_id = $item['id'];
                $quantity = $item['selectedQty'];
                $name = $item['name'];
                $totalPrice = $item['total'];
        
                $sql = "INSERT INTO inventory (offer_id, quantity, offer_name, total_per_qty) 
                        VALUES ('$offer_id', '$quantity', '$name', '$totalPrice')";
        
                if ($conn->query($sql) === TRUE) {
                    echo "New record created successfully";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            }
        } else {
            echo "No data received.";
        }
    }

    $conn->close();
    ?>



    <div class="button-container2">
        <button onclick="goBack()" class="image-button_return"></button>
    </div>
    <div class="button-container">
        <form  method="post" id="dataForm">
            <button class="image-button_check" ></button>
        </form>
    </div>
    <div class="center-container">
        <div class="scroll-table">
            <table>
                <thead>
                    <tr>
                        <th style="width:30%">QUANTITY</th>
                        <th style="width:40%">OFFER</th>
                        <th style="width:30%">PRICE</th>
                    </tr>
                </thead>
                <tbody id="data-table">
                    <!-- The array list will be dynamically inserted here -->
                </tbody>
            </table>
        </div>
    </div>


    <script>
        function goBack() {
            window.history.back(); // Go back to the previous page
        }

        window.addEventListener('load', () => {
            // Retrieve the array list from local storage or URL parameters
            const storedData = localStorage.getItem('selectedValues');
            const selectedValues = storedData ? JSON.parse(storedData) : [];

            // Get the table body
            const tableBody = document.getElementById('data-table');
            let totalPrice2 = 0;
            // Iterate through the array list and populate the table
            selectedValues.forEach(item => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${item.selectedQty}</td>
                    <td>${item.name}</td>
                    <td>${item.price}</td>
                    
                `;
                tableBody.appendChild(row);
                totalPrice2 += parseFloat(item.total);
            });
            console.log(selectedValues);
            // Create a new row
            const newRow = document.createElement('tr');

            // Add an empty cell to the row
            const emptyCell = document.createElement('td');
            emptyCell.textContent = 'TOTAL: PHP ' + totalPrice2;
            emptyCell.style.backgroundColor = '#48bc94'; // Set background color
            emptyCell.style.width = '100px'; // Set width
            emptyCell.style.height = '40px';
            emptyCell.style.color = 'white';
            emptyCell.colSpan = '5';
            newRow.appendChild(emptyCell);

            // Append the new row to the table body
            tableBody.appendChild(newRow);
        });
    </script>
    <script>
        // Retrieve selectedValues from local storage
        const storedData = localStorage.getItem('selectedValues');
        const selectedValues = storedData ? JSON.parse(storedData) : [];

        // Get the form element
        const form = document.getElementById('dataForm');

        // Add an event listener to the form submission
        form.addEventListener('submit', function (event) {
            event.preventDefault(); // Prevent the default form submission

            if (selectedValues.length === 0) {
            console.log('No data to submit.');
            alert('No data to submit. Please select items before proceeding.');
            return; // Stop further execution if selectedValues is empty
        }
            // Send selectedValues to the PHP script in the same file using AJAX
            fetch('', { // Empty string denotes the current file
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ selectedValues }),
            })
                .then(response => response.text())
                .then(data => {
                    //console.log(data);
                    window.location.href = "options.php";
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        });
    </script>
    

</body>

</html>