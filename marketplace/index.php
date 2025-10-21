<?php

if(session_status() === PHP_SESSION_NONE){
    session_start();
}else{
   session_destroy();
}

require_once '../conexao/conexao.php';
$conexao = ligar();


?>

<!DOCTYPE html>
<html lang="pt">
<head>
<title>SGI</title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="description" content="Bluesky template project">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="styles/bootstrap4/bootstrap.min.css">
<link href="plugins/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="plugins/OwlCarousel2-2.2.1/owl.carousel.css">
<link rel="stylesheet" type="text/css" href="plugins/OwlCarousel2-2.2.1/owl.theme.default.css">
<link rel="stylesheet" type="text/css" href="plugins/OwlCarousel2-2.2.1/animate.css">
<link rel="stylesheet" type="text/css" href="styles/properties.css">
<link rel="stylesheet" type="text/css" href="styles/properties_responsive.css">
</head>
<body>

<div class="super_container">

	<!-- Header -->	

	<header class="header">
		<div class="container">
			<div class="row">
				<div class="col">
					<div class="header_content d-flex flex-row align-items-center justify-content-start">
						<div class="logo">
							<a href="#"><img src="images/logo.png" alt=""></a>
						</div>
						<nav class="main_nav">
							<ul>
								<li class="active"><a href="./">Home</a></li>
								<li><a href="sobre.php">Sobre Nós</a></li>
								<li><a href="visita.php">Agende uma Visita</a></li>
							</ul>
						</nav>
						<div class="phone_num ml-auto">
							<div class="phone_num_inner">
								<a href="login.php"><span>Login</span></a>
							</div>
						</div>
						<div class="hamburger ml-auto"><i class="fa fa-bars" aria-hidden="true"></i></div>
					</div>
				</div>
			</div>
		</div>
	</header>

	<!-- Menu 2,597,145.292 -->

	<div class="menu trans_500">
		<div class="menu_content d-flex flex-column align-items-center justify-content-center text-center">
			<div class="menu_close_container"><div class="menu_close"></div></div>
			<div class="logo menu_logo">
				<a href="#">
					<div class="logo_container d-flex flex-row align-items-start justify-content-start">
						<div class="logo_image"><div><img src="images/logo.png" alt=""></div></div>
					</div>
				</a>
			</div>
			<ul>
				<li class="active"><a href="./">Home</a></li>
				<li class="menu_item"><a href="sobre.php">Sobre Nós</a></li>
				<li><a href="visita.php">Agende uma Visita</a></li>
				
			</ul>
		</div>
		<div class="menu_phone"><span>Contactos: </span>999412536</div>
	</div>
	
	<!-- Home -->

	<div class="home">
		<div class="parallax_background parallax-window" data-parallax="scroll" data-image-src="images/properties.jpg" data-speed="0.8"></div>
		<div class="home_container">
			<div class="container">
				<div class="row">
					<div class="col">
						<div class="home_content d-flex flex-row align-items-end justify-content-start">
							<div class="home_title">Pesquisar</div>
							<div class="breadcrumbs ml-auto">
								<ul>
									<li><a href="index.htmo">Home</a></li>
									<li>Pesquisar Resultados</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Home Search -->
	<div class="home_search">
		<div class="container">
			<div class="row">
				<div class="col">
					<div class="home_search_container">
						<div class="home_search_content">
							<form action="#" class="search_form d-flex flex-row align-items-start justfy-content-start">
								<div class="search_form_content d-flex flex-row align-items-start justfy-content-start flex-wrap">
									<div>
										<select class="search_form_select">
											<option disabled selected>Disponibilidade</option>
											<option>Venda</option>
											<option>Renda</option>
										</select>
									</div>
									<div>
										<select class="search_form_select">
											<option disabled selected>Todos Tipo</option>
											<option value="apartamento">Apartamento</option>
											<option>Moradia</option>
											<option>Casa</option>
										
										</select>
									</div>
									<div>
										<select class="search_form_select">
											<option disabled selected>Cidade</option>
											<option>New York</option>
											<option>Paris</option>
											<option>Amsterdam</option>
											<option>Rome</option>
										</select>
									</div>
									<div>
										<select class="search_form_select">
											<option disabled selected>Quartos</option>
											<option>1</option>
											<option>2</option>
											<option>3</option>
											<option>4</option>
										</select>
									</div>
									<div>
										<select class="search_form_select">
											<option disabled selected>Banheiros</option>
											<option>1</option>
											<option>2</option>
											<option>3</option>
										</select>
									</div>
								</div>
								<button class="search_form_button ml-auto">Pesquisar</button>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Properties -->

	<div class="properties">
		<div class="container">
			<div class="row">
				<div class="col">
					<div class="section_title"><?=$conexao->query("SELECT COUNT(*) AS total FROM imovel")->fetchColumn();?> imoveis encontrados</div>
					<div class="section_subtitle">procura a sua casa dos sonhos</div>
				</div>
			</div>
			<div class="row properties_row">
				
				<!-- Property -->

				<?php 
				$sem_foto="../app/assets/img/sem.png";
				$selecionar_imovel = $conexao->query("SELECT * FROM imovel order by idimovel DESC");
				if($selecionar_imovel->rowCount()<=0){
					echo "Nenhum imovel encontrado";
				}
				while($row_imovel = $selecionar_imovel->fetch(PDO::FETCH_ASSOC)){
				$sel=$conexao->query("SELECT * FROM fotos_imoveis WHERE imovel_id=".$row_imovel['idimovel']." and principal=1 LIMIT 1");
				$row_imagem = $sel->fetch(PDO::FETCH_ASSOC);
				if(!isset($row_imagem['caminho'])){
					
					$row_imagem['caminho']="sem.png";
				}
				?>
				<div class="col-xl-4 col-lg-6 property_col">
					<div class="property">
						<div class="property_image">
							<img src="../app/assets/img/<?=$row_imagem['caminho']?>" alt="imagem não disponível" width="600" height="250">
							<?php
							if($row_imovel['status'] == "disponivel"){

								echo '<div class="tag_new property_tag"><a href="#">Disponível</a></div>';

							}else if($row_imovel['status'] == "alugado"){
								echo '<div class="tag_offer property_tag"><a href="#">Alugado</a></div>';
							}else{
								echo '<div class="tag_featured property_tag"><a href="#">Vendido</a></div>';
							}
							
							?>
						</div>
						<div class="property_body text-center">
							<div class="property_location"><?=$row_imovel['endereco']?></div>
							<div class="property_title"><a href="detalhe.php?id=<?=$row_imovel['idimovel']?>"><?=$row_imovel['titulo']?></a></div>
							<div class="property_price"><?=number_format($row_imovel['preco'],2,",",".")?></div>
						</div>
						<div class="property_footer d-flex flex-row align-items-center justify-content-start">
							<div><div class="property_icon"><img src="images/icon_1.png" alt=""></div><span><?=$row_imovel['area']?> M2</span></div>
							<div><div class="property_icon"><img src="images/icon_2.png" alt=""></div><span><?=$row_imovel['quartos']?> Quartos</span></div>
							<div><div class="property_icon"><img src="images/icon_3.png" alt=""></div><span><?=$row_imovel['banheiros']?> Banheiros</span></div>
						</div>
					</div>
				</div>
<?php }  ?>
				<!-- Property -->
				

			</div>
			<div class="row">
				<div class="col">
					<div class="pagination">
						<ul>
							<li class="active"><a href="#">01.</a></li>
							<li><a href="#">02.</a></li>
							<li><a href="#">03.</a></li>
							<li><a href="#">04.</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Newsletter -->

	<div class="newsletter">
		<div class="parallax_background parallax-window" data-parallax="scroll" data-image-src="images/newsletter.jpg" data-speed="0.8"></div>
		<div class="container">
			<div class="row">
				<div class="col">
					<div class="newsletter_content d-flex flex-lg-row flex-column align-items-start justify-content-start">
						<div class="newsletter_title_container">
							<div class="newsletter_title">Queres comprar ou alugar?</div>
							<div class="newsletter_subtitle">procura a sua casa dos sonhos</div>
						</div>
						<div class="newsletter_form_container">
							<form action="#" class="newsletter_form">
								<input type="email" class="newsletter_input" placeholder="Por favor insira o seu email" required="required">
								<button class="newsletter_button">Enviar </button>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Footer -->

	<footer class="footer">
		<div class="footer_main">
			
		</div>
		<div class="footer_bar">
			<div class="container">
				<div class="row">
					<div class="col">
						<div class="footer_bar_content d-flex flex-row align-items-center justify-content-start">
							<div class="cr"><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
Copyright &copy;<script>document.write(new Date().getFullYear());</script> Todos dos direitos reservados<i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="#" >SGI</a>
<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
</div>
					
						</div>
					</div>
				</div>
			</div>
		</div>
	</footer>
</div>

<script src="js/jquery-3.2.1.min.js"></script>
<script src="styles/bootstrap4/popper.js"></script>
<script src="styles/bootstrap4/bootstrap.min.js"></script>
<script src="plugins/greensock/TweenMax.min.js"></script>
<script src="plugins/greensock/TimelineMax.min.js"></script>
<script src="plugins/scrollmagic/ScrollMagic.min.js"></script>
<script src="plugins/greensock/animation.gsap.min.js"></script>
<script src="plugins/greensock/ScrollToPlugin.min.js"></script>
<script src="plugins/OwlCarousel2-2.2.1/owl.carousel.js"></script>
<script src="plugins/easing/easing.js"></script>
<script src="plugins/parallax-js-master/parallax.min.js"></script>
<script src="js/properties.js"></script>
</body>
</html>