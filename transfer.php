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

// Initialize variables
$successMessage = $errorMessage = '';

// Handle form submission for money transfer
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sender_account = $_POST['sender_account'];
    $receiver_account = $_POST['receiver_account'];
    $amount = $_POST['amount'];

    // Validate the input (you should add more validation based on your requirements)

    // Check if the sender account exists
    $check_sender_sql = "SELECT CurrentBal FROM info WHERE ID = $sender_account";
    $sender_result = $conn->query($check_sender_sql);

    // Check if the receiver account exists
    $check_receiver_sql = "SELECT CurrentBal FROM info WHERE ID = $receiver_account";
    $receiver_result = $conn->query($check_receiver_sql);

    if ($sender_result->num_rows > 0 && $receiver_result->num_rows > 0) {
        $sender_balance = $sender_result->fetch_assoc()['CurrentBal'];

        if ($sender_balance >= $amount) {
            // Deduct amount from sender
            $update_sender_sql = "UPDATE info SET CurrentBal = CurrentBal - $amount WHERE ID = $sender_account";
            $conn->query($update_sender_sql);

            // Add amount to receiver
            $update_receiver_sql = "UPDATE info SET CurrentBal = CurrentBal + $amount WHERE ID = $receiver_account";
            $conn->query($update_receiver_sql);

            // Set success message
            $successMessage = "Money transfer successful!";
        } else {
            // Set error message
            $errorMessage = "Insufficient balance!";
        }
    } else {
        // Set error message
        $errorMessage = "Sender or receiver account not found!";
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Money Transfer</title>
    
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: black; /* Updated background color */
            background-image: url('img2.webp');
            background-size: 1400px;
            color: #fff;
            overflow: hidden; /* Prevent scrollbar flash during animations */
        }

        .container {
            max-width: 800px;
            margin: 150px auto; /* Center the container */
            padding: 20px;
            color: black;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        
            animation: fadeInUp 1s ease-out; /* Fade in animation */
        }

        h1 {
            text-align: center;
            color: black; /* Updated text color */
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        label {
            margin-top: 15px;
        }

        input, button {
            margin-top: 8px;
            padding: 8px;
        }

        .success-message, .error-message {
            margin-top: 20px;
            padding: 10px;
            border-radius: 4px;
            text-align: center;
        }

        .success-message {
            background-color: #2ecc71; /* Updated success message color */
        }

        .error-message {
            background-color: #e74c3c; /* Updated error message color */
        }

        .go-to-customers-button {
            margin-top: 20px;
            padding: 10px;
            border: none;
            border-radius: 4px;
            background-color: #3498db;
            color: #fff;
            cursor: pointer;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Money Transfer</h1>
    <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <label for="sender_account">Sender Account Number:</label>
        <input type="text" name="sender_account" required>

        <label for="receiver_account">Receiver Account Number:</label>
        <input type="text" name="receiver_account" required>

        <label for="amount">Amount:</label>
        <input type="number" name="amount" required>

        <button type="submit">Transfer Money</button>
    </form>

    <?php
    // Display success message and button only when the transfer is successful
    if (!empty($successMessage)) {
        echo "<div class='success-message'>$successMessage";
        // Add the button to go to customer details
        echo "<button class='go-to-customers-button' onclick='goToCustomerDetails()'>Go to Customer Details</button>";
        echo "</div>";
    }

    // Display error message
    if (!empty($errorMessage)) {
        echo "<div class='error-message'>$errorMessage</div>";
    }
    ?>

    <!-- Error Messages will be displayed here -->
</div>

<!-- JavaScript to navigate to the customers page -->
<script>
    function goToCustomerDetails() {
        window.location.href = 'customers.php'; // Replace 'customers.php' with the actual URL of your customers page
    }
</script>

</body>
</html>
