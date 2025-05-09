<!DOCTYPE html>
<html lang="fr">

  <head>
    <title>Inscription</title>
    <link href="../styles/register.css" rel="stylesheet">
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

    <div id="container" class="container vh-100 d-flex align-items-center justify-content-center">
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
                le nom d'utilisateur est manquant. <a href='#' class='alert-link'>Cliquez ici pour revenir à la page d'accueil</a>. Vous serez redirigé automatiquement dans 5 secondes.
                </div>";
                echo "<script>
                setTimeout(function() {
                window.location.href = '/bfshack/index.php';
                }, 5000);
                </script>";
                exit;
              }
              // Vérification de si le nom d'utilisateur n'existe pas déjà
              else {
                $userName = $_POST['userName'];
                $sqlQuery = 'SELECT COUNT(*) FROM account WHERE username = :userName';
                $stmt = $pdo->prepare($sqlQuery);
                $stmt->execute([':userName' => $userName]);
                $count = $stmt->fetchColumn();
                if ($count > 0) {
                  echo "<div class='alert alert-danger text-justify' role='alert'>
                  Ce nom d'utilisateur est déjà utilisé. Veuillez en choisir un autre. <a href='#' class='alert-link'>Cliquez ici pour revenir à la page d'accueil</a>. Vous serez redirigé automatiquement dans 5 secondes.
                  </div>";
                  echo "<script>
                  setTimeout(function() {
                  window.location.href = '/bfshack/index.php';
                  }, 5000);
                  </script>";
                  exit;
                }
              }
              // Vérification de la présence de l'email
              if (empty($_POST['email'])) {
                echo "<div class='alert alert-danger text-justify' role='alert'>
                L'adresse email est manquante. <a href='#' class='alert-link'>Cliquez ici pour revenir à la page d'accueil</a>. Vous serez redirigé automatiquement dans 5 secondes.
                </div>";
                echo "<script>
                setTimeout(function() {
                window.location.href = '/bfshack/index.php';
                }, 5000);
                </script>";
                exit;
              } else {
                $email = $_POST['email'];
              }
              // Vérification de la présence du mot de passe
              if (empty($_POST['password'])) {
                echo "<div class='alert alert-danger text-justify' role='alert'>
                  L'adresse mot de passe est manquant. <a href='#' class='alert-link'>Cliquez ici pour revenir à la page d'accueil</a>. Vous serez redirigé automatiquement dans 5 secondes.
                  </div>";
                echo "<script>
                setTimeout(function() {
                window.location.href = '/bfshack/index.php';
                }, 5000);
                </script>";
                exit;
              }
              // Hashage du mot de passe
              else {
                $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
              }
              // Valeurs pour l'enregistrement du compte ainsi que des logs
              $donnees['ip'] = $_SERVER['REMOTE_ADDR'];
              $donnees['date'] = date('Y-m-d');
              $donnees['heure'] = date('H:i:s');
              $donnees['userAgent'] = $_SERVER['HTTP_USER_AGENT'];
            }

            // Préparation de la requête d'insertion
            $sqlQuery = "INSERT INTO account (userName, email, password, ip, date, heure, userAgent) VALUES (:userName, :email, :password, :ip, :date, :heure, :userAgent)";
            
            // Préparation de la requête SQL
            $stmt = $pdo->prepare($sqlQuery);

            // Liaison des paramètres
            $stmt->bindParam(':userName', $userName);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $password);
            $stmt->bindParam(':ip', $donnees['ip']);
            $stmt->bindParam(':date', $donnees['date']);
            $stmt->bindParam(':heure', $donnees['heure']);
            $stmt->bindParam(':userAgent', $donnees['userAgent']);

            // Exécution de la requête, enregitrement du compte
            $stmt->execute();

            echo "<div class='alert alert-success d-flex align-items-center text-justify' role='alert'>

            <div>
            Votre compte a bien été créé ! <a href='/bfshack/index.php' class='alert-link'>Cliquez ici pour revenir à la page d'accueil</a>. Vous serez redirigé automatiquement dans 5 secondes.
            </div>
            </div>";
            echo "<script>
            setTimeout(function() {
            window.location.href = '/bfshack/index.php';
            }, 5000);
            </script>";

          ?>

        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>

  </body>

</html>