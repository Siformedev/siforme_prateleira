<!DOCTYPE html>
<html class="no-js">
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-171833651-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-171833651-1');
</script>
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<meta name="robots" content="index, follow">
	<meta name="language" content="Portuguese">
	<meta name="description"
		content="Plataforma de arrecadação financeira, 100% pensada e desenvolvida para Comissão de Formatura ">
	<meta name="keywords" content="arrecadação financeira, comissão de formatura, formaturas">
	<title>Siforme - Plataforma para Agências de Formaturas</title>
	<meta property="og:image:width" content="600">
	<meta property="og:image:height" content="500">

	<meta property="og:image" content="{{asset('site/img/og.png')}}">
	<link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;600;700&display=swap" rel="stylesheet">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<!-- Favicons
		================================================== -->
	<link rel="shortcut icon" href="{{asset('site/img/favicon.png')}}">
	<link rel="apple-touch-icon" href="{{asset('site/img/apple-touch-icon.png')}}">
	<link rel="apple-touch-icon" sizes="72x72" href="{{asset('site/img/apple-touch-icon-72x72.png')}}">
	<link rel="apple-touch-icon" sizes="114x114" href="{{asset('site/img/apple-touch-icon-114x114.png')}}">

	<!-- CSS
		================================================== -->




	<link rel="stylesheet" href="{{asset('site/css/font-awesome.min.css')}}">

	<link rel="stylesheet" href="{{asset('site/css/bootstrap.min.css')}}">
	<link rel="stylesheet" href="{{asset('site/css/owl.carousel.css')}}">
	<link rel="stylesheet" href="{{asset('site/css/slit-slider.css')}}">
	<link rel="stylesheet" href="{{asset('site/css/animate.css')}}">
	<link rel="stylesheet" href="{{asset('site/css/main.css')}}">
	<script src="{{asset('site/js/modernizr-2.6.2.min.js')}}"></script>

	<a href="https://api.whatsapp.com/send?l=pt&amp;phone=5511948550007"><img src="{{asset('site/img/whats.png')}}"
			class="whats" alt="whats-icone" data-selector="img"></a>

</head>

<body id="body">

	<div id="preloader">
		<div class="loder-box">
			<div class="battery"></div>
		</div>
	</div>

	<header id="navigation" class="navbar-inverse navbar-fixed-top animated-header">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
					<span class="sr-only">Toggle</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>

				</button>

				<a id="logo" href="https://siforme.com.br/"><img src="{{asset('site/img/logo.png')}}"
						alt="logotipo"></a>


				<h1 class="logotipo">
					Sistema Gerenciador de Formaturas
				</h1>
			</div>

			<nav class="collapse navbar-collapse navbar-right">
				<ul class="nav navbar-nav">
					<li><a href="{{route('login')}}">Login</a></li>
				</ul>
			</nav>

			<nav class="collapse navbar-collapse navbar-right" role="navigation">
				<ul id="nav" class="nav navbar-nav">
					<li><a href="#body">Home</a></li>
					<li><a href="#objetivo">Objetivo</a></li>
					<li><a href="#servicos">Serviços</a></li>
					<li><a href="#contato">Contato</a></li>
				</ul>
			</nav>
		</div>
	</header>


	<main class="site-content" role="main">


		<section id="home-slider">

			<div id="slider" class="sl-slider-wrapper">

				<div class="sl-slider img-responsive">

					<div class="sl-slide img-responsive" data-orientation="horizontal" data-slice1-rotation="-25"
						data-slice2-rotation="-25" data-slice1-scale="2" data-slice2-scale="2">
						<div class="bg-img bg-img-1"></div>
					</div>

					<div class="sl-slide img-responsive" data-orientation="vertical" data-slice1-rotation="10"
						data-slice2-rotation="-15" data-slice1-scale="1.5" data-slice2-scale="1.5">
						<div class="bg-img bg-img-2"></div>
					</div>

					<div class="sl-slide img-responsive" data-orientation="horizontal" data-slice1-rotation="3"
						data-slice2-rotation="3" data-slice1-scale="2" data-slice2-scale="1">
						<div class="bg-img bg-img-3"></div>
					</div>

				</div>

				<nav id="nav-arrows" class="nav-arrows hidden-xs hidden-sm visible-md visible-lg">
					<a href="javascript:;" class="sl-prev">
						<i class="fa fa-angle-left fa-3x"></i>
					</a>
					<a href="javascript:;" class="sl-next">
						<i class="fa fa-angle-right fa-3x"></i>
					</a>
				</nav>


				<nav id="nav-dots" class="nav-dots visible-xs visible-sm hidden-md hidden-lg">
					<span class="nav-dot-current"></span>
					<span></span>
					<span></span>
				</nav>

			</div>
		</section>



		<section id="about">
			<div class="container">
				<div class="row">

					<div class="col-md-12 wow animated fadeInRight">
						<div class="welcome-block">

							<div class="sec-title text-center">
								<h3 class="wow animated bounceInLeft">A Melhor Plataforma de Gestão Financeira para
									Empresas de Formatura</h3>
							</div>


							<div class="message-body">
								<img src="{{asset('site/img/graduacao.jpg')}}" class="pull-left" alt="graduacao">
								<p>Siforme foi desenvolvido e pensado para trazer o máximo de tecnologia e agilidade nos
									procedimentos internos e externos das agências de formaturas.
									Sendo assim, conseguimos após mais de 10 anos de desenvolvimento e aperfeiçoamento,
									chegar ao ápice,
									diminuindo o custo fixo das Agências, fazendo a plataforma verdadeiramente trabalhar
									24 hs de suporte ao cliente final, trazendo transferência e muita rapidez para
									agências e seus Clientes.
								</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>


		<section id="objetivo" class="parallax">
			<div class="overlay">
				<div class="container">
					<div class="row">

						<div class="sec-title text-center white wow animated fadeInDown">
							<h2>Nosso Objetivo</h2>
						</div>

						<div class=" wow animated fadeInUp">
							<div class="text-center">
								<div class="clearfix">
									<span class="seiscentos">Ser a melhor plataforma de gestão financeira para Agências
										de Formaturas</span>

								</div>
							</div>

						</div>

					</div>
				</div>
			</div>
		</section>

		<section id="servicos">
			<div class="container">
				<div class="row">

					<div class="sec-title text-center">
						<h2 class="wow animated bounceInLeft">Serviços</h2>
						<p class="seiscentos wow animated bounceInRight">Conheça nossas vantagens</p>
					</div>

					<div class="col-md-3 col-sm-6 col-xs-12 text-center wow animated zoomIn">
						<div class="service-item">
							<div class="service-icon">
								<i class="fa fa-clock-o fa-3x"></i>
							</div>
							<h3>Suporte</h3>
							<p>24 horas por dia de suporte total ao cliente final</p>
						</div>
					</div>

					<div class="col-md-3 col-sm-6 col-xs-12 text-center wow animated zoomIn" data-wow-delay="0.3s">
						<div class="service-item">
							<div class="service-icon">
								<i class="fa fa-money fa-3x"></i>
							</div>
							<h3>Custo Fixo</h3>
							<p>Grande diminuição do custo fixo das agências e transferência</p>
						</div>
					</div>

					<div class="col-md-3 col-sm-6 col-xs-12 text-center wow animated zoomIn" data-wow-delay="0.6s">
						<div class="service-item">
							<div class="service-icon">
								<i class="fa fa-heart fa-3x"></i>
							</div>
							<h3>Vantagens</h3>
							<p>Mapa de Mesas On-line, Rifa On-line, Clube de Vantagens, Lojinha Virtual da Turma e muito
								mais... </p>
						</div>
					</div>

					<div class="col-md-3 col-sm-6 col-xs-12 text-center wow animated zoomIn" data-wow-delay="0.9s">
						<div class="service-item">
							<div class="service-icon">
								<i class="fa fa-lock fa-3x"></i>
							</div>

							<h3>PagSeguro</h3>
							<p>Conte com um banco forte: o Pagseguro, que abraçou e entendeu todos os processos das
								Agências.</p>
						</div>
					</div>

				</div>
			</div>

		</section>
		<!-- end Service section -->


		<div class="container">
			<ul class="project-wrapper wow animated fadeInUp">
				<li class="portfolio-item">
					<img src="{{asset('site/img/02.jpg')}}" class="img-responsive" alt="imagem_01">
					<ul class="external">

						<li><a class="fancybox" title="Facilidade, Agilidade e Design" data-fancybox-group="works"
								href="{{asset('site/img/02.jpg')}}"><i class="fa fa-search"></i></a></li>
					</ul>
				</li>
				<li class="portfolio-item">
					<img src="{{asset('site/img/03.jpg')}}" class="img-responsive" alt="imagem_01">
					<ul class="external">
						<li><a class="fancybox" title="Mapa de Mesas Interativo e Animado" data-fancybox-group="works"
								href="{{asset('site/img/03.jpg')}}"><i class="fa fa-search"></i></a></li>
					</ul>
				</li>
				<li class="portfolio-item">
					<img src="{{asset('site/img/04.jpg')}}" class="img-responsive" alt="imagem_01">
					<ul class="external">
						<li><a class="fancybox" title="Rifa Online" data-fancybox-group="works"
								href="{{asset('site/img/04.jpg')}}"><i class="fa fa-search"></i></a></li>
					</ul>
				</li>
				<li class="portfolio-item">
					<img src="{{asset('site/img/05.jpg')}}" class="img-responsive" alt="imagem_01">
					<ul class="external">
						<li><a class="fancybox" title="Clube de Vantagens" data-fancybox-group="works"
								href="{{asset('site/img/05.jpg')}}"><i class="fa fa-search"></i></a></li>
					</ul>
				</li>
				<li class="portfolio-item">
					<img src="{{asset('site/img/06.jpg')}}" class="img-responsive" alt="imagem_01">
					<ul class="external">
						<li><a class="fancybox" title="Loja da Turma" data-fancybox-group="works"
								href="{{asset('site/img/06.jpg')}}"><i class="fa fa-search"></i></a></li>
					</ul>
				</li>
				<li class="portfolio-item">
					<img src="{{asset('site/img/07.jpg')}}" class="img-responsive" alt="imagem_01">
					<ul class="external">
						<li><a class="fancybox" title="Vendas Extras!" data-fancybox-group="works"
								href="{{asset('site/img/07.jpg')}}"><i class="fa fa-search"></i></a></li>
					</ul>
				</li>
			</ul>

		</div>





		<!-- Social section -->
		<section id="social" class="parallax">
			<div class="overlay">
				<div class="container">
					<div class="row">

						<div class="sec-title text-center white wow animated fadeInDown">
							<h2>SIGA-NOS</h2>
							<p class="seiscentos">Fique por dentro de nossas novidades nas redes sociais</p>
						</div>

						<ul class="social-button">
							<li class="wow animated zoomIn"><a href="#"><i class="fa fa-thumbs-up fa-2x"></i></a></li>
							<li class="wow animated zoomIn" data-wow-delay="0.3s"><a href="#"><i
										class="fa fa-instagram fa-2x"></i></a></li>
							<li class="wow animated zoomIn" data-wow-delay="0.6s"><a href="#"><i
										class="fa fa-youtube fa-2x"></i></a></li>
						</ul>

					</div>
				</div>
			</div>
		</section>
		<!-- end Social section -->

		<!-- Contact section -->
		<section id="contato">
			<div class="container">
				<div class="row">

					<div class="sec-title text-center wow animated fadeInDown">
						<h2>Contato</h2>
						<p class="seiscentos">Entre em contato agora mesmo!</p>
					</div>


					<div class="col-md-7 contact-form wow animated fadeInLeft">
						<form method="post" action="/contato">
							{{ csrf_field() }}
							<div class="input-field">
								<input type="text" name="nome" id="nome" class="form-control" required
									placeholder="Seu Nome...">
							</div>
							<div class="input-field">
								<input type="email" name="email" id="email" class="form-control" required
									placeholder="Seu E-mail...">
							</div>
							<div class="input-field">
								<input type="telefone" name="telefone" id="telefone" class="form-control" required
									placeholder="Seu Telefone...">
							</div>
							<div class="input-field">
								<textarea name="mensagem" id="mensagem" class="form-control" required
									placeholder="Mensagem..."></textarea>
							</div>
							<button name="BTEnvia" type="submit" id="submit"
								class="btn btn-blue btn-effect">ENVIAR</button>
						</form>
					</div>

					<div class="col-md-5 wow animated fadeInRight">
						<address class="contact-details">
							<h3>Solicite agora seu orçamento!</h3>
							<p><i class="fa fa-pencil"></i>Av. Paulista 2073<br>São Paulo/SP - CEP 01311-300</p><br>
							<p><i class="fa fa-phone"></i><a href="tel:5511948550007">Tel.: (11) 94855-0007</a></p>
							<p><i class="fa fa-envelope"></i><a
									href="mailto:contato@siforme.com.br">contato@siforme.com.br</a></p>
						</address>
					</div>

				</div>
			</div>
		</section>

		<section id="google-map">
			<iframe
				src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d7314.587261314799!2d-46.66256274343545!3d-23.55789544530395!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xc84500afe89dd017!2sAvenida%20Paulista%2C%202073!5e0!3m2!1spt-PT!2sbr!4v1585684105932!5m2!1spt-PT!2sbr"
				width="100%" height="450" frameborder="0" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
		</section>

	</main>

	<footer id="footer">
		<div class="container">
			<div class="row text-center">
				<div class="footer-content">

					<div class="row">
						<div class="col-md-6 col-6">
							<img id="logoA" src="{{asset('site/img/logo_footer.png')}}" alt="logo">

						</div>
						<div class="col-md-6 col-6">
							<img id="logoPag" src="{{asset('site/img/pag_seguro.png')}}" alt="pag_seguro">
						</div>
					</div>


					<p>Copyright &copy; 2020 - Siforme</p>
				</div>
			</div>
		</div>
	</footer>

	<!-- Essential jQuery Plugins
				================================================== -->

	<script src="{{asset('site/js/jquery-1.11.1.min.js')}}"></script>
	<script src="{{asset('site/js/bootstrap.min.js')}}"></script>
	<script src="{{asset('site/js/jquery.singlePageNav.min.js')}}"></script>
	<script src="{{asset('site/js/jquery.fancybox.pack.js')}}"></script>
	<script src="https://maps.google.com/maps/api/js?sensor=false"></script>
	<script src="{{asset('site/js/owl.carousel.min.js')}}"></script>
	<script src="{{asset('site/js/jquery.easing.min.js')}}"></script>
	<script src="{{asset('site/js/jquery.slitslider.js')}}"></script>
	<script src="{{asset('site/js/jquery.ba-cond.min.js')}}"></script>
	<script src="{{asset('site/js/wow.min.js')}}"></script>
	<script src="{{asset('site/js/main.js')}}"></script>
</body>

</html>