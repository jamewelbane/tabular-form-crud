<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include("../database/connection.php");
include("customer-function.php");
$captcha_error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userid = $_POST["userid"];
    $userid = intval($userid);
    $fullname = htmlspecialchars($_POST["fullname"]);
    $gender = $_POST["gender"];
    $email = htmlspecialchars($_POST["email"]);
    $username = htmlspecialchars($_POST["username"]);

    // Original information
    $OrigEmail = $_POST["email"];
    $OrigUsername = $_POST["username"];



    if (empty($fullname) || empty($gender) || empty($username) || empty($email)) {
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

        handleValidationError($errorMessage);
    } else {

       
        if (empty($fullname) || empty($gender) || empty($username) || empty($email)) {
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
        
            handleValidationError($errorMessage);
        } else {
        
            if (UPDATEisUsernameExists($link, $username, $OrigUsername)) {
                // handleValidationError("Username is taken");
                
            }
        
            if (UPDATEisEmailExists($link, $email, $OrigEmail)) {
                // handleValidationError("Email already exist");
                
            }
        
            // Update database
            $queryUsers = "UPDATE user_account SET fullname = ?, gender = ?, username = ?, email = ? WHERE user_id = ?";
            $stmtUsers = mysqli_prepare($link, $queryUsers);
            mysqli_stmt_bind_param($stmtUsers, "sissi", $fullname, $gender, $username, $email, $userid);
        
            try {
                $isUpdated = mysqli_stmt_execute($stmtUsers);
                if ($isUpdated) {
                    handleValidationSuccess("User information updated successfully!.");
                }
            } catch (mysqli_sql_exception $e) {
                // Error 
                handleValidationError("Duplicate entry! Please check the email or username.");
            }
        }
        
        
    }
}
