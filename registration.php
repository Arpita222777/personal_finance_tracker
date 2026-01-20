<!DOCTYPE html>
<html>
<head>
    <title>Registration Validation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color:rgb(249, 249, 249);
        }

        h2 {
            color: #333;
        }

        form {
            background-color:rgb(232, 171, 237);
            padding: 20px;
            border: 1px solid #ccc;
            width: 400px;
            border-radius: 8px;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="date"] {
            width: 100%;
            padding: 8px;
            margin-top: 4px;
            margin-bottom: 12px;
            border: 1px solid #aaa;
            border-radius: 4px;
        }

        input[type="radio"] {
            margin-top: 5px;
        }

        input[type="submit"] {
            background-color:rgb(120, 14, 69);
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color:rgb(41, 6, 90);
        }

        .error {
            color: red;
            font-size: 14px;
        }

        .success {
            color: green;
            font-size: 16px;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
<?php include 'validation.php'; ?>

<h2>Registration Form</h2>

<form method="post" action="">
    <label for="firstname">First name:</label>
    <input type="text" name="firstname"><br>
    <br>

    <label for="lastname">Last name:</label>
    <input type="text" name="lastname"><br>
    <br>

    <label for="email">Email:</label>
    <input type="email" name="email"><br>
    <br>

    <label for="Gender">Gender:</label>
    <br>
    <input type="radio" name="gender" value="Male">Male<br>
    <input type="radio" name="gender" value="Female">Female<br>
    <br>

    <label for="dob">Date of Birth:</label>
    <input type="date" name="dob"><br>
    <br>


    <label for="password">Password:</label>
    <input type="password" name="password"><br>
    <br>

    <label for="confirmPassword">Confirm Password:</label>
    <input type="password" name="confirmPassword"><br>
    <br>
     /* */
    <input type="submit" value="Submit">
</form>

</body>
</html>
