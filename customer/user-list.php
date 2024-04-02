<!DOCTYPE html>

<html>
<?php
session_start();
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
                require ("../function/table.php");
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
    <!-- end -->


    <script src="../javascript/table-javascript.js"></script>
    <script src="../javascript/sorting.js"></script>

  <!-- delete customer -->
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
<!-- end -->


<!-- Edit/modify user's info : modal -->
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

    <!-- END -->





</html>