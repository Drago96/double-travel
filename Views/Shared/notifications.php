<?php if (array_key_exists("success", $GLOBALS)): ?>
  <div class="success notification"><?php echo $GLOBALS["success"] ?></div>
<?php endif; ?>

<?php if (array_key_exists("error", $GLOBALS)): ?>
  <div class="error notification"><?php echo $GLOBALS["error"] ?></div>
<?php endif; ?>
