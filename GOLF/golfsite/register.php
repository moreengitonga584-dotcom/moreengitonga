<?php
$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "members";
$message = "";
$conn = mysqli_connect($servername, $username, $password, $dbname);


if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
echo "Connected successfully";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $firstname = $_POST["firstname"];
    $lastname =$_POST["lastname"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $membership_type = $_POST["membership_type"];

    
    $stmt = $conn->prepare(
        "INSERT INTO members (full_name, email, phone, membership_type)
         VALUES (?, ?, ?, ?)"
    );

    $stmt->bind_param("ssss", $firstname,$lastname, $email, $phone, $membership_type);

    if ($stmt->execute()) {
        $message = "Registration successful!";
    } else {
        $message = "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Join Membership</title>
    <link rel="stylesheet" href="css/golf.css">
</head>
<body>



<section class="membership-section">
    <h2>Join Elite Golf Club</h2>


    <?php if ($message != ""): ?>
        <p style="color: green; font-weight: bold;"><?php echo $message; ?></p>
    <?php endif; ?>

    
    <form method="POST" class="membership-form">
        <input type="text" name="firstname" placeholder="First Name" required>
        <input type="text" name="lastname" placeholder="Last Name" required>
        <input type="email" name="email" placeholder="Email Address" required>
        <input type="text" name="phone" placeholder="Phone Number" required>

        <select name="membership_type" required>
            <option value="">Select Membership Type</option>
            <option>Standard</option>
            <option>Premium</option>
            <option>Junior</option>
        </select>

        <button type="submit">Register</button>
    </form>
</section>
<p><a href="index.html">Back to Home</a></p>
</body>
</html>






