<?php session_start(); ?>
<?php
  $userName = @$_SESSION['userName'];
  session_destroy(); // Détruit tous les données de session
  setcookie('rememberMe', '', time() - 3600, "/"); // Supprime le cookie
?>

<!DOCTYPE html>
<html lang="fr">

  <head>
    <title>Deconnexion</title>
    <link href="../styles/login.css" rel="stylesheet">
    <meta charset="utf-8" >
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  </head>

  <body>

    <?php  require_once(__DIR__ . '/header.php'); ?>
    <?php  require_once(__DIR__ . '/footer.php'); ?>

    <?php echo $userName; ?>

    <noscript>
      <style>
        #page {
          display: none !important;
        }
      </style>
      <div class="container-fluid vh-100 d-flex align-items-center justify-content-center mt-5 mb-5">
        <div class="row mt-2">
          <div class="col-md-auto">
            <div class="alert alert-danger text-justify" role="alert">
              JavaScript est actuellement désactivé dans votre navigateur. Veuillez activer JavaScript dans les paramètres de votre navigateur afin de pouvoir accéder à <strong>bfshack</strong>.
            </div>
          </div>
        </div>
      </div>
    </noscript>

    <?php
      // Lire le fichier .env et le transformer en tableau associatif
      $env = parse_ini_file(__DIR__ . '/../private.env');

      // Utiliser les valeurs
      $host = $env['DB_HOST'];
      $dbname = $env['DB_NAME'];
      $user = $env['DB_USER'];
      $pass = $env['DB_PASS'];
    ?>

    <?php
      // Valeurs à enregistrer dans les logs
      //$userName = $_SESSION['userName'];
      $donnees['ip'] = $_SERVER['REMOTE_ADDR'];
      $donnees['date'] = date('d/m/Y');
      $donnees['heure'] = date('H:i:s');
      $donnees['userAgent'] = $userAgent = $_SERVER['HTTP_USER_AGENT'];
      $etat = "Deconnexion";

      // Connexion à la base de données
      $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      // Préparation de la requête d'insertion
      $sqlQuery = "INSERT INTO login_logout (etat, userName, ip, heure, date, userAgent) VALUES (:etat, :userName, :ip, :heure, :date, :userAgent)";

      // Préparation de la requête SQL
      $stmt = $pdo->prepare($sqlQuery);

      // Liaison des paramètres
      $stmt->bindParam(':etat', $etat);
      $stmt->bindParam(':userName', $userName);
      $stmt->bindParam(':ip', $donnees['ip']);
      $stmt->bindParam(':date', $donnees['date']);
      $stmt->bindParam(':heure', $donnees['heure']);
      $stmt->bindParam(':userAgent', $donnees['userAgent']);
      
      // Exécution de la requête, enregistrement des logs
      $stmt->execute();
    ?>

    

    <?php
      //Redirection à l'index en JS car impossible de le faire en PHP à cause des includes des header/footer
      echo '<script>
      window.location.href = "../index.php";
      </script>';
    ?>

    <div id="page" class="container vh-100 d-flex align-items-center justify-content-center">
      <div class="row">
        <div class="col-md-auto">
        
        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>

  </body>

</html>