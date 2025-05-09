<?php ob_start(); session_start(); ?>

<!DOCTYPE html>
<html lang="fr">

  <head>
    <title>Connexion</title>
    <link href="../styles/login.css" rel="stylesheet">
    <meta charset="utf-8" >
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  </head>

  <body>

    <?php require_once(__DIR__ . '/header.php'); ?>
    <?php require_once(__DIR__ . '/footer.php'); ?>

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

    <div id="page" class="container vh-100 d-flex align-items-center justify-content-center">
      <div class="row">
        <div class="col-md-auto">

    <?php
      // Vérification de si la requête a été transmise
      if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Connexion à la base de données
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      // Vérification de la présence du nom d'utilisateur
      if (empty($_POST['userName'])) {
        echo "<div class='alert alert-danger text-justify' role='alert'>
        Le nom d'utilisateur saisi est manquant. <a href='#' class='alert-link'>Cliquez ici pour revenir à la page d'accueil</a>. Vous serez redirigé automatiquement dans 5 secondes.
        </div>";
        echo "<script>
        setTimeout(function() {
        window.location.href = '/bfshack/index.php';
        }, 5000);
        </script>";
        exit;
      }
      // Vérification de la présence du mot de passe
      if (empty($_POST['password'])) {
        echo "<div class='alert alert-danger text-justify' role='alert'>
        Le mot de passe est manquant. <a href='#' class='alert-link'>Cliquez ici pour revenir à la page d'accueil</a>. Vous serez redirigé automatiquement dans 5 secondes.
        </div>";
        echo "<script>
        setTimeout(function() {
        window.location.href = '/bfshack/index.php';
        }, 5000);
        </script>";
        exit;
      }
        $userName = $_POST['userName'];
        // Préparation de la requête SQL
        $sqlQuery = 'SELECT password FROM account WHERE username = :userName';
        $stmt = $pdo->prepare($sqlQuery);
        $stmt->execute([':userName' => $userName]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        // Vérification si un utilisateur a été trouvé
        if ($user) {
          // Vérification du mot de passe
          if (password_verify($_POST['password'], $user['password'])) {
            $_SESSION['userName'] = $userName;
            // Token pour le cookie
            $token = bin2hex(random_bytes(64));
            // Variable pour le cookie
            $rememberMe = 'rememberMe';
            // Crée le cookie de 30 jours
            setcookie($rememberMe, $token, time() + (86400 * 30), "/");
            // Enregistrement du token
            $sqlUpdateToken = "UPDATE account SET token = :token WHERE username = :userName";
            $stmt = $pdo->prepare($sqlUpdateToken);
            $stmt->execute([':token' => $token, ':userName' => $userName]);
            // Valeurs à enregistrer dans les logs
            $donnees['ip'] = $_SERVER['REMOTE_ADDR'];
            $donnees['date'] = date('d/m/Y');
            $donnees['heure'] = date('H:i:s');
            $donnees['userAgent'] = $userAgent = $_SERVER['HTTP_USER_AGENT'];
            $etat = "Connexion";
            $sqlQuery = "INSERT INTO login_logout (etat, userName, ip, heure, date, userAgent) VALUES (:etat, :userName, :ip, :heure, :date, :userAgent)";
            $stmt = $pdo->prepare($sqlQuery);
            $stmt->bindParam(':etat', $etat);
            $stmt->bindParam(':userName', $userName);
            $stmt->bindParam(':ip', $donnees['ip']);
            $stmt->bindParam(':date', $donnees['date']);
            $stmt->bindParam(':heure', $donnees['heure']);
            $stmt->bindParam(':userAgent', $donnees['userAgent']);
            // Exécution de la requête, enregistrement des logs
            $stmt->execute();
            // Redirection vers l'index
            header('Location: /bfshack/index.php'); 
          } else {
            echo "<div class='alert alert-danger text-justify' role='alert'>
            Le mot de passe saisi est invalide. <a href='#' class='alert-link'>Cliquez ici pour revenir à la page d'accueil</a>. Vous serez redirigé automatiquement dans 5 secondes.
            </div>";
            echo "<script>
            setTimeout(function() {
                window.location.href = '/bfshack/index.php';
            }, 5000);
            </script>";
          }
        } else {
            echo "<div class='alert alert-danger text-justify' role='alert'>
            Le nom d'utilisateur saisi est invalide. <a href='#' class='alert-link'>Cliquez ici pour revenir à la page d'accueil</a>. Vous serez redirigé automatiquement dans 5 secondes.
            </div>";
            echo "<script>
            setTimeout(function() {
                window.location.href = '/bfshack/index.php';
            }, 5000);
            </script>"; 
          }
        }
    ?>

        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

  </body>

</html>