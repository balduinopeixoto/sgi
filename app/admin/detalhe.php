<div class="content-wrapper" style="min-height: 1419.6px;">
  <?php
  
  if(isset($_GET['idimovel'])){
    $idimovel = $_GET['idimovel'];

    $select=$conexao->prepare("SELECT * FROM imovel WHERE idimovel=:idimovel");
    $select->bindValue(":idimovel", $idimovel);
    $select->execute();
    $imovel = $select->fetch(PDO::FETCH_ASSOC); 

    if (!$imovel) {
      echo "Imóvel não encontrado.";
      exit;
    }

  $selectFotos=$conexao->prepare("SELECT * FROM fotos_imoveis WHERE imovel_id=:idimovel");
  $selectFotos->bindValue(":idimovel", $idimovel);  
  $selectFotos->execute();
  $fotos = $selectFotos->fetchAll(PDO::FETCH_ASSOC);

     $imagemPrincipal = !empty($fotos) ? "../assets/img/" . $fotos[0]['caminho'] : "../assets/img/sem.PNG";
  
  
  
  ?>
    <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Detalhes do Imóvel</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="?rota=imoveis">Imóveis</a></li>
            <li class="breadcrumb-item active">Detalhes</li>
          </ol>
        </div>
      </div>
    </div>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="card card-solid">
      <div class="card-body">
        <div class="row">
          <!-- 🖼️ Imagens -->
          <div class="col-12 col-sm-6">
            <h3 class="d-inline-block d-sm-none"><?= htmlspecialchars($imovel['titulo']) ?></h3>
            <div class="col-12">
              <img src="<?= $imagemPrincipal ?>" class="product-image" alt="Imagem do imóvel">
            </div>
            <div class="col-12 product-image-thumbs">
              <?php foreach ($fotos as $foto): ?>
                <div class="product-image-thumb">
                  <img src="../assets/img/<?= htmlspecialchars($foto['caminho']) ?>" alt="Imagem do imóvel">
                </div>
              <?php endforeach; ?>
            </div>
          </div>

          <!-- 🏠 Informações -->
          <div class="col-12 col-sm-6">
            <h3 class="my-3"><?= htmlspecialchars($imovel['titulo']) ?></h3>
            <p><?= nl2br(htmlspecialchars($imovel['descricao'])) ?></p>

            <hr>
            <h4><i class="fas fa-home"></i> Tipo:</h4>
            <p><?= ucfirst($imovel['tipo']) ?></p>

            <h4><i class="fas fa-map-marker-alt"></i> Endereço:</h4>
            <p><?= htmlspecialchars($imovel['endereco']) ?></p>

            <h4><i class="fas fa-ruler-combined"></i> Área:</h4>
            <p><?= number_format($imovel['area'], 2, ',', '.') ?> m²</p>

            <div class="row mt-3">
              <div class="col-md-4"><strong>Quartos:</strong> <?= (int)$imovel['quartos'] ?></div>
              <div class="col-md-4"><strong>Banheiros:</strong> <?= (int)$imovel['banheiros'] ?></div>
              <div class="col-md-4"><strong>Garagem:</strong> <?= (int)$imovel['garagem'] ?></div>
            </div>

            <div class="bg-gray py-2 px-3 mt-4">
              <h2 class="mb-0 text-success">
                <?= number_format($imovel['preco'], 2, ',', '.') ?> AOA
              </h2>
              <h4 class="mt-0">
                <small>Estado: 
                  <?php
                    switch ($imovel['status']) {
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
                    }
                  ?>
                </small>
              </h4>
            </div>

            <div class="mt-4">
              <a href="?page=imovel" class="btn btn-secondary btn-flat">
                <i class="fas fa-arrow-left mr-2"></i> Voltar
              </a>
            </div>
          </div>
        </div>
      </div>
      <!-- /.card-body -->
    </div>
  </section>

  <?php
  
  } else {
    echo "ID do imóvel não fornecido.";
    exit;
  }
  
  
  ?>