<?php 

// logique de connexion a la database

//information pour se connecter
//l'endroit ou est ma database


//fonction qui crée et renvoi une connexion a la db
function dbConnexion() {
    $host = "localhost";
//le nom de la db
    $dbname = "task_db";
    //identifiant de connexion
    $username = "root";
    //mdp de connexion
    $password = "";
    //port
    $port = 3306;
    //encodage
    $charset = "utf8mb4";

    try {
        //mes param de co // DSN= DATA SOURCE NAME (indique à PHP comment se connecter a la base de données)
        $dsn = "mysql:host=$host;dbname=$dbname;charset=$charset;port=$port";
        //fait mon object de co
        $pdo = new PDO($dsn, $username, $password);
        //comment recuperer les exception (erreurs) //Si erreurs SQL, lance une exeption(erreur php qui est du coup récuperable) Sans ca les erreurs SQL son parfois silencieuses.
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //comment me renvoyer les données
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        var_dump($pdo);
        return $pdo;     // renvois $pdo pour l'utiliser ailleurs (ex: u autre fichier php)

    } catch (PDOException $e) {           // si une erreur se produit dans try =, on entre ici.
        die("erreur durant la co a la bd: " . $e->getMessage());  // die arrete le script et affiche la string d'erreur. $e->getMessage() ajoute le detail de l'erreur mySQL.
    }
}
//dbConnexion();// lancement de la fonction de connection pour test
?>