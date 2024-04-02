<?php
session_start();
include("../database/connection.php");
include("new-user-function.php");
$captcha_error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userid = random_num(5);
    $fullname = htmlspecialchars($_POST["fullname"]);
    $gender = $_POST["gender"];
    $email = htmlspecialchars($_POST["email"]);
    $username = htmlspecialchars($_POST["username"]);
    $password = password_hash(htmlspecialchars($_POST["userpass"]), PASSWORD_BCRYPT);

    $_SESSION['fullname'] = $fullname;
    $_SESSION['gender'] = $gender;
    $_SESSION['email'] = $email;
    $_SESSION['username'] = $username;


    if (empty($fullname) || empty($gender) || empty($username) || empty($email) || empty($password)) {
        $errorMessage = "Error. Please complete the form ";
        if (empty($fullname)) {
            $errorMessage .= "Fullname ";
        }
        if (empty($gender)) {
            $errorMessage .= "Gender ";
        }
        if (empty($username)) {
            $errorMessage .= "Username ";
        }
        if (empty($email)) {
            $errorMessage .= "Email ";
        }
        if (empty($password)) {
            $errorMessage .= "Password ";
        }
        handleValidationError($errorMessage);
    } else {

        if (isUsernameExists($link, $username)) {
            handleValidationError("Username is taken");
            unset($_SESSION['username']);
        }

        if (isEmailExists($link, $email)) {
            handleValidationError("Email already exist");
            unset($_SESSION['email']);
        }


        //save to database

        $queryUsers = "INSERT INTO user_account (user_id, fullname, gender, username, email, password) VALUES (?, ?, ?, ?, ?, ?)";
        $stmtUsers = mysqli_prepare($link, $queryUsers);

        $isUnique = false;
        while (!$isUnique) {
            $userid = random_num(5);
            mysqli_stmt_bind_param($stmtUsers, "ssssss", $userid, $fullname, $gender, $username, $email, $password);

            try {
                $isUnique = mysqli_stmt_execute($stmtUsers);
                if ($isUnique) {
                    handleValidationSuccess("User added successfully!");
                    unset($_SESSION['fullname']);
                    unset($_SESSION['gender']);
                    unset($_SESSION['email']);
                    unset($_SESSION['username']);
                }
            } catch (mysqli_sql_exception $e) {
                //Error 
                $errorCode = $e->getCode();
                if ($errorCode == 1062) {

                    echo "Error: Duplicate entry";
                    break;
                } else {
                    // Handle other types of errors
                    echo "An error occurred while registering. Please try again later.";
                    break;
                }
            }
        }
    }
}
