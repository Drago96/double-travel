<form id="login-form" class="authentication-form" method="post">
  <h2 class="form-header">Login</h2>
  <section class="form-body">
    <?php if (isset($formError)): ?>
      <span class="form-error"><?php echo $formError ?></span>
    <?php endif; ?>
    <input
        type="text"
        placeholder="Username"
        name="username"
        id="username"
        class="form-input"
        value="<?php echo $model->username ?>"
    />
    <input
        type="password"
        placeholder="Password"
        name="password"
        id="password"
        class="form-input"
    />
    <input type="submit" value="Login" class="form-submit"/>
  </section>
</form>

<script src="/Assets/js/users/login.js"></script>
