
<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

// Generate a random 6-digit OTP
$otp = rand(100000, 999999);

// Store the OTP in the database
$conn = mysqli_connect("localhost", "root", "", "rentit");
$email = $_POST["email"];
$sql = "SELECT * FROM users WHERE email='$email'";
$sql = "UPDATE users SET otp='$otp' WHERE email='$email'";
mysqli_query($conn, $sql);

if(isset($_POST["send"])){
    $mail = new PHPMailer(true);

    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com'; // SMTP server
    $mail->SMTPAuth   = true;
    $mail->Username   = 'walidbin.kamal64@gmail.com'; // SMTP username
    $mail->Password   = 'lwphdqfhxaagkcuw'; // SMTP password
    $mail->SMTPSecure = 'ssl';
    $mail->Port       = 465;

    $mail->setFrom('walidbin.kamal64@gmail.com');
    $mail->addAddress($_POST["email"]);

    
    $mail->isHTML(true);
    $mail->Subject = 'OTP for password reset';
    $mail->Body    = "Your OTP is: $otp";

    $mail->send();
    echo "
    <script>
    alert('Sent Successfully');
    document.location/href = 'index.php';
    </script>
    ";
}
?>
