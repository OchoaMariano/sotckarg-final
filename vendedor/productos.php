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

// OPERACIONES CRUD SOBRE LA TABLA PRODUCTOS

// Obtenemos los productos del usurio
$sql = "SELECT * FROM Producto WHERE id_usuario = '$id_usuario'";
$result = mysqli_query($conexion, $sql);

// Si no se puede ejecutar la consulta, mostrar error
if (!$result) {
  echo "Error en la consulta: " . mysqli_error($conexion);
}
// Si no hay productos, mostrar mensaje
if (mysqli_num_rows($result) == 0) {
  echo "No hay productos";
}

// Si hay productos, guardarlos en un array
$productos = mysqli_fetch_all($result, MYSQLI_ASSOC);


// CRUD --> CREAR -> Si presionamos el boton de borrar
if (isset($_POST['crear'])) {
  echo "Crear producto";
  // Obtenemos los datos del formulario
  $nombre_producto = $_POST['nombre_n'];
  $descripcion = $_POST['descripcion_n'];
  $precio = $_POST['precio_n'];
  $stock = $_POST['stock_n'];

  // Insertamos el producto en la base de datos
  $sql = "INSERT INTO Producto (nombre, descripcion, stock, precio, id_usuario) 
  VALUES ('$nombre_producto', '$descripcion','$stock', '$precio', '$id_usuario')";
  $result = mysqli_query($conexion, $sql);

  // Si no se puede ejecutar la consulta, mostrar error
  if (!$result) {
    echo "Error en la consulta: " . mysqli_error($conexion);
  }
  echo "Producto creado";
  // Redireccionamos a la pagina de productos
  header("Location: productos.php");
  
}

// CRUD --> EDITAR / ACTUALIZAR -> Si presionamos el boton de editar
if (isset($_POST['editar'])) {

  $id_producto = $_POST['id_producto'];
  $nombre_producto = $_POST['nombre_producto'];
  $descripcion = $_POST['descripcion'];
  $precio = $_POST['precio'];
  $stock = $_POST['stock'];

  $sql = "UPDATE Producto SET nombre_producto = '$nombre_producto', descripcion = '$descripcion', precio = '$precio', stock = '$stock' WHERE id_producto = '$id_producto'";
  $result = mysqli_query($conexion, $sql);
  if (!$result) {
    echo "Error en la consulta: " . mysqli_error($conexion);
  }
  header("Location: productos.php");
}

// CRUD --> BORRAR -> Si presionamos el boton de borrar
if (isset($_POST['borrar'])) {
  // Obtenemos el id del producto seleccionado
  $id_producto = $_POST['id_producto_seleccionado'];
  // Eliminamos el producto de la base de datos
  $sql = "DELETE FROM Producto WHERE id = '$id_producto'";
  mysqli_query($conexion, $sql);
  // Si no se puede ejecutar la consulta, mostrar error
  if (!$result) {
    echo "Error en la consulta: " . mysqli_error($conexion);
  }
  // Redireccionamos a la pagina de productos
  header("Location: productos.php");
}


?>





<!DOCTYPE html>

<html
  lang="en"
  class="light-style layout-menu-fixed"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="../assets/"
  data-template="vertical-menu-template-free">
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />

    <title>Productos | Stockarg</title>

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
            <a href="/stockarg-v1/vendedor/dashboard.php" class="app-brand-link">
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
              <a href="dashboard.php" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Dashboard</div>
              </a>
            </li>

            <li class="menu-header small text-uppercase">
              <span class="menu-header-text">Productos</span>
            </li>

            <!-- Productos -->
            <li class="menu-item active">
              <a href="productos.php" class="menu-link">
                 <i class="menu-icon tf-icons bx bx-collection"></i>
                <div data-i18n="Analytics">Productos</div>
              </a>
            </li>

            <!-- Operaciones / Ventas -->
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
            <li class="menu-item ">
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

          <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar" >
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
                    placeholder="B??scar..."
                    aria-label="B??scar..."
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
                              <?php echo $nombre; ?>
                            </span>
                            <small class="text-muted">
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
                        <span class="align-middle">Cerrar sesi??n</span>
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
                  <h4 class="fw-bold py-3 mb-4">
                    <span class="text-muted fw-light">Productos /</span> Listado de tus productos
                  </h4>
                </div>
                <div class="col-4">
                  <button
                  type="button"
                  class="btn btn-primary"
                  data-bs-toggle="modal"
                  data-bs-target="#modalCenter"
                  >
                  Agregar Nuevo Producto
                  </button>
                </div>
                
                
              </div>
              
              <!-- MODAL > AGREGAR PRODUCTO -->
              <div class="modal fade" id="modalCenter" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                <form method="post">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="modalCenterTitle">Crear Producto</h5>
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
                          <label for="emailWithTitle" class="form-label">Nombre</label>
                          <input
                            name="nombre_n"
                            type="text"
                            id="emailWithTitle"
                            class="form-control"
                            placeholder="Ingrese el nombre del producto"
                          />
                        </div>
                        <div class="col mb-0">
                          <label for="dobWithTitle" class="form-label">Descripcion</label>
                          <input
                            type="text"
                            name="descripcion_n"
                            id="dobWithTitle"
                            class="form-control"
                            placeholder="Ingrese la descripcion del producto"
                          />
                        </div>
                      </div>
                      <div class="row g-2 mb-3">
                        <div class="col mb-0">
                          <label for="emailWithTitle" class="form-label">Stock</label>
                          <input
                            name="stock_n"
                            type="number"
                            id="emailWithTitle"
                            class="form-control"
                            placeholder="Ingrese el stock del producto"
                          />
                        </div>
                        <div class="col mb-0">
                          <label for="dobWithTitle" class="form-label">Precio</label>
                          <input
                            name="precio_n"
                            type="number"
                            id="precio"
                            class="form-control"
                            placeholder="Ingrese el precio del producto"
                          />
                        </div>
                      </div>
                      
                    
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Close
                      </button>
                      <button type="submit" name="crear" class="btn btn-primary" data-bs-dismiss="modal">Crear prodcuto</button>
                    </div>
                  </form>
                  </div>
                </div>
              </div>

              <!-- Hoverable Table rows -->
              <div class="card">
                <h5 class="card-header">Productos</h5>
                <div class="table-responsive text-nowrap">
                  <table class="table table-hover">
                    <thead>
                      <tr>
                        <th style="width:20px;">id</th>
                        <th>Nombre</th>
                        <th>Descripci??n</th>
                        <th>Stock</th>
                        <th>Precio</th>
                        <th>Acciones</th>
                      </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                      <?php foreach($productos as $producto): ?>
                        <tr>
                          <td>
                            <?= $producto['id']; ?>
                          </td>
                          <td>
                            <strong>
                              <?= $producto['nombre']; ?>
                            </strong>
                          </td>
                          <td class="descripcion__table">
                            <?= $producto['descripcion']; ?>
                          </td>
                          <td>
                            <?= $producto['stock']; ?>
                          </td>
                          <td>
                            $<?= $producto['precio']; ?>
                          </td>
                          <td>
                            <div class="dropdown">
                              <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                <i class="bx bx-dots-vertical-rounded"></i>
                              </button>
                              <div class="dropdown-menu">
                              <button
                                type="button"
                                class="dropdown-item"
                                data-bs-toggle="modal"
                                data-bs-target="#modalCenterEdit"
                                >
                              <i class="bx bx-edit-alt me-1"></i> Editar
                              </button>
                              
                                <form method="post">
                                  <input type="hidden" name="id_producto_seleccionado" value="<?= $producto['id']; ?>">
                                  <button class="dropdown-item" type="submit" name="borrar">
                                    <i class="bx bx-trash me-1"></i>
                                    Borrar
                                  </button>
                                </form>
                                
                              </div>
                            </div>
                          </td>
                        </tr>
                        <!-- MODAL > EDITAR -->
                        <div class="modal fade" id="modalCenterEdit" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                              <form method="post">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="modalCenterTitle">Editar Producto</h5>
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
                                        <label for="emailWithTitle" class="form-label">Nombre</label>
                                        <input
                                          name="nombre_n"
                                          type="text"
                                          id="emailWithTitle"
                                          class="form-control"
                                          placeholder="Ingrese el nombre del producto"
                                          value="<?= $producto['nombre']; ?>"
                                        />
                                      </div>
                                      <div class="col mb-0">
                                        <label for="dobWithTitle" class="form-label">Descripcion</label>
                                        <input
                                          type="text"
                                          name="descripcion_n"
                                          id="dobWithTitle"
                                          class="form-control"
                                          placeholder="Ingrese la descripcion del producto"
                                          value="<?= $producto['descripcion']; ?>"
                                        />
                                      </div>
                                    </div>
                                    <div class="row g-2 mb-3">
                                      <div class="col mb-0">
                                        <label for="emailWithTitle" class="form-label">Stock</label>
                                        <input
                                          name="stock_n"
                                          type="number"
                                          id="emailWithTitle"
                                          class="form-control"
                                          placeholder="Ingrese el stock del producto"
                                          value="<?= $producto['stock']; ?>"
                                        />
                                      </div>
                                      <div class="col mb-0">
                                        <label for="dobWithTitle" class="form-label">Precio</label>
                                        <input
                                          name="precio_n"
                                          type="number"
                                          id="precio"
                                          class="form-control"
                                          placeholder="Ingrese el precio del producto"
                                          value="<?= $producto['precio']; ?>"
                                        />
                                      </div>
                                    </div>
                                    <div class="row">
                                      <div class="col mb-3">
                                        <label for="nameWithTitle" class="form-label">Fecha</label>
                                        <input
                                          name="fecha_n"
                                          type="date"
                                          id="nameWithTitle"
                                          class="form-control"
                                          placeholder="Ingrese la fecha del producto"
                                        />
                                      </div>
                                    </div>
                                  
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                      Close
                                    </button>
                                    <button type="submit" name="editar" class="btn btn-primary" data-bs-dismiss="modal">Editar producto</button>
                                </div>
                              </form>
                              </div>
                            </div>
                        </div>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>
              </div>
              <!--/ Hoverable Table rows -->

             

              
            </div>
            <!-- / Content -->

            <!-- Footer -->
            <footer class="content-footer footer bg-footer-theme" >
              <div class="container-xxl d-flex flex-wrap justify-content-end py-2 flex-md-row flex-column">
                <div class="mb-2 mb-md-0">
                  ??
                  <script>
                    document.write(new Date().getFullYear());
                  </script>
                  , hecho con ?????? 
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
