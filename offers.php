<!DOCTYPE html>
<html>

<head>
  <title>Offers</title>
  <link rel="stylesheet" href="styles.css">
</head>

<body>
  <?php
  // PHP logic for handling form submission
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "bms_database";

  $conn = new mysqli($servername, $username, $password, $dbname);

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  // SQL query to select data from the table
  $sql = "SELECT id, offer_available, offer_name, offer_price FROM offers";
  $result = $conn->query($sql);

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $available = isset($_POST['available']) ? $_POST['available'] : '';
    $offerName = isset($_POST['offerName']) ? $_POST['offerName'] : '';
    $offerPrice = isset($_POST['price']) ? $_POST['price'] : '';

    $sql = "INSERT INTO offers (offer_available, offer_name, offer_price) VALUES ('$available', '$offerName', '$offerPrice')";
    if ($conn->query($sql) === TRUE) {
      echo '<script>alert("Submit Successfully!")</script>';
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }

  }

  $conn->close();
  ?>

  <div class="center-container-offers">

    <div class="offers_container">
      <div class="extra_div"></div>
        <h3>OFFERS</h3>
      <div class="proceed_button-container">
        <button type="submit" onclick="storeAndRedirect()" class="image-button_proceed"></button>
      </div>
    </div>
    <div class="button-container">
      <button type="submit" class="button_add">+</button>
    </div>
    
    <div class="scroll-container">
      <?php
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          echo '<div class="offer_product_container">';
          echo '<div class="offer_product_name_container">';
          echo '<input type="text" placeholder="0" class="qty_input" value="' . $row['offer_available'] . '" disabled>';
          echo '<input type="text" placeholder="OFFER" class="offer_textbox" value="' . $row['offer_name'] . '" disabled>';
          echo '<button type="submit" class="confirm_btn" data-offer-price="' . $row['offer_price'] . '" data-offer-id="' . $row['id'] . '" data-offer-name="' . $row['offer_name'] . '" data-offer-available="' . $row['offer_available'] . '"></button>';
          echo '</div>';
          echo '<div class="offer_price_container">';
          echo '<input type="text" placeholder="Price" class="price_textbox" value="PHP ' . $row['offer_price'] . '" disabled>';
          echo '</div>';
          echo '</div>';
        }
      } else {
        echo '<div class="offer_product_container">';
        echo '<div class="offer_product_name_container">';
        echo '<input type="text" placeholder="0" class="qty_input" disabled>';
        echo '<input type="text" placeholder="OFFER" class="offer_textbox" disabled>';
        echo '<button type="submit" class="confirm_btn"></button>';
        echo '</div>';
        echo '<div class="offer_price_container">';
        echo '<input type="text" placeholder="Price" class="price_textbox" disabled>';
        echo '</div>';
        echo '</div>';
      }
      ?>
    </div>

    <!-- The Modal -->
    <div id="myModal" class="add_offer_modal">

      <!-- Modal content -->
      <div class="add_offer_modal-content">

        <span class="closebtn" onclick="closeModal()">&times;</span>
        <h2>Add New Offer</h2>
        <form class="offer-modal-form" method="post">

          <div class="input-field-modal">
            <label for="available" class="input-lbl">Available:</label>
            <input type="text" id="numericInput1" name="available" placeholder="0">

            <label for="offerName" class="input-lbl">Offer name:</label>
            <input type="text" id="offerName" name="offerName" class="input-box">

            <label for="price" class="input-lbl">Price:</label>
            <input type="text" id="numericInput2" name="price" class="input-box">

            <div class="save_btn_container">
              <button type="submit" class="save_offer_btn">Add</button>
            </div>

          </div>
        </form>
      </div>
    </div>

    <div id="digitsModal" class="digits_qty_modal">
      <div class="digits_qty_modal-content">
        <div class="offer_name_qty_container">
          <label class="offer_name_qty">Offer Name</label>
          <label class="offer_qty"></label>
        </div>
        <div class="buttons-container">
          
        <div class="offer_num_qty_container">
          <button type="button" class="digits_btn">7</button>
          <button type="button" class="digits_btn">8</button>
          <button type="button" class="digits_btn">9</button>
          <button type="button" class="digits_btn">0</button>
        </div>
        <div class="offer_num_qty_container">
          <button type="button" class="digits_btn">4</button>
          <button type="button" class="digits_btn">5</button>
          <button type="button" class="digits_btn">6</button>
          <button type="button" class="digits_btn" id="btnDel">DEL</button>
        </div>
        <div class="offer_num_qty_container">
          <button type="button" class="digits_btn">1</button>
          <button type="button" class="digits_btn">2</button>
          <button type="button" class="digits_btn">3</button>
          <button type="button" class="digits_btn">=</button>
        </div>
        <div class="offer_num_qty_container">
          <button type="button" class="history_btn">HISTORY</button>
          <button type="button" class="digits_btn">OK</button>
        </div>
        
        </div>
      </div>
    </div>

  </div>

  <script>
    document.getElementById('digitsModal').style.display = 'none';
    document.getElementById('myModal').style.display = 'none';

    function openModal() {
      document.getElementById('myModal').style.display = 'block';
    }

    function closeModal() {
      document.getElementById('myModal').style.display = 'none';
    }

    const addOffer = document.querySelector('.button_add');
    addOffer.addEventListener('click', openModal);

    function opendigitsModal() {
      document.getElementById('digitsModal').style.display = 'block';
    }

    function closedigitsModal() {
      document.getElementById('digitsModal').style.display = 'none';
    }

    // Delegating the click event to a parent element (in this case, the body)
    document.body.addEventListener('click', function (event) {
      if (event.target.classList.contains('confirm_btn')) {
        opendigitsModal();
      }
    });

    // Function to handle numeric input
    function handleNumericInput(event) {
      let inputValue = event.target.value;
      inputValue = inputValue.replace(/\D/g, '');
      event.target.value = inputValue;
    }

    // Get the input elements
    const numericInput1 = document.getElementById('numericInput1');
    const numericInput2 = document.getElementById('numericInput2');

    // Add event listeners for the 'input' event on both input fields
    numericInput1.addEventListener('input', handleNumericInput);
    numericInput2.addEventListener('input', handleNumericInput);

    function reloadPage() {
      // Perform any actions needed before reload (if any)
      location.reload(); // Reload the page
    }
  </script>
  <script>
    let globalOfferId, globalOfferName, globalOfferQTY, selectedoffer, globalOfferPrice;
    const confirmButtons = document.querySelectorAll('.confirm_btn');

    confirmButtons.forEach(button => {
      button.addEventListener('click', function () {
        globalOfferId = this.dataset.offerId;
        globalOfferName = this.dataset.offerName;
        globalOfferQTY = this.dataset.offerAvailable;
        globalOfferPrice = this.dataset.offerPrice;
        selectedoffer = this.parentElement.querySelector('.qty_input');
        document.querySelector('.offer_name_qty').innerText = globalOfferName + " - ";
        document.getElementById('digitsModal').style.display = 'block';

      });
    });
  </script>

  <script>
    const digitsButtons = document.querySelectorAll('.digits_btn');
    const offerqtyLabel = document.querySelector('.offer_qty');
    const selectedValues = [];
    digitsButtons.forEach(button => {
      button.addEventListener('click', function () {
        const buttonText = this.innerText;
        if (buttonText == 'DEL') {
          const currentText = offerqtyLabel.textContent;
          offerqtyLabel.textContent = currentText.slice(0, -1);
        } else if (buttonText == 'OK') {
          const qtyinput = offerqtyLabel.textContent.trim(); // Assuming it's a text content
          if (qtyinput !== null && qtyinput !== undefined && qtyinput !== '' && qtyinput !== "0") {
            const remainingQuantity = globalOfferQTY - parseInt(qtyinput, 10);
            const totalPrice = parseInt(qtyinput, 10) * globalOfferPrice;

            if (!isNaN(remainingQuantity) && !isNaN(totalPrice) && remainingQuantity >= 0) {
              console.log(remainingQuantity);
              console.log(globalOfferPrice);
              console.log(totalPrice);
              selectedoffer.value = remainingQuantity;
              selectedValues.push({
                id: globalOfferId,
                name: globalOfferName,
                qty: globalOfferQTY,
                price: globalOfferPrice,
                selectedQty: parseInt(qtyinput, 10),
                total: totalPrice
              });
              console.log(selectedValues);
              document.getElementById('digitsModal').style.display = 'none';
            } else {
              console.log('Invalid quantity or price calculations.');
            }
          } else {
            document.getElementById('digitsModal').style.display = 'none';
            console.log('Quantity input is empty.');
          }
        }
        else {
          offerqtyLabel.textContent += buttonText;
        }
      });
    });

    function storeAndRedirect() {
      localStorage.setItem('selectedValues', JSON.stringify(selectedValues));
      window.location.href = 'checkout.php';
    }

  </script>
  <script>
    if (window.history.replaceState) {
      window.history.replaceState(null, null, window.location.href);
    }
  </script>
</body>

</html>