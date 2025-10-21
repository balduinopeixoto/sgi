

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
            <h1>Imóveis Registrados</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Painel</a></li>
              <li class="breadcrumb-item active">Imóveis</li>
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
             > <i class="fas fa-user-plus"> Novo Imóvel</i></button>
              
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Titulo</th>
                  <th>Tipo</th>
                  <th>Endereço</th>
                  <th>Preço</th>
                  <th>Estado</th>
                  <th>Acção</th>
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


                $total_query = $conexao->prepare("SELECT COUNT(*) FROM imovel");
                $total_query->execute();
                $total_registros = $total_query->fetchColumn();

                $total_paginas = ceil($total_registros / $registros_por_pagina);

                 $pesquisa=null;
                if(isset($_POST['pesquisar']) && $_POST['pesquisar']!=""){
                    $pesquisa = $_POST['pesquisar'];
                }

                $bucar = $conexao->prepare("SELECT * FROM imovel inner join proprietario on imovel.proprietario_id=proprietario.idproprietario WHERE titulo LIKE :pesquisa order by idimovel desc LIMIT {$offset}, {$registros_por_pagina}"); 
                $bucar->bindValue(':pesquisa', "%$pesquisa%");
                
                $bucar->execute();

                 if($bucar->rowCount()<=0){
                    echo "<div class='alert alert-danger' role='alert'>
                    <a href='#' class='alert-link'>Nenhum registo encontrado.</div>";
                 }else{
                    while($row=$bucar->fetch(PDO::FETCH_OBJ)){

                      $fo=$conexao->prepare("SELECT * FROM fotos_imoveis WHERE imovel_id=:idimovel");
                      $fo->bindValue(":idimovel", $row->idimovel);
                      $fo->execute();
                      $fotos = $fo->fetch(PDO::FETCH_ASSOC);
                
                ?>
                <tr>
                  <td><?php echo $row->titulo?></td>
                  <td><?php echo $row->tipo?></td>
                  <td><?php echo $row->endereco?></td>
                  <td><?php echo number_format($row->preco, 2,',','.')?></td>
                  <td>
                       <?php 
    switch ($row->status) {
        case 'disponivel':
            echo '<span class="badge badge-success">Disponível</span>';
            break;

        case 'alugado':
            echo '<span class="badge badge-warning">Alugado</span>';
            break;

        case 'vendido':
            echo '<span class="badge badge-danger">Vendido</span>';
            break;

        default:
            echo '<span class="badge badge-secondary">Indefinido</span>';
            break;
    }
    ?>
                  </td>
                  <td>
                    <a  class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-editar<?php echo $row->idimovel?>"><i class="fas fa-edit" ></i></a>
                    <a href="?page=detalhe&idimovel=<?php echo $row->idimovel?>" class="btn btn-default btn-sm"><i class="fas fa-eye"></i></a>
                    <a href="#" class="btn btn-pri btn-sm"><i class="fas fa-trash"></i></a>
                </td>


        <div class="modal fade show" id="modal-editar<?php echo $row->idimovel?>" style="display:none; padding-right: 15px;" aria-modal="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Editar <?php echo $row->titulo?> (*) campos obrigatórios</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <form action="../../controller/imovel_controller.php?acao=editar" method="POST" enctype="multipart/form-data">
            <div class="modal-body">
            
            <div class="card-body">
  <div class="row">

    <!-- Título -->
    <div class="col-md-6">
      <div class="form-group">
        <label for="titulo">Título do Imóvel *</label>
        <input type="text" name="titulo" class="form-control" id="titulo" value="<?php echo $row->titulo?>" required>
      </div>
    </div>

    <!-- Tipo -->
    <div class="col-md-6">
      <div class="form-group">
        <label for="tipo">Tipo *</label>
        <select name="tipo" id="tipo" class="form-control select2" style="width:100%;" required>
          <option ><?php echo $row->tipo ?></option>
          <option value="casa">Casa</option>
          <option value="apartamento">Apartamento</option>
          <option value="terreno">Terreno</option>
          <option value="sala_comercial">Sala Comercial</option>
        </select>
      </div>
    </div>

    <!-- Descrição -->
    <div class="col-md-12">
      <div class="form-group">
        <label for="descricao">Descrição</label>
        <textarea name="descricao" id="descricao" class="form-control" rows="3"><?php echo $row->descricao?></textarea>
      </div>
    </div>

    <!-- Preço -->
    <div class="col-md-4">
      <div class="form-group">
        <label for="preco">Preço (AOA) *</label>
        <input type="number" name="preco" class="form-control" id="preco" step="0.01" value="<?=$row->preco?>" required>
      </div>
    </div>

    <!-- Área -->
    <div class="col-md-4">
      <div class="form-group">
        <label for="area">Área (m²)</label>
        <input type="number" name="area" class="form-control" id="area" step="0.01" value="<?=$row->area?>">
      </div>
    </div>

    <!-- Status -->
    <div class="col-md-4">
      <div class="form-group">
        <label for="status">Estado</label>
        <select name="status" id="status" class="form-control select2" style="width:100%;">
          <option ><?php echo $row->status ?></option>
          <option value="disponivel">Disponível</option>
          <option value="alugado">Alugado</option>
          <option value="vendido">Vendido</option>
        </select>
      </div>
    </div>

    <!-- Quartos -->
    <div class="col-md-4">
      <div class="form-group">
        <label for="quartos">Quartos</label>
        <input type="number" name="quartos" class="form-control" id="quartos" min="0" value="<?=$row->quartos?>">
      </div>
    </div>

    <!-- Banheiros -->
    <div class="col-md-4">
      <div class="form-group">
        <label for="banheiros">Banheiros</label>
        <input type="number" name="banheiros" class="form-control" id="banheiros" min="0" value="<?=$row->banheiros?>">
      </div>
    </div>

    <!-- Garagem -->
    <div class="col-md-4">
      <div class="form-group">
        <label for="garagem">Garagem</label>
        <input type="number" name="garagem" class="form-control" id="garagem" min="0" value="<?=$row->garagem?>">
      </div>
    </div>

    <!-- Endereço -->
    <div class="col-md-12">
      <div class="form-group">
        <label for="endereco">Endereço</label>
        <input type="text" name="endereco" class="form-control" id="endereco" value="<?=$row->endereco?>">
      </div>
    </div>

    <!-- Latitude / Longitude -->
    <div class="col-md-6">
      <div class="form-group">
        <label for="latitude">Latitude</label>
        <input type="text" name="latitude" class="form-control" id="latitude" value="<?=$row->latitude?>">
      </div>
    </div>

    <div class="col-md-6">
      <div class="form-group">
        <label for="longitude">Longitude</label>
        <input type="text" name="longitude" class="form-control" id="longitude" value="<?=$row->longitude?>">
      </div>
    </div>

    <!-- Proprietário -->
    <div class="col-md-6">
      <div class="form-group">
        <label for="proprietario_id">Proprietário *</label>
        <select name="proprietario_id" id="proprietario_id" class="form-control select2" style="width:100%;" required>
          <option value="<?= $row->idproprietario ?>"><?= $row->nome ?></option>
          <?php
            $sql = "SELECT idproprietario, nome, email, telefone, documento FROM proprietario ORDER BY nome ASC";
            $stmt = $conexao->prepare($sql);
            $stmt->execute();
            
            while ($p = $stmt->fetch(PDO::FETCH_ASSOC)) {
              echo "<option value='{$p['idproprietario']}'>{$p['nome']}</option>";
            }
          ?>
        </select>
      </div>
    </div>
    <!-- imagens -->
  <div class="col-md-6">
    <div class="form-group">
      <label for="files">Imagens *</label>
      <input type="file" name="files[]" id="files" accept="image/*" class="form-control" multiple  onchange="previewImagens(event)">
      <small class="form-text text-muted">Permite várias imagens — mantenha pressionado Ctrl/Shift para seleccionar várias.</small>
    </div>

    <!-- Usuário (logado) -->
    <input type="hidden" name="id" value="<?= $row->idimovel?>">

  </div> <!-- /.row -->
<!-- Pré-visualização de novas imagens -->
  <div id="preview-container" 
       class="d-flex flex-wrap mt-2" 
       style="gap:10px; border-top: 1px dashed #ccc; padding-top: 10px;">
  </div>
<!-- Imagens actuais -->
<div class="col-md-12 mt-3">
  <div class="form-group">
    <label>Imagens actuais</label>
    <div class="d-flex flex-wrap" style="gap:10px;">
      <?php
        $fo = $conexao->prepare("SELECT * FROM fotos_imoveis WHERE imovel_id = :idimovel");
        $fo->bindValue(":idimovel", $row->idimovel);
        $fo->execute();
        $fotos = $fo->fetchAll(PDO::FETCH_ASSOC);

        if ($fotos) {
          foreach ($fotos as $foto) {
            $id = $foto["id"];
            echo "
              <div style='position: relative;' class='foto-card'>
                <img src=\"../assets/img/{$foto['caminho']}\" 
                     alt='Imagem do imóvel' 
                     width='100' height='80' 
                     style='object-fit: cover; border-radius: 5px; border: 1px solid #ccc;' />

                <button type='button' 
                        class='btn btn-danger btn-sm'
                        onclick='confirmarApagar($id, this)'
                        style='position: absolute; top: -8px; right: -8px; border-radius: 50%; padding: 3px 6px;'
                        title='Eliminar imagem'>
                  <i class='fas fa-times'></i>
                </button>
              </div>
            ";
          }
        } else {
          echo "<p class='text-muted'>Nenhuma imagem adicionada ainda.</p>";
        }
      ?>
    </div>
  </div>
</div>




</div> <!-- /.card-body -->
          
          
        
         
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
            <a href="?page=<?= max(1, $pagina_atual - 1) ?>" class="page-link">anterior</a>
        </li>

        <!-- Páginas -->
        <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
            <li class="paginate_button page-item <?= ($i == $pagina_atual) ? 'active' : '' ?>">
                <a href="?page=<?= $i ?>" class="page-link"><?= $i ?></a>
            </li>
        <?php endfor; ?>

        <!-- Botão Próximo -->
        <li class="paginate_button page-item <?= ($pagina_atual >= $total_paginas) ? 'disabled' : '' ?>" id="example2_next">
            <a href="?page=<?= min($total_paginas, $pagina_atual + 1) ?>" class="page-link">próximo</a>
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
              <h4 class="modal-title">Cadastro de Imóvel (*) campos obrigatórios</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <form id="modal-cadastro form" action="../../controller/imovel_controller.php?acao=cadastrar" method="POST" enctype="multipart/form-data">
            <div class="modal-body">
            
        
         <div class="card-body">
  <div class="row">

    <!-- Título -->
    <div class="col-md-6">
      <div class="form-group">
        <label for="titulo">Título do Imóvel *</label>
        <input type="text" name="titulo" class="form-control" id="titulo" placeholder="Ex: Casa de 3 quartos no centro" required>
      </div>
    </div>

    <!-- Tipo -->
    <div class="col-md-6">
      <div class="form-group">
        <label for="tipo">Tipo *</label>
        <select name="tipo" id="tipo" class="form-control select2" style="width:100%;" required>
          <option value="">Selecione o tipo</option>
          <option value="casa">Casa</option>
          <option value="apartamento">Apartamento</option>
          <option value="terreno">Terreno</option>
          <option value="sala_comercial">Sala Comercial</option>
        </select>
      </div>
    </div>

    <!-- Descrição -->
    <div class="col-md-12">
      <div class="form-group">
        <label for="descricao">Descrição</label>
        <textarea name="descricao" id="descricao" class="form-control" rows="3" placeholder="Descreva detalhes do imóvel..."></textarea>
      </div>
    </div>

    <!-- Preço -->
    <div class="col-md-4">
      <div class="form-group">
        <label for="preco">Preço (AOA) *</label>
        <input type="number" name="preco" class="form-control" id="preco" step="0.01" placeholder="Ex: 25000000" required>
      </div>
    </div>

    <!-- Área -->
    <div class="col-md-4">
      <div class="form-group">
        <label for="area">Área (m²)</label>
        <input type="number" name="area" class="form-control" id="area" step="0.01" placeholder="Ex: 180">
      </div>
    </div>

    <!-- Status -->
    <div class="col-md-4">
      <div class="form-group">
        <label for="status">Status</label>
        <select name="status" id="status" class="form-control select2" style="width:100%;">
          <option value="disponivel">Disponível</option>
          <option value="alugado">Alugado</option>
          <option value="vendido">Vendido</option>
        </select>
      </div>
    </div>

    <!-- Quartos -->
    <div class="col-md-4">
      <div class="form-group">
        <label for="quartos">Quartos</label>
        <input type="number" name="quartos" class="form-control" id="quartos" min="0" value="0">
      </div>
    </div>

    <!-- Banheiros -->
    <div class="col-md-4">
      <div class="form-group">
        <label for="banheiros">Banheiros</label>
        <input type="number" name="banheiros" class="form-control" id="banheiros" min="0" value="0">
      </div>
    </div>

    <!-- Garagem -->
    <div class="col-md-4">
      <div class="form-group">
        <label for="garagem">Garagem</label>
        <input type="number" name="garagem" class="form-control" id="garagem" min="0" value="0">
      </div>
    </div>

    <!-- Endereço -->
    <div class="col-md-12">
      <div class="form-group">
        <label for="endereco">Endereço</label>
        <input type="text" name="endereco" class="form-control" id="endereco" placeholder="Rua, bairro, cidade...">
      </div>
    </div>

    <!-- Latitude / Longitude -->
    <div class="col-md-6">
      <div class="form-group">
        <label for="latitude">Latitude</label>
        <input type="text" name="latitude" class="form-control" id="latitude" placeholder="-8.8383">
      </div>
    </div>

    <div class="col-md-6">
      <div class="form-group">
        <label for="longitude">Longitude</label>
        <input type="text" name="longitude" class="form-control" id="longitude" placeholder="13.2349">
      </div>
    </div>

    <!-- Proprietário -->
    <div class="col-md-6">
      <div class="form-group">
        <label for="proprietario_id">Proprietário *</label>
        <select name="proprietario_id" id="proprietario_id" class="form-control select2" style="width:100%;" required>
          <option value="">Selecione o proprietário</option>
          <?php
            $sql = "SELECT idproprietario, nome, email, telefone, documento FROM proprietario ORDER BY nome ASC";
            $stmt = $conexao->prepare($sql);
            $stmt->execute();
            
            while ($p = $stmt->fetch(PDO::FETCH_ASSOC)) {
              echo "<option value='{$p['idproprietario']}'>{$p['nome']}</option>";
            }
          ?>
        </select>
      </div>
    </div>
    <!-- imagens -->
  <div class="col-md-6">
    <div class="form-group">
      <label for="files">Imagens *</label>
      <input type="file" name="files[]" id="files" accept="image/*" class="form-control" multiple required onchange="previewImagens(event)">
      <small class="form-text text-muted">Permite várias imagens — mantenha pressionado Ctrl/Shift para seleccionar várias.</small>
    </div>

   

  </div> <!-- /.row -->
<!-- Pré-visualização de novas imagens -->
  <div id="preview-containerr" 
       class="d-flex flex-wrap mt-2" 
       style="gap:10px; border-top: 1px dashed #ccc; padding-top: 10px;">
  </div>

    <!-- Usuário (logado) -->
    <input type="hidden" name="usuario_id" value="<?= $_SESSION['usuario_id'] ?? '' ?>">

  </div> <!-- /.row -->
</div> <!-- /.card-body -->

        
         
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









      <script>
document.addEventListener('DOMContentLoaded', function() {
  const form = document.querySelector('#modal-cadastro form');
  const btnSalvar = document.getElementById('btnSalvar');

  if (form && btnSalvar) {
    form.addEventListener('submit', function(e) {
      // mostra loading e desativa o botão
      btnSalvar.disabled = true;
      btnSalvar.innerHTML = `
        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
        Salvando...
      `;
    });
  }
});
</script>



<script>
function confirmarApagar(idfoto, elemento) {
  Swal.fire({
    title: 'Eliminar imagem?',
    text: 'Esta ação não pode ser desfeita.',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Sim, eliminar',
    cancelButtonText: 'Cancelar'
  }).then((result) => {
    if (result.isConfirmed) {
      // Mostra o loading
      Swal.fire({
        title: 'Eliminando...',
        text: 'Aguarde um momento.',
        allowOutsideClick: false,
        didOpen: () => {
          Swal.showLoading();
        }
      });

      fetch('../../controller/imovel_controller.php?acao=apagar_foto', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `idfoto=${idfoto}`
      })
      .then(res => res.json())
      .then(data => {
        Swal.close();

        if (data.status === 'success') {
          // Remove o card imediatamente da interface
          const card = elemento.closest('.foto-card');
          if (card) card.remove();

          Swal.fire('Eliminada!', data.message, 'success');
        } else {
          Swal.fire('Erro!', data.message, 'error');
        }
      })
      .catch(err => {
        Swal.close();
        Swal.fire('Erro!', 'Falha ao comunicar com o servidor.', 'error');
      });
    }
  });
}
</script>


<script>
function previewImagens(event) {
  const container = document.getElementById('preview-container');
  container.innerHTML = ''; // limpa visualizações anteriores
  const files = event.target.files;

  if (!files.length) return;

  Array.from(files).forEach((file, index) => {
    // valida se é imagem
    if (!file.type.startsWith('image/')) {
      Swal.fire('Arquivo inválido', 'Apenas imagens são permitidas.', 'warning');
      return;
    }

    const reader = new FileReader();
    reader.onload = function(e) {
      const card = document.createElement('div');
      card.classList.add('foto-card');
      card.style.position = 'relative';
      card.style.width = '100px';
      card.style.height = '80px';

      const img = document.createElement('img');
      img.src = e.target.result;
      img.alt = `Pré-visualização ${index + 1}`;
      img.style.width = '100%';
      img.style.height = '100%';
      img.style.objectFit = 'cover';
      img.style.borderRadius = '5px';
      img.style.border = '1px solid #ccc';

      const removeBtn = document.createElement('button');
      removeBtn.innerHTML = '<i class="fas fa-times"></i>';
      removeBtn.classList.add('btn', 'btn-danger', 'btn-sm');
      removeBtn.style.position = 'absolute';
      removeBtn.style.top = '-8px';
      removeBtn.style.right = '-8px';
      removeBtn.style.borderRadius = '50%';
      removeBtn.style.padding = '3px 6px';
      removeBtn.title = 'Remover imagem';

      // remove da pré-visualização
      removeBtn.onclick = () => {
        card.remove();

        // atualiza o input file (remove apenas o removido)
        const dt = new DataTransfer();
        Array.from(files).forEach((f, i) => {
          if (i !== index) dt.items.add(f);
        });
        event.target.files = dt.files;
      };

      card.appendChild(img);
      card.appendChild(removeBtn);
      container.appendChild(card);
    };

    reader.readAsDataURL(file);
  });


  const containerr = document.getElementById('preview-containerr');
  containerr.innerHTML = ''; // limpa visualizações anteriores
  const filess = event.target.files;

  if (!files.length) return;

  Array.from(files).forEach((file, index) => {
    // valida se é imagem
    if (!file.type.startsWith('image/')) {
      Swal.fire('Arquivo inválido', 'Apenas imagens são permitidas.', 'warning');
      return;
    }

    const reader = new FileReader();
    reader.onload = function(e) {
      const cardd = document.createElement('div');
      cardd.classList.add('foto-card');
      cardd.style.position = 'relative';
      cardd.style.width = '100px';
      cardd.style.height = '80px';

      const img = document.createElement('img');
      img.src = e.target.result;
      img.alt = `Pré-visualização ${index + 1}`;
      img.style.width = '100%';
      img.style.height = '100%';
      img.style.objectFit = 'cover';
      img.style.borderRadius = '5px';
      img.style.border = '1px solid #ccc';

      const removeBtn = document.createElement('button');
      removeBtn.innerHTML = '<i class="fas fa-times"></i>';
      removeBtn.classList.add('btn', 'btn-danger', 'btn-sm');
      removeBtn.style.position = 'absolute';
      removeBtn.style.top = '-8px';
      removeBtn.style.right = '-8px';
      removeBtn.style.borderRadius = '50%';
      removeBtn.style.padding = '3px 6px';
      removeBtn.title = 'Remover imagem';

      // remove da pré-visualização
      removeBtn.onclick = () => {
        card.remove();

        // atualiza o input file (remove apenas o removido)
        const dt = new DataTransfer();
        Array.from(files).forEach((f, i) => {
          if (i !== index) dt.items.add(f);
        });
        event.target.files = dt.files;
      };

      cardd.appendChild(img);
      cardd.appendChild(removeBtn);
      containerr.appendChild(cardd);
    };

    reader.readAsDataURL(file);
  });
}
</script>



