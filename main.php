<?php
// ----------------- Database Connection -----------------
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mcadb";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database if it doesn't exist
$conn->query("CREATE DATABASE IF NOT EXISTS $dbname");

// Select the database
$conn->select_db($dbname);

// Create table if it doesn't exist
$table_sql = "CREATE TABLE IF NOT EXISTS book_details (
    book_no INT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    edition INT NOT NULL,
    publisher VARCHAR(100) NOT NULL
)";
$conn->query($table_sql);

// ----------------- Form Submission -----------------
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $bookno = mysqli_real_escape_string($conn, $_POST['bookno']);
    $booktitle = mysqli_real_escape_string($conn, $_POST['booktitle']);
    $bookedition = mysqli_real_escape_string($conn, $_POST['booked']);
    $bookpub = mysqli_real_escape_string($conn, $_POST['bookpub']);

    // Insert data into table
    $insert_sql = "INSERT INTO book_details (book_no, title, edition, publisher)
                   VALUES ('$bookno', '$booktitle', '$bookedition', '$bookpub')";
    $conn->query($insert_sql);
}

// Fetch all records
$result = $conn->query("SELECT * FROM book_details");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Book Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #74ebd5, #ACB6E5);
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: 50px auto;
            background: #ffffffdd;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 10px 25px rgba(0,0,0,0.2);
        }
        h2 {
            text-align: center;
            color: #333;
        }
        form {
            margin-bottom: 40px;
            text-align: center;
        }
        input[type=text], input[type=number] {
            padding: 10px;
            width: 50%;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin: 10px 0;
            font-size: 16px;
        }
        input[type=submit] {
            padding: 10px 30px;
            font-size: 16px;
            background-color: #6C63FF;
            border: none;
            color: white;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
        }
        input[type=submit]:hover {
            background-color: #574fd6;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table th, table td {
            border: 1px solid #aaa;
            padding: 12px;
            text-align: center;
        }
        table th {
            background-color: #6C63FF;
            color: white;
        }
        table tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        table tr:hover {
            background-color: #d0d0f5;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Book Details Form</h2>
    <form method="POST">
        <input type="text" name="bookno" placeholder="Book Number" required><br>
        <input type="text" name="booktitle" placeholder="Book Title" required><br>
        <input type="number" name="booked" placeholder="Book Edition" required><br>
        <input type="text" name="bookpub" placeholder="Book Publisher" required><br>
        <input type="submit" value="Submit">
    </form>

    <h2>All Books</h2>
    <table>
        <tr>
            <th>Book Number</th>
            <th>Title</th>
            <th>Edition</th>
            <th>Publisher</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['book_no'] . "</td>";
                echo "<td>" . $row['title'] . "</td>";
                echo "<td>" . $row['edition'] . "</td>";
                echo "<td>" . $row['publisher'] . "</td>";
                echo "</tr>";
            }
        }
        ?>
    </table>
</div>
</body>
</html>

