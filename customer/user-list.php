<!DOCTYPE html>

<html>
<?php
session_start();
require("../head.html");

// session_unset();

// if (!isset($_SESSION['user_id_filter'])) {
//     // Set the default value
//     $_SESSION['user_id_filter'] = 1; // Default value is 1
// }

//   echo "{$_SESSION['user_id_filter']}";
// ?>


<h2 style="color:black">User List</h2>
<div class="table-wrapper">


    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <?php require("../function/new-user.php"); ?>
        </div>
    </div>



    <form method="GET" action="">
        <center>
            <div style="align-items: center;">
                <input type="text" name="search" style="width: 40%;" placeholder="Search..." value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
                <button type="submit" class="button1 search"><i class="fas fa-search"></i></button>
            </div>
        </center>
    </form>
    
    <table class="fl-table">
        <button data-id='' title='Delete' onclick="openModal()" class='button1 create'><i class='fas fa-user-plus'></i></button>

        <thead>
            <tr>
                <th <?php echo (isset($_SESSION['user_id_filter']) && $_SESSION['user_id_filter'] == 0) ? "style='display: none;'" : ""; ?>>
                    User ID
                    <i onclick="sortColumn('user_id')" style="cursor: pointer;" class="fas fa-caret-up"></i>
                    <i onclick="sortColumnDesc('user_id')" style="cursor: pointer;" class="fas fa-caret-down"></i>
                </th>

                <th>
                    Full Name
                    <i onclick="sortColumn('fullname')" style="cursor: pointer;" class="fas fa-caret-up"></i>
                    <i onclick="sortColumnDesc('fullname')" class="fas fa-caret-down"></i>
                </th>
                <th>
                    Gender
                    <i onclick="sortColumn('gender')" style="cursor: pointer;" class="fas fa-caret-up"></i>
                    <i onclick="sortColumnDesc('gender')" style="cursor: pointer;" class="fas fa-caret-down"></i>
                </th>
                <th>
                    Email
                    <i onclick="sortColumn('email')" style="cursor: pointer;" class="fas fa-caret-up"></i>
                    <i onclick="sortColumnDesc('email')" style="cursor: pointer;" class="fas fa-caret-down"></i>
                </th>
                <th>
                    Username
                    <i onclick="sortColumn('username')" style="cursor: pointer;" class="fas fa-caret-up"></i>
                    <i onclick="sortColumnDesc('username')" style="cursor: pointer;" class="fas fa-caret-down"></i>
                </th>
                <th>Action</th>
            </tr>
        </thead>



        <tbody>
            <?php
            include("../database/connection.php");

            // Pagination variables
            $results_per_page = 5; // Number of rows to display per page

            // Fetch total number of rows in the table
            $sql_total = "SELECT COUNT(*) AS total FROM user_account";
            $result_total = mysqli_query($link, $sql_total);
            $row_total = mysqli_fetch_assoc($result_total);
            $total_rows = $row_total['total'];

            // Calculate total pages
            $total_pages = ceil($total_rows / $results_per_page);

            // Current page
            $page = isset($_GET['page']) ? $_GET['page'] : 1;
            $page = max(1, min($page, $total_pages)); // Ensure page is within valid range

            $start_from = ($page - 1) * $results_per_page;


            // Fetch data from database with pagination and search
            $search_query = isset($_GET['search']) ? mysqli_real_escape_string($link, $_GET['search']) : '';
            $search_condition = $search_query ? "WHERE fullname LIKE '%$search_query%' OR email LIKE '%$search_query%' OR username LIKE '%$search_query%' OR user_id LIKE '%$search_query%'" : '';

            // Determine sorting order
            $sort_by = isset($_GET['sort']) ? $_GET['sort'] : 'user_id';
            $sort_order = isset($_GET['order']) ? $_GET['order'] : 'desc';
            $sort_clause = "ORDER BY $sort_by $sort_order";

            $sql = "SELECT user_id, fullname, gender, email, username FROM user_account $search_condition $sort_clause LIMIT $start_from, $results_per_page";
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
            " . (isset($_SESSION['user_id_filter']) && $_SESSION['user_id_filter'] == 0 ? "<td style='display: none;'>" . $row["user_id"] . "</td>" : "<td>" . $row["user_id"] . "</td>") . "
            " . (isset($_SESSION['fullname_filter']) && $_SESSION['fullname_filter'] == 0 ? "<td style='display: none;'>" . $row["fullname"] . "</td>" : "<td>" . $row["fullname"] . "</td>") . "
            " . (isset($_SESSION['gender_filter']) && $_SESSION['gender_filter'] == 0 ? "<td style='display: none;'>" . $gender . "</td>" : "<td>" . $gender . "</td>") . "
            " . (isset($_SESSION['email_filter']) && $_SESSION['email_filter'] == 0 ? "<td style='display: none;'>" . $row["email"] . "</td>" : "<td>" . $row["email"] . "</td>") . "
            " . (isset($_SESSION['username_filter']) && $_SESSION['username_filter'] == 0 ? "<td style='display: none;'>" . $row["username"] . "</td>" : "<td>" . $row["username"] . "</td>") . "
            <td>
                <button data-id='" . $row["user_id"] . "' title='Delete' class='button1 delete' style=''><i class='fas fa-trash-alt'></i></button>
                <button data-id='" . $row["user_id"] . "' title='Delete' class='button1 edit' style=''><i class='fas fa-edit'></i></button>
            </td>
        </tr>";
                }
            } else {
                echo "<tr><td colspan='6'>0 results</td></tr>";
            }
            ?>
        </tbody>

    </table>
    <!-- Pagination links -->
    <center>
        <div class="pagination">
            <div class="pagination">
                <?php
                // Limit the number of links to show
                $num_links_to_show = 5; // Change this number as desired


                // Calculate start and end page numbers
                $start_page = max(1, $page - floor($num_links_to_show / 2));
                $end_page = min($total_pages, $start_page + $num_links_to_show - 1);

                // Ensure we have enough links on the right side
                $start_page = max(1, $end_page - $num_links_to_show + 1);

                // Previous page button
                if ($page > 1) {
                    echo "<a href='?page=1' class='pagination-button'>&laquo;</a>";
                }

                // Pagination numbers
                for ($i = $start_page; $i <= $end_page; $i++) {
                    echo "<a href='?page=$i' " . ($i == $page ? "class='active'" : "") . ">$i</a> ";
                }

                // Next page button
                if ($page < $total_pages) {
                    echo "<a href='?page=$total_pages' class='pagination-button'>&raquo;</a>";
                }
                ?>
            </div>
    </center>


    <script src="../javascript/table-javascript.js"></script>
    <script src="../javascript/sorting.js"></script>



    <script type='text/javascript'>
        $(function() {
            // Use event delegation for the click event
            $(document).on('click', '.button1.edit', function() {
                var user_id = $(this).data('id');
                $.ajax({
                    url: '../function/update-customer.php',
                    type: 'post',
                    data: {
                        user_id: user_id
                    },
                    success: function(response) {
                        $('#modalContent').html(response);
                        $('#myModalUpdate').modal('show');

                        $(document).on('click', '#close-btn', function() {
                            $('#myModalUpdate').modal('hide');
                        });
                    }
                });
            });
        });
    </script>


    <div id="myModalUpdate" class="modal">
        <div class="modal-content" id="modalContent">

        </div>
    </div>



    <!-- delete -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
          const deleteButtons = document.querySelectorAll('.button1.delete');

          deleteButtons.forEach(button => {
              button.addEventListener('click', function() {
                  const user_id = this.getAttribute('data-id');
                  const confirmDelete = confirm('You are about to delete this customer.\nAre you sure?');
                  if (confirmDelete) {
                      const xhr = new XMLHttpRequest();
                      xhr.open('POST', '../function/delete-customer.php', true);
                      xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                      xhr.onreadystatechange = function() {
                          if (xhr.readyState === 4 && xhr.status === 200) {
                              alert('Deleted!\n' + xhr.responseText);
                              window.location.reload();
                          }
                      };
                      xhr.send('user_id=' + user_id);
                  }
              });
          });
      });
    </script>




</html>