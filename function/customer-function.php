<?php


// form validation function
function isUsernameExists($link, $username,)
{

    $checkQuery = "SELECT * FROM user_account WHERE username = ?";
    $stmt = mysqli_prepare($link, $checkQuery);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    return (mysqli_num_rows($result) > 0);
}


function UPDATEisUsernameExists($link, $username, $OrigUsername)
{
    if (!empty($username) && $username != $OrigUsername) {
        $checkQuery = "SELECT * FROM user_account WHERE username = ?";
        $stmt = mysqli_prepare($link, $checkQuery);
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        $numRows = mysqli_num_rows($result);

        mysqli_stmt_close($stmt); // Close the prepared statement
        
        return ($numRows > 0);
    } else {
        
        return false; 
        
    }
    handleValidationError("Username is taken");
}




function isEmailExists($link, $email)
{

    $checkQuery = "SELECT * FROM user_account WHERE email = ?";
    $stmt = mysqli_prepare($link, $checkQuery);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    return (mysqli_num_rows($result) > 0);
}

function UPDATEisEmailExists($link, $email, $OrigEmail)
{
    if ($email != $OrigEmail) {
        $checkQuery = "SELECT * FROM user_account WHERE email = ?";
        $stmt = mysqli_prepare($link, $checkQuery);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        $numRows = mysqli_num_rows($result);

        mysqli_stmt_close($stmt); // Close the prepared statement
        handleValidationError("Email already exist!");
        return ($numRows > 0);
    } else {
        return false; 
    }
}



//error message alert
function handleValidationError($errorMessage)
{
    echo "<script>
              var errorMessage = '" . $errorMessage . "';
              if (errorMessage) {
                  if (confirm(errorMessage)) {
                    history.back();
                  }
              }
            </script>";
}

//success message alert
function handleValidationSuccess($successMessage)
{
    echo "<script>
          var successMessage = '" . $successMessage . "';
          if (successMessage) {
              if (confirm(successMessage)) {
                window.location.href = '../customer/user-list.php';
              }
          }
        </script>";



}

//random number generator
function random_num($length)
{

    $text = "";
    if ($length < 5) {
        $length = 5;
    }

    $len = rand(4, $length);

    for ($i = 0; $i < $len; $i++) {


        $text .= rand(0, 9);
    }

    return $text;
}





?>

