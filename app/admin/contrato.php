

<script>
document.addEventListener("DOMContentLoaded", () => {
  const form = document.querySelector("#form-cadastro");
  form.addEventListener("submit", validarFormularioCadastro);
});
</script>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Contratos Registrados</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Painel</a></li>
              <li class="breadcrumb-item active">Contratos</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-12">

          <div class="card">
            <div class="card-header">
              <h3 class="card-title"></h3>
              <button
                data-toggle="modal" data-target="#modal-cadastro"
             class="btn btn-default d-flex align-items-center g"
             type="button"
             style="margin:3px; float: right;"
             > <i class="fas fa-file-alt"> Celebrar novo</i></button>
              
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Nome</th>
                  <th>Imovel</th>
                  <th>Tipo</th>
                  <th>Data Inicio</th>
                  <th>Data Fim</th>
                  <th>Estado</th>
                  <th>F.Pagamento</th>
                  <th>Parcelas/Mensalidade</th>
                  <th>Valor</th>
                  <th>Accçãoe</th>
                </tr>
                </thead>
                <tbody>

                <?php
                
                $registros_por_pagina = 20; // quantidade de faculdades por página
                $pagina_atual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
                if ($pagina_atual < 1) {
                    $pagina_atual = 1;
                }
                $offset = ($pagina_atual - 1) * $registros_por_pagina;


                $total_query = $conexao->prepare("SELECT COUNT(*) FROM contrato");
                $total_query->execute();
                $total_registros = $total_query->fetchColumn();

                $total_paginas = ceil($total_registros / $registros_por_pagina);

                 $pesquisa=null;
                if(isset($_POST['pesquisar']) && $_POST['pesquisar']!=""){
                    $pesquisa = $_POST['pesquisar'];
                }

                $bucar = $conexao->prepare("SELECT idcontrato,imovel_id,cliente_id,C.tipo,valor,data_inicio
                ,data_fim,forma_pagamento,numero_parcelas,anexo,
                valor_parcela,data_assinatura,C.status, C.observacoes,nome, titulo FROM CONTRATO C INNER JOIN 
                IMOVEL M ON(C.imovel_id=M.idimovel) INNER JOIN CLIENTE CL ON (C.cliente_id=CL.idcliente) 
                WHERE nome LIKE :pesquisa order by idcontrato desc LIMIT {$offset}, {$registros_por_pagina}"); 
                $bucar->bindValue(':pesquisa', "%$pesquisa%");
                
                $bucar->execute();

                 if($bucar->rowCount()<=0){
                    echo "<div class='alert alert-danger' role='alert'>
                    <a href='#' class='alert-link'>Nenhum registo encontrado.</div>";
                 }else{
                    while($row=$bucar->fetch(PDO::FETCH_OBJ)){
                 $nomeSanitizado = preg_replace('/[^A-Za-z0-9_\-]/', '_', $row->nome);
                ?>
                <tr>
                  <td><?php echo $row->nome?></td>
                  <td><?php echo $row->titulo?></td>
                  <td><?php echo $row->tipo?></td>
                  <td><?php echo $row->data_inicio?></td>
                  <td><?php echo $row->data_fim?></td>
                  <td><?php if($row->status=="ativo"){?>
                    <span class="badge badge-success">Activo</span> 
                    <?php }else{?>
                    <span class="badge badge-danger"><?php echo $row->status;?></span> 
                    <?php }?></td>
                  <td><?php echo $row->forma_pagamento?></td>
                  <td><?php echo $row->numero_parcelas?></td>
                  <td><?php echo $row->valor?></td>
                  
                  <td>
                    <a  class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-editar<?php echo $row->idcontrato?>"><i class="fas fa-edit" ></i></a>
                    <a target="_blank" href="../assets/contratos/<?="contrato_{$nomeSanitizado}_{$row->idcontrato}.pdf"?>" class="btn btn-dark btn-sm"><i class="fas fa-download"></i></a>
                    <a href="#" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>
                </td>


        <div class="modal fade show" id="modal-editar<?php echo $row->idcontrato?>" style="display:none; padding-right: 15px;" aria-modal="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Editar <?php echo $row->nome?> (*) campos obrigatórios</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <form action="../../controller/contrato_controller.php?acao=editar" method="POST" enctype="multipart/form-data">
             <div class="modal-body">
  <div class="card-body">
    <div class="row">

      <!-- CLIENTE -->
      <div class="col-md-6">
        <div class="form-group">
          <label>Cliente *</label>
          <select class="form-control select2" name="cliente_id" required>
            <option value="<?=$row->idcliente?>"><?php echo $row->nome?></option>
            <?php
            $sql = "SELECT * FROM cliente";
            $result = $conexao->query($sql);
            if ($result->rowCount() > 0) {
              while ($rows = $result->fetch(PDO::FETCH_ASSOC)) {
                echo '<option value="' . $rows['idcliente'] . '">' . $rows['nome'] . '</option>';
              }
            } else {
              echo '<option value="">Nenhum cliente disponível</option>';
            }
            ?>
          </select>
        </div>
      </div>

      <!-- IMÓVEL -->
      <div class="col-md-6">
        <div class="form-group">
          <label>Imóvel *</label>
          <select class="form-control select2" name="imovel_id" required>
            <option value="<?=$row->idimovel?>"><?php echo $row->titulo?></option>
            <?php
            $sql = "SELECT * FROM imovel WHERE status='disponivel'";
            $result = $conexao->query($sql);
            if ($result->rowCount() > 0) {
              while ($rowss = $result->fetch(PDO::FETCH_ASSOC)) {
                echo '<option value="' . $rowss['idimovel'] . '">' . $rowss['titulo'] . '</option>';
              }
            } else {
              echo '<option value="">Nenhum imóvel disponível</option>';
            }
            ?>
          </select>
        </div>
      </div>

      <!-- TIPO -->
      <div class="col-md-6">
        <div class="form-group">
          <label>Tipo de Contrato *</label>
          <select class="form-control select2" name="tipo" required>
            <option><?php echo $row->tipo?></option>
            <option value="aluguel">Aluguel</option>
            <option value="venda">Venda</option>
          </select>
        </div>
      </div>

      <!-- VALOR -->
      <div class="col-md-6">
        <div class="form-group">
          <label>Valor *</label>
          <input type="text" name="valor" class="form-control" value="<?=$row->valor?>" required>
        </div>
      </div>

      <!-- DATA INÍCIO -->
      <div class="col-md-6">
        <div class="form-group">
          <label>Data Início *</label>
          <input type="date" name="data_inicio" class="form-control" value="<?=$row->data_inicio?>" required>
        </div>
      </div>

      <!-- DATA FIM -->
      <div class="col-md-6">
        <div class="form-group">
          <label>Data Fim *</label>
          <input type="date" name="data_fim" class="form-control" value="<?=$row->data_fim?>" required>
        </div>
      </div>

      <!-- FORMA DE PAGAMENTO -->
      <div class="col-md-6">
        <div class="form-group">
          <label>Forma de Pagamento *</label>
          <select name="forma_pagamento" class="form-control select2" required>
            <option><?php echo $row->forma_pagamento?></option>
            <option value="avista">À Vista</option>
            <option value="parcelado">Parcelado</option>
            <option value="mensal">Mensal</option>
            <option value="outro">Outro</option>
          </select>
        </div>
      </div>

      <!-- NÚMERO DE PARCELAS -->
      <div class="col-md-6">
        <div class="form-group">
          <label>Total de Parcelas</label>
          <input type="number" name="numero_parcelas" class="form-control" value="<?=$row->numero_parcelas?>">
        </div>
      </div>

      <!-- VALOR PARCELA -->
      <div class="col-md-6">
        <div class="form-group">
          <label>Valor da Parcela</label>
          <input type="text" name="valor_parcela" class="form-control" value="<?=$row->valor_parcela?>">
        </div>
      </div>

      <!-- DATA ASSINATURA -->
      <div class="col-md-6">
        <div class="form-group">
          <label>Data da Assinatura</label>
          <input type="date" name="data_assinatura" class="form-control" value="<?=$row->data_assinatura?>">
          <input type="hidden" name="id" class="form-control" value="<?=$row->idcontrato?>">
        </div>
      </div>

      

      <!-- ANEXO -->
<div class="col-md-6">
  <div class="form-group">
    <label>Anexo (PDF ou Imagem)</label>
    <input type="file" name="file" class="form-control" accept="image/*,application/pdf">
    
    <?php
    // Caminho completo do arquivo atual (ajusta o caminho conforme a tua pasta)
    $anexoPath = "../assets/anexo/" . $row->anexo;

    // Verifica se o arquivo existe
    if (!empty($row->anexo) && file_exists($anexoPath)) {
        $extensao = strtolower(pathinfo($row->anexo, PATHINFO_EXTENSION));

        echo "<div class='mt-3'>";
        echo "<label><b>Visualização do Anexo Atual:</b></label><br>";

        // Se for imagem
        if (in_array($extensao, ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'])) {
            echo "<img src='{$anexoPath}' alt='Anexo' class='img-fluid rounded shadow-sm' style='max-height:300px; border:1px solid #ccc;'>";
        }
        // Se for PDF
        elseif ($extensao === 'pdf') {
            echo "<iframe src='{$anexoPath}' width='100%' height='400px' style='border:1px solid #ccc; border-radius:5px;'></iframe>";
        }
        // Outro tipo
        else {
            echo "<p class='text-muted'>Tipo de arquivo não suportado para visualização.</p>";
        }

        echo "</div>";
    } else {
        echo "<p class='text-muted mt-2'>Nenhum anexo disponível.</p>";
    }
    ?>
  </div>
</div>


      <!-- OBSERVAÇÕES -->
      <div class="col-md-12">
        <div class="form-group">
          <label>Observação</label>
          <textarea name="observacoes" rows="4" class="form-control" placeholder="Digite a observação"><?php echo $row->observacoes?></textarea>
        </div>
      </div>

    </div>
  </div>
 </div>
          <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Sair</button>
              <button type="submit" class="btn btn-primary">Editar</button>
            </div>
            </div>
          
          </div></form>
         
        </div>
       
      </div>

 </tr>
              <?php }}?>
              
                </tbody>
                
                
              </table>

              
            </div>
            <div class="col-sm-12 col-md-7" >
             <div class="dataTables_paginate paging_simple_numbers" id="example2_paginate" style="float: right;">
    <ul class="pagination">

        <!-- Botão Anterior -->
        <li class="paginate_button page-item <?= ($pagina_atual <= 1) ? 'disabled' : '' ?>" id="example2_previous">
            <a href="?page=<?=$_GET['page']?>&pagina=<?= max(1, $pagina_atual - 1) ?>" class="page-link">anterior</a>
        </li>

        <!-- Páginas -->
        <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
            <li class="paginate_button page-item <?= ($i == $pagina_atual) ? 'active' : '' ?>">
                <a href="?page=<?=$_GET['page']?>&pagina=<?= $i ?>" class="page-link"><?= $i ?></a>
            </li>
        <?php endfor; ?>

        <!-- Botão Próximo -->
        <li class="paginate_button page-item <?= ($pagina_atual >= $total_paginas) ? 'disabled' : '' ?>" id="example2_next">
            <a href="?page=<?=$_GET['page']?>&pagina=<?= min($total_paginas, $pagina_atual + 1) ?>" class="page-link">próximo</a>
        </li>

    </ul>
</div>

                    
                    </div>
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>


  <div class="modal fade show" id="modal-cadastro" style="display:none; padding-right: 15px;" aria-modal="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Celebração de Contrato (*) campos obrigatórios</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <form action="../../controller/contrato_controller.php?acao=cadastrar" method="POST" enctype="multipart/form-data">
            <div class="modal-body">
  <div class="card-body">
    <div class="row">

      <!-- CLIENTE -->
      <div class="col-md-6">
        <div class="form-group">
          <label>Cliente *</label>
          <select class="form-control select2" name="cliente_id" required>
            <option value="">Seleccione o cliente</option>
            <?php
            $sql = "SELECT * FROM cliente";
            $result = $conexao->query($sql);
            if ($result->rowCount() > 0) {
              while ($rows = $result->fetch(PDO::FETCH_ASSOC)) {
                echo '<option value="' . $rows['idcliente'] . '">' . $rows['nome'] . '</option>';
              }
            } else {
              echo '<option value="">Nenhum cliente disponível</option>';
            }
            ?>
          </select>
        </div>
      </div>

      <!-- IMÓVEL -->
      <div class="col-md-6">
        <div class="form-group">
          <label>Imóvel *</label>
          <select class="form-control select2" name="imovel_id" required id="imovel_id">
            <option value="">Seleccione o imóvel</option>
            <?php
            $sql = "SELECT * FROM imovel WHERE status='disponivel'";
            $result = $conexao->query($sql);
            if ($result->rowCount() > 0) {
              while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                echo '<option value="' . $row['idimovel'] . '">' . $row['titulo'] . '</option>';
              }
            } else {
              echo '<option value="">Nenhum imóvel disponível</option>';
            }
            ?>
          </select>
        </div>
      </div>

      <!-- TIPO -->
      <div class="col-md-6">
        <div class="form-group">
          <label>Tipo de Contrato *</label>
          <select class="form-control select2" name="tipo" required>
            <option value="">Seleccione o tipo</option>
            <option value="aluguel">Aluguel</option>
            <option value="venda">Venda</option>
          </select>
        </div>
      </div>

      <!-- VALOR -->
      <div class="col-md-6">
        <div class="form-group">
          <label>Valor *</label>
          <input type="text" name="valor" id="valor" class="form-control" placeholder="Digite o valor" required>
        </div>
      </div>

      <!-- DATA INÍCIO -->
      <div class="col-md-6">
        <div class="form-group">
          <label>Data Início *</label>
          <input type="date" name="data_inicio" class="form-control" required>
        </div>
      </div>

      <!-- DATA FIM -->
      <div class="col-md-6">
        <div class="form-group">
          <label>Data Fim *</label>
          <input type="date" name="data_fim" class="form-control" required>
        </div>
      </div>

      <!-- FORMA DE PAGAMENTO -->
      <div class="col-md-6">
        <div class="form-group">
          <label>Forma de Pagamento *</label>
          <select name="forma_pagamento" class="form-control select2" required>
            <option value="">Seleccione</option>
            <option value="avista">À Vista</option>
            <option value="parcelado">Parcelado</option>
            <option value="mensal">Mensal</option>
            <option value="outro">Outro</option>
          </select>
        </div>
      </div>

      <!-- NÚMERO DE PARCELAS -->
      <div class="col-md-6">
        <div class="form-group">
          <label>Total de Parcelas</label>
          <input type="number" name="numero_parcelas" class="form-control" placeholder="Ex: 12">
        </div>
      </div>

      <!-- VALOR PARCELA -->
      <div class="col-md-6">
        <div class="form-group">
          <label>Valor da Parcela</label>
          <input type="text" name="valor_parcela" class="form-control" placeholder="Ex: 15000.00">
        </div>
      </div>

      <!-- DATA ASSINATURA -->
      <div class="col-md-6">
        <div class="form-group">
          <label>Data da Assinatura</label>
          <input type="date" name="data_assinatura" class="form-control">
        </div>
      </div>

      <!-- ANEXO -->
      <div class="col-md-6">
        <div class="form-group">
          <label>Anexo</label>
          <input type="file" name="anexo" class="form-control">
        </div>
      </div>

      <!-- OBSERVAÇÕES -->
      <div class="col-md-12">
        <div class="form-group">
          <label>Observação</label>
          <textarea name="observacoes" rows="4" class="form-control" placeholder="Digite a observação"></textarea>
        </div>
      </div>

    </div>
  </div>
 </div>

          <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Sair</button>
              <button type="submit" class="btn btn-primary">Gravar</button>
            </div>
            </div>
          
          </div></form>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>



<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {

  // Quando o imóvel for selecionado
  $('#imovel_id').change(function() {
      let imovelId = $(this).val();
      let tipo = $('#tipo').val();

      if (!imovelId) return;

      $.ajax({
          url: '../../controller/imovel_controller.php?acao=buscar_valor',
          method: 'GET',
          data: { id: imovelId },
          dataType: 'json',
          success: function(res) {
              if (res.erro) {
                  alert(res.erro);
              } else {
                  // Define o valor com base no tipo
                  if (tipo === 'aluguel' && res.valor) {
                      $('#valor').val(res.valor);
                  } else if (tipo === 'venda' && res.valor) {
                      $('#valor').val(res.valor);
                  } else {
                      $('#valor').val(res.valor || res.valor || '');
                  }
              }
          },
          error: function() {
              alert('Não foi possível buscar o valor do imóvel.');
          }
      });
  });

  // Se o tipo mudar, recarrega o valor (caso já tenha selecionado o imóvel)
  $('#tipo').change(function() {
      $('#imovel_id').trigger('change');
  });

  // Calcular valor da parcela quando digitar número de parcelas
  $('#numero_parcelas').on('input', function() {
      let tipo = $('#tipo').val();
      let valor = parseFloat($('#valor').val().replace(',', '.')) || 0;
      let parcelas = parseInt($(this).val()) || 0;

      if (tipo === 'aluguel' && parcelas > 0) {
          let valorParcela = (valor / parcelas).toFixed(2);
          $('#valor_parcela').val(valorParcela);
      } else {
          $('#valor_parcela').val('');
      }
  });

});
</script>



     