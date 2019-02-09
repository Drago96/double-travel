<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Double Travel</title>
  <link rel="icon"
        type="image/png"
        href="/Assets/images/favicon.png">
  <?php echo $this->partial("Shared/styles"); ?>
</head>

<body>
<header>
  <?php echo $this->partial("Shared/navigation"); ?>
</header>

<main role="main" class="container">
  <?php echo $this->partial("Shared/notifications"); ?>
  <?php echo $content_for_layout; ?>
</main>

<footer>
  <?php echo $this->partial("Shared/footer"); ?>
</footer>

<?php echo $this->partial("Shared/scripts"); ?>
</body>
</html>
