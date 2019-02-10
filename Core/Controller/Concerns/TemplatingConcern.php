<?php

trait TemplatingConcern
{
  public $layout = "default";

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
