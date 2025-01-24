<?php
// admin/index.php
if (session_status() === PHP_SESSION_NONE)
    session_start();
require_once '../config.php';

// Simple admin authentication (you should implement proper authentication)
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}

// Get all types for the dropdown
$types_stmt = $pdo->query("SELECT * FROM Immobilier_type");
$types = $types_stmt->fetchAll(PDO::FETCH_ASSOC);

// Handle Delete Operation
if (isset($_POST['delete']) && isset($_POST['id'])) {
    $stmt = $pdo->prepare("DELETE FROM Immobilier_habitation WHERE id = ?");
    $stmt->execute([$_POST['id']]);
    header('Location: index.php');
    exit;
}

// Handle Create/Update Operations
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $id = isset($_POST['id']) ? $_POST['id'] : null;
    $data = [
        'id_type' => $_POST['id_type'],
        'nombre_chambre' => $_POST['nombre_chambre'],
        'loyer' => $_POST['loyer'],
        'quartier' => $_POST['quartier'],
        'designation' => $_POST['designation']
    ];

    if ($id) {
        // Update
        $sql = "UPDATE Immobilier_habitation SET 
                id_type = :id_type,
                nombre_chambre = :nombre_chambre,
                loyer = :loyer,
                quartier = :quartier,
                designation = :designation
                WHERE id = :id";
        $data['id'] = $id;
    } else {
        // Create
        $sql = "INSERT INTO Immobilier_habitation 
                (id_type, nombre_chambre, loyer, quartier, designation) 
                VALUES 
                (:id_type, :nombre_chambre, :loyer, :quartier, :designation)";
    }

    $stmt = $pdo->prepare($sql);
    $stmt->execute($data);
    header('Location: index.php');
    exit;
}

// Get habitation for editing if ID is provided
$editing = null;
if (isset($_GET['edit'])) {
    $stmt = $pdo->prepare("SELECT * FROM Immobilier_habitation WHERE id = ?");
    $stmt->execute([$_GET['edit']]);
    $editing = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Fetch all habitations
$stmt = $pdo->query("SELECT h.*, t.designation as type_name 
                     FROM Immobilier_habitation h 
                     JOIN Immobilier_type t ON h.id_type = t.id 
                     ORDER BY h.id DESC");
$habitations = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration - Gestion des Habitations</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="admin.css">
</head>
<body>
<div class="admin-container">
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <i class="fas fa-user-shield"></i>
            <h2>Admin Panel</h2>
        </div>
        <nav>
            <a href="index.php" class="active">
                <i class="fas fa-home"></i>
                Habitations
            </a>
            <a href="logout.php">
                <i class="fas fa-sign-out-alt"></i>
                Déconnexion
            </a>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="content-header">
            <h1><?php echo $editing ? 'Modifier' : 'Ajouter'; ?> une habitation</h1>
        </div>

        <!-- Form -->
        <div class="card">
            <form method="POST" class="admin-form">
                <?php if ($editing): ?>
                    <input type="hidden" name="id" value="<?php echo $editing['id']; ?>">
                <?php endif; ?>

                <div class="form-row">
                    <div class="form-group">
                        <label>Type</label>
                        <select name="id_type" required>
                            <?php foreach ($types as $type): ?>
                                <option value="<?php echo $type['id']; ?>"
                                    <?php echo ($editing && $editing['id_type'] == $type['id']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($type['designation']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
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

                <button type="submit" name="submit" class="btn-submit">
                    <i class="fas fa-save"></i>
                    <?php echo $editing ? 'Mettre à jour' : 'Ajouter'; ?>
                </button>

                <?php if ($editing): ?>
                    <a href="index.php" class="btn-cancel">Annuler</a>
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
                                <a href="?edit=<?php echo $habitation['id']; ?>" class="btn-edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form method="POST" class="delete-form" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette habitation ?');">
                                    <input type="hidden" name="id" value="<?php echo $habitation['id']; ?>">
                                    <button type="submit" name="delete" class="btn-delete">
                                        <i class="fas fa-trash"></i>
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
</body>
</html>