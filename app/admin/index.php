<?php
session_start();
require_once '../../conexao/conexao.php';

$conexao=ligar();

if(!isset($_SESSION['usuario']) && !isset($_SESSION['idusuario'])) {
    header('Location: ../../marketplace/login.php');
    exit();
}

?>
<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>Sistema de gestão Imobiliaria</title>
<!-- Font Awesome Icons -->
<link rel="stylesheet" href="../assets/plugins/fontawesome-free/css/all.min.css">
<!-- Ionicons -->
<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
<!-- overlayScrollbars -->
<link rel="stylesheet" href="../assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
<!-- daterangepicker -->
<link rel="stylesheet" href="../assets/plugins/daterangepicker/daterangepicker.css">
<!-- iCheck -->
<link rel="stylesheet" href="../assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
<!-- Bootstrap Color Picker -->
<link rel="stylesheet" href="../assets/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
<!-- Tempusdominus Bootstrap 4 -->
<link rel="stylesheet" href="../assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
<!-- Select2 -->
<link rel="stylesheet" href="../assets/plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="../assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
<!-- Bootstrap4 Duallistbox -->
<link rel="stylesheet" href="../assets/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
<!-- Theme style -->
<link rel="stylesheet" href="../assets/dist/css/adminlte.min.css">
<!-- Google Font: Source Sans Pro -->
<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="?page=painel" class="nav-link">Home</a>
      </li>
      
    </ul>

    <!-- SEARCH FORM -->
    <form class="form-inline ml-3" method="POST">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" type="search" name="pesquisar" placeholder="Pesquisar" aria-label="Pesquisar">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-comments"></i>
          <span class="badge badge-danger navbar-badge">3</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="../assets/dist/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Brad Diesel
                  <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">Call me whenever you can...</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="../assets/dist/img/user8-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  John Pierce
                  <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">I got your message bro</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="../assets/dist/img/user3-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Nora Silvester
                  <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">The subject goes here</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
        </div>
      </li>
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="fas fa-cog"></i>
          <span class="badge badge-warning navbar-badge"></span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">Configurações</span>
          <div class="dropdown-divider"></div>
          <a  class="dropdown-item" data-toggle="modal" data-target="#modal-senha">
            <i class="fas fa-key mr-2"></i> Mudar Senha
            <span class="float-right text-muted text-sm"></span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="../../controller/login_controller.php?acao=logout" class="dropdown-item">
            <i class="fas fa-sign-out-alt mr-2"></i> Terminar Sessão
            <span class="float-right text-muted text-sm"></span>
          </a>
          
          
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#"><i
            class="fas fa-th-large"></i></a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="../assets/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">SGI- Imobiliária</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="../assets/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?=$_SESSION['nome'];?></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item has-treeview menu-open">
            <a href="?page=painel" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Painel Princípal
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            
          </li>
          <li class="nav-item">
            <a href="?page=imovel" class="nav-link">
              <i class="nav-icon fas fa-home"></i>
              <p>
                Imóvel 
                <span class="right badge badge-danger"></span>
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="?page=proprietario" class="nav-link">
              <i class="nav-icon fas fa-user"></i>
              <p>
                Proprietário
                <span class="right badge badge-danger"></span>
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="?page=usuarios" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Usuário
                <span class="right badge badge-danger"></span>
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="?page=cliente" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Cliente
                <span class="right badge badge-danger"></span>
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="?page=contrato" class="nav-link">
              <i class="nav-icon fas fa-file"></i>
              <p>
                Contratos
                <span class="right badge badge-danger"></span>
              </p>
            </a>
          </li>
         
         
          <!--<li class="nav-item has-treeview">
            <a href="?page=imovel" class="nav-link">
              <i class="nav-icon fas fa-tree"></i>
              <p>
               Imóvel
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="assets/pages/UI/general.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>General</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="assets/pages/UI/icons.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Icons</p>
                </a>
              </li>
              </ul>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-edit"></i>
              <p>
                Contratos
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="assets/pages/forms/general.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>General Elements</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="assets/pages/forms/advanced.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Advanced Elements</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="assets/pages/forms/editors.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Editors</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/forms/validation.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Validation</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Visitas
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="pages/tables/simple.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Simple Tables</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/tables/data.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>DataTables</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/tables/jsgrid.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>jsGrid</p>
                </a>
              </li>
            </ul>
          </li>-->
           </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>


  <!-- Content Wrapper. Contains page content -->
  <?php

if(isset($_GET['page'])) {
    include($_GET['page'].'.php');
}
  else {
    include('painel.php');
  }


?>





  <div class="modal fade show" id="modal-senha" style="display:none; padding-right: 15px;" aria-modal="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Alterar Senha</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <form action="../../controller/usuario_controller.php?acao=alterarsenha" method="POST">
            <div class="modal-body">
             <div class="card-body" data-select2-id="30">
                <div class="row" data-select2-id="53">
              <div class="col-md-6">
             <div class="form-group">
                    <label for="exampleInputEmail1">Senha Antiga</label>
                    <input type="password" name="senhaantiga" class="form-control" id="senhaantiga" placeholder="Digite a senha antiga">
                  </div>
             </div>
              <div class="col-md-6">
             <div class="form-group">
                    <label for="exampleInputEmail1">Nova Senha</label>
                    <input type="password" name="novasenha" class="form-control" id="novasenha" placeholder="Digite a nova senha">
                    <input type="hidden" name="id" class="form-control" id="id">
                  </div>
             </div>
              <div class="col-md-6">
             <div class="form-group">
                    <label for="exampleInputEmail1">Confirma-senha</label>
                    <input type="password" name="confirmar-senha" class="form-control" id="confirmar-senha" placeholder="Confirme a senha">
                  </div>
             </div>
            </div>
             
            </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Sair</button>
              <button type="button" class="btn btn-primary">Gravar</button>
            </div>
            </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>





  <!-- /.content-wrapper -->

  <footer class="main-footer">
    <strong>Copyright &copy; 2025/2026 </strong>
    .
    <div class="float-right d-none d-sm-inline-block">
      <b>Versão</b> 1.0
    </div>
  </footer>
</div>
<!-- ./wrapper -->
<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="../assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="../assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Select2 -->
<script src="../assets/plugins/select2/js/select2.full.min.js"></script>
<!-- Bootstrap4 Duallistbox -->
<script src="../assets/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
<!-- overlayScrollbars -->
<script src="../assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- InputMask -->
<script src="../assets/plugins/moment/moment.min.js"></script>
<script src="../assets/plugins/inputmask/min/jquery.inputmask.bundle.min.js"></script>
<!-- date-range-picker -->
<script src="../assets/plugins/daterangepicker/daterangepicker.js"></script>
<!-- bootstrap color picker -->
<script src="../assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="../assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Bootstrap Switch -->
<script src="../assets/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
<!-- ChartJS -->
<script src="../assets/plugins/chart.js/Chart.min.js"></script>
<!-- jQuery Mapael -->
<script src="../assets/plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
<script src="../assets/plugins/raphael/raphael.min.js"></script>
<script src="../assets/plugins/jquery-mapael/jquery.mapael.min.js"></script>
<script src="../assets/plugins/jquery-mapael/maps/usa_states.min.js"></script>
<!-- AdminLTE App -->
<script src="../assets/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../assets/dist/js/demo.js"></script>
<!-- AdminLTE Pages -->
<script src="../assets/dist/js/pages/dashboard2.js"></script>
<!-- SweetAlert2 -->
<script src="sweetalert2.js"></script>


<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })

    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
    //Money Euro
    $('[data-mask]').inputmask()

    //Date range picker
    $('#reservation').daterangepicker()
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({
      timePicker: true,
      timePickerIncrement: 30,
      locale: {
        format: 'MM/DD/YYYY hh:mm A'
      }
    })
    //Date range as a button
    $('#daterange-btn').daterangepicker(
      {
        ranges   : {
          'Today'       : [moment(), moment()],
          'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month'  : [moment().startOf('month'), moment().endOf('month')],
          'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate  : moment()
      },
      function (start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
      }
    )

    //Timepicker
    $('#timepicker').datetimepicker({
      format: 'LT'
    })
    
    //Bootstrap Duallistbox
    $('.duallistbox').bootstrapDualListbox()

    //Colorpicker
    $('.my-colorpicker1').colorpicker()
    //color picker with addon
    $('.my-colorpicker2').colorpicker()

    $('.my-colorpicker2').on('colorpickerChange', function(event) {
      $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
    });

    $("input[data-bootstrap-switch]").each(function(){
      $(this).bootstrapSwitch('state', $(this).prop('checked'));
    });

  })
</script>



</body>
</html>
