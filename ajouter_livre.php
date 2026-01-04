<?php
require_once 'connexion.php';

$erreur = "";
$success = "";

/* Traitement du formulaire */
if (isset($_POST['btnAjouter'])) {

    $nomAuteur = trim($_POST['nom_auteur'] ?? '');
    $prenomAuteur = trim($_POST['prenom_auteur'] ?? '');
    $titre = trim($_POST['titre'] ?? '');
    $isbn13 = trim($_POST['isbn13'] ?? '');
    $annee = $_POST['anneeparution'] ?? '';
    $detail = trim($_POST['detail'] ?? '');

    if ($nomAuteur && $prenomAuteur && $titre && $isbn13 && $annee && $detail) {

        /* 1️⃣ Vérifier si l’auteur existe */
        $stmt = $connexion->prepare(
            "SELECT noauteur FROM auteur 
             WHERE nom = :nom AND prenom = :prenom"
        );
        $stmt->execute([
            'nom' => $nomAuteur,
            'prenom' => $prenomAuteur
        ]);

        $auteur = $stmt->fetch(PDO::FETCH_ASSOC);

        /* 2️⃣ Sinon, l’ajouter */
        if ($auteur) {
            $noauteur = $auteur['noauteur'];
        } else {
            $stmt = $connexion->prepare(
                "INSERT INTO auteur (nom, prenom)
                 VALUES (:nom, :prenom)"
            );
            $stmt->execute([
                'nom' => $nomAuteur,
                'prenom' => $prenomAuteur
            ]);

            $noauteur = $connexion->lastInsertId();
        }

        /* 3️⃣ Insertion du livre */
        $stmt = $connexion->prepare(
            "INSERT INTO livre
            (noauteur, titre, isbn13, anneeparution, detail, dateajout, photo)
            VALUES
            (:noauteur, :titre, :isbn13, :annee, :detail, CURDATE(), NULL)"
        );

        $stmt->execute([
            'noauteur' => $noauteur,
            'titre' => $titre,
            'isbn13' => $isbn13,
            'annee' => $annee,
            'detail' => $detail
        ]);

        $success = "Livre ajouté avec succès ✅";

    } else {
        $erreur = "Tous les champs sont obligatoires";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <link href="style.css" rel="stylesheet">
</head>

<body class="text-light bg-blur">

<?php include 'entete.php'; ?>

<div class="container mt-5 mb-5">

    <div class="card shadow p-4">
        <h3 class="mb-4 text-center">➕ Ajouter un livre</h3>

        <?php if ($erreur): ?>
            <div class="alert alert-danger"><?= $erreur ?></div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="alert alert-success"><?= $success ?></div>
        <?php endif; ?>

        <form method="post">

            <h5 class="mb-3">Auteur</h5>

            <div class="mb-3">
                <label class="form-label">Prénom de l’auteur</label>
                <input type="text" name="prenom_auteur" class="form-control" required>
            </div>

            <div class="mb-4">
                <label class="form-label">Nom de l’auteur</label>
                <input type="text" name="nom_auteur" class="form-control" required>
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

            <button name="btnAjouter" class="btn btn-primary btn-lg w-100">
                Ajouter le livre
            </button>

        </form>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
