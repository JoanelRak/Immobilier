<?php
?>
<main>
    <div class="auth-container">
        <div class="auth-box">
            <div class="auth-header">
                <h2><i class="fas fa-sign-in-alt"></i> Connexion</h2>
            </div>
            <?php if(isset($error)): ?>
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i>
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>
            <form method="POST" class="auth-form" action="submit-login">
                <div class="form-group">
                    <label for="nom"><i class="fas fa-user"></i> Nom d'utilisateur</label>
                    <input type="text" id="nom" name="nom" required>
                </div>
                <div class="form-group">
                    <label for="mdp"><i class="fas fa-lock"></i> Mot de passe</label>
                    <input type="password" id="mdp" name="mdp" required>
                </div>
                <button type="submit" class="btn-submit">
                    <i class="fas fa-sign-in-alt"></i> Se connecter
                </button>
            </form>
            <div class="auth-footer">
                <p>Pas encore de compte ? <a href="signIn">S'inscrire</a></p>
            </div>
        </div>
    </div>
</main>
