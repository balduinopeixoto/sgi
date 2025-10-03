

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
            <h1>Usuários Registrados</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Painel</a></li>
              <li class="breadcrumb-item active">Usuários Usuários Registrados</li>
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
             > <i class="fas fa-user-plus"> Novo Usuário</i></button>
              
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Nome</th>
                  <th>E-mail</th>
                  <th>Telefone</th>
                  <th>Usuário</th>
                  <th>Estado</th>
                  <th>Accçãoe</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                  <td>Trident</td>
                  <td>InternetExplorer 4.0</td>
                  <td>Win 95+</td>
                  <td> 4</td>
                  <td>X</td>
                  <td>
                    <a href="#" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                    <a href="#" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>
                </td>
                </tr>
              
              
                </tbody>
                
                
              </table>

              
            </div>
            <div class="col-sm-12 col-md-7" >
                <div class="dataTables_paginate paging_simple_numbers" id="example2_paginate" style="float: right;">
                    <ul class="pagination">
                        <li class="paginate_button page-item previous disabled" id="example2_previous"><a href="#" aria-controls="example2" data-dt-idx="0" tabindex="0" class="page-link">anterior</a></li>
                        <li class="paginate_button page-item active"><a href="#" aria-controls="example2" data-dt-idx="1" tabindex="0" class="page-link">1</a></li>
                        <li class="paginate_button page-item "><a href="#" aria-controls="example2" data-dt-idx="2" tabindex="0" class="page-link">2</a></li>
                        <li class="paginate_button page-item "><a href="#" aria-controls="example2" data-dt-idx="3" tabindex="0" class="page-link">3</a></li>
       
                        <li class="paginate_button page-item next" id="example2_next"><a href="#" aria-controls="example2" data-dt-idx="7" tabindex="0" class="page-link">próximo</a></li></ul></div></div>
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
              <h4 class="modal-title">Cadastro de Usuários (*) campos obrigatórios</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <form action="../../controller/usuarioController.php?acao=cadastrar" method="POST" onsubmit="validarFormularioCadastro(e)">
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
                    <label for="exampleInputEmail1">Usuário</label>
                    <input type="text" name="usuario" class="form-control" id="usuario" placeholder="Digite o nome de usuário">
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
                    <label for="exampleInputEmail1">Senha</label>
                    <input type="password" name="senha" class="form-control" id="senha" placeholder="Digite a senha">
                  </div>
             </div>
              <div class="col-md-6">
             <div class="form-group">
                    <label for="exampleInputEmail1">Confirma-senha</label>
                    <input type="password" name="confirmar-senha" class="form-control" id="confirmar-senha" placeholder="Confirme a senha">
                  </div>
             </div>

              <!--<div class="col-md-6">
                <div class="form-group">
                  <label>Minimal</label>
                  <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" data-select2-id="1" tabindex="-1" aria-hidden="true">
                    <option selected="selected" data-select2-id="3">Alabama</option>
                    <option>Alaska</option>
                    <option>California</option>
                    <option>Delaware</option>
                    <option>Tennessee</option>
                    <option>Texas</option>
                    <option>Washington</option>
                  </select>
                </div>
             </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Minimal</label>
                  <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" data-select2-id="1" tabindex="-1" aria-hidden="true">
                    <option selected="selected" data-select2-id="3">Alabama</option>
                    <option>Alaska</option>
                    <option>California</option>
                    <option>Delaware</option>
                    <option>Tennessee</option>
                    <option>Texas</option>
                    <option>Washington</option>
                  </select>
                </div>
             </div>-->
             
               
               
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