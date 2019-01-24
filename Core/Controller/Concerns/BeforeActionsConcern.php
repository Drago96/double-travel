<?php

trait BeforeActionsConcern
{
  protected $beforeActions = [];

  public function executeBeforeActions($action)
  {
    foreach ($this->beforeActions as $beforeAction) {
      if (is_string($beforeAction)) {
        call_user_func([$this, $beforeAction]);

        continue;
      }

      if (array_key_exists("only", $beforeAction)) {
        $forActions = $beforeAction["only"];

        if(in_array($action, $forActions)) {
          call_user_func([$this, $beforeAction["method"]]);
        }

        continue;
      }

      if(array_key_exists("except", $beforeAction)) {
        $exceptActions = $beforeAction["except"];

        if(!in_array($action, $exceptActions)) {
          call_user_func([$this, $beforeAction["method"]]);
        }
      }
    }
  }
}