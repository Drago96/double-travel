document.addEventListener("DOMContentLoaded", function (event) {
  const loginFormValidator = new FormValidator({
    formId: 'login-form',
    validations: {
      username: [required( "Username")],
      password: [required( "Password")]
    }
  });

  loginFormValidator.initialize();
});