<!DOCTYPE html>
<html lang="fr">

  <head>
    <title>bfshack</title>
    <link href="../styles/upload.css" rel="stylesheet">
    <meta charset="utf-8">
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
      $env = parse_ini_file(__DIR__ . '/../private.env');
      $host = $env['DB_HOST'];
      $dbname = $env['DB_NAME'];
      $user = $env['DB_USER'];
      $pass = $env['DB_PASS'];
      $hostingProvider = $env['HOSTING_PROVIDER'];

      if (isset($_FILES['image']) && $_FILES['image']['error'] == 0 && getimagesize($_FILES['image']['tmp_name'])) {
        $infoImage = $_FILES['image'];
        $tailleImage = $infoImage['size'];
        $tailleImageMo = round($tailleImage / 1048576, 2);
            
        if ($tailleImage > 52428800 || $_FILES['image']['error'] === UPLOAD_ERR_INI_SIZE) {
          echo "<div id='page' class='container-fluid vh-100 d-flex align-items-center justify-content-center mt-5 mb-5' >
          <div class='row mt-2'>
          <div class='col-md-auto'> ";
          
          echo "<div class='alert alert-danger text-justify' role='alert'>
          L'envoi a échoué, l'image est trop volumineuse : {$tailleImageMo} Mo. <a href='/bfshack/index.php' class='alert-link'>Cliquez ici pour revenir à la page d'accueil</a>. Vous serez redirigé automatiquement dans 5 secondes.
          </div>";
          
          echo "<script>
          setTimeout(function() {
              window.location.href = '/bfshack/index.php';
          }, 5000);
          </script>";
          echo "</div> </div> </div>";
          exit;
            } else {
              $infoNomImage = pathinfo($infoImage['name']);
              $extension = strtolower($infoNomImage['extension']);
              $extensionsAutorisees = ['jpg', 'jpeg', 'png', 'bmp', 'gif', 'webp', 'tif', 'tiff', 'heic', 'avif', 'svg'];

              if (!in_array($extension, $extensionsAutorisees)) {

                echo "<div class='container-fluid vh-100 d-flex align-items-center justify-content-center mt-5 mb-5' id='page'>
                <div class='row mt-2'>
                <div class='col-md-auto'> ";
                
                echo "<div class='alert alert-danger text-justify' role='alert'>
                L'envoi a échoué, l'extension .$extension n'est pas autorisée <a href='/bfshack/index.php' class='alert-link'>Cliquez ici pour revenir à la page d'accueil</a>. Vous serez redirigé automatiquement dans 5 secondes.
                </div>";
                
                echo "<script>
                setTimeout(function() {
                    window.location.href = '/bfshack/index.php';
                }, 5000);
                </script>";
                echo "</div> </div> </div>";
                exit;
                } else {
                  $chemin = dirname(__DIR__) . '/uploads/';
                  if (!is_dir($chemin)) {
                        
                    echo "<div class='container-fluid vh-100 d-flex align-items-center justify-content-center mt-5 mb-5' id='page'>
                    <div class='row mt-2'>
                    <div class='col-md-auto'> ";
                    
                    echo "<div class='alert alert-danger text-justify' role='alert'>
                    L'envoi a échoué, le repertoire est inexistant. <a href='/bfshack/index.php' class='alert-link'>Cliquez ici pour revenir à la page d'accueil</a>. Vous serez redirigé automatiquement dans 5 secondes.
                    </div>";
                    
                    echo "<script>
                    setTimeout(function() {
                        window.location.href = '/bfshack/index.php';
                    }, 5000);
                    </script>";
                    echo "</div> </div> </div>";
                    exit;
                  } elseif (is_dir($chemin)) {
                    $repertoireUpload = dirname(__DIR__) . '/uploads/';
                    $nomImage = $_FILES['image']['name'];
                    $nomImageSansEspaces = str_replace(' ', '_', $nomImage);
                    $nomFinalImage = date('d-m-Y-H-i-s') . uniqid() . "-" . $nomImageSansEspaces;
                    $cheminImage = $repertoireUpload . $nomFinalImage;
                        
                      if (move_uploaded_file($_FILES['image']['tmp_name'], $cheminImage)) {
                        if ($hostingProvider === "server") {
                          $urlImage = "http://195.154.164.26/bfshack/uploads/" . $nomFinalImage;
                        } elseif ($hostingProvider === "local") {
                          $urlImage = "http://localhost/bfshack/uploads/" . $nomFinalImage;
                        } else {
                                
                          echo "<div class='container-fluid vh-100 d-flex align-items-center justify-content-center mt-5 mb-5' id='page'>
                          <div class='row mt-2'>
                          <div class='col-md-auto'> ";
                          
                          echo "<div class='alert alert-danger text-justify' role='alert'>
                          L’envoi a échoué en raison d’une erreur sur le serveur d’hébergement. <a href='/bfshack/index.php' class='alert-link'>Cliquez ici pour revenir à la page d'accueil</a>. Vous serez redirigé automatiquement dans 5 secondes.
                          </div>";
                          
                          echo "<script>
                          setTimeout(function() {
                              window.location.href = '/bfshack/index.php';
                          }, 5000);
                          </script>";
                          echo "</div> </div> </div>";
                          exit; 
                        }
                            
                        echo "<div class='container vh-100 d-flex align-items-center justify-content-center' id='page'>
                        <div class='row w-100'>
                        <div class='col-md-6  mx-auto text-center'>";
                        echo " <a href='$urlImage'><img src='$urlImage' alt='image' class='img-fluid image' ></a>";
                        echo "<button id=\"boutonCopier\" type=\"button\">Copier le lien</button>
                                <input type=\"text\" value=\"$urlImage\" id=\"lienCopier\" readonly> </input>";     
                        echo "<script>
                                const copyBtn = document.getElementById('boutonCopier'); // Le bouton copier
                                const copyText = document.getElementById('lienCopier');  // Le champ à copier
                                let timeoutId;

                                copyBtn.addEventListener('click', function(e) {
                                    e.preventDefault(); // Empêche l'action par défaut

                                    // Sélectionne le texte du champ
                                    copyText.select();
                                    copyText.setSelectionRange(0, 99999); // Compatibilité mobile

                                    // Copie via l'API moderne (si disponible)
                                    if (navigator.clipboard && window.isSecureContext) {
                                        navigator.clipboard.writeText(copyText.value).then(() => {
                                            activerBouton(); // Ajoute la classe active après succès
                                        });
                                    } else {
                                        // Fallback pour anciens navigateurs
                                        document.execCommand('copy');
                                        activerBouton();
                                    }
                                });

                                function activerBouton() {
                                    clearTimeout(timeoutId); // Annule le timer précédent s'il existe

                                    // Ajoute la classe active uniquement pendant 1,5 seconde
                                    copyBtn.classList.add('active');

                                    timeoutId = setTimeout(() => {
                                        copyBtn.classList.remove('active');
                                    }, 50);
                                }
                              </script>";

                        echo "</div> </div> </div>";
                            
                        $page = "Page d'upload";
                        $donnees['ip'] = $_SERVER['REMOTE_ADDR'];
                        $donnees['date'] = date('d/m/Y');
                        $donnees['heure'] = date('H:i:s');
                        $donnees['userAgent'] = $userAgent = $_SERVER['HTTP_USER_AGENT'];
                        
                        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
                        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        
                        $sqlQuery = "INSERT INTO log_upload (page, compte, ip, date, heure, userAgent, image, taille, urlImage) VALUES (:page, :compte, :ip, :date, :heure, :userAgent, :image, :taille, :urlImage)";
                        $stmt = $pdo->prepare($sqlQuery);
                            
                        $stmt->bindParam(':page', $page);
                          if (isset($_SESSION['userName'])) {
                            $stmt->bindParam(':compte', $_SESSION['userName']);
                          }
                          if (!isset($_SESSION['userName'])) {
                            $stmt->bindValue(':compte', "Utilisateur anonyme", PDO::PARAM_STR);
                          }
                              $stmt->bindParam(':ip', $donnees['ip']);
                              $stmt->bindParam(':date', $donnees['date']);
                              $stmt->bindParam(':heure', $donnees['heure']);
                              $stmt->bindParam(':userAgent', $donnees['userAgent']);
                              $stmt->bindParam(':image', $nomFinalImage);
                              $stmt->bindParam(':taille', $tailleImageMo);
                              $stmt->bindParam(':urlImage', $urlImage);   
                              $stmt->execute();
                      } else {
                        echo "<div class='container-fluid vh-100 d-flex align-items-center justify-content-center mt-5 mb-5' id='page'>
                        <div class='row mt-2'>
                        <div class='col-md-auto'> ";
                        
                        echo "<div class='alert alert-danger text-justify' role='alert'>
                        L'envoi a échoué. <a href='/bfshack/index.php' class='alert-link'>Cliquez ici pour revenir à la page d'accueil</a>. Vous serez redirigé automatiquement dans 5 secondes.
                        </div>";
                        
                        echo "<script>
                        setTimeout(function() {
                        window.location.href = '/bfshack/index.php';
                        }, 5000);
                        </script>";
                        echo "</div> </div> </div>";
                        exit;
                      }                           
                   }
                }
            }
      } else {
        if (isset($_FILES['image']) && $_FILES['image']['error'] === 4)  {
          echo "<div class='container-fluid vh-100 d-flex align-items-center justify-content-center mt-5 mb-5' id='page'>
          <div class='row mt-2'>
          <div class='col-md-auto'> ";
          
          echo "<div class='alert alert-danger text-justify' role='alert'>
          L’envoi a échoué, l’image est introuvable. <a href='/bfshack/index.php' class='alert-link'>Cliquez ici pour revenir à la page d'accueil</a>. Vous serez redirigé automatiquement dans 5 secondes.
          </div>";
          
          echo "<script>
          setTimeout(function() {
              window.location.href = '/bfshack/index.php';
          }, 5000);
          </script>";
          echo "</div> </div> </div>";
          exit;
        } elseif (isset($_FILES['image']) && $_FILES['image']['error']) {
          echo "<div class='container-fluid vh-100 d-flex align-items-center justify-content-center mt-5 mb-5' id='page'>
          <div class='row mt-2'>
          <div class='col-md-auto'> ";
          echo "<div class='alert alert-danger text-justify' role='alert'>
          L'envoi a échoué, l'image comporte une erreur. <a href='/bfshack/index.php' class='alert-link'>Cliquez ici pour revenir à la page d'accueil</a>. Vous serez redirigé automatiquement dans 5 secondes.
          </div>";
          
          echo "<script>
          setTimeout(function() {
              window.location.href = '/bfshack/index.php';
          }, 5000);
          </script>";
          echo "</div> </div> </div>";
          exit;
        } elseif (!getimagesize($_FILES['image']['tmp_name'])) {
          echo "<div class='container-fluid vh-100 d-flex align-items-center justify-content-center mt-5 mb-5' id='page'>
          <div class='row mt-2'>
          <div class='col-md-auto'> ";
          
          echo "<div class='alert alert-danger text-justify' role='alert'>
          L'envoi a échoué, le fichier n'est pas une image. <a href='/bfshack/index.php' class='alert-link'>Cliquez ici pour revenir à la page d'accueil</a>. Vous serez redirigé automatiquement dans 5 secondes.
          </div>";
          
          echo "<script>
          setTimeout(function() {
              window.location.href = '/bfshack/index.php';
          }, 5000);
          </script>";
          echo "</div> </div> </div>";
          exit;
        }
      }
    ?>
            
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
            
  </body>
          
</html>
        