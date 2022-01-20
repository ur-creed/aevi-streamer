var loginForm;
var loginButton;
var logoutButton;
var signupForm;

function signup(formData) {
    $.ajax({
        url: '/aevistreamer/signup.php',
        method: "POST",
        data: formData,
        contentType: false,
        cache: false,
        processData: false,
    }).done(function (result) {
        var data = $.parseJSON(result);
        var hasError = data.message !== undefined;

        if(!hasError) {
            window.location.reload();
        } else {
            var alert = $('#SignUpAlert');
            alert[0].innerHTML = data.message;
            alert[0].removeAttribute('hidden');
        }
    });
}

function login(credentials) {
    $.ajax({
        url: '/aevistreamer/login.php',
        method: "POST",
        data: credentials
    }).done(function (result) {
        var data = $.parseJSON(result);
        var hasError = data.message !== undefined;

        if(!hasError) {
            window.location.href = '/aevistreamer/profile.php';
        } else {
            var alert = $('#LoginAlert');
            alert[0].innerHTML = data.message;
            alert[0].removeAttribute('hidden');
        }
    });
}

function logout() {
    $.ajax({
        url: '/aevistreamer/logout.php',
        method: "POST"
    }).done(function() {
        window.location.reload();
    });
}

function streamerSearch() {
    $('.search_input').typeahead
}

$(document).ready(function () {
    loginForm = $('#LoginForm');
    logoutButton = $('#LogoutButtonLink');
    signupForm = $('#SignUpForm');

    loginForm.submit(function (e) {
        e.preventDefault();

        var credentials = loginForm.serialize();
        login(credentials);
    });

    logoutButton.click(function (){
        logout();
    });

    signupForm.submit(function (e) {
        e.preventDefault();

        var formData = new FormData(signupForm[0]);
        signup(formData);
    });

});