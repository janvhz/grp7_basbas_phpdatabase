<?php
session_start();

function sanitizeInput($data) {
    return strip_tags(trim($data)) ;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $age = filter_input(INPUT_POST, 'age', FILTER_VALIDATE_INT);
    $bio = filter_input(INPUT_POST, 'bio', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);

    if ($email) {
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $image = $_FILES['image'];
            $imageName = basename($image['name']);
            $_SESSION['name'] = $name;
            $_SESSION['age'] = $age;
            setcookie("user_name", $name, time() + (86400 * 30), "/");
            $servername = "localhost";
            $username = "root"; 
            $password = "";    
            $dbname = "applications"; 
            $conn = new mysqli($servername, $username, $password, $dbname);
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            $stmt = $conn->prepare("INSERT INTO applicants (name, age, bio, email, image_name) VALUES (?, ?, ?, ?, ?)");
            if (!$stmt) {
                die("Error in SQL query preparation: " . $conn->error);
            }

            $stmt->bind_param("sisss", $name, $age, $bio, $email, $imageName);

            if ($stmt->execute()) {
                echo "<p id='success-message'>Registration successful! Welcome, " . htmlspecialchars($name) . ".</p>";
            } else {
                echo "<p id='error-message'>Error: " . $stmt->error . "</p>";
            }

            $stmt->close();
            $conn->close();

        } else {
            echo "<p id='error-message'>Please upload a valid image file.</p>";
        }
    } else {
        echo "<p id='error-message'>Please enter a valid Email address.</p>";
    }
}
if (isset($_COOKIE['user_name'])) {
    $userName = htmlspecialchars($_COOKIE['user_name']);
    echo "<p>Welcome back, $userName!</p>";
}
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="style.css"> 
</head>
<body class="register-page">
<form id="registerForm" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name">
    </div>
    <div class="form-group">
        <label for="age">Age:</label>
        <select id="age" name="age">
            <?php
            for ($i = 18; $i <= 50; $i++) {
                echo "<option value='$i'>$i</option>";
            }
            ?>
        </select>
    </div>
    <div class="form-group">
        <label for="bio">Bio:</label>
        <textarea id="bio" name="bio" rows="4" cols="50"></textarea>
    </div>
    <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email">
    </div>
    <div class="form-group">
        <label for="image">Select Profile Image:</label>
        <input type="file" id="image" name="image" accept="image/*">
    </div>
    <input type="submit" name="register" value="Register" class="register-btn">
    <input type="submit" formaction="applications.php" value="Check Pending Applications" class="pending-btn">
</form>