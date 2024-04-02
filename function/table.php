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
$page = max(1, min($page, $total_pages));  
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
