<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bank";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    // Insert into info table
    $name = $_POST['name'];
    $age = $_POST['age'];
    $email = $_POST['email'];
    $currentBal = $_POST['currentBal'];
    $mobileNo = $_POST['mobileNo'];
    $address = $_POST['address'];

    $insert_info_sql = "INSERT INTO info (Name, Age, Email, CurrentBal, MobileNo, Address) VALUES ('$name', $age, '$email', $currentBal, '$mobileNo', '$address')";
    $conn->query($insert_info_sql);

    // Get the ID of the newly inserted row
    $new_id = $conn->insert_id;

    // Insert into credits table
    $points = $_POST['points'];

    $insert_credits_sql = "INSERT INTO credits (ID, Points) VALUES ($new_id, $points)";
    $conn->query($insert_credits_sql);

    echo "<div class='success-message'>Customer added successfully!</div>";
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Customer</title>
    <style>
        body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #3498db; /* Background color */
    background-image: url('img6.jpg');
    color: #fff;
    overflow: auto; /* Allow scrolling */
    }


        .container {
            max-width: 600px;
            margin: 100px auto; /* Center the container */
            background-color: black; /* Container background color */
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #ecf0f1; /* Title text color */
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-top: 15px;
        }

        input, button {
            margin-top: 8px;
            padding: 8px;
        }

        .success-message {
            margin-top: 20px;
            padding: 10px;
            border-radius: 4px;
            text-align: center;
            background-color: #2ecc71; /* Success message color */
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Add New Customer</h1>
    <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <label for="name">Name:</label>
        <input type="text" name="name" required>

        <label for="age">Age:</label>
        <input type="number" name="age" required>

        <label for="email">Email:</label>
        <input type="email" name="email" required>

        <label for="currentBal">Current Balance:</label>
        <input type="number" name="currentBal" required>

        <label for="mobileNo">Mobile Number:</label>
        <input type="text" name="mobileNo" required>

        <label for="address">Address:</label>
        <input type="text" name="address" required>

        <label for="points">Credit Points:</label>
        <input type="number" name="points" required>

        <button type="submit" name="submit">Add Customer</button>
    </form>

    <!-- Success Message will be displayed here -->
</div>

</body>
</html>