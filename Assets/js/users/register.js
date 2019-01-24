document.addEventListener("DOMContentLoaded", function (event) {
    const registerFormValidator = new FormValidator({
        formId: 'register-form',
        validations: {
            username: [length(Constants.USERNAME_MIN_LENGTH, Constants.USERNAME_MAX_LENGTH, "Username")],
            password: [length(Constants.PASSWORD_MIN_LENGTH, Constants.PASSWORD_MAX_LENGTH, "Password")],
            confirmPassword: [ mustMatch("password", "Passwords")]
        }
    });

    registerFormValidator.initialize();
});