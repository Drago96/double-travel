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
        $onlyActions = $beforeAction["only"];

        if(in_array($action, $onlyActions)) {
          call_user_func([$this, $beforeAction["do"]]);
        }

        continue;
      }

      if(array_key_exists("except", $beforeAction)) {
        $exceptActions = $beforeAction["except"];

        if(!in_array($action, $exceptActions)) {
          call_user_func([$this, $beforeAction["do"]]);
        }
      }
    }
  }
}