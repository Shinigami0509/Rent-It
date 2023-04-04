<?php
// check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // retrieve form data
    $email = $_POST["email"];
    $password = $_POST["password"];

    // connect to the database
    $conn = mysqli_connect("localhost", "root", "", "rentit");

    // check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // prepare SQL statement
    $sql = "SELECT id FROM users WHERE email = '$email' AND password = '$password'";

    // execute SQL statement
    $result = mysqli_query($conn, $sql);

    // check if any rows were returned
    if (mysqli_num_rows($result) > 0) {
        // login successful
        $row = mysqli_fetch_assoc($result);
        $user_id = $row["id"];
        session_start();
        $_SESSION["user_id"] = $user_id;
        header("Location: dashboard.html");
        exit();
    } else {
        // login failed
        echo "Invalid email or password.";
    }

    // close connection
    mysqli_close($conn);
}
?>
