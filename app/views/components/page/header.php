<?php


?>
<header class="header">
    <nav class="nav">
        <div class="logo">
            <a href="/" class="nav-link">Noel</a>

        </div>
        <input type="checkbox" id="menu-toggle" class="menu-toggle">
        <label for="menu-toggle" class="menu-icon">
            <span class="menu-icon-line"></span>
        </label>
        <div class="nav-menu">
            <ul>
                <?php
                    if (isset($_SESSION["depots"])) { ?>
                        <li><a href="/admin" class="nav-link">Admin</a></li>
                   <?php  }

                ?>
                <li><a href="/" class="nav-link">Home</a></li>
                <?php
                    if (isset($_SESSION["user"])) { ?>
                        <li><a href="/depot" class="nav-link">Faire un depot</a></li>
                        <li><a href="/form" class="nav-link">Demander des cadeau</a></li>
                    <?php }
                    else { ?>

                   <?php }
                ?>

            </ul>
        </div>
        <div class="nav-buttons">
            <?php
            if (isset($_SESSION["user"])) { ?>
                <a href="/logOut" class="signup-btn">Log out</a>
            <?php }
            else { ?>
                <a href="/login" class="login-btn">Log In</a>
                <a href="/signIn" class="signup-btn">Sign Up</a>
            <?php }
            ?>

        </div>
    </nav>
</header>