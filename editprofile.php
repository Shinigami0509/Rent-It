
<!DOCTYPE html>
<html>
<head>
    <title>Edit Profile</title>
    <style>
        * {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

body {
    background-color: #f1f1f1;
    font-family: Arial, Helvetica, sans-serif;
}

.container {
    background-color: #fff;
    border-radius: 5px;
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
    margin: 50px auto;
    padding: 20px;
    width: 400px;
}

h1 {
    text-align: center;
}

.form-group {
    margin-bottom: 10px;
}

label {
    display: block;
    font-weight: bold;
    margin-bottom: 5px;
}

input[type="text"],
input[type="email"],
input[type="password"] {
    border-radius: 5px;
    border: none;
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
    padding: 10px;
    width: 100%;
}

input[type="submit"] {
    background-color: #4CAF50;
    border: none;
    border-radius: 5px;
    color: #fff;
    cursor: pointer;
    font-size: 16px;
    padding: 10px;
    width: 100%;
}

input[type="submit"]:hover {
    background-color: #3e8e41;
}

input[contenteditable] {
    background-color: #f1f1f1;
    cursor: pointer;
}


    </style>
</head>
<body>

    <div class="container">
        <h1>Edit Profile</h1>
        <form action="#" method="post">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" value="<?php echo $name; ?>" contenteditable>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo $email; ?>" contenteditable>
            </div>
            <div class="form-group">
                <label for="nid">NID:</label>
                <input type="text" id="nid" name="nid" value="<?php echo $nid; ?>" contenteditable>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" contenteditable>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm Password:</label>
                <input type="password" id="confirm_password" name="confirm_password" contenteditable>
            </div>
            <div class="form-group">
                <input type="submit" value="Save Changes">
            </div>
        </form>
    </div>

</body>
</html>
