<?php

if(session_status() === PHP_SESSION_NONE){
    session_start();
}else{
   session_destroy();
}


require_once '../conexao/conexao.php';
$conexao = ligar();

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $sql = "SELECT * FROM imovel WHERE idimovel = :id";
    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $imovel = $stmt->fetch(PDO::FETCH_ASSOC);

    if(!$imovel){
        header("Location: ./");
        exit();
    }

    $files=array();   
    $sql_files = "SELECT caminho FROM fotos_imoveis WHERE imovel_id = :id";
    $stmt_files = $conexao->prepare($sql_files);
    $stmt_files->bindParam(':id', $id);
    $stmt_files->execute();
    $files = $stmt_files->fetchAll(PDO::FETCH_ASSOC);   
}else{

    header("Location: ./");
    exit();
}



?>



<!DOCTYPE html>
<html lang="pt">
<head>
<title>Detalhe</title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="description" content="Bluesky template project">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="styles/bootstrap4/bootstrap.min.css">
<link href="plugins/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="plugins/OwlCarousel2-2.2.1/owl.carousel.css">
<link rel="stylesheet" type="text/css" href="plugins/OwlCarousel2-2.2.1/owl.theme.default.css">
<link rel="stylesheet" type="text/css" href="plugins/OwlCarousel2-2.2.1/animate.css">
<link rel="stylesheet" type="text/css" href="plugins/rangeslider.js-2.3.0/rangeslider.css">
<link rel="stylesheet" type="text/css" href="styles/property.css">
<link rel="stylesheet" type="text/css" href="styles/property_responsive.css">
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
								<li class="menu_item"><a href="./">Home</a></li>
				<li class="menu_item"><a href="sobre.php">Sobre Nós</a></li>
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

	<!-- Menu -->

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
				<li class="menu_item"><a href="./">Home</a></li>
				<li class="menu_item"><a href="sobre.php">Sobre Nós</a></li>
				<li><a href="visita.php">Agende uma Visita</a></li>
				
			</ul>
		</div>
		<div class="menu_phone"><span>Contactos: </span>999412536</div>
	</div>
	
	<br>
	<br>
	<br>

	<!-- Home Search 
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

	 Intro -->

	<div class="intro">
		<div class="container">
			<div class="row">
				<div class="col">
					<div class="intro_content d-flex flex-lg-row flex-column align-items-start justify-content-start">
						<div class="intro_title_container">
							<div class="intro_title"><?=$imovel['titulo']?></div>
							<div class="intro_tags">
								<!--<ul>
									<li><a href="#">Hottub</a></li>
									<li><a href="#">Swimming Pool</a></li>
									<li><a href="#">Garden</a></li>
									<li><a href="#">Patio</a></li>
									<li><a href="#">Hard Wood Floor</a></li>
								</ul>-->
							</div>
						</div>
						<div class="intro_price_container ml-lg-auto d-flex flex-column align-items-start justify-content-center">
							<div>A venda /Aluguer por apenas </div>
							<div class="intro_price"><?= number_format($imovel['preco'], 2,',','.')?> AOA</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="intro_slider_container">

			<!-- Intro Slider -->
			<div class="owl-carousel owl-theme intro_slider">
				<?php
                foreach($files as $file){
                    
                ?>
				<div class="owl-item"><img src="../app/assets/img/<?=$file['caminho']?>" alt="" height="500"></div>
				<?php }?>
			</div>

			<!-- Intro Slider Nav -->
			<div class="intro_slider_nav_container">
				<div class="container">
					<div class="row">
						<div class="col">
							<div class="intro_slider_nav_content d-flex flex-row align-items-start justify-content-end">
								<div class="intro_slider_nav intro_slider_prev"><i class="fa fa-chevron-left" aria-hidden="true"></i></div>
								<div class="intro_slider_nav intro_slider_next"><i class="fa fa-chevron-right" aria-hidden="true"></i></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Property -->

	<div class="property">
		<div class="container">
			<div class="row">
				
				<!-- Sidebar -->

				
				
				<!-- Property Content -->
				<div class="col-lg-12 offset-lg-1">
					<div class="property_content">
						<div class="property_icons">
							<div class="property_title">Comodidades Extras</div>
							<div class="property_text property_text_1">
								<p>informações sobre o imóvel</p>
							</div>
							<div class="property_rooms d-flex flex-sm-row flex-column align-items-start justify-content-start">

								<!-- Property Room Item -->
								<div class="property_room">
									<div class="property_room_title">Quartos</div>
									<div class="property_room_content d-flex flex-row align-items-center justify-content-start">
										<div class="room_icon"><img src="images/room_1.png" alt=""></div>
										<div class="room_num"><?=$imovel['quartos']?></div>
									</div>
								</div>

								<!-- Property Room Item -->
								<div class="property_room">
									<div class="property_room_title">Banheiros</div>
									<div class="property_room_content d-flex flex-row align-items-center justify-content-start">
										<div class="room_icon"><img src="images/room_2.png" alt=""></div>
										<div class="room_num"><?=$imovel['banheiros']?></div>
									</div>
								</div>

								<!-- Property Room Item -->
								<div class="property_room">
									<div class="property_room_title">Area</div>
									<div class="property_room_content d-flex flex-row align-items-center justify-content-start">
										<div class="room_icon"><img src="images/room_3.png" alt=""></div>
										<div class="room_num"><?=$imovel['area']?> Ft</div>
									</div>
								</div>

								<!-- Property Room Item 
								<div class="property_room">
									<div class="property_room_title">Patio</div>
									<div class="property_room_content d-flex flex-row align-items-center justify-content-start">
										<div class="room_icon"><img src="images/room_4.png" alt=""></div>
										<div class="room_num">1</div>
									</div>
								</div>-->

								<!-- Property Room Item -->
								<div class="property_room">
									<div class="property_room_title">Garagem</div>
									<div class="property_room_content d-flex flex-row align-items-center justify-content-start">
										<div class="room_icon"><img src="images/room_5.png" alt=""></div>
										<div class="room_num"><?=$imovel['garagem']?></div>
									</div>
								</div>

							</div>
						</div>

						<!-- Description -->

						<div class="property_description">
							<div class="property_title">Detalhes</div>
							<div class="property_text property_text_2">
								<p><?=$imovel['descricao']?></p>
							</div>
						</div>

						<!-- Additional Details 

						<div class="additional_details">
							<div class="property_title">Additional Details</div>
							<div class="details_container">
								<ul>
									<li><span>bedroom features: </span>Main Floor Master Bedroom, Walk-In Closet</li>
									<li><span>dining area: </span>Breakfast Counter/Bar, Living/Dining Combo</li>
									<li><span>doors & windows: </span>Bay Window</li>
									<li><span>entry location: </span>Mid Level</li>
									<li><span>floors: </span>Raised Foundation, Vinyl Tile, Wall-to-Wall Carpet, Wood</li>
								</ul>
							</div>
						</div>

					 Property On Map -->

						
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
<script src="plugins/rangeslider.js-2.3.0/rangeslider.min.js"></script>
<script src="plugins/parallax-js-master/parallax.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyCIwF204lFZg1y4kPSIhKaHEXMLYxxuMhA"></script>
<script src="js/property.js"></script>
</body>
</html>