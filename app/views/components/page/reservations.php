<main>
    <div class="container">
        <h1>Mes Réservations</h1>
        <?php if (is_array($reservations)): ?>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Habitation</th>
                        <th>Date d'Arrivée</th>
                        <th>Date de Départ</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reservations as $reservation): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($reservation['id_habitation']); ?></td>
                            <td><?php echo htmlspecialchars($reservation['date_arrivee']); ?></td>
                            <td><?php echo htmlspecialchars($reservation['date_depart']); ?></td>
                            <td>
                                <form method="POST" style="display:inline;">
                                    <input type="hidden" name="reservation_id" value="<?php echo $reservation['id']; ?>">
                                    <button type="submit" name="cancel" class="btn-delete">
                                        <i class="fas fa-trash"></i> Annuler
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Aucune réservation trouvée.</p>
        <?php endif; ?>
    </div>
</main>