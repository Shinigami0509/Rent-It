<!DOCTYPE html>
<html>
<head>
	<title>Reset Password</title>
	<style>
		form {
			margin: 50px auto;
			padding: 20px;
			width: 400px;
			border: 2px solid #ddd;
			border-radius: 5px;
			box-shadow: 0px 0px 5px #ddd;
			background-color: #f7f7f7;
			font-family: sans-serif;
			font-size: 16px;
		}
		input[type="password"] {
			padding: 10px;
			margin: 10px 0;
			border: none;
			border-radius: 5px;
			box-shadow: 0px 0px 3px #ddd;
			font-size: 16px;
		}
		input[type="submit"] {
			padding: 10px 20px;
			border: none;
			border-radius: 5px;
			background-color: #4CAF50;
			color: #fff;
			font-size: 16px;
			cursor: pointer;
		}
		input[type="submit"]:hover {
			background-color: #3e8e41;
		}
	</style>
</head>
<body>
	<?php
		if (isset($_POST["reset"])) {
			// Retrieve the new password and email from the form data
			$email = $_POST["email"];
			$new_password = $_POST["new_password"];

			// Update the password in the database for the email address
			$conn = mysqli_connect("localhost", "root", "", "rentit");
			$sql = "UPDATE users SET password='$new_password', otp='' WHERE email='$email'";
			mysqli_query($conn, $sql);

			echo "<p>Password has been reset successfully.</p>";
			echo "<a href='login.html'>Go to login page</a>";
		} else {
			echo "<form action='resetpassword.php' method='post'>";
			echo "<input type='hidden' name='email' value='{$_GET["email"]}'>";
			echo "<label for='new_password'>New Password:</label>";
			echo "<input type='password' id='new_password' name='new_password' required><br><br>";
			echo "<label for='confirm_password'>Confirm Password:</label>";
			echo "<input type='password' id='confirm_password' name='confirm_password' required><br><br>";
			echo "<input type='submit' name='reset' value='Reset Password'>";
			echo "</form>";
		}
	?>
</body>
</html>
