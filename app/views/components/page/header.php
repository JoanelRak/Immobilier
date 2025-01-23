<?php ?>


<header class="main-header">
    <div class="header-top">
        <div class="container">
            <div class="contact-info">
                <span><i class="fas fa-phone"></i> +33 1 23 45 67 89</span>
                <span><i class="fas fa-envelope"></i> contact@immobooking.fr</span>
            </div>
            <div class="social-links">
                <a href="#"><i class="fab fa-facebook"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
            </div>
        </div>
    </div>
    <nav class="main-nav">
        <div class="container">
            <div class="logo">
                <a href="index.php">
                    <i class="fas fa-home"></i>
                    <span>ImmoBooking</span>
                </a>
            </div>
            <div class="search-bar">
                <form action="index.php" method="GET">
                    <div class="search-input">
                        <i class="fas fa-search"></i>
                        <label>
                            <input type="text" name="search" placeholder="Rechercher par ville, type de bien...">
                        </label>
                    </div>
                    <button type="submit">Rechercher</button>
                </form>
            </div>
            <div class="nav-links">
                <a href="/" class="<?php echo $currentPage === 'home' ? 'active' : ''; ?>">
                    <i class="fas fa-home"></i> Accueil
                </a>
                <?php if(isset($_SESSION['user'])): ?>
                    <a href="reservations.php" class="<?php echo $currentPage === 'reservations' ? 'active' : ''; ?>">
                        <i class="fas fa-calendar-alt"></i> Mes Réservations
                    </a>
                    <div class="user-menu">
                        <button class="user-menu-btn">
                            <i class="fas fa-user-circle"></i>
                            <?php echo htmlspecialchars($_SESSION['user_name']); ?>
                        </button>
                        <div class="dropdown-menu">
                            <a href="profile"><i class="fas fa-user"></i> Mon Profil</a>
                            <a href="logOut"><i class="fas fa-sign-out-alt"></i> Déconnexion</a>
                        </div>
                    </div>
                <?php else: ?>
                    <a href="login" class="<?php echo $currentPage === 'login' ? 'active' : ''; ?>">
                        <i class="fas fa-sign-in-alt"></i> Connexion
                    </a>
                    <a href="signIn" class="btn-register <?php echo $currentPage === 'register' ? 'active' : ''; ?>">
                        <i class="fas fa-user-plus"></i> Inscription
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </nav>
</header>