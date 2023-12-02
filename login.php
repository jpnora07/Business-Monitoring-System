<!DOCTYPE html>
<html>
<head>
  <title>Login Page</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body class="landing_page">

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['username']) && isset($_POST['password'])) {
    // Retrieve username and password from the form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Replace this with your actual login validation logic
    // For example, checking against a database
    $valid_username = 'username'; // Replace with your valid username
    $valid_password = 'password'; // Replace with your valid password

    // Check if the entered credentials match the valid credentials
    if ($username === $valid_username && $password === $valid_password) {
        // Successful login, redirect to a success page
        header("Location: options.php");
        exit;
    } else {
        // Invalid credentials, show an error message using CSS-based modal
        echo '<div id="myModal" class="modal">';
        echo '  <div class="modal-content">';
        echo '    <span class="closebtn" onclick="document.getElementById(\'myModal\').style.display=\'none\'">&times;</span>';
        echo '    <p>Invalid username or password. Please try again.</p>';
        echo '  </div>';
        echo '</div>';
        echo '<style>';
        echo '.modal { display: none; position: fixed; z-index: 1; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.4); }';
        echo '.modal-content { background-color: #fefefe; margin: 1% auto; padding: 20px; border: 1px solid #888; width: 50%; }';
        echo '.closebtn { color: #aaa; float: right; font-size: 28px; line-height: 20px; font-weight: bold; }';
        echo '.closebtn:hover, .closebtn:focus { color: black; text-decoration: none; cursor: pointer; }';
        echo '</style>';
        echo '<script>';
        echo 'document.getElementById("myModal").style.display = "block";';
        echo '</script>';
    }
}
?>
<div class="container">
  <form method="post" class="login-form">
  <label for="username" class="input-with-icon">
      <img src="images/username.png" alt="Username Icon">
      <span>Username:</span>
      <input type="text" id="username" name="username">
    </label>

    <label for="password" class="input-with-icon">
      <img src="images/pasword.png" alt="Password Icon">
      <span>Password:</span>
      <input type="password" id="password" name="password">
    </label>
    <div class="login_btn_container" >
      <button type="submit" value="Login" class="login_btn">Log in</button>
  </div>
  </form>
</div>
<script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>
</body>

</html>
