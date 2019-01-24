<!DOCTYPE html>
<head>
    <meta charset="utf-8"/>
    <title>Double Travel</title>
    <?php echo $this->partial("Shared/styles"); ?>
</head>

<body>

<nav>

</nav>

<header>
  <?php echo $this->partial("Shared/navigation"); ?>
</header>

<main role="main" class="container">
  <?php echo $content_for_layout; ?>
</main>

<footer>
  <?php echo $this->partial("Shared/footer"); ?>
</footer>

<?php echo $this->partial("Shared/scripts"); ?>
</body>
</html>
