<?php

require_once('connexion.php');



// Récupérer l'auteur depuis la navbar
$author = isset($_GET['author']) ? $_GET['author'] : '';

// Requête pour chercher les livres de cet auteur
$sql = "SELECT livre.titre, livre.anneeparution, livre.photo, auteur.nom, auteur.prenom
        FROM livre
        JOIN auteur ON livre.noauteur = auteur.noauteur
        WHERE CONCAT(auteur.nom, ' ', auteur.prenom) LIKE :author
        ORDER BY livre.titre ASC";

$stmt = $pdo->prepare($sql);
$stmt->execute(['author' => "%$author%"]);
$books = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Résultats pour : <?php echo htmlspecialchars($author); ?></h2>

<ul>
<?php foreach ($books as $book): ?>
    <li>
        <strong><?php echo htmlspecialchars($book['titre']); ?></strong>
        par <?php echo htmlspecialchars($book['prenom'] . ' ' . $book['nom']); ?>
        (<?php echo $book['anneeparution']; ?>)
        <?php if ($book['photo']): ?>
            <br><img src="images/<?php echo htmlspecialchars($book['photo']); ?>" alt="<?php echo htmlspecialchars($book['titre']); ?>" width="100">
        <?php endif; ?>
    </li>
<?php endforeach; ?>
</ul>
