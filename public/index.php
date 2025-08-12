<!-- a faire : ajout de priority et (checkbox?) -->

<?php
    session_start();
    require_once "../config/database.php";

    $errors =[];

    //Récuperation des données du formulaire et nettoyage ---
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $titre = htmlspecialchars(trim($_POST["titre"] ?? ""));
        $description = htmlspecialchars(trim($_POST["description"] ?? ""));
        // $status = htmlspecialchars(trim($_POST["status"] ?? ""));
        // $priority = htmlspecialchars(trim($_POST["priority"] ?? ""));
    }
    //validation des données ---
    if (empty($titre)){
        $errors[] = "champ titre vide";
    }
    if (empty($description)){
        $errors[] = "champ description vide";
    }
    // if (empty($status)){
    //     $errors[] = "selectionner un statut";
    // }
    // if (empty($priority)){
    //     $errors[] = "selectionner une priorité";
    // }

    //logique de traitement en db ---
    $pdo = dbConnexion();

    // Condition pour ajouter une ligne dans DB ---
    if (empty($errors)) {
        $insert = "INSERT INTO tasks (title, description) VALUES (?, ?)";
        $insertTask = $pdo->prepare($insert);
        $insertTask->execute([$titre, $description]);
    }

    // Condition pour supression de ligne dans DB ---
    if (isset($_GET['delete'])) {
        $idDelete = (int) $_GET["delete"];
        $deleteTask = $pdo->prepare("DELETE FROM tasks WHERE id = ?");
        $deleteTask->execute([$idDelete]);
    }

    // Requête pour récupérer toutes les tâches ---
    $select = "SELECT id, title, description FROM tasks";
    $requeteTache = $pdo->prepare($select);
    $requeteTache->execute();
    // Récupération des résultats ---
    $tasks = $requeteTache->fetchAll(PDO::FETCH_ASSOC);

    //Récuperation des keys dans un tableau (finalement inutile avec array_key_first($tasks[0]))---
    $titres = [];

    foreach ($tasks[0] as $task => $value) {
    $titres[] = $task;
    }
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
    <header>
        <?php
            include '../includes/header.php'; //import header ---
        ?>
    </header>
<!-- ------------------------------------------------------------------------------------------ -->
<!--                      Formulaire                                                            -->
<!-- ------------------------------------------------------------------------------------------ -->
    <main>
        <form class ="formContainer" action="" method="post">
            <input type="text" name="titre" id="titre" placeholder="Le titre">
            <input type="text" name="description" id="description" placeholder="La description">
            <!-- <input type="text" name="status" id="status" placeholder="Status">                a voir pour le status si ajout checkbox -->
            <select class="selectMenu" name="priority">         <!-- menu déroulant pour selectionner une priorité -->
            <option value="basse">Basse</option>
            <option value="moyenne">Moyenne</option>
            <option value="haute">Haute</option>
            <input class="submitBtn" type="submit" value="Ajouter">
        </form>
<!-- ------------------------------------------------------------------------------------------ -->
<!--                      Tableau 1                                                             -->
<!-- ------------------------------------------------------------------------------------------ -->
        <!-- import des keys du tableau -->
        <section>
            <div class="tableRow">
                <div class="tableauId"><?= htmlspecialchars(array_key_first($tasks[0] ?? "")) ?></div> <!--!!! array_key_first = raccourci !!!-->
                <div class="tableauTitle"><?= htmlspecialchars($titres[1] ?? "") ?></div>
                <div class="tableauDescription"><?= htmlspecialchars($titres[2] ?? "") ?></div>
            </div>
            <!-- import des values du tableau et ajout du bouton de supression-->
            <?php foreach ($tasks as $task) { ?>
                <div class="tableRow">
                    <div class="tableauId">
                        <a class="delete-btn" href="?delete=<?= $task["id"] ?>">🗑</a>
                        <?= htmlspecialchars($task["id"] ?? "") ?>
                    </div>
                    <div class="tableauTitle"><?= htmlspecialchars($task["title"] ?? "") ?></div>
                    <div class="tableauDescription"><?= htmlspecialchars($task["description"] ?? "") ?></div>
                </div>
            <?php } ?>
        </section>

<!-- ------------------------------------------------------------------------------------------ -->
<!--                      Tableau 2 : test avec ancien todolist                                 -->
<!-- ------------------------------------------------------------------------------------------ -->

        <div class="todosContainer">
            <?php foreach ($tasks[0] as $columnName => $value) { ?> <!-- Boucle sur chaque catégorie en incluant les taches qu'on leur a assigné -->
                <section class="todoContainer">
                    <h3 class="title todoTitle"><?= htmlspecialchars($columnName) ?? ""  ?></h3>
                    <?php if (empty($tasks)) { ?>
                        <p class="empty">Aucune tâche pour cette catégorie.</p>
                    <?php } else { ?>
                        <ul>
                            <?php foreach ($tasks as $task) { ?>
                                <li>
                                    <?php if ($columnName === 'id') { ?>
                                        <input type="checkbox" name="checkbox">
                                        <a class="delete-btn" href="?delete=<?= $task['id'] ?? "" ?>">🗑</a>
                                    <?php } ?>
                                    <span class="todoContainer"><?= htmlspecialchars($task[$columnName] ?? "") ?></span>                                    
                                </li>
                            <?php } ?>
                        </ul>
                    <?php } ?>
                </section>
            <?php } ?>
        </div>

<!-- ------------------------------------------------------------------------------------------ -->
<!--                      Tableau 3 : test                                                      -->
<!-- ------------------------------------------------------------------------------------------ -->

        <div class="todosContainer">
            <ul>
                <?php foreach ($tasks as $task) { ?>
                    <li class="tableRow2">
                        <div class="column id">
                            <input type="checkbox" name="checkbox">
                            <a class="delete-btn" href="?delete=<?= $task['id'] ?>">🗑</a>
                            <span><?= htmlspecialchars($task['id']) ?></span>
                        </div>
                        <div class="column title"><?= htmlspecialchars($task['title'] ?? "") ?></div>
                        <div class="column description"><?= htmlspecialchars($task['description'] ?? "") ?></div>
                    </li>                
                <?php } ?>
            </ul>
        </div>
    </main>
    <footer>
        <?php
            include '../includes/footer.php'; //import footer ---
        ?>
    </footer>
</body>                               