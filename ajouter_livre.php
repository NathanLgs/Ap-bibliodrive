<?php
require_once 'connexion.php';

$erreur = "";
$success = "";

/* Récupération des auteurs pour le select */
$auteursStmt = $connexion->query("SELECT noauteur, prenom, nom FROM auteur ORDER BY nom ASC");
$auteurs = $auteursStmt->fetchAll(PDO::FETCH_ASSOC);

/* Traitement du formulaire */
if (isset($_POST['btnAjouter'])) {

    $noauteur = $_POST['noauteur'] ?? '';
    $titre = trim($_POST['titre'] ?? '');
    $isbn13 = trim($_POST['isbn13'] ?? '');
    $annee = $_POST['anneeparution'] ?? '';
    $detail = trim($_POST['detail'] ?? '');

    if ($noauteur && $titre && $isbn13 && $annee && $detail) {

        // -------------------- Gestion de l'image --------------------
        $photo = null;
        if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
            $tmp_name = $_FILES['photo']['tmp_name'];
            $filename = basename($_FILES['photo']['name']);
            $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

            $allowed = ['jpg', 'jpeg', 'png', 'gif'];
            if (in_array($extension, $allowed)) {
                $newFilename = uniqid('livre_') . '.' . $extension;
                $destination = __DIR__ . '/images/' . $newFilename;
                if (move_uploaded_file($tmp_name, $destination)) {
                    $photo = $newFilename;
                } else {
                    $erreur = "Erreur lors de l'upload de l'image.";
                }
            } else {
                $erreur = "Extension de fichier non autorisée (jpg, jpeg, png, gif).";
            }
        }

        if (!$erreur) {
            // -------------------- Insertion du livre --------------------
            $stmt = $connexion->prepare(
                "INSERT INTO livre
                (noauteur, titre, isbn13, anneeparution, detail, dateajout, photo)
                VALUES
                (:noauteur, :titre, :isbn13, :annee, :detail, CURDATE(), :photo)"
            );

            $stmt->execute([
                'noauteur' => $noauteur,
                'titre' => $titre,
                'isbn13' => $isbn13,
                'annee' => $annee,
                'detail' => $detail,
                'photo' => $photo
            ]);

            $success = "Livre ajouté avec succès ✅";
        }

    } else {
        $erreur = "Tous les champs sont obligatoires";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <title>AJOUT LIVRE</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <link href="style.css" rel="stylesheet">
</head>

<body class="text-light bg-blur">

<?php include 'entete.php'; // Affiche la barre de menu spécifique profil ?>

<div class="container mt-5 mb-5">

    <div class="card shadow p-4">
        <h3 class="mb-4 text-center">➕ Ajouter un livre</h3>

        <?php if ($erreur): ?>
            <div class="alert alert-danger"><?= $erreur ?></div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="alert alert-success"><?= $success ?></div>
        <?php endif; ?>

        <form method="post" enctype="multipart/form-data">

            <h5 class="mb-3">Auteur</h5>

            <div class="mb-4">
                <label class="form-label">Sélectionnez un auteur existant</label>
                <select name="noauteur" class="form-select" required>
                    <option value="">-- Choisir un auteur --</option>
                    <?php foreach ($auteurs as $a): ?>
                        <option value="<?= $a['noauteur'] ?>">
                            <?= $a['prenom'] . " " . $a['nom'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <h5 class="mb-3">Livre</h5>

            <div class="mb-3">
                <label class="form-label">Titre</label>
                <input type="text" name="titre" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">ISBN</label>
                <input type="text" name="isbn13" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Année de parution</label>
                <input type="number" name="anneeparution" class="form-control" required>
            </div>

            <div class="mb-4">
                <label class="form-label">Description</label>
                <textarea name="detail" class="form-control" rows="5" required></textarea>
            </div>

            <div class="mb-4">
                <label class="form-label">Image du livre</label>
                <input type="file" name="photo" class="form-control" accept=".jpg,.jpeg,.png,.gif">
            </div>

            <button name="btnAjouter" class="btn btn-primary btn-lg w-100">
                Ajouter le livre
            </button>

        </form>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
