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

// SQL query to retrieve details of people with credit points more than 80
$sql = "SELECT info.ID, info.Name, info.Age, info.Email, info.CurrentBal, info.MobileNo, info.Address, credits.Points
        FROM info
        JOIN credits ON info.ID = credits.ID
        WHERE credits.Points > 80";

$result = $conn->query($sql);

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>High Credit Score</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body{
            background-color: grey;
            background-image: url('img5.jpg');
            background-size: 1000px;
            color: white;
        }
        .container {
            background-color: black;
            
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
    <h1>High Credit Score</h1>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Age</th>
            <th>Email</th>
            <th>Current Balance</th>
            <th>Mobile Number</th>
            <th>Address</th>
            <th>Credit Points</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['ID']; ?></td>
                <td><?php echo $row['Name']; ?></td>
                <td><?php echo $row['Age']; ?></td>
                <td><?php echo $row['Email']; ?></td>
                <td><?php echo $row['CurrentBal']; ?></td>
                <td><?php echo $row['MobileNo']; ?></td>
                <td><?php echo $row['Address']; ?></td>
                <td><?php echo $row['Points']; ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
</div>

</body>
</html>
