<link rel="stylesheet" type="text/css" href="/Assets/styles/navigation.css">

<nav>
    <ul class="navigation">
        <li>
            <a href="/">
                Double Travel
                <img class="logo" src="/Assets/images/logo.png"/>
            </a>
        </li>
        <?php
            if($this->isAuthenticated()) {
              echo $this->partial("Shared/Navigation/authenticated");
            } else {
              echo $this->partial("Shared/Navigation/anonymous");
            }
        ?>
    </ul>
</nav>
