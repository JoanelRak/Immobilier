<?php
use app\components\ErrorHandler;
?>
<main>
    <div class="auth-container">
        <div class="auth-box">
            <div class="auth-header">
                <h2><i class="fas fa-user-plus"></i> Inscription</h2>
            </div>
            <?php if(isset($error)): ?>
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i>
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>
            <form method="POST" class="auth-form" action="submit-signIn">
                <div class="form-group">
                    <label for="nom"><i class="fas fa-user"></i> Nom d'utilisateur</label>
                    <input type="text" id="nom" name="nom" required>
                </div>
                <div class="form-group">
                    <label for="email"><i class="fas fa-envelope"></i> Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="mdp"><i class="fas fa-lock"></i> Mot de passe</label>
                    <input type="password" id="mdp" name="mdp" required>
                </div>
                <div class="form-group">
                    <label for="numTel"><i class="fas fa-phone"></i> Téléphone</label>
                    <input type="tel" id="numTel" name="numTel" required>
                </div>
                <button type="submit" class="btn-submit">
                    <i class="fas fa-user-plus"></i> S'inscrire
                </button>
            </form>
            <div class="auth-footer">
                <p>Déjà un compte ? <a href="login">Se connecter</a></p>
            </div>
            <?php
                if (isset($_SESSION["error_message"])) { ?>
                    <div class="alert-error">
                        <p><?= ErrorHandler::getError()?></p>
                    </div>
                <?php 
                ErrorHandler::reset();
                }
            ?>
        </div>
    </div>
</main>
