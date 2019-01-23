<link rel="stylesheet" type="text/css" href="/Assets/styles/navigation.css">

<nav class="navigation">
    <a class="logo-link" href="/">
        Double Travel
        <img class="logo" src="/Assets/images/logo.png"/>
    </a>
    <ul class="navigation-links">
      <?php if ($this->isAuthenticated()): ?>
          <li><a href="/">Home</a></li>
      <?php else: ?>
          <li><a href="/users/login">Login</a></li>
          <li><a href="/users/register">Register</a></li>
      <?php endif; ?>
    </ul>
</nav>
