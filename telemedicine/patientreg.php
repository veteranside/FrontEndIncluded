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
    $password = "";
    $dbname = "miniproject_db";

    // Create a connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Insert data into the database (modify the query based on your table structure)
    $sql = "INSERT INTO patients (patientName, gender, dob, email, phoneNumber, password) 
            VALUES ('$patientName', '$gender', '$dob', '$email', '$phoneNumber', '$hashedPassword')";

    if ($conn->query($sql) === TRUE) {
        echo "Registration successful!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the connection
    $conn->close();
}
?>
