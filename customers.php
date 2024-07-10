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

// Fetch customer details from the database
$sql = "SELECT * FROM info";
$result = $conn->query($sql);

// Store the results in an array
$customers = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $customers[] = $row;
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
    <title>Customer Information</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body{
            background-image: url('img6.jpg');
            background-color: grey;
            color: white;
        }
        .container {
            background-color: black;
            text-align: center;
            padding: 20px;
            margin: 300px;
            border-radius: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid white;
        }

        th {
            background-color: black;
        }

        tr:nth-child(even) {
            background-color: #555;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Customer Information</h1>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Age</th>
            <th>Email</th>
            <th>Current Balance</th>
            <th>Mobile Number</th>
            <th>Address</th>
        </tr>
        <?php foreach ($customers as $customer): ?>
            <tr>
                <td><?php echo $customer['ID']; ?></td>
                <td><?php echo $customer['Name']; ?></td>
                <td><?php echo $customer['Age']; ?></td>
                <td><?php echo $customer['Email']; ?></td>
                <td><?php echo $customer['CurrentBal']; ?></td>
                <td><?php echo $customer['MobileNo']; ?></td>
                <td><?php echo $customer['Address']; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>

</body>
</html>
