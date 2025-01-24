<?php

?>

<main>
    <div class="admin-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-header">
                <i class="fas fa-user-shield"></i>
                <h2>Admin Panel</h2>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Form -->
            <div class="card">
                <form method="POST" class="admin-form"
                      action="<?php
                      if (!empty($editing)) {
                          echo  'admin/habitations/update';
                      } else {
                          echo  'admin/habitations/add';
                      }
                      ?>">
                    <?php if (!empty($editing)): ?>
                        <input type="hidden" name="id" value="<?php echo $editing['id']; ?>">
                    <?php endif; ?>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Type</label>
                            <label>
                                <select name="id_type" required>
                                    <?php foreach ($types as $type): ?>
                                        <option value="<?php echo $type['id']; ?>"
                                            <?php echo ($editing && $editing['id_type'] == $type['id']) ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($type['designation']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </label>
                        </div>

                        <div class="form-group">
                            <label>Nombre de chambres</label>
                            <input type="number" name="nombre_chambre"
                                   value="<?php echo $editing ? $editing['nombre_chambre'] : ''; ?>" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Loyer</label>
                            <input type="number" step="0.01" name="loyer"
                                   value="<?php echo $editing ? $editing['loyer'] : ''; ?>" required>
                        </div>

                        <div class="form-group">
                            <label>Quartier</label>
                            <input type="text" name="quartier"
                                   value="<?php echo $editing ? $editing['quartier'] : ''; ?>" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Désignation</label>
                        <input type="text" name="designation"
                               value="<?php echo $editing ? $editing['designation'] : ''; ?>" required>
                    </div>

                    <button type="submit" class="btn-submit">
                        <i class="fas fa-save"></i>
                        <?php echo $editing ? 'Mettre à jour' : 'Ajouter'; ?>
                    </button>

                    <?php if ($editing): ?>
                        <a href="admin" class="btn-cancel">Annuler</a>
                    <?php endif; ?>
                </form>
            </div>

            <!-- Table -->
            <div class="card">
                <h2>Liste des habitations</h2>
                <div class="table-responsive">
                    <table class="admin-table">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Type</th>
                            <th>Chambres</th>
                            <th>Loyer</th>
                            <th>Quartier</th>
                            <th>Désignation</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($habitations as $habitation): ?>
                            <tr>
                                <td><?php echo $habitation['id']; ?></td>
                                <td><?php echo htmlspecialchars($habitation['type_name']); ?></td>
                                <td><?php echo $habitation['nombre_chambre']; ?></td>
                                <td><?php echo number_format($habitation['loyer'], 2); ?> €</td>
                                <td><?php echo htmlspecialchars($habitation['quartier']); ?></td>
                                <td><?php echo htmlspecialchars($habitation['designation']); ?></td>
                                <td class="actions">
                                    <a href="admin?edit=<?php echo $habitation['id']; ?>" class="btn-edit">
                                        Edit
                                    </a>
                                    <form method="POST" action="admin/habitations/delete" class="delete-form"
                                          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette habitation ?');">
                                        <input type="hidden" name="id" value="<?php echo $habitation['id']; ?>">
                                        <button type="submit" class="btn-delete">
                                            Supprimer
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>
