<?php
session_start();

function sanitizeInput($data) {
    return strip_tags(trim($data)) ;
}

$servername = "localhost";
$username = "root"; 
$password = "";     
$dbname = "applications"; 
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT name, age, bio, email, image_name FROM applicants";
$result = $conn->query($sql);

if ($result) {
    if ($result->num_rows > 0) {
        echo "<h2>List of Applicants:</h2>";
        echo "<table border='1'>
                <tr>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Bio</th>
                    <th>Email</th>
                    <th>Image</th>
                </tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . htmlspecialchars($row["name"]) . "</td>
                    <td>" . htmlspecialchars($row["age"]) . "</td>
                    <td>" . htmlspecialchars($row["bio"]) . "</td>
                    <td>" . htmlspecialchars($row["email"]) . "</td>
                    <td><img src='" . htmlspecialchars($row["image_name"]) . "' alt='Profile Image' width='100'></td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No pending applications.</p>";
    }
} else {
    echo "Error in SQL query: " . $conn->error;
}

$conn->close();
?>
