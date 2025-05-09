<!DOCTYPE html>
<html lang="fr">

  <head>

    <title> </title>
    <meta charset="utf-8" >
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link href="../styles/contact_envoi.css" rel="stylesheet" >

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

    <div id="page" class="container-fluid vh-100 d-flex align-items-center justify-content-center mt-5 mb-5">
      <div class="row mt-2">
        <div class="col-md-auto">

          <?php
            // Vérifie si le formulaire a été soumis
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Valeurs du formulaire + valeurs des logs
                $donnees['ip'] = $_SERVER['REMOTE_ADDR'];
                $donnees['date'] = date('d/m/Y');
                $donnees['heure'] = date('H:i:s');
                $donnees['userAgent'] = $userAgent = $_SERVER['HTTP_USER_AGENT'];
                $prenom = htmlspecialchars($_POST['prenom']);
                $nom = htmlspecialchars($_POST['nom']);
                $adresseMail = htmlspecialchars($_POST['adresseMail']);
                $message = htmlspecialchars($_POST['message']);
        
              if (isset($_POST['abus'])) {
                $abus = "Abus";
              } else {
                 $abus = "Pas d'abus";
              }
        
              // Connexion à la base de données
              $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
              $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

              // Préparation de la requête d'insertion
              $sqlQuery = "INSERT INTO contact (compte, prenom, nom, adresseMail, abus, message, ip, heure, date, userAgent) VALUES (:compte, :prenom, :nom, :adresseMail, :abus, :message, :ip, :heure, :date, :userAgent)";

              // Préparation de la requête SQL
              $stmt = $pdo->prepare($sqlQuery);

             // Liaison des paramètres
             if (isset($_SESSION['userName'])) {
              $stmt->bindParam(':compte', $_SESSION['userName']);
             }
             if (!isset($_SESSION['userName'])) {
              $stmt->bindValue(':compte', "Utilisateur anonyme", PDO::PARAM_STR);
             }
             $stmt->bindParam(':prenom', $prenom);
             $stmt->bindParam(':nom', $nom);
             $stmt->bindParam(':adresseMail', $adresseMail);
             $stmt->bindParam(':abus', $abus);
             $stmt->bindParam(':message', $message);
             $stmt->bindParam(':ip', $donnees['ip']);
             $stmt->bindParam(':date', $donnees['date']);
             $stmt->bindParam(':heure', $donnees['heure']);
             $stmt->bindParam(':userAgent', $donnees['userAgent']);
             
             // Exécution de la requête, envoi du message de contact + enregistrement des logs
             $stmt->execute();
             echo "<div class='alert alert-success d-flex align-items-center text-justify' role='alert'>
                     <div>
                      Votre demande a bien été transmise. <a href='/bfshack/index.php' class='alert-link'>Cliquez ici pour revenir à la page d'accueil</a>. Vous serez redirigé automatiquement dans 5 secondes.
                     </div>
                   </div>";  
             echo "<script>
                    setTimeout(function() {
                    window.location.href = '/bfshack/index.php';
                    }, 5000);
                   </script>";
             exit;
            } else {
             echo "<div class='alert alert-success d-flex align-items-center text-justify' role='alert'>
                     <div>
                      Une erreur s’est produite. Votre demande n’a pas été transmise. <a href='/bfshack/index.php' class='alert-link'>Cliquez ici pour revenir à la page d'accueil</a>. Vous serez redirigé automatiquement dans 5 secondes.
                      </div>
                    </div>";  
              echo "<script>
                      setTimeout(function() {
                      window.location.href = '/bfshack/index.php';
                      }, 5000);
                    </script>";
                    exit;

            }
            
          ?>

          </div>
        </div>
      </div>

      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
            
  </body>
        
</html>