function checkPassword(str)
  {
    var re = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}$/;
    return re.test(str);
  }

function validateForm() {
    var login_username = document.forms["login-form"]['login-username'].value;
    var login_pass = document.forms["login-form"]['login-password'].value;
     re = /^\w+$/;

    if (login_username == "") {
        alert("Username must be filled out");
        document.forms["login-form"]['login-username'].focus();
        return false;
    }

    
    else if (login_pass == "") {
        alert("Fill out the password");
        document.forms["login-form"]['login-password'].focus();
        return false;   
    }
    else if(!re.test(form.username.value)) {
      alert("Error: Username must contain only letters, numbers and underscores!");
      form.username.focus();
      return false;
    }
}

function validateForm2() {

    var register_firstname = document.forms["register-form"]["register-fname"].value;
    var register_lastname = document.forms["register-form"]["register-lname"].value;
    var register_password = document.forms["register-form"]["register-password"].value;
    var confirm_pass = document.forms["register-form"]["register-confirm"].value
    
    if (register_firstname == "") {
        alert("Fill out the firstname");
        return false;
    }

    else if (register_lastname == "") {
        alert("Fill out the lastname");
        return false;
    }

    else if (register_password != "" && register_password == confirm_pass) {
        if (!checkPassword(register_password)) {
            alert("Invalid password");
            document.forms["register-form"]["register-password"].focus();
            return false;
        }
    }
}