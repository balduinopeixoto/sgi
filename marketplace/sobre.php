<?php
if(session_status() === PHP_SESSION_NONE){
    session_start();
}else{
   session_destroy();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>Sobre Nós</title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="description" content="Bluesky template project">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="styles/bootstrap4/bootstrap.min.css">
<link href="plugins/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="plugins/OwlCarousel2-2.2.1/owl.carousel.css">
<link rel="stylesheet" type="text/css" href="plugins/OwlCarousel2-2.2.1/owl.theme.default.css">
<link rel="stylesheet" type="text/css" href="plugins/OwlCarousel2-2.2.1/animate.css">
<link rel="stylesheet" type="text/css" href="styles/about.css">
<link rel="stylesheet" type="text/css" href="styles/about_responsive.css">
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
								<li><a href="./">Home</a></li>
								<li class="active"><a href="about.html">Sobre Nós</a></li>
								
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
				<li class="active"><a href="sobre.php">Sobre Nós</a></li>
			   <li><a href="visita.php">Agende uma Visita</a></li>
			</ul>
		</div>
		<div class="menu_phone"><span>Contactos </span>999412536</div>
	</div>
	
	<!-- Home -->

	<div class="home">
		<div class="parallax_background parallax-window" data-parallax="scroll" data-image-src="images/about.jpg" data-speed="0.8"></div>
		<div class="home_container">
			<div class="container">
				<div class="row">
					<div class="col">
						<div class="home_content d-flex flex-row align-items-end justify-content-start">
							<div class="home_title">Sobre Nós</div>
							<div class="breadcrumbs ml-auto">
								<ul>
									<li><a href="index.htmo">Home</a></li>
									<li>Sobre Nós</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Home Search -->
	<!--<div class="home_search">
		<div class="container">
			<div class="row">
				<div class="col">
					<div class="home_search_container">
						<div class="home_search_content">
							<form action="#" class="search_form d-flex flex-row align-items-start justfy-content-start">
								<div class="search_form_content d-flex flex-row align-items-start justfy-content-start flex-wrap">
									<div>
										<select class="search_form_select">
											<option disabled selected>For rent</option>
											<option>Yes</option>
											<option>No</option>
										</select>
									</div>
									<div>
										<select class="search_form_select">
											<option disabled selected>All types</option>
											<option>Type 1</option>
											<option>Type 2</option>
											<option>Type 3</option>
											<option>Type 4</option>
										</select>
									</div>
									<div>
										<select class="search_form_select">
											<option disabled selected>City</option>
											<option>New York</option>
											<option>Paris</option>
											<option>Amsterdam</option>
											<option>Rome</option>
										</select>
									</div>
									<div>
										<select class="search_form_select">
											<option disabled selected>Bedrooms</option>
											<option>1</option>
											<option>2</option>
											<option>3</option>
											<option>4</option>
										</select>
									</div>
									<div>
										<select class="search_form_select">
											<option disabled selected>Bathrooms</option>
											<option>1</option>
											<option>2</option>
											<option>3</option>
										</select>
									</div>
								</div>
								<button class="search_form_button ml-auto">search</button>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>-->

	<!-- About -->

	<div class="about">
		<div class="container">
			<div class="row">

				<!-- About Content -->
				<div class="col-lg-6">
					<div class="about_content">
						<div class="section_title">A Chave para o </div>
						<div class="section_subtitle">seu Sonho Imobiliários</div>
						<div class="about_text">
							<p>Na Imóvel System Gestão, acreditamos que encontrar o lar perfeito é a realização de um sonho e o início de um novo capítulo. Somos uma plataforma de gestão de imóveis dedicada a simplificar e otimizar a sua jornada no mercado imobiliário. O nosso foco é dar visibilidade e eficiência ao processo de procura e gestão, utilizando tecnologia avançada para criar uma ponte transparente entre proprietários e futuros moradores.

O nosso compromisso é Simplificar a sua pesquisa e Apoiar cada passo, mantendo a nossa plataforma na vanguarda da Inovação. Seja para comprar, vender ou gerir, a Imóvel System Gestão está aqui para transformar o complexo mercado imobiliário numa experiência satisfatória e sem complicações. </p>
						</div>
					</div>
				</div>

				<!-- About Image -->
				<div class="col-lg-6">
					<div class="about_image"><img src="images/about_image.jpg" alt=""></div>
				</div>
			</div>
			<div class="row milestones_row">

				<!-- Milestone -->
				<div class="col-lg-3 milestone_col">
					<div class="milestone d-flex flex-row align-items-center justify-content-start">
						<div class="milestone_icon d-flex flex-column align-items-center justify-content-center"><img src="images/milestones_1.png" alt=""></div>
						<div class="milestone_content">
							<div class="milestone_counter" data-end-value="20">0</div>
							<div class="milestone_text">Vendas</div>
						</div>
					</div>
				</div>

				<!-- Milestone -->
				<div class="col-lg-3 milestone_col">
					<div class="milestone d-flex flex-row align-items-center justify-content-start">
						<div class="milestone_icon d-flex flex-column align-items-center justify-content-center"><img src="images/milestones_2.png" alt=""></div>
						<div class="milestone_content">
							<div class="milestone_counter" data-end-value="20">0</div>
							<div class="milestone_text">Clientes Satisfeitos</div>
						</div>
					</div>
				</div>

				<!-- Milestone -->
				<div class="col-lg-3 milestone_col">
					<div class="milestone d-flex flex-row align-items-center justify-content-start">
						<div class="milestone_icon d-flex flex-column align-items-center justify-content-center"><img src="images/milestones_3.png" alt=""></div>
						<div class="milestone_content">
							<div class="milestone_counter" data-end-value="124">0</div>
							<div class="milestone_text">Alugado</div>
						</div>
						
					</div>
				</div>

				<!-- Milestone -->
				<!--<div class="col-lg-3 milestone_col">
					<div class="milestone d-flex flex-row align-items-center justify-content-start">
						<div class="milestone_icon d-flex flex-column align-items-center justify-content-center"><img src="images/milestones_4.png" alt=""></div>
						<div class="milestone_content">
							<div class="milestone_counter" data-end-value="25">0</div>
							<div class="milestone_text">Awards Won</div>
						</div>
					</div>
				</div>-->

			</div>
		</div>
	</div>

	<!-- Realtors -->

	<div class="realtors">
		<div class="container">
			<div class="row">
				<div class="col">
					<div class="section_title">Colaboradores</div>
					<div class="section_subtitle"></div>
				</div>
			</div>
			<div class="row realtors_row">
				
				<!-- Realtor -->
				<div class="col-lg-3 col-md-6">
					<div class="realtor_outer">
						<div class="realtor">
							<div class="realtor_image"></div>
							<div class="realtor_body">
								<div class="realtor_title">Maria Williams</div>
								<div class="realtor_subtitle">Senior Realtor</div>
							</div>
							
						</div>
						
					</div>
				</div>

				<!-- Realtor -->
				<div class="col-lg-3 col-md-6">
					<div class="realtor_outer">
						<div class="realtor">
							<div class="realtor_image"></div>
							<div class="realtor_body">
								<div class="realtor_title">Christian Smith</div>
								<div class="realtor_subtitle">Senior Realtor</div>
							</div>
							
						</div>
						
					</div>
				</div>

				<!-- Realtor -->
				<div class="col-lg-3 col-md-6">
					<div class="realtor_outer">
						<div class="realtor">
							<div class="realtor_image"></div>
							<div class="realtor_body">
								<div class="realtor_title">Steve G. Brown</div>
								<div class="realtor_subtitle">Senior Realtor</div>
							</div>
							
						</div>
						
					</div>
				</div>

				<!-- Realtor -->
				<div class="col-lg-3 col-md-6">
					<div class="realtor_outer">
						<div class="realtor">
							<div class="realtor_image"></div>
							<div class="realtor_body">
								<div class="realtor_title">Jessica Walsh</div>
								<div class="realtor_subtitle">Senior Realtor</div>
							</div>
							
						</div>
						
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
<script src="js/about.js"></script>
</body>
</html>