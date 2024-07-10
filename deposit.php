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

// Handle deposit logic when the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $account_number = $_POST['account_number'];
    $amount = $_POST['amount'];

    // Validate the input (you should add more validation based on your requirements)

    // Check if the account exists
    $check_account_sql = "SELECT CurrentBal FROM info WHERE ID = $account_number";
    $account_result = $conn->query($check_account_sql);

    if ($account_result->num_rows > 0) {
        // Add amount to the account
        $update_account_sql = "UPDATE info SET CurrentBal = CurrentBal + $amount WHERE ID = $account_number";
        $conn->query($update_account_sql);

        echo "<div class='success-message'>Deposit successful!</div>";
        // Redirect to the customers.php page
        header("Location: customers.php");
        exit();
    } else {
        echo "<div class='error-message'>Account not found!</div>";
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
    <title>Deposit Money</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: grey; /* Updated background color */
            background-image: url('img4.jpg');
            color: #fff;
            overflow: hidden; /* Prevent scrollbar flash during animations */
        }

        .container {
            max-width: 800px;
            margin: 170px auto; /* Center the container */
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            animation: fadeInUp 1s ease-out; /* Fade in animation */
        }

        h1 {
            text-align: center;
            color: #ecf0f1; /* Updated text color */
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
            background-color: #27ae60; /* Updated success message color */
        }

        .error-message {
            background-color: #e74c3c; /* Updated error message color */
        }

        /* Animation keyframes */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Deposit Money</h1>
    <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <label for="account_number">Account Number:</label>
        <input type="text" name="account_number" required>

        <label for="amount">Amount:</label>
        <input type="number" name="amount" required>

        <button type="submit">Deposit Money</button>
    </form>

    <!-- Success or Error Messages will be displayed here -->
</div>

</body>
</html>
