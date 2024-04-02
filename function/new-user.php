<link rel="stylesheet" href="../style/form-style.css">

<form method="post" action="../function/new-user-process.php">
    <div class="user-details">
        <div class="input-box">
            <span class="details">Full Name</span>
            <input type="text" name="fullname" value="<?php echo isset($_SESSION['fullname']) ? $_SESSION['fullname'] : ''; ?>" placeholder="Enter user's full name" required>

        </div>

        <div class="input-box">
            <span class="details">Gender</span>
            <select name="gender" required>
                <option value="" selected disabled>Select gender</option>
                <option value="1" <?php echo (isset($_SESSION['gender']) && $_SESSION['gender'] == 1) ? 'selected' : ''; ?>>MALE</option>
                <option value="2" <?php echo (isset($_SESSION['gender']) && $_SESSION['gender'] == 2) ? 'selected' : ''; ?>>FEMALE</option>
                <option value="3" <?php echo (isset($_SESSION['gender']) && $_SESSION['gender'] == 3) ? 'selected' : ''; ?>>NON-BINARY</option>
            </select>
        </div>
        

        <div class="input-box">
            <span class="details">Username</span>
            <input type="text" name="username" placeholder="Enter user's username" value="<?php echo isset($_SESSION['username']) ? $_SESSION['username'] : ''; ?>" required>
        </div>

        <div class="input-box">
            <span class="details">Email</span>
            <input type="email" name="email" placeholder="Enter user's email" value="<?php echo isset($_SESSION['email']) ? $_SESSION['email'] : ''; ?>" required>
        </div>


        <div class="input-box">
            <span class="details">Password</span>
            <div style="display: grid; grid-template-columns: 1fr auto;">
                <input type="password" id="passwordField" name="userpass" placeholder="Enter your password" required>
                <button class="showPass" type="button"
                    onclick="togglePasswordVisibility('passwordField', 'passwordToggleIcon')">
                    <span class="far fa-eye" id="passwordToggleIcon"></span>
                </button>
            </div>
            <div id="passwordError" style="color: red; font-style: italic; font-size: 12px;"></div>
        </div>

    </div>

    <div class="button">
        <input type="submit" value="Add">
    </div>

</form>

