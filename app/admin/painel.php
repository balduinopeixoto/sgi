<?php

$proprietarios = $conexao->query("SELECT * FROM proprietario")->rowCount();
$imoveis = $conexao->query("SELECT * FROM imovel")->rowCount();
$imoveisAlugados = $conexao->query("SELECT * FROM imovel where status='alugado'")->rowCount();
$imoveis_vendidos = $conexao->query("SELECT * FROM imovel where status='vendido'")->rowCount();
$imoveisDisponiveis = $conexao->query("SELECT * FROM imovel where status='disponivel'")->rowCount();
$contratos = $conexao->query("SELECT * FROM contrato")->rowCount();
$marcacoes = $conexao->query("SELECT * FROM visitas")->rowCount();


?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Painel Principal</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Painel Principal</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Info boxes -->
        <div class="row">
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-user"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Proprietários</span>
                <span class="info-box-number">
                  <?=$proprietarios?>
                  <small></small>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-home"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Imoveis</span>
                <span class="info-box-number"> <?=$imoveis?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

          <!-- fix for small devices only -->
          <div class="clearfix hidden-md-up"></div>

          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-file"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Contratos</span>
                <span class="info-box-number"><?=$contratos?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Marcações</span>
                <span class="info-box-number"><?=$marcacoes?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->

        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h5 class="card-title">Relatório Mensal de Atividades</h5>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <!--<div class="btn-group">
                    <button type="button" class="btn btn-tool dropdown-toggle" data-toggle="dropdown">
                      <i class="fas fa-wrench"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" role="menu">
                      <a href="#" class="dropdown-item">Action</a>
                      <a href="#" class="dropdown-item">Another action</a>
                      <a href="#" class="dropdown-item">Something else here</a>
                      <a class="dropdown-divider"></a>
                      <a href="#" class="dropdown-item">Separated link</a>
                    </div>
                  </div>-->
                  <!--<button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>-->
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
                  <div class="col-md-10">
                    <p class="text-center">
                      <strong>Actividades Actualizadas em : <?php echo date('d/m/Y');?></strong>
                    </p>

                    <div class="chart">
                      <!-- Sales Chart Canvas -->
                      <canvas id="salesChart" height="180" style="height: 180px;"></canvas>
                    </div>
                    <!-- /.chart-responsive -->
                  </div>
                  <!-- /.col -->
                  <div class="col-md-2">
                    <p class="text-center">
                      <strong>Estatística de Imóveis </strong>
                    </p>
                      <?php
                      // garantir que as variáveis existem e são inteiros
                      $imoveis = max(0, (int) ($imoveis ?? 0));
                      $imoveisAlugados = max(0, (int) ($imoveisAlugados ?? 0));
                      $imoveis_vendidos = max(0, (int) ($imoveis_vendidos ?? 0));
                      $imoveisDisponiveis = max(0, (int) ($imoveisDisponiveis ?? 0));

                      // calcula percentagens com 1 casa decimal (ajusta para 0 se preferires inteiro)
                      function pct($part, $total, $decimals = 0) {
                          if ($total === 0) return '0';
                          return number_format(($part / $total) * 100, $decimals, ',', '');
                      }

                      $pctAlugados = (float) ($imoveis === 0 ? 0 : ($imoveisAlugados / $imoveis) * 100);
                      $pctVendidos = (float) ($imoveis === 0 ? 0 : ($imoveis_vendidos / $imoveis) * 100);
                      $pctDisponiveis = (float) ($imoveis === 0 ? 0 : ($imoveisDisponiveis / $imoveis) * 100);

                      // Formatos para exibição (sem casas decimais)
                      // se preferires mostrar 1 decimal altera 0 para 1 em pct(...)
                      $labelAlugados = pct($imoveisAlugados, $imoveis, 0) . '%';
                      $labelVendidos = pct($imoveis_vendidos, $imoveis, 0) . '%';
                      $labelDisponiveis = pct($imoveisDisponiveis, $imoveis, 0) . '%';
                      ?>

                    <div class="progress-group">
                    <span class="progress-text">Alugados</span>
                    <span class="float-right"><b><?=$imoveisAlugados?></b>/<?=$imoveis?> <small class="text-muted"><?=$labelAlugados?></small></span>
                    <div class="progress progress-sm">
                      <div class="progress-bar bg-primary" role="progressbar"
                          style="width: <?= htmlspecialchars($pctAlugados, ENT_QUOTES) ?>%;"
                          aria-valuenow="<?= round($pctAlugados) ?>" aria-valuemin="0" aria-valuemax="100">
                      </div>
                    </div>
                  </div>

                  <div class="progress-group">
                    <span class="progress-text">Vendidos</span>
                    <span class="float-right"><b><?=$imoveis_vendidos?></b>/<?=$imoveis?> <small class="text-muted"><?=$labelVendidos?></small></span>
                    <div class="progress progress-sm">
                      <div class="progress-bar bg-danger" role="progressbar"
                          style="width: <?= htmlspecialchars($pctVendidos, ENT_QUOTES) ?>%;"
                          aria-valuenow="<?= round($pctVendidos) ?>" aria-valuemin="0" aria-valuemax="100">
                      </div>
                    </div>
                  </div>

                  <div class="progress-group">
                    <span class="progress-text">Disponíveis</span>
                    <span class="float-right"><b><?=$imoveisDisponiveis?></b>/<?=$imoveis?> <small class="text-muted"><?=$labelDisponiveis?></small></span>
                    <div class="progress progress-sm">
                      <div class="progress-bar bg-success" role="progressbar"
                          style="width: <?= htmlspecialchars($pctDisponiveis, ENT_QUOTES) ?>%;"
                          aria-valuenow="<?= round($pctDisponiveis) ?>" aria-valuemin="0" aria-valuemax="100">
                      </div>
                    </div>
                  </div>
                </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->
              </div>
              <!-- ./card-body -->
              
              <!-- /.card-footer -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->

        <!-- Main row -->
        <div class="row">
          <!-- Left col -->
          <div class="col-md-12">
           

            <!-- TABLE: LATEST ORDERS -->
            <div class="card">
              <div class="card-header border-transparent">
                <h3 class="card-title">Visitas</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table m-0">
                    <thead>
                    <tr>
                      <th>Imóvel</th>
                      <th>Cliente</th>
                      <th>Data</th>
                      <th>Hora da Visita</th>
                      <th>Estado</th>
                    </tr>
                    </thead>
                    <tbody>

                   <?php
                    $buscar = $conexao->query("
                        SELECT * 
                        FROM visitas 
                        INNER JOIN imovel i ON imovel_id = idimovel 
                        inner join usuario u on i.usuario_id = idusuario
                        ORDER BY id DESC 
                        LIMIT 5
                    ");
                    $buscar->execute();

                    while ($row = $buscar->fetch(PDO::FETCH_OBJ)) {
                        // Estado da visita
                        $estado = strtolower(trim($row->estado ?? 'agendado')); // valor default
                        
                        // Define cor e texto conforme o estado
                        switch ($estado) {
                            case 'confirmada':
                                $classe = 'badge-primary';
                                $texto = 'Confirmada';
                                break;
                            case 'realizada':
                                $classe = 'badge-success';
                                $texto = 'Realizada';
                                break;
                            case 'cancelada':
                                $classe = 'badge-danger';
                                $texto = 'Cancelada';
                                break;
                            case 'agendada':
                            default:
                                $classe = 'badge-warning';
                                $texto = 'Agendada';
                                break;
                        }
                    ?>
                        <tr>
                            <td><a href="pages/examples/invoice.html"><?= htmlspecialchars($row->titulo) ?></a></td>
                            <td><?=$row->nome?></td>
                            <td><?= date('d/m/Y', strtotime($row->data_visita)) ?></td>
                            <td><?= htmlspecialchars($row->hora_visita) ?></td>
                            <td>
                                <div class="sparkbar" data-color="#00a65a" data-height="20">
                                    <span class="badge <?= $classe ?>"><?= $texto ?></span>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>

                    
                 
                 
                    </tbody>
                  </table>
                </div>
                <!-- /.table-responsive -->
              </div>
              <!-- /.card-body 
              <div class="card-footer clearfix">
                <a href="javascript:void(0)" class="btn btn-sm btn-info float-left">Notificar Clientes sobre Casas disponiveis </a>
                <a href="javascript:void(0)" class="btn btn-sm btn-secondary float-right">Ver todas</a>
              </div>
          card-footer -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->

          
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
  </div>