<main>
    <div class="hero-section">
        <div class="hero-content container">
            <h1>Trouvez votre logement idéal</h1>
            <p>Des milliers de biens disponibles partout en France</p>
            <form action="home" method="GET" class="hero-search">
                <div class="search-group">
                    <i class="fas fa-search"></i>
                    <label>
                        <input type="text" name="search" class="input-search" placeholder="Où voulez-vous habiter ?"
                               value="<?php echo htmlspecialchars($search ?? ''); ?> " required>
                    </label>
                </div>
                <button type="submit" class="btn-search">Rechercher</button>
            </form>
        </div>
    </div>

    <div class="featured-section container">
        <h2>Nos meilleures offres</h2>
        <div class="property-grid">
            <?php
            if (!empty($habitations)) {
                foreach ($habitations as $habitation): ?>
                    <div class="property-card">
                        <div class="property-image">
                            <img src="<?php echo htmlspecialchars($habitation['img_url']); ?>"
                                 alt="<?php echo htmlspecialchars($habitation['designation']); ?>">
                            <div class="property-type">
                                <?php echo htmlspecialchars($habitation['type_name']); ?>
                            </div>
                        </div>
                        <div class="property-details">
                            <h3><?php echo htmlspecialchars($habitation['designation']); ?></h3>
                            <div class="property-location">
                                <i class="fas fa-map-marker-alt"></i>
                                <?php echo htmlspecialchars($habitation['quartier']); ?>
                            </div>
                            <div class="property-features">
                                <span><i class="fas fa-bed"></i> <?php echo $habitation['nombre_chambre']; ?> chambres</span>
                                <span><i class="fas fa-euro-sign"></i> <?php echo number_format($habitation['loyer'], 2); ?> /mois</span>
                            </div>
                            <a href="property/<?php echo $habitation['id']; ?>" class="btn-view-property">
                                Voir le bien
                            </a>
                        </div>
                    </div>
                <?php endforeach;
            } ?>
        </div>
    </div>

    <div class="features-section">
        <div class="container">
            <h2>Pourquoi choisir ImmoBooking ?</h2>
            <div class="features-grid">
                <div class="feature-card">
                    <i class="fas fa-search"></i>
                    <h3>Recherche facile</h3>
                    <p>Trouvez rapidement le logement qui vous correspond</p>
                </div>
                <div class="feature-card">
                    <i class="fas fa-shield-alt"></i>
                    <h3>Sécurisé</h3>
                    <p>Paiements et réservations 100% sécurisés</p>
                </div>
                <div class="feature-card">
                    <i class="fas fa-clock"></i>
                    <h3>Disponible 24/7</h3>
                    <p>Réservez à tout moment, où que vous soyez</p>
                </div>
                <div class="feature-card">
                    <i class="fas fa-heart"></i>
                    <h3>Service client</h3>
                    <p>Une équipe à votre écoute 7j/7</p>
                </div>
            </div>
        </div>
    </div>
</main>

