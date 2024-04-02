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


    // view and hide password
function togglePasswordVisibility(fieldId, iconId) {
    var passwordField = document.getElementById(fieldId);
    var passwordToggleIcon = document.getElementById(iconId);
  
    if (passwordField.type === "password") {
      passwordField.type = "text";
      passwordToggleIcon.classList.remove("fa-eye");
      passwordToggleIcon.classList.add("fa-eye-slash");
    } else {
      passwordField.type = "password";
      passwordToggleIcon.classList.remove("fa-eye-slash");
      passwordToggleIcon.classList.add("fa-eye");
    }
  }

  const passwordError = document.getElementById('passwordError');

passwordField.addEventListener('input', validatePassword);

function validatePassword() {
  const password = passwordField.value;
  const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_+])[A-Za-z\d!@#$%^&*()_+]{8,}$/;

  if (!passwordRegex.test(password)) {
    passwordError.textContent = "Password must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, one digit, and one special character.";
    passwordField.setCustomValidity("Invalid password format");
    passwordError.style.display = 'block';
    passwordField.style.borderColor = 'red';
  } else {
    passwordError.textContent = "";
    passwordField.setCustomValidity("");
    passwordError.style.display = 'none';
    passwordField.style.borderColor = '';
  }
}




  