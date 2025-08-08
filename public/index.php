<?php

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-do list</title>
    <link rel="stylesheet" href="../assets/style/style.css">
</head>
<body>
    <?php
        include '../includes/header.php';
    ?>
    <main>
    <!-- Formulaire -->
        <form action="" method="post">
            <input type="text" name="titre" id="titre" placeholder="Le titre">
            <input type="text" name="description" id="description" placeholder="La description">
            <input type="text" name="status" id="status" placeholder="Status"> <!-- a voir pour le status si ajout checkbox -->
            <select class="selectMenu" name="category" required>         <!-- menu déroulant pour selectionner une priorité -->
            <option value="basse">Basse</option>
            <option value="moyenne">Moyenne</option>
            <option value="haute">Haute</option>
        </form>
        <div class="todosContainer">
            <?php foreach ($_SESSION["todos"] as $category => $tasks) { ?> <!-- Boucle sur chaque catégorie en incluant les taches qu'on leur a assigné -->
                <section class="todoContainer">
                    <h3 class="title todoTitle"><?= $category ?></h3>
                    <?php if (empty($tasks)) { ?>
                        <p class="empty">Aucune tâche pour cette catégorie.</p>
                    <?php } else { ?>
                        <ul>
                            <?php foreach ($tasks as $index => $task) { ?>
                                <li>
                                    <input type="checkbox">
<!-- ---------------------------------------------------------------------------------------------------------------------- -->
<!----------------------------- a ajouter si sauvegarde des taches coché ----------------------------------------------------->
                                <!-- <input -->
                                    <!-- type="checkbox" -->
                                    <!-- name="done[<//?= htmlspecialchars($category) ?>][]" -->
                                    <!-- value="<//?= $index ?>" -->
                                    <!-- <//?= $task['done'] ? 'checked' : '' ?> -->
                                >
                                    <a class="delete-btn" href="?delete=<?= $index ?>&category=<?= $category ?>">🗑</a>
                                    <span><?= htmlspecialchars($task) ?></span>
                                </li>
                            <?php } ?>
                        </ul>
                    <?php } ?>
                </section>
            <?php } ?>
        </div>
    </main>
    <?php
        include '../includes/footer.php';
    ?>
</body>
</html>