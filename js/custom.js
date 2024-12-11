// Fonction pour valider le formulaire d'inscription
function validateRegistrationForm() {
    const username = document.getElementById('username');
    const email = document.getElementById('email');
    const password = document.getElementById('password');
    const confirmPassword = document.getElementById('confirm_password');

    if (username.value.length < 3) {
        alert("Le nom d'utilisateur doit contenir au moins 3 caractères.");
        return false;
    }

    if (!isValidEmail(email.value)) {
        alert("Veuillez entrer une adresse email valide.");
        return false;
    }

    if (password.value.length < 6) {
        alert("Le mot de passe doit contenir au moins 6 caractères.");
        return false;
    }

    if (password.value !== confirmPassword.value) {
        alert("Les mots de passe ne correspondent pas.");
        return false;
    }

    return true;
}

// Fonction pour valider le formulaire de création d'événement
function validateEventForm() {
    const title = document.getElementById('title');
    const description = document.getElementById('description');
    const startDate = document.getElementById('start_date');
    const endDate = document.getElementById('end_date');

    if (title.value.length < 5) {
        alert("Le titre de l'événement doit contenir au moins 5 caractères.");
        return false;
    }

    if (description.value.length < 20) {
        alert("La description de l'événement doit contenir au moins 20 caractères.");
        return false;
    }

    if (new Date(startDate.value) >= new Date(endDate.value)) {
        alert("La date de fin doit être postérieure à la date de début.");
        return false;
    }

    return true;
}

// Fonction utilitaire pour valider les adresses email
function isValidEmail(email) {
    const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
}

// Attacher les gestionnaires d'événements aux formulaires
document.addEventListener('DOMContentLoaded', function() {
    const registrationForm = document.getElementById('registration-form');
    if (registrationForm) {
        registrationForm.addEventListener('submit', function(e) {
            if (!validateRegistrationForm()) {
                e.preventDefault();
            }
        });
    }

    const eventForm = document.getElementById('event-form');
    if (eventForm) {
        eventForm.addEventListener('submit', function(e) {
            if (!validateEventForm()) {
                e.preventDefault();
            }
        });
    }
});