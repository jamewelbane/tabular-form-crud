<?php

include("../database/connection.php");

$id = intval($_REQUEST["user_id"]);


$sql = "SELECT * FROM user_account WHERE user_id=?";
if ($stmt = mysqli_prepare($link, $sql)) {
   
    mysqli_stmt_bind_param($stmt, "i", $id);
    
   
    if (mysqli_stmt_execute($stmt)) {
       
        $result = mysqli_stmt_get_result($stmt);
        
        
        if ($row = mysqli_fetch_array($result)) {
            $id = $row["user_id"];
            $fullname = $row["fullname"];
            $gender = $row["gender"];
            $email = $row["email"];
            $username = $row["username"];
            
            
            if ($gender == 1) {
                $genderForm = "MALE";
            } elseif ($gender == 2) {
                $genderForm = "FEMALE";
            } elseif ($gender == 3) {
                $genderForm = "NON-BINARY";
            } else {
                $genderForm = "No gender selected";
            }
        } else {
            echo "No user found.";
        }
    } else {
        echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
    }

    
    mysqli_stmt_close($stmt);
} else {
    echo "ERROR: Could not prepare statement: $sql. " . mysqli_error($link);
}


mysqli_close($link);
?>



<link rel="stylesheet" href="../style/form-style.css">
<h2 style="text-align: center; color: black;">Update Information</h2>

<form method="post" action="#">
    <div class="user-details">
        <div class="input-box">
            <span class="details">Full Name</span>
            <input type="text" name="fullname" value="<?php echo $fullname ?>" placeholder="Enter user's name" required>

        </div>

        <div class="input-box">
            <span class="details">Gender</span>
            <select name="gender">
                <option value="<?php echo $gender ?>" selected><?php echo $genderForm ?></option>
                <?php if ($gender === '1') : ?>
                    <option value="2">FEMALE</option>
                    <option value="3">NON-BINARY</option>
                <?php elseif ($gender === '2') : ?>
                    <option value="1">MALE</option>
                    <option value="3">NON-BINARY</option>
                <?php elseif ($gender === '3') : ?>
                    <option value="1">MALE</option>
                    <option value="2">FEMALE</option>
                <?php elseif ($gender === '') : ?>
                    <option value="1">MALE</option>
                    <option value="2">FEMALE</option>
                    <option value="3">NON-BINARY</option>
                <?php endif; ?>
            </select>

        </div>

        <div class="input-box">
            <span class="details">Email</span>
            <input type="email" name="email" placeholder="Enter user's email" value="<?php echo $email ?>" required>
        </div>

        <div class="input-box">
            <span class="details">Username</span>
            <input type="text" name="username" placeholder="Enter user's username" value="<?php echo $username ?>" required>
        </div>



    </div>

    <div class="button">
        <input type="submit" value="Update">
    </div>

</form>