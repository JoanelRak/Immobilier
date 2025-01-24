<?php

use app\components\ErrorHandler;

?>

<div class="property-detail-container">
    <!-- Property Header -->
    <div class="property-header">
        <div class="container">
            <h1><?php echo htmlspecialchars($habitation['designation']); ?></h1>
            <div class="property-meta">
                <span class="location">
                    <i class="fas fa-map-marker-alt"></i>
                    <?php echo htmlspecialchars($habitation['quartier']); ?>
                </span>
                <span class="type">
                    <i class="fas fa-home"></i>
                    <?php echo htmlspecialchars($habitation['type_name']); ?>
                </span>
                <span class="price">
                    <i class="fas fa-euro-sign"></i>
                    <?php echo number_format($habitation['loyer'], 2); ?> /mois
                </span>
            </div>
        </div>
    </div>

    <!-- Property Gallery -->
    <div class="property-gallery container">
        <div class="main-image">
            <img src="<?php echo htmlspecialchars($habitation['img_url'][0]["img_url"]); ?>"
                 alt="<?php echo htmlspecialchars($habitation['designation']); ?>">
        </div>
    </div>

    <!-- Property Content -->
    <div class="property-content container">
        <div class="property-main">
            <div class="property-section">
                <h2>Description</h2>
                <div class="features-grid">
                    <div class="feature">
                        <i class="fas fa-bed"></i>
                        <span><?php echo $habitation['nombre_chambre']; ?> chambres</span>
                    </div>
                    <div class="feature">
                        <i class="fas fa-building"></i>
                        <span><?php echo htmlspecialchars($habitation['type_name']); ?></span>
                    </div>
                    <div class="feature">
                        <i class="fas fa-map-marked-alt"></i>
                        <span><?php echo htmlspecialchars($habitation['quartier']); ?></span>
                    </div>
                </div>
                <p class="description">
                    Magnifique <?php echo strtolower(htmlspecialchars($habitation['type_name'])); ?> situé dans un quartier prisé.
                    Ce bien dispose de <?php echo $habitation['nombre_chambre']; ?> chambres spacieuses et lumineuses.
                    Idéalement situé, proche de toutes commodités.
                </p>
            </div>

            <!-- Booking Section -->
            <div class="property-section booking-section">
                <h2>Réserver ce bien</h2>
                <?php if(isset($_SESSION['user'])): ?>
                    <?php if(isset($success)): ?>
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle"></i>
                            <?php echo $success; ?>
                        </div>
                    <?php endif; ?>
                    <?php if(isset($_SESSION["error_message"])): ?>
                        <div class="alert alert-error">
                            <i class="fas fa-exclamation-circle"></i>
                            <?= ErrorHandler::getError() ?>
                        </div>
                    <?php
                        ErrorHandler::reset();
                        endif; 
                    ?>
                    <form method="POST" class="booking-form" action="book-property/<?= $habitation["id"] ?>">
                        <div class="dates-group">
                            <div class="form-group">
                                <label for="date_arrivee">
                                    <i class="fas fa-calendar-alt"></i>
                                    Date d'arrivée
                                </label>
                                <input type="datetime-local" id="date_arrivee" name="date_arrivee" required>
                            </div>
                            <div class="form-group">
                                <label for="date_depart">
                                    <i class="fas fa-calendar-alt"></i>
                                    Date de départ
                                </label>
                                <input type="datetime-local" id="date_depart" name="date_depart" required>
                            </div>
                        </div>
                        <div class="price-summary">
                            <div class="price-row">
                                <span>Loyer mensuel</span>
                                <span><?php echo number_format($habitation['loyer'], 2); ?> €</span>
                            </div>
                            <div class="price-row total">
                                <span>Total</span>
                                <span><?php echo number_format($habitation['loyer'], 2); ?> €</span>
                            </div>
                        </div>
                        <button type="submit" class="btn-book">
                            <i class="fas fa-calendar-check"></i>
                            Réserver maintenant
                        </button>
                    </form>
                <?php else: ?>
                    <div class="login-prompt">
                        <p>
                            <i class="fas fa-info-circle"></i>
                            Veuillez vous connecter pour effectuer une réservation
                        </p>
                        <a href="login" class="btn-login">
                            <i class="fas fa-sign-in-alt"></i>
                            Se connecter
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
