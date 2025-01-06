<?php
?>
<main>
    <section class="content-section">
        <form action="/submit-login" method="post" class="login-form" >
            <label for="name">
                Name :
            </label>
            <input type="text" name="name" id="name" class="name-input" />

            <label for="password">
                Mot de passe :
            </label>
            <input type="password" name="password" id="password" class="password-input" />
            <input type="submit" value="Connecter">

        </form>
    </section>
</main>
