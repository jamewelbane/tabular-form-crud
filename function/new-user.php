<style>
input[type=text], input[type=email], input[type=password], select {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
}

input[type=submit] {
  width: 100%;
  background-color: #4CAF50;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

input[type=submit]:hover {
  background-color: #45a049;
}

.user-details {
  border-radius: 5px;
 
  padding: 20px;
}
</style>

<div class="user-details">
    <div class="input-box">
        <span class="details">Full Name</span>
        <input type="text" name="fullname" placeholder="Enter user's name" required>
    </div>

    <div class="input-box">
        <span class="details">Gender</span>
        <select name="gender" name="gender" required>
            <option value="" selected disabled>Select gender</option>
            <option value="1">MALE</option>
            <option value="2">FEMALE</option>
            <option value="3">NON-BINARY</option>
        </select>
    </div>

    <div class="input-box">
        <span class="details">Username</span>
        <input type="text" name="username" placeholder="Enter user's username" required>
    </div>

    <div class="input-box">
        <span class="details">Email</span>
        <input type="email" name="email" placeholder="Enter user's email" required>
    </div>


    <div class="input-box">
        <span class="details">Password</span>
        <div style="display: grid; grid-template-columns: 1fr auto;">
            <input type="password" id="passwordField" name="userpass" placeholder="Enter your password" required>
            <button class="showPass" type="button" onclick="togglePasswordVisibility('passwordField', 'passwordToggleIcon')">
                <span class="far fa-eye" id="passwordToggleIcon"></span>
            </button>
        </div>
        <div id="passwordError" style="color: red; font-style: italic; font-size: 12px;"></div>

    </div>

</div>

<div class="button">
    <input type="submit" value="Add">
</div>