<?php

trait TemplatingConcern
{
  static $SESSION_SUCCESS_KEY = "successMessage";
  static $SESSION_ERROR_KEY = "errorMessage";

  public $layout = "default";

  public function notifySuccess($message) {
    $_SESSION[TemplatingConcern::$SESSION_SUCCESS_KEY] = $message;
  }

  public function notifyError($message) {
    $_SESSION[TemplatingConcern::$SESSION_ERROR_KEY] = $message;
  }

  public function extractMessages() {
    if(array_key_exists(TemplatingConcern::$SESSION_SUCCESS_KEY, $_SESSION)) {
      $successMessage = $_SESSION[TemplatingConcern::$SESSION_SUCCESS_KEY];

      $GLOBALS["success"] = $successMessage;

      unset($_SESSION[TemplatingConcern::$SESSION_SUCCESS_KEY]);
    }

    if(array_key_exists(TemplatingConcern::$SESSION_ERROR_KEY, $_SESSION)) {
      $errorMessage = $_SESSION[TemplatingConcern::$SESSION_ERROR_KEY];

      $GLOBALS["error"] = $errorMessage;

      unset($_SESSION[TemplatingConcern::$SESSION_ERROR_KEY]);
    }
  }

  public function render($filename, $data = [])
  {
    $this->extractMessages();

    extract($data);

    $content_for_layout = $this->partial(ucfirst(str_replace('Controller', '', get_class($this))) . '/' . $filename, $data);

    if ($this->layout == false) {
      $content_for_layout;
    } else {
      require(ROOT . "Views/Layouts/" . $this->layout . '.php');
    }

    exit();
  }

  public function partial($path, $data = [])
  {
    extract($data);

    ob_start();
    require(ROOT . "Views/" . $path . '.php');
    return ob_get_clean();
  }
}
