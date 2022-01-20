var logoutButton;
var communityBioForm;
var createTournamentForm;
var topButton;

function initializeCommunityBioTinyMce() {
    tinymce.init({
        selector: '#CommunityBiography',
        menubar: 'edit format'
    });
}

// TODO :: Refactor to use the modal type so we don't have to have duplicate code.
function initializeTournamentModalTinyMce() {
    tinymce.init({
        selector: '#CreateTournamentRules',
        menubar: 'edit format'
    });
}

function updateCommunityBiography(bio) {
    $.ajax({
        url: '/aevistreamer/profile/biography.php',
        method: "POST",
        data: bio
    }).done(function (result) {
        var data = $.parseJSON(result);
        var type = data.messageType;

        var alert = $('#CommunityBiographyAlert');
        alert[0].classList.add('alert-' + type);
        alert[0].innerHTML = data.message;
        alert[0].removeAttribute('hidden');
    });
}

function createTournament(tournament) {
    $.ajax({
        url: '/aevistreamer/tournament/create.php',
        method: "POST",
        data: tournament
    }).done(function (result) {
        var data = $.parseJSON(result);
        var type = data.messageType;

        $('#CreateTournamentModal').modal('hide');

        var alert = $('#TournamentAlert');
        alert[0].classList.add('alert-' + type);
        alert[0].innerHTML = data.message;
        alert[0].removeAttribute('hidden');

    });
}

function logout() {
    $.ajax({
        url: '/aevistreamer/logout.php',
        method: "POST"
    }).done(function () {
        window.location.href = 'aevistreamer/index.php'
    });
}

function scrollFunction() {
    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
        topButton.css('display', 'block');
    } else {
        topButton.css('display', 'none');
    }
}

// When the user clicks on the button, scroll to the top of the document
function topFunction() {
    document.body.scrollTop = 0;
    document.documentElement.scrollTop = 0;
}

$(document).ready(function () {
    topButton = $('#TopButton');
    logoutButton = $('#LogoutButtonLink');
    communityBioForm = $('#CommunityBiographyForm');
    createTournamentForm = $('#CreateTournamentForm');

    initializeCommunityBioTinyMce();
    initializeTournamentModalTinyMce();

    communityBioForm.submit(function (e) {
        e.preventDefault();

        var bio = $(this).serialize();
        updateCommunityBiography(bio);
    });

    createTournamentForm.submit(function (e) {
        e.preventDefault();

        var tournament = $(this).serialize();
        createTournament(tournament);
    });

    logoutButton.click(function (){
        logout();
    });

    // When the user scrolls down 20px from the top of the document, show the button
    window.onscroll = function() {
        scrollFunction()
    };

    topButton.click(function () {
       topFunction();
    });
});


