<?php
?>
<main>
    <section class="content-section">
        <form action="/submit-signIn" method="post" class="submit-form" >
            <label for="name">
                Name :
            </label>
            <input type="text" name="name" id="name" class="name-input" />

            <label for="password">
                Mot de passe :
            </label>
            <input type="password" name="password" id="password" class="password-input" />

            <label for="age">
                Age :
            </label>
            <input type="number" name="age" id="age" class="age-input">

            <input type="submit" value="S'inscrir">
        </form>
    </section>
</main>
