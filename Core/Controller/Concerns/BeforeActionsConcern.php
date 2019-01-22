<?php

trait BeforeActionsConcern {
  protected $beforeActions = [];

  public function executeBeforeActions()
  {
    foreach ($this->beforeActions as $beforeAction) {
      call_user_func([$this, $beforeAction]);
    }
  }
}