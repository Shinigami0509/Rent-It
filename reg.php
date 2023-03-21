<?php
    $name= $_POST['fullname'];
    $email = $_POST['email'];
    $phone = $_POST['phone']; 
    $nid = $_POST['nid'];    
    $password = $_POST['password'];
    //database connection
    $conn = new mysqli('localhost', 'root', '', 'rentit');
    if($conn->connect_error){
        die('Connection Failed : '.$conn->connect_error);        
    }
    else{
        $stmt = $conn->prepare("insert into users(name, email, phone, nid, password) 
            values(?,?,?,?,?)");
       $stmt->bind_param("ssiis", $name, $email, $phone, $nid, $password);
        $stmt->execute();
        echo "Registration Complete";
        $stmt->close();
        $conn->close();
    }
?>