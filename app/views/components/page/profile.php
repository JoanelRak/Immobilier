<?php
if (!isset($_SESSION['user'])) {
    header('Location: ..\index.php');
    exit;
}

$user = $_SESSION['user'];
?>

<main>
    <div class="container">
        <h1>Mon Profil</h1>
        <form method="POST" class="auth-form">
            <div class="form-group">
                <label for="name">Nom</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            </div>
            <div class="form-group">
                <label for="numTel">Numéro de Téléphone</label>
                <input type="tel" id="numTel" name="numTel" value="<?php echo htmlspecialchars($user['numTel']); ?>" required>
            </div>
            <button type="submit" class="btn-submit">
                <i class="fas fa-save"></i> Mettre à jour
            </button>
        </form>
    </div>
</main>