<link rel="stylesheet" type="text/css" href="/Assets/styles/shared/navigation.css">

<nav class="navigation">
  <a class="logo-link" href="/">
    Double Travel
    <img class="logo" src="/Assets/images/logo.png"/>
  </a>
  <ul class="navigation-links">
    <?php if ($this->isAuthenticated()): ?>
      <li><a href="/users/profile">Hello, <?php echo $this->getCurrentUser()->username ?></a></li>
      <li><a href="/">Home</a></li>
      <li>
        <form class="logout-form" method="post" action="/users/logout">
          <input type="submit" value="Logout"/>
        </form>
      </li>
    <?php else: ?>
      <li><a href="/users/login">Login</a></li>
      <li><a href="/users/register">Register</a></li>
    <?php endif; ?>
  </ul>
</nav>
