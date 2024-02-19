<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Retrieve form data
    $patientName = $_POST["patientName"];
    $gender = $_POST["gender"];
    $dob = $_POST["year"] . "-" . $_POST["month"] . "-" . $_POST["day"];
    $email = $_POST["email"];
    $phoneNumber = $_POST["phoneNumber"];
    $password = $_POST["password"];
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT); // Hash the password

    // Validate and sanitize data (you should enhance validation based on your requirements)

    // Database connection details (modify these based on your database setup)
    $servername = "localhost";
    $username = "root";
    $dbpassword = "";
    $dbname = "miniproject_db";

    // Create a connection
    $conn = new mysqli($servername, $username, $dbpassword, $dbname);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Use prepared statements to prevent SQL injection
    $sql = "INSERT INTO patients (patientName, gender, dob, email, phoneNumber, password) 
            VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    // Bind parameters
    $stmt->bind_param("ssssss", $patientName, $gender, $dob, $email, $phoneNumber, $hashedPassword);

    // Execute the statement
    if ($stmt->execute()) {
        // Redirect to another page upon successful registration
        header("Location: success_page.html");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
