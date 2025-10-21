

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
            <h1>Proprietários Registrados</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Painel</a></li>
              <li class="breadcrumb-item active">Proprietários</li>
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
             > <i class="fas fa-user-plus"> Novo Proprietário</i></button>
              
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Nome</th>
                  <th>E-mail</th>
                  <th>Telefone</th>
                  <th>Nº Documento</th>
                  <th>Acção</th>
                </tr>
                </thead>
                <tbody>

                <?php
                
                $registros_por_pagina = 20; // quantidade de faculdades por página
                $pagina_atual = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                if ($pagina_atual < 1) {
                    $pagina_atual = 1;
                }
                $offset = ($pagina_atual - 1) * $registros_por_pagina;


                $total_query = $conexao->prepare("SELECT COUNT(*) FROM proprietario");
                $total_query->execute();
                $total_registros = $total_query->fetchColumn();

                $total_paginas = ceil($total_registros / $registros_por_pagina);

                 $pesquisa=null;
                if(isset($_POST['pesquisar']) && $_POST['pesquisar']!=""){
                    $pesquisa = $_POST['pesquisar'];
                }

                $bucar = $conexao->prepare("SELECT * FROM proprietario WHERE nome LIKE :pesquisa order by idproprietario desc LIMIT {$offset}, {$registros_por_pagina}"); 
                $bucar->bindValue(':pesquisa', "%$pesquisa%");
                
                $bucar->execute();

                 if($bucar->rowCount()<=0){
                    echo "<div class='alert alert-danger alert-dismissible' role='alert'>
                    <a href='#' class='alert-link'>Nenhum registo encontrado.</div>";
                 }else{
                    while($row=$bucar->fetch(PDO::FETCH_OBJ)){
                
                ?>
                <tr>
                  <td><?php echo $row->nome?></td>
                  <td><?php echo $row->email?></td>
                  <td><?php echo $row->telefone?></td>
                  <td><?php echo $row->documento?></td>
                  
                  <td>
                    <a  class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-editar<?php echo $row->idproprietario?>"><i class="fas fa-edit" ></i></a>
               </td>


        <div class="modal fade show" id="modal-editar<?php echo $row->idproprietario?>" style="display:none; padding-right: 15px;" aria-modal="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Editar <?php echo $row->nome?> (*) campos obrigatórios</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <form action="../../controller/proprietario_controller.php?acao=editar" method="POST">
            <div class="modal-body">
            
        
          <!-- /.card-header -->
            <div class="card-body" data-select2-id="30">
                <div class="row" data-select2-id="53">
                <div class="col-md-6">
                <div class="form-group">
                        <label for="exampleInputEmail1">Nome</label>
                        <input type="text" name="nome" class="form-control" id="nome" value="<?php echo $row->nome?>">
                    </div>
                </div>
           
          

                <div class="col-md-6">
             <div class="form-group">
                    <label for="exampleInputEmail1">E-mail</label>
                    <input type="email" name="email" class="form-control" id="email" value="<?php echo $row->email?>">
                  </div>
             </div>

              <div class="col-md-6">
             <div class="form-group">
                    <label for="exampleInputEmail1">Telefone</label>
                    <input type="text" name="telefone" class="form-control" id="telefone" value="<?php echo $row->telefone?>">
                  </div>
             </div>

              <div class="col-md-6">
             <div class="form-group">
                    <label for="exampleInputEmail1">Nº Documento</label>
                    <input type="text" name="documento" class="form-control" id="documento" value="<?php echo $row->documento?>">
                  </div>
             </div>
             
              <div class="col-md-6">
             <div class="form-group">
                  
                    <input type="hidden" name="id" class="form-control" id="id" value="<?php echo $row->idproprietario?>">
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
                <a href="?page=<?=$_GET['page']?>&pagina=<?=$i ?>" class="page-link"><?= $i ?></a>
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
              <h4 class="modal-title">Cadastrar Proprietário (*) campos obrigatórios</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <form action="../../controller/proprietario_controller.php?acao=cadastrar" method="POST">
            <div class="modal-body">
            
        
          <!-- /.card-header -->
            <div class="card-body" data-select2-id="30">
                <div class="row" data-select2-id="53">
                <div class="col-md-6">
                <div class="form-group">
                        <label for="exampleInputEmail1">Nome</label>
                        <input type="text" name="nome" class="form-control" id="nome" placeholder="Digite o nome completo">
                    </div>
                </div>
           
                <div class="col-md-6">
             <div class="form-group">
                    <label for="exampleInputEmail1">E-mail</label>
                    <input type="email" name="email" class="form-control" id="email" placeholder="Digite o e-mail">
                  </div>
             </div>

              <div class="col-md-6">
             <div class="form-group">
                    <label for="exampleInputEmail1">Telefone</label>
                    <input type="text" name="telefone" class="form-control" id="telefone" placeholder="Digite o telefone">
                  </div>
             </div>
              <div class="col-md-6">
             <div class="form-group">
                    <label for="exampleInputEmail1">Nº Documento</label>
                    <input type="text" name="documento" class="form-control" id="documento" placeholder="Digite a senha">
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





  <div class="modal fade show" id="modal-editar" style="display:none; padding-right: 15px;" aria-modal="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Large Modal</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">
              <p>One fine body…</p>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary">Save changes</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>





      <script>
  function validarFormularioProprietario(e) {
    e.preventDefault(); // evita envio automático

    let formValido = true;

    // pega os campos
    let nome = document.getElementById("nome");
    let email = document.getElementById("email");
    let telefone = document.getElementById("telefone");
    let documento = document.getElementById("documento");

    // função auxiliar
    function validarObrigatorio(campo) {
      if (!campo.value.trim()) {
        campo.classList.add("is-invalid");
        formValido = false;
      } else {
        campo.classList.remove("is-invalid");
      }
    }

    // valida obrigatórios
    validarObrigatorio(nome);
    validarObrigatorio(email);
    validarObrigatorio(telefone);
    validarObrigatorio(documento);

    // valida e-mail
    let regexEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (email.value.trim() && !regexEmail.test(email.value)) {
      email.classList.add("is-invalid");
      Swal.fire({
        icon: 'error',
        title: 'E-mail inválido!',
        text: 'Digite um e-mail válido.'
      });
      return false;
    }

    // valida telefone (somente números, mínimo 9 dígitos)
    let regexTel = /^[0-9]{9,15}$/;
    if (telefone.value.trim() && !regexTel.test(telefone.value)) {
      telefone.classList.add("is-invalid");
      Swal.fire({
        icon: 'error',
        title: 'Telefone inválido!',
        text: 'Digite apenas números (mínimo 9 dígitos).'
      });
      return false;
    }

    // valida nº documento (mínimo 5 caracteres — ajusta conforme regra de negócio)
    if (documento.value.trim() && documento.value.length < 5) {
      documento.classList.add("is-invalid");
      Swal.fire({
        icon: 'error',
        title: 'Documento inválido!',
        text: 'O documento deve ter pelo menos 5 caracteres.'
      });
      return false;
    }

    // se algum campo obrigatório faltou
    if (!formValido) {
      Swal.fire({
        icon: 'warning',
        title: 'Campos obrigatórios!',
        text: 'Preencha todos os campos antes de gravar.'
      });
      return false;
    }

    // envia se tudo certo
    e.target.submit();
  }

  document.addEventListener("DOMContentLoaded", () => {
    const form = document.querySelector("#modal-cadastro form");
    form.addEventListener("submit", validarFormularioProprietario);

    // remover borda vermelha ao digitar
    document.querySelectorAll("#modal-cadastro input").forEach(input => {
      input.addEventListener("input", () => {
        input.classList.remove("is-invalid");
      });
    });
  });
</script>
