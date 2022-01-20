var loginButton;
var logoutButton;

function login() {
    window.location.href = '/aevistreamer/index.php';
}

function logout() {
    $.ajax({
        url: '/aevistreamer/logout.php',
        method: "POST"
    }).done(function () {
        window.location.reload();
    });
}

$(document).ready(function () {
    loginButton = $('#LoginButtonLink');
    logoutButton = $('#LogoutButtonLink');

    loginButton.click(function (){
        login();
    });

    logoutButton.click(function (){
        logout();
    });
});