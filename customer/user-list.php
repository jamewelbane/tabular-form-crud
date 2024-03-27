<!DOCTYPE html>

<html>
<?php
require("../head.html");

?>


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
                <th>
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



    <script>
        function sortColumn(column) {
            var currentUrl = window.location.href;
            var sortParam = 'sort=' + column;
            var ascendingOrderParam = 'order=asc';
            var descendingOrderParam = 'order=desc';

            // Remove existing sorting parameters from the URL
            currentUrl = currentUrl.replace(/[?&]sort=[^&]*/g, '').replace(/[?&]order=[^&]*/g, '');

            // Add new sorting parameters to the URL
            var sortUrl = currentUrl;
            if (sortUrl.includes('?')) {
                sortUrl += '&';
            } else {
                sortUrl += '?';
            }
            sortUrl += sortParam + '&' + ascendingOrderParam;

            // Redirect to the sorted URL
            window.location.href = sortUrl;

            // Update caret icon class
            var iconClass = 'fas fa-caret-up';
            document.querySelector('th.' + column + ' i').className = iconClass;
        }


        function sortColumnDesc(column) {
            var currentUrl = window.location.href;
            var sortParam = 'sort=' + column;
            var descendingOrderParam = 'order=desc';

            // Remove existing sorting parameters from the URL
            currentUrl = currentUrl.replace(/[?&]sort=[^&]*/g, '').replace(/[?&]order=[^&]*/g, '');

            // Add new sorting parameters to the URL
            var sortUrl = currentUrl;
            if (sortUrl.includes('?')) {
                sortUrl += '&';
            } else {
                sortUrl += '?';
            }
            sortUrl += sortParam + '&' + descendingOrderParam;

            // Redirect to the sorted URL
            window.location.href = sortUrl;

            // Update caret icon class
            var iconClass = 'fas fa-caret-up';
            document.querySelector('th.' + column + ' i').className = iconClass;
        }
    </script>





    </script>

</html>