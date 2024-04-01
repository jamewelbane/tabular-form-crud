<?php

include("../database/connection.php");


$ID = $_POST['user_id'];
$ID = intval($ID);

// Check if customer exists
$checkQueryCustomer = "SELECT * FROM user_account WHERE user_id = ?";
if ($stmtCheckCustomer = mysqli_prepare($link, $checkQueryCustomer)) {
    mysqli_stmt_bind_param($stmtCheckCustomer, "i", $ID);
    mysqli_stmt_execute($stmtCheckCustomer);
    $resultCustomer = mysqli_stmt_get_result($stmtCheckCustomer);

    if ($resultCustomer && mysqli_num_rows($resultCustomer) > 0) {
       
        mysqli_autocommit($link, false); // Turn off autocommit

        // Deleting from user_account
        $queryDeleteCustomer = "DELETE FROM user_account WHERE user_id = ?";
        if ($stmtDeleteCustomer = mysqli_prepare($link, $queryDeleteCustomer)) {
            mysqli_stmt_bind_param($stmtDeleteCustomer, "i", $ID);
            $deleteSuccessCustomer = mysqli_stmt_execute($stmtDeleteCustomer);

            $allSuccess = $deleteSuccessCustomer;

            if ($allSuccess) {
                mysqli_commit($link); 
                echo "Customer data has been deleted";
            } else {
                mysqli_rollback($link); // if failed, rollback the transaction
                echo "Cannot complete deletion";
            }

           
            mysqli_stmt_close($stmtDeleteCustomer);
        } else {
            echo "Error preparing delete statement";
        }
    } else {
        echo "Can't find customer data";
    }

    // Close prep statements
    mysqli_stmt_close($stmtCheckCustomer);
} else {
    echo "Error preparing check statement";
}

$link->close();

?>
