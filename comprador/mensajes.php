<?php 

// Incluimos el archivo de config con la conexion a la base de datos
include "../config.php";

// Iniciamos la sesion
session_start();
error_reporting(1);

// Obtenemos el nombre de usuario y el nombre del usuario
$nombre_usuario = $_SESSION['nombre_usuario'];
$nombre = $_SESSION['nombre'];
$id_usuario = $_SESSION['id_usuario'];
$rol_id = $_SESSION['id_rol'];

//Recuperar registro de la tabla "Rol" que corresponde al ID del atributo
$sql = "SELECT * FROM Rol WHERE id='$rol_id'";
$result = mysqli_query($conexion, $sql);
$atributo = mysqli_fetch_assoc($result);
$nombre_rol = $atributo['nombre_rol'];

//Obtenemos los mensajes recibidos del usuario y hacemos un JOIN con la tabla Usuario para obtener el nombre del remitente
$sql_mr = "SELECT Usuario.nombre AS remitente, Mensaje.id, Mensaje.mensaje FROM Mensaje JOIN Usuario ON Mensaje.id_remitente = Usuario.id WHERE Mensaje.id_destinatario = '$id_usuario'";
$result_mr = mysqli_query($conexion, $sql_mr);
$mensajes_r = mysqli_fetch_all($result_mr, MYSQLI_ASSOC);

//Obtenemos los mensajes enviados del usuario y hacemos un JOIN con la tabla Usuario para obtener el nombre del destinatario
$sql_me = "SELECT Usuario.nombre AS destinatario, Mensaje.id, Mensaje.mensaje FROM Mensaje JOIN Usuario ON Mensaje.id_destinatario = Usuario.id WHERE Mensaje.id_remitente = '$id_usuario'";
$result_me = mysqli_query($conexion, $sql_me);
$mensajes_e = mysqli_fetch_all($result_me, MYSQLI_ASSOC);


//Obtenemos el listado de usuarios vendedores
$sql_uc = "SELECT * FROM Usuario WHERE id_rol=1";
$users_c = mysqli_query($conexion, $sql_uc);


//Hacemos el envio de un mensaje
if(isset($_POST['enviar'])){
    $id_remitente = $_POST['id_usuario_remitente'];
    $id_destinatario = $_POST['id_destinatario'];
    $mensaje = $_POST['mensaje'];

    $sql = "INSERT INTO Mensaje (id_remitente, id_destinatario, mensaje, fecha) VALUES ('$id_remitente', '$id_destinatario', '$mensaje', NOW())";
    $result = mysqli_query($conexion, $sql);

    if($result){
        echo "<script>alert('Mensaje enviado correctamente')</script>";
    }else{
        echo "<script>alert('Error al enviar el mensaje')</script>";
    }
    // Redireccionamos a la pagina de productos
    header("Location: mensajes.php");
}

?>

<!DOCTYPE html>

<html
  lang="en"
  class="light-style layout-menu-fixed"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="../assets/"
  data-template="vertical-menu-template-free"
>
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />

    <title>Mensajes | Stockarg</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet"
    />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="../assets/vendor/fonts/boxicons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="../assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="../assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="../assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="../assets/vendor/js/helpers.js"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="../assets/js/config.js"></script>
  </head>

  <body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
        <!-- Menu -->

        <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
          <div class="app-brand demo">
            <a href="/stockarg-v1/comprador/home.php" class="app-brand-link">
              <span class="app-brand-logo demo">
                <svg
                  width="25"
                  viewBox="0 0 25 42"
                  version="1.1"
                  xmlns="http://www.w3.org/2000/svg"
                  xmlns:xlink="http://www.w3.org/1999/xlink"
                >
                  <defs>
                    <path
                      d="M13.7918663,0.358365126 L3.39788168,7.44174259 C0.566865006,9.69408886 -0.379795268,12.4788597 0.557900856,15.7960551 C0.68998853,16.2305145 1.09562888,17.7872135 3.12357076,19.2293357 C3.8146334,19.7207684 5.32369333,20.3834223 7.65075054,21.2172976 L7.59773219,21.2525164 L2.63468769,24.5493413 C0.445452254,26.3002124 0.0884951797,28.5083815 1.56381646,31.1738486 C2.83770406,32.8170431 5.20850219,33.2640127 7.09180128,32.5391577 C8.347334,32.0559211 11.4559176,30.0011079 16.4175519,26.3747182 C18.0338572,24.4997857 18.6973423,22.4544883 18.4080071,20.2388261 C17.963753,17.5346866 16.1776345,15.5799961 13.0496516,14.3747546 L10.9194936,13.4715819 L18.6192054,7.984237 L13.7918663,0.358365126 Z"
                      id="path-1"
                    ></path>
                    <path
                      d="M5.47320593,6.00457225 C4.05321814,8.216144 4.36334763,10.0722806 6.40359441,11.5729822 C8.61520715,12.571656 10.0999176,13.2171421 10.8577257,13.5094407 L15.5088241,14.433041 L18.6192054,7.984237 C15.5364148,3.11535317 13.9273018,0.573395879 13.7918663,0.358365126 C13.5790555,0.511491653 10.8061687,2.3935607 5.47320593,6.00457225 Z"
                      id="path-3"
                    ></path>
                    <path
                      d="M7.50063644,21.2294429 L12.3234468,23.3159332 C14.1688022,24.7579751 14.397098,26.4880487 13.008334,28.506154 C11.6195701,30.5242593 10.3099883,31.790241 9.07958868,32.3040991 C5.78142938,33.4346997 4.13234973,34 4.13234973,34 C4.13234973,34 2.75489982,33.0538207 2.37032616e-14,31.1614621 C-0.55822714,27.8186216 -0.55822714,26.0572515 -4.05231404e-15,25.8773518 C0.83734071,25.6075023 2.77988457,22.8248993 3.3049379,22.52991 C3.65497346,22.3332504 5.05353963,21.8997614 7.50063644,21.2294429 Z"
                      id="path-4"
                    ></path>
                    <path
                      d="M20.6,7.13333333 L25.6,13.8 C26.2627417,14.6836556 26.0836556,15.9372583 25.2,16.6 C24.8538077,16.8596443 24.4327404,17 24,17 L14,17 C12.8954305,17 12,16.1045695 12,15 C12,14.5672596 12.1403557,14.1461923 12.4,13.8 L17.4,7.13333333 C18.0627417,6.24967773 19.3163444,6.07059163 20.2,6.73333333 C20.3516113,6.84704183 20.4862915,6.981722 20.6,7.13333333 Z"
                      id="path-5"
                    ></path>
                  </defs>
                  <g id="g-app-brand" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                    <g id="Brand-Logo" transform="translate(-27.000000, -15.000000)">
                      <g id="Icon" transform="translate(27.000000, 15.000000)">
                        <g id="Mask" transform="translate(0.000000, 8.000000)">
                          <mask id="mask-2" fill="white">
                            <use xlink:href="#path-1"></use>
                          </mask>
                          <use fill="#696cff" xlink:href="#path-1"></use>
                          <g id="Path-3" mask="url(#mask-2)">
                            <use fill="#696cff" xlink:href="#path-3"></use>
                            <use fill-opacity="0.2" fill="#FFFFFF" xlink:href="#path-3"></use>
                          </g>
                          <g id="Path-4" mask="url(#mask-2)">
                            <use fill="#696cff" xlink:href="#path-4"></use>
                            <use fill-opacity="0.2" fill="#FFFFFF" xlink:href="#path-4"></use>
                          </g>
                        </g>
                        <g
                          id="Triangle"
                          transform="translate(19.000000, 11.000000) rotate(-300.000000) translate(-19.000000, -11.000000) "
                        >
                          <use fill="#696cff" xlink:href="#path-5"></use>
                          <use fill-opacity="0.2" fill="#FFFFFF" xlink:href="#path-5"></use>
                        </g>
                      </g>
                    </g>
                  </g>
                </svg>
              </span>
              <span class="app-brand-text demo menu-text fw-bolder ms-2">Stockarg</span>
            </a>

            <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
              <i class="bx bx-chevron-left bx-sm align-middle"></i>
            </a>
          </div>

          <div class="menu-inner-shadow"></div>

          <ul class="menu-inner py-1">
            <!-- Dashboard -->
            <li class="menu-item">
              <a href="home.php" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Home</div>
              </a>
            </li>

            <li class="menu-header small text-uppercase">
              <span class="menu-header-text">Compras</span>
            </li>

            <!-- Operaciones / Ventas -->
            <li class="menu-item ">
              <a href="compras.php" class="menu-link">
              <i class="menu-icon tf-icons bx bx-collection"></i>
                <div data-i18n="Analytics">Compras</div>
              </a>
            </li>

            <!-- Operaciones / Compras -->
            <li class="menu-item ">
              <a href="operaciones.php" class="menu-link">
                <i class="menu-icon tf-icons bx bx-copy"></i>
                <div data-i18n="Analytics">Operaciones</div>
              </a>
            </li>

            <li class="menu-header small text-uppercase">
              <span class="menu-header-text">Notificaciones</span>
            </li>

            <!-- Mensajes -->
            <li class="menu-item active">
              <a href="mensajes.php" class="menu-link">
                <i class="menu-icon tf-icons bx bx-detail"></i>
                <div data-i18n="Analytics">Mensajes</div>
              </a>
            </li>

          </ul>
          
        </aside>
        <!-- / Menu -->

        <!-- Layout container -->
        <div class="layout-page">
          <!-- Navbar -->

          <nav  class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
            <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
              <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                <i class="bx bx-menu bx-sm"></i>
              </a>
            </div>

            <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
              <!-- Search -->
              <div class="navbar-nav align-items-center">
                <div class="nav-item d-flex align-items-center">
                  <i class="bx bx-search fs-4 lh-0"></i>
                  <input
                    type="text"
                    class="form-control border-0 shadow-none"
                    placeholder="Búscar..."
                    aria-label="Búscar..."
                  />
                </div>
              </div>
              <!-- /Search -->

              <ul class="navbar-nav flex-row align-items-center ms-auto">
                

                <!-- User -->
                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                  <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <div class="avatar avatar-online">
                      <img src="../assets/img/avatars/1.png" alt class="w-px-40 h-auto rounded-circle" />
                    </div>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                      <a class="dropdown-item" href="#">
                        <div class="d-flex">
                          <div class="flex-shrink-0 me-3">
                            <div class="avatar avatar-online">
                              <img src="../assets/img/avatars/1.png" alt class="w-px-40 h-auto rounded-circle" />
                            </div>
                          </div>
                          <div class="flex-grow-1">
                            <span class="fw-semibold d-block">
                              <!-- IMPRIMIMOS EL VALOR DE NOMBRE DEL USUARIO -->
                              <?php echo $nombre; ?>
                            </span>
                            <small class="text-muted">
                              <!-- IMPRIMIMOS EL ROL DE NOMBRE DEL USUARIO -->
                              <?php echo $nombre_rol; ?>
                            </small>
                            
                          </div>
                        </div>
                      </a>
                    </li>
                    <li>
                      <div class="dropdown-divider"></div>
                    </li>
                    <li>
                      <a class="dropdown-item" href="../logout.php">
                        <i class="bx bx-power-off me-2"></i>
                        <span class="align-middle">Cerrar sesión</span>
                      </a>
                    </li>
                  </ul>
                </li>
                <!--/ User -->
              </ul>
            </div>
          </nav>

          <!-- / Navbar -->

          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
              <div class="header__section row">
                <div class="col-8">
                  <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Mensajes /</span> Tus Mensajes</h4>
                  </div>
                <div class="col-4">
                  <button
                  type="button"
                  class="btn btn-primary"
                  data-bs-toggle="modal"
                  data-bs-target="#modalCenter"
                  >
                  Enviar nuevo mensaje
                  </button>
                </div>
              </div>
              
              <!-- MODAL > AGREGAR PRODUCTO -->
              <div class="modal fade" id="modalCenter" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                <form method="post">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="modalCenterTitle">Enviar mensaje</h5>
                      <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                      ></button>
                    </div>
                    <div class="modal-body">
                    
                      <div class="row g-2 mb-3">
                        <div class="col mb-0">
                          <label for="defaultSelect" class="form-label">Selecciona un destinatario</label>
                          <select name="id_destinatario" id="defaultSelect" class="form-select">
                            <option>Seleccionar</option>
                            <?php foreach($users_c as $user): ?>
                              <option value="<?= $user['id']; ?>"><?= $user['nombre']; ?></option>
                            <?php endforeach; ?>
                          </select>     
                        </div>
                      </div>
                      <div class="row g-2 mb-3">
                        <div class="col mb-0">
                          <label for="dobWithTitle" class="form-label">Mensaje</label>
                          <textarea
                            type="text"
                            name="mensaje"
                            id="dobWithTitle"
                            class="form-control"
                            placeholder="Ingrese la descripcion del producto"
                          >
                          </textarea>
                          <input type="hidden" name="id_usuario_remitente" value="<?= $id_usuario; ?>">
                        </div>
                      </div>
                      
                    
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Close
                      </button>
                      <button type="submit" name="enviar" class="btn btn-primary" data-bs-dismiss="modal">Enviar mensaje</button>
                    </div>
                  </form>
                  </div>
                </div>
              </div>
              

              <!-- MENSAJES RECIBIDOS -->
              <div class="card">
                <h5 class="card-header">Mensajes Recibidos</h5>
                <div class="table-responsive text-nowrap">
                  <table class="table table-hover">
                    <thead>
                      <tr>
                        <th>#ID Mensaje</th>
                        <th>Comprador</th>
                        <th>Mensaje</th>
                        
                      </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                    <?php foreach($mensajes_r as $mr): ?>
                      <tr>
                        <td>
                          <?= $mr['id']; ?>
                        </td>
                        <td>
                          <i class="fab fa-angular fa-lg text-danger me-3"></i> 
                          <strong>
                            <?= $mr['remitente']; ?>
                          </strong>
                        </td>
                        <td>
                          <?= $mr['mensaje']; ?>
                        </td>
                        
                        
                      </tr>
                    <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>
              </div>
              <!--/ MENSAJES RECIBIDOS -->
              <hr class="my-5" />
              <!-- MENSAJES ENVIADOS -->
              <div class="card">
                <h5 class="card-header">Mensajes Enviados</h5>
                <div class="table-responsive text-nowrap">
                  <table class="table table-hover">
                    <thead>
                      <tr>
                        <th>#ID Mensaje</th>
                        <th>Destinatario</th>
                        <th>Mensaje</th>
                        
                      </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                    <?php foreach($mensajes_e as $me): ?>
                      <tr>
                        <td><?= $me['id']; ?></td>
                        <td>
                          <i class="fab fa-angular fa-lg text-danger me-3"></i> 
                          <strong><?= $me['destinatario']; ?></strong>
                        </td>
                        <td>
                          <?= $me['mensaje']; ?>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>
              </div>
              <!--/ MENSAJES ENVIADOS -->
              
            </div>
            <!-- / Content -->

            <!-- Footer -->
            <footer class="content-footer footer bg-footer-theme" >
              <div class="container-xxl d-flex flex-wrap justify-content-end py-2 flex-md-row flex-column">
                <div class="mb-2 mb-md-0">
                  ©
                  <script>
                    document.write(new Date().getFullYear());
                  </script>
                  , hecho con ❤️ 
                  <a href="https://themeselection.com" target="_blank" class="footer-link fw-bolder"></a>
                </div>
               
              </div>
            </footer>
            <!-- / Footer -->

            <div class="content-backdrop fade"></div>
          </div>
          <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
      </div>

      <!-- Overlay -->
      <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="../assets/vendor/libs/jquery/jquery.js"></script>
    <script src="../assets/vendor/libs/popper/popper.js"></script>
    <script src="../assets/vendor/js/bootstrap.js"></script>
    <script src="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

    <script src="../assets/vendor/js/menu.js"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->

    <!-- Main JS -->
    <script src="../assets/js/main.js"></script>

    <!-- Page JS -->

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
  </body>
</html>
