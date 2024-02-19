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
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Validate user credentials
    $sql = "SELECT * FROM patient_registration_table WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashedPassword = $row["password"];

        // Verify password
        if (password_verify($password, $hashedPassword)) {
            echo "Login successful!";
            // Redirect to another page after successful login
            header("Location: QuestionSet.html");
            exit();
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "Invalid email.";
    }

    $stmt->close();
}

// Close the connection
$conn->close();
?>
