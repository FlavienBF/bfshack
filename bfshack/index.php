<!DOCTYPE html>
<html lang="fr">

<head>
    
  <title>bfshack</title>
  <link href="styles/index.css" rel="stylesheet">
  <meta charset="utf-8" >
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"     integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    

</head>

<body>

<?php require_once(__DIR__ . '/contenu/header.php'); ?> 
<?php require_once(__DIR__ . '/contenu/footer.php'); ?>

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
  $env = parse_ini_file(__DIR__ . '/private.env');

  // Utiliser les valeurs
  $host = $env['DB_HOST'];
  $dbname = $env['DB_NAME'];
  $user = $env['DB_USER'];
  $pass = $env['DB_PASS'];
?>

<?php
    // Valeurs à enregistrer dans les logs
    $page = "Index";
    $donnees['ip'] = $_SERVER['REMOTE_ADDR'];
    $donnees['date'] = date('d/m/Y');
    $donnees['heure'] = date('H:i:s');
    $donnees['userAgent'] = $userAgent = $_SERVER['HTTP_USER_AGENT'];
?>

<?php
    // Connexion à la base de données 

    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass); 
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Préparation de la requête d'insertion
    $sqlQuery = "INSERT INTO log_index (page, compte, ip, date, heure, userAgent) VALUES (:page, :compte, :ip, :date, :heure, :userAgent)";
    // Préparation de la requête SQL
    $stmt = $pdo->prepare($sqlQuery);

    // Liaison des paramètres
    $stmt->bindParam(':page', $page);
    if (isset($_SESSION['userName'])) {  $stmt->bindParam(':compte', $_SESSION['userName']); }
    if (!isset($_SESSION['userName'])) {  $stmt->bindValue(':compte', "Utilisateur anonyme", PDO::PARAM_STR); }
    $stmt->bindParam(':ip', $donnees['ip']);
    $stmt->bindParam(':date', $donnees['date']);
    $stmt->bindParam(':heure', $donnees['heure']);
    $stmt->bindParam(':userAgent', $donnees['userAgent']);

    // Exécution de la requête, enregistrement des logs 
    $stmt->execute();
    // Récupération du nombre d'images uploadées, ancienne fonctionnalité 
    $sqlQuery = 'SELECT * FROM log_upload ORDER BY clics DESC LIMIT 1';
    $log_uploadStatement = $pdo->prepare($sqlQuery);
    $log_uploadStatement->execute();
    $log_upload = $log_uploadStatement->fetch();


?>

<div id="page" class="container vh-100 d-flex align-items-center justify-content-center">
    <div class="row w-100">
        <div class="col-md-6 mx-auto">
            <form action="contenu/upload.php" method="POST" enctype="multipart/form-data">
                <div class="formulaire">
                    <label for="image" class="form-texte w-100 text-center">Sélectionnez une image</label>
                    <input type="file" class="form-selection w-100" id="image" name="image" />
                    <p id="file-info" class="file-info text-center mt-2"></p>
                    <button type="submit" class="form-bouton w-100">Envoyer</button>
                    
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Récupère l'élément d'input de type fichier (avec l'ID "image")
    const fileInput = document.getElementById('image');

    // Récupère le bouton de soumission (ayant la classe "form-bouton")
    const submitBtn = document.querySelector('.form-bouton');

    // Déclare une variable pour stocker l'identifiant du timer
    let timeoutId;

    // Ajoute un écouteur d'événement sur le changement de fichier
    fileInput.addEventListener('change', () => {
        // Annule tout timer existant pour éviter les déclenchements multiples
        clearTimeout(timeoutId);

        // Vérifie si un ou plusieurs fichiers ont été sélectionnés
        if (fileInput.files.length > 0) {
              // Lance un nouveau timer (100ms) pour activer le bouton
              timeoutId = setTimeout(() => {
              submitBtn.classList.add('active'); // Ajoute la classe "active" au bouton
            }, 100);
        } else {
            // Si aucun fichier sélectionné, retire la classe "active"
            submitBtn.classList.remove('active');
        }
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    
</body>

</html>