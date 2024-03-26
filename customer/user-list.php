<!DOCTYPE html>
<?php
include("../head.html");
?>
<html>

<h2 style="color:black">User List</h2>
<div class="table-wrapper">
<button data-id='' title='Delete' onclick="openModal()" class='button1 create'><i class='fas fa-user-plus'></i></button>


    <!-- The Modal -->
    <div id="myModal" class="modal">

        <!-- Modal content -->
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <?php
            include ("../function/new-user.php");
            ?>
        </div>

    </div>

    <script>
    // Get the modal
var modal = document.getElementById('myModal');

// Function to open the modal
function openModal() {
    modal.style.display = "block";
}

// Function to close the modal
function closeModal() {
    modal.style.display = "none";
}

// Close the modal when clicking outside of it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>


    <table class="fl-table">
        <thead>
            <tr>
                <th>User ID</th>
                <th>Full Name</th>
                <th>Gender</th>
                <th>Email</th>
                <th>Username</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include("../database/connection.php");

            // Fetch data from database
            $sql = "SELECT user_id, fullname, gender, email, username FROM user_account";
            $result = mysqli_query($link, $sql);

            if (mysqli_num_rows($result) > 0) {
                // Output data of each row
                while ($row = mysqli_fetch_assoc($result)) {
                    $gender = "";
                    if ($row["gender"] == 1) {
                        $gender = "Male";
                    } elseif ($row["gender"] == 2) {
                        $gender = "Female";
                    } elseif ($row["gender"] == 3) {
                        $gender = "Non-binary";
                    } else {
                        $gender = "Unknown";
                    }
                    echo "<tr>
                            <td>" . $row["user_id"] . "</td>
                            <td>" . $row["fullname"] . "</td>
                            <td>" . $gender . "</td>
                            <td>" . $row["email"] . "</td>
                            <td>" . $row["username"] . "</td>
                            <td>
                            <button data-id='" . $row["user_id"] . "' title='Delete' class='button1 delete' style=''><i class='fas fa-trash-alt'></i></button>
                            <button data-id='" . $row["user_id"] . "' title='Delete' class='button1 edit' style=''><i class='fas fa-edit'></i></button>
                            </td>
                          </tr>";
                }
            } else {
                echo "0 results";
            }

            mysqli_close($link);
            ?>
        <tbody>
    </table>
</div>

</html>