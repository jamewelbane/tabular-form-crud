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

<form method="post" action="../function/update-customer-process.php">
    <div class="user-details">
        <div class="input-box">

            <input name="userid" value="<?php echo $id ?>" hidden>
            <span class="details">Full Name</span>
            <input type="text" name="fullname" value="<?php echo $fullname ?>" placeholder="Enter user's name" required>

        </div>

        <div class="input-box">
            <span class="details">Gender</span>
            <select name="gender">
                <option value="1" <?php echo ($gender === '1' || (!isset($_POST["gender"]) && $gender === '1')) ? 'selected' : ''; ?>>MALE</option>
                <option value="2" <?php echo ($gender === '2' || (!isset($_POST["gender"]) && $gender === '2')) ? 'selected' : ''; ?>>FEMALE</option>
                <option value="3" <?php echo ($gender === '3' || (!isset($_POST["gender"]) && $gender === '3')) ? 'selected' : ''; ?>>NON-BINARY</option>
            </select>
        </div>


        <div class="input-box">
            <span class="details">Email</span>
            <input type="email" name="email" placeholder="Enter user's email" value="<?php echo $email ?>" required>

            <!-- Orig Email -->
            <input name="OrigEmail" value="<?php echo $email ?>" hidden>
        </div>

        <div class="input-box">
            <span class="details">Username</span>
            <input type="text" name="username" placeholder="Enter user's username" value="<?php echo $username ?>" required>

            <!-- Orig username -->
            <input name="OrigUsername" value="<?php echo $username ?>" hidden>
        </div>



    </div>

    <div class="button">
        <input type="submit" value="Update">
    </div>

</form>