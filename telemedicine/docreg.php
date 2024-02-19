<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "miniproject_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Extract form data
    $doctorName = $_POST["doctorName"];
    $gender = $_POST["gender"];
    $year = $_POST["year"];
    $month = $_POST["month"];
    $day = $_POST["day"];
    $email = $_POST["email"];
    $phoneNumber = $_POST["phoneNumber"];
    $rawPassword = $_POST["password"];
    $confirmPassword = $_POST["confirmPassword"];

    // Check if password and confirm password match
    if ($rawPassword !== $confirmPassword) {
        die("Error: Password and Confirm Password do not match.");
    }

    // Hash the password
    $password = password_hash($rawPassword, PASSWORD_DEFAULT);

    // Insert data into the database
    $sql = "INSERT INTO doctor_registration_table (full_name, gender, date_of_birth, email, phone_number, password)
            VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $doctorName, $gender, "$year-$month-$day", $email, $phoneNumber, $password);

    if ($stmt->execute()) {
        // Redirect to another HTML page after successful form submission
        header("Location: doc.html");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $stmt->error;
    }

    $stmt->close();
}

// Close the connection
$conn->close();
?>
