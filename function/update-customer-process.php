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


        //update database

        $queryUsers = "UPDATE user_account SET fullname = ?, gender = ?, username = ?, email = ? WHERE user_id = ?";
        $stmtUsers = mysqli_prepare($link, $queryUsers);
        mysqli_stmt_bind_param($stmtUsers, "sissi", $fullname, $gender, $username, $email, $userid);

        try {
            $isUnique = mysqli_stmt_execute($stmtUsers);
            if ($isUnique) {
                handleValidationSuccess("User added successfully!");
            }
        } catch (mysqli_sql_exception $e) {
            //Error 
            $errorCode = $e->getCode();
            if ($errorCode == 1062) {
                echo "Error: Duplicate entry";
            } else {
                // Handle other types of errors
                echo "An error occurred while registering. Please try again later.";
            }
        }
    }
}
