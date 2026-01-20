<?php
$firstname = $lastname = $email = $confirmEmail = $gender = $dob = $password = "";
$firstnameErr = $lastnameErr = $emailErr = $confirmEmailErr = $genderErr = $dobErr = $passwordErr = "";

function test_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    if (empty($_POST["firstname"])) {
        $firstnameErr = "First name is required";
    } else {
        $firstname = test_input($_POST["firstname"]);
        if (!preg_match("/^[a-zA-Z][a-zA-Z .-]*$/", $firstname)) {
            $firstnameErr = "Only letters, dots, and dashes. Must start with a letter.";
        } elseif (str_word_count($firstname) < 2) {
            $firstnameErr = "Must contain at least two words.";
        }
    }
 /* */
    
    if (empty($_POST["lastname"])) {
        $lastnameErr = "Last name is required";
    } else {
        $lastname = test_input($_POST["lastname"]);
        if (!preg_match("/^[a-zA-Z][a-zA-Z .-]*$/", $lastname)) {
            $lastnameErr = "Only letters, dots, and dashes. Must start with a letter.";
        } elseif (str_word_count($lastname) < 2) {
            $lastnameErr = "Must contain at least two words.";
        }
    }

    
    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
    } else {
        $email = test_input($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
        }
    }

   
    if (empty($_POST["confirmPassword"])) {
        $confirmPassErr = "Please confirm your password";
    } else {
        $confirmPassword = test_input($_POST["confirmPassword"]);
        if ($confirmPassword !== $password) {
            $confirmPassErr = "Password do not match";
        }
    }

    if (empty($_POST["gender"])) {
        $genderErr = "Gender is required";
    } else {
        $gender = $_POST["gender"];
    }

    
    if (empty($_POST["dob"])) {
        $dobErr = "Date of Birth is required";
    } else {
        $dob = $_POST["dob"];
        $parts = explode("-", $dob);
        if (count($parts) == 3) {
            $year = (int)$parts[0];
            $month = (int)$parts[1];
            $day = (int)$parts[2];
            if (!checkdate($month, $day, $year) || $year < 1900 || $year > 2016) {
                $dobErr = "DOB must be between 1900 and 2016";
            }
        } else {
            $dobErr = "Invalid date format";
        }
    }

    
    if (empty($_POST["password"])) {
        $passwordErr = "Password is required";
    } else {
        $password = $_POST["password"];
    }
}
?>
