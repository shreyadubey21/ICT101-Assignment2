// script.js - form validation for Paws & Polish
// Each form calls one of these functions when it is submitted.
// If there is a problem, the function shows a message and returns false,
// which stops the form from being sent.


// ---------- Helper functions ----------

// Gets the value typed into a box, without extra spaces
function getValue(id) {
    return document.getElementById(id).value.trim();
}

// Shows an error message in the red text area under the form
function showError(id, message) {
    document.getElementById(id).innerHTML = message;
}

// Checks an email looks like name@example.com
function isValidEmail(email) {
    var pattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return pattern.test(email);
}

// Checks a phone number is 10 digits, like 0412345678
function isValidPhone(phone) {
    var pattern = /^0[0-9]{9}$/;
    return pattern.test(phone);
}

// Checks a password has at least 8 characters and at least one number
function isStrongPassword(password) {
    return password.length >= 8 && /[0-9]/.test(password);
}


// ---------- Register form ----------

function validateRegister() {
    var fullName = getValue("full_name");
    var username = getValue("username");
    var email    = getValue("email");
    var phone    = getValue("phone");
    var password = document.getElementById("password").value;
    var confirm  = document.getElementById("confirm_password").value;

    if (fullName == "" || username == "" || email == "" || phone == "" || password == "") {
        showError("register-error", "Please fill in all the fields.");
        return false;
    }
    if (username.length < 4) {
        showError("register-error", "Your username must be at least 4 characters.");
        return false;
    }
    if (!isValidEmail(email)) {
        showError("register-error", "Please enter a valid email, like name@example.com.");
        return false;
    }
    if (!isValidPhone(phone)) {
        showError("register-error", "Please enter a 10-digit phone number, like 0412345678.");
        return false;
    }
    if (!isStrongPassword(password)) {
        showError("register-error", "Your password must be at least 8 characters and include a number.");
        return false;
    }
    if (password != confirm) {
        showError("register-error", "The two passwords do not match.");
        return false;
    }
    return true;
}


// ---------- Login form ----------

function validateLogin() {
    if (getValue("username") == "" || document.getElementById("password").value == "") {
        showError("login-error", "Please enter your username and password.");
        return false;
    }
    return true;
}


// ---------- Forgot password form ----------

function validateForgot() {
    var username = getValue("username");
    var email    = getValue("email");
    var password = document.getElementById("new_password").value;
    var confirm  = document.getElementById("confirm_password").value;

    if (username == "" || email == "" || password == "") {
        showError("forgot-error", "Please fill in all the fields.");
        return false;
    }
    if (!isValidEmail(email)) {
        showError("forgot-error", "Please enter a valid email, like name@example.com.");
        return false;
    }
    if (!isStrongPassword(password)) {
        showError("forgot-error", "Your new password must be at least 8 characters and include a number.");
        return false;
    }
    if (password != confirm) {
        showError("forgot-error", "The two passwords do not match.");
        return false;
    }
    return true;
}


// ---------- My Account: update details ----------

function validateDetails() {
    var fullName = getValue("full_name");
    var email    = getValue("email");
    var phone    = getValue("phone");

    if (fullName == "" || email == "" || phone == "") {
        showError("details-error", "Please fill in all the fields.");
        return false;
    }
    if (!isValidEmail(email)) {
        showError("details-error", "Please enter a valid email, like name@example.com.");
        return false;
    }
    if (!isValidPhone(phone)) {
        showError("details-error", "Please enter a 10-digit phone number, like 0412345678.");
        return false;
    }
    return true;
}


// ---------- My Account: add a pet ----------

function validatePet() {
    if (getValue("pet_name") == "") {
        showError("pet-error", "Please enter your pet's name.");
        return false;
    }
    return true;
}


// ---------- Booking form ----------

function validateBooking() {
    var pet     = getValue("pet_id");
    var service = getValue("service_id");
    var date    = getValue("booking_date");
    var time    = getValue("booking_time");

    if (pet == "" || service == "" || date == "" || time == "") {
        showError("booking-error", "Please choose a pet, a service, a date and a time.");
        return false;
    }

    // The date must be in the future
    var chosenDate = new Date(date + "T00:00");
    var today = new Date();
    if (chosenDate <= today) {
        showError("booking-error", "Please choose a date from tomorrow onwards.");
        return false;
    }

    // We are closed on Sundays (getDay() gives 0 for Sunday)
    if (chosenDate.getDay() == 0) {
        showError("booking-error", "Sorry, we are closed on Sundays. Please choose another day.");
        return false;
    }
    return true;
}


// ---------- Feedback form ----------

function validateFeedback() {
    var name    = getValue("name");
    var email   = getValue("email");
    var rating  = getValue("rating");
    var message = getValue("message");

    if (name == "" || email == "" || rating == "" || message == "") {
        showError("feedback-error", "Please fill in all the fields.");
        return false;
    }
    if (!isValidEmail(email)) {
        showError("feedback-error", "Please enter a valid email, like name@example.com.");
        return false;
    }
    if (message.length < 10) {
        showError("feedback-error", "Please write at least 10 characters.");
        return false;
    }
    return true;
}


// ---------- Search form ----------

function validateSearch() {
    if (getValue("keyword") == "") {
        showError("search-error", "Please type a word to search for.");
        return false;
    }
    return true;
}
