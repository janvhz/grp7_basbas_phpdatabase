<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['accept_cookies'])) {
    setcookie('cookies_accepted', 'true', time() + (86400 * 30), "/");
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

function sanitizeInput($data) {
    return strip_tags(trim($data)) ;
}

$dataFile = 'group7_data.txt';
if (file_exists($dataFile)) {
    $teamArray = file($dataFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
} else {
    $teamData = 
        "Rechelle|image1.png|Group Member|candidorechelleanne@gmail.com|I'm Rechelle Anne Candido, a third-year BSIT student. A working student, nail tech, makeup artist and I own a small business. I work hard because I want to pursue my course and become successful in the future.\n" .
        "Johnn Vhelle|Image2.jpg|Group Member|johnnvhellebasbas@gmail.com|Hi there! I'm Vhelle, and I'm a third-year college student at PLMun. I currently take the BSIT program. Watching movies and reading stories are two of my interests, and I'd like to master digital art someday.\n" .
        "Ian Christoper|Image5.jpeg|Group Leader|icasenci12@gmail.com|I'm Ian, a third-year BSIT student at PLMun! Just a guy trying to do better every passing day and hoping that life takes me to a simple yet better place.\n" .
        "Justin|Image4.jpg|Group Member|Justinpadora@gmail.com|I'm Justin Padora, a third-year BSIT student who also works as a crew leader at a fast food restaurant. I'm motivated to work hard in order to achieve my goal of graduating.\n";
    file_put_contents($dataFile, $teamData);
    $teamArray = file($dataFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Group 7 Team Portfolio</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <script>

function validateName() {
            const nameInput = document.getElementById('name');
            const nameError = document.getElementById('nameError');
            const submitButton = document.querySelector('button[type="submit"]');
            const nameRegex = /^[a-zA-Z\s]+$/;

            if (!nameRegex.test(nameInput.value)) {
                nameError.textContent = "Invalid name. Please use only letters and spaces.";
                submitButton.disabled = true;
            } else {
                nameError.textContent = "";
                if (document.getElementById('emailError').textContent === "") {
                submitButton.disabled = false;
            }
        }
    }
        function validateEmail() {
        const emailInput = document.getElementById('email');
        const emailError = document.getElementById('emailError');
        const submitButton = document.querySelector('button[type="submit"]');
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (!emailRegex.test(emailInput.value)) {
            emailError.textContent = "Invalid email address.";
            submitButton.disabled = true;
        } else {
            emailError.textContent = "";
            if (document.getElementById('nameError').textContent === "") {
                submitButton.disabled = false;
            }
        }
    }

        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('name').addEventListener('input', validateName);
            document.getElementById('email').addEventListener('input', validateEmail);
        });
    </script>
</head>
<body>
<header>
        <div class="header-container">
            <div class="logo">
                <h1>Group 7 Team Portfolio</h1>
            </div>
            <nav class="nav-links">
                <a href="register.php">Register</a>
                <a href="submit.php">Team</a>
                <a href="#" onclick="toggleInquiryForm(event)">Contact Us</a>
            </nav>
        </div>
    </header>
    
    <div class="team-members">
        <?php foreach ($teamArray as $index => $memberData): 
            $member = explode('|', sanitizeInput($memberData)); ?>
        <div class="team-member">
            <img id="imagePreview<?php echo $index + 1; ?>" src="<?php echo $member[1]; ?>" alt="Team Member <?php echo $index + 1; ?>">
            <h2><?php echo htmlspecialchars($member[0]); ?></h2>
            <div class="role-label">Role</div>
            <p class="role"><?php echo htmlspecialchars($member[2]); ?></p>
            <div class="contact-label">Contact</div>
            <p class="contact"><?php echo htmlspecialchars($member[3]); ?></p>
            <div class="bio-label">Bio</div>
            <p class="bio"><?php echo htmlspecialchars($member[4]); ?></p>
        </div>
        <?php endforeach; ?>
    </div>
    
    <div class="inquiry-form-container" id="contact" style="display: none;">
        <h2>Contact Us</h2>
        <form id="inquiryForm" action="form.php" method="post">
            <div class="inquiry-form">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
                <span id="nameError" style="color:red;"></span>
            </div>
            <div class="inquiry-form">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
                <span id="emailError" style="color:red;"></span>
            </div>
            <div class="inquiry-form">
                <label for="message">Message:</label>
                <textarea id="message" name="message" required></textarea>
            </div>
            <div class="inquiry-form">
                <button type="submit">Submit</button>
            </div>
        </form>
    </div>

<div id="cookieBanner" class="cookie-banner">
    <p>This website uses cookies to improve user experience. By using our website you consent to all cookies in accordance with our Cookie Policy. <button onclick="acceptCookies()">Accept</button></p>
</div>

<footer>
<div class="footer-container">
        <div class="footer-links">
            <div class="footer-section">
                <h3>About Us</h3>
                <a href="#about">Company</a>
            </div>
            <div class="legal-links">
                <h3>Terms & Policies</h3>
        <ul>
                <li><a href="#terms">Terms of Service</a></li>
                <li><a href="#policy">Privacy Policy</a></li>
        </ul>
            </div>
            <div class="footer-section">
                <h3>Support</h3>
                <a href="#faq">FAQ</a>
            </div>
        </div>
    <div class="social-media">
        <a href="https://www.facebook.com" target="_blank">
            <img src="facebook.jpg" alt="Facebook" style="width:32px;height:32px;">
        </a>
        <a href="https://www.twitter.com" target="_blank">
            <img src="twitter.png" alt="Twitter" style="width:32px;height:32px;">
        </a>
        <a href="https://www.instagram.com" target="_blank">
            <img src="instagram.jpg" alt="Instagram" style="width:32px;height:32px;">
        </a>
        <a href="https://www.whatsapp.com" target="_blank">
            <img src="whatsapp.jpg" alt="Whatsapp" style="width:32px;height:32px;">
        </a>
    </div>
 </div>
 <p>&copy; Copyright 2024 Group 7 IT3L. All Rights Reserved.</p>
</footer>

    <script>
    function toggleInquiryForm(event) {
    event.preventDefault();
    const inquiryFormContainer = document.getElementById('contact');
    if (inquiryFormContainer.style.display === 'none') {
        inquiryFormContainer.style.display = 'block';
        window.scrollTo({
            top: inquiryFormContainer.offsetTop,
            behavior: 'smooth'
        });
    } else {
        inquiryFormContainer.style.display = 'none';
    }
}

    function acceptCookies() {
        document.cookie = "cookies_accepted=true; max-age=" + (86400 * 30) + "; path=/";
        document.getElementById('cookieBanner').style.display = 'none';
    }

    function checkCookies() {
        let cookies = document.cookie.split(';').map(cookie => cookie.trim());
        let cookiesAccepted = cookies.some(cookie => cookie.startsWith('cookies_accepted='));
        if (!cookiesAccepted) {
            document.getElementById('cookieBanner').style.display = 'block';
        }
    }
    checkCookies();

    document.getElementById("registerForm").addEventListener("submit", function(event) {
    event.preventDefault(); 

    var email = document.getElementById("email").value;
    var errorMessage = document.getElementById("error-message");
    var successMessage = document.getElementById("success-message");

    var emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    if (!emailPattern.test(email)) {
        errorMessage.textContent = "Please enter a valid email address.";
        successMessage.style.display = "none"; 
    } else {
        errorMessage.textContent = ""; 

        successMessage.style.display = "block";

        setTimeout(function() {
            alert("Form successfully submitted!"); 
        }, 500); 
    }
});
    </script>
</body>
</html>