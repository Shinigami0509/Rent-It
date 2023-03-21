<?php
    $name= $_POST['fullname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];    
    $password = $_POST['password'];
    //database connection
    $conn = new mysqli('localhost', 'root', '', 'rentit');
    if($conn->connect_error){
        die('Connection Failed : '.$conn->connect_error);        
    }
    else{
        $stmt = $conn->prepare("insert into users(name, email, phone, password) 
            values(?,?,?,?)");
       $stmt->bind_param("ssis", $name, $email, $phone, $password);
        $stmt->execute();
        echo "Registration Complete";
        $stmt->close();
        $conn->close();
    }
?>