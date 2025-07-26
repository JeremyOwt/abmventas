<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once "entidades/usuario.php";
include_once "config.php";

$claveEncriptada = password_hash("admin123", PASSWORD_DEFAULT);

//Es postback?
if ($_POST) {
  $txtUsuario = $_POST["txtUsuario"];
  $txtClave = $_POST["txtClave"];

  $entidadUsuario = new Usuario();
  $entidadUsuario->obtenerPorUsuario($txtUsuario);

  if ($txtUsuario == $entidadUsuario->usuario && password_verify($txtClave, $entidadUsuario->clave)) {
    $_SESSION["nombre"] = $entidadUsuario->nombre . " " . $entidadUsuario->apellido;
    header("location: index.php");

    //Si no es correcto la clave o el usuario mostrar en pantalla "Usuario o clave incorrecto"
  } else {
    $msg = "Usuario o clave incorrecto";
  }
}



?>
<!DOCTYPE html>
<html lang="es">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>SB Admin 2 - Login</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

  <div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-10 col-lg-12 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-6 d-none d-lg-block bg-login-image d-flex align-items-center justify-content-center">
                <svg id="animated-svg" width="500" height="500" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
                  <!-- Laptop base -->
                  <rect x="50" y="120" width="100" height="50" fill="#4e73df" rx="8" />

                  <!-- Laptop screen -->
                  <rect x="55" y="80" width="90" height="45" fill="#ffffff" stroke="#2e59d9" stroke-width="2" rx="4" />

                  <!-- Head -->
                  <circle id="head" cx="100" cy="60" r="15" fill="#f6c23e" />

                  <!-- Body -->
                  <path id="body" d="M85 75 Q100 90 115 75 Q110 100 90 100 Z" fill="#36b9cc" />

                  <!-- Hands -->
                  <circle cx="80" cy="85" r="5" fill="#f6c23e" />
                  <circle cx="120" cy="85" r="5" fill="#f6c23e" />
                </svg>
              </div>


              <div class="col-lg-6">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Bienvenido</h1>
                  </div>
                  <form action="" method="POST" class="user">
                    <?php if (isset($msg)): ?>
                      <div class="alert alert-danger" role="alert">
                        <?php echo $msg; ?>
                      </div>
                    <?php endif; ?>
                    <div class="form-group">
                      <input type="text" class="form-control form-control-user" id="txtUsuario" name="txtUsuario" aria-describedby="emailHelp" placeholder="Usuario">
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control form-control-user" id="txtClave" name="txtClave" placeholder="Clave">
                    </div>
                    <div class="form-group">
                      <div class="custom-control custom-checkbox small">
                        <input type="checkbox" class="custom-control-input" id="customCheck">
                        <label class="custom-control-label" for="customCheck">Recordarme</label>
                      </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-user btn-block">
                      Entrar
                    </button>
                  </form>
                  <hr>
                  <div class="text-center">
                    <a class="small" href="forgot-password.html">Olvidaste la clave?</a>
                  </div>
                  <div class="text-center">
                    <a class="small" href="register.html">Crear una cuenta!</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>

  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>
  <!-- Custom scripts for this page-->
  <!-- Anime.js CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>

<script>
  anime({
    targets: '#head',
    translateY: [-5, 5],
    direction: 'alternate',
    loop: true,
    duration: 1000,
    easing: 'easeInOutSine'
  });

  anime({
    targets: '#body',
    scale: [1, 1.05],
    direction: 'alternate',
    loop: true,
    duration: 2000,
    easing: 'easeInOutQuad'
  });
</script>


</body>

</html>