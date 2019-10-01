<!-- O primeiro include deve ser config.php -->

<?php require_once('config.php') ?>

<?php require_once( ROOT_PATH . '/includes/registration_login.php') ?> 

<!-- config.php deve estar aqui como o primeiro incluir  -->

<?php require_once( ROOT_PATH . '/includes/public_functions.php') ?>

<!--Recuperar todas as postagens do banco de dados  -->
<?php $posts = getPublishedPosts(); ?>
<?php $postsc = getPublishedPostss(); ?>
<?php require_once( ROOT_PATH . '/includes/head_section.php') ?>
	<title>DEpois da Escola </title>
</head>

<?php include( ROOT_PATH . '/includes/navbar.php'); ?>
		
<div class="pageheader-content row">
            <div class="col-full">

                <div class="featured">

                    <div class="featured__column featured__column--big">
                        <div class="entry" style="background-image:url('static/images/banner.jpg');">
                            
                            <div class="entry__content">
                                <span class="entry__category"><a href="#0">Inspirção</a></span>

                                <h1><a href="#0" title="">Um dia sua vida irá piscar diante dos seus olhos. <br> 
        Certifique-se de que vale a pena assistir.</a></h1>

                                <div class="entry__info">
                                    <a href="#0" class="entry__profile-pic">
                                        <img class="avatar" src="static/images/avatars/user-03.jpg" alt="">
                                    </a>

                                    <ul class="entry__meta">
                                        <li><a href="#0">~ Gerard Way</a></li>
                                        <li>Julnho 15, 2019</li>
                                    </ul>
                                </div>
                            </div> <!-- end entry__content -->
                            
                        </div> <!-- end entry -->
                    </div> <!-- end featured__big -->

					<div class="featured__column featured__column--small">
					<?php foreach ($postsc as $post): ?>
<div class="entry" style="background-image:url('<?php echo BASE_URL . '/static/images/' . $post['image']; ?>');">
<?php if (isset($post['topic']['name'])): ?>
	<div class="entry__content">
		<span class="entry__category"><a href="<?php echo BASE_URL . 'filtered_posts.php?topic=' . $post['topic']['id'] ?>">
				<?php echo $post['topic']['name'] ?></span>

		<h1><a href="#0" title=""><?php echo $post['title'] ?></a></h1>

		<div class="entry__info">
			<a href="#0" class="entry__profile-pic">
				<img class="avatar" src="images/avatars/user-03.jpg" alt="">
			</a>

			<ul class="entry__meta">
				<li><a href="#0">John Doe</a></li>
				<li>December 27, 2017</li>
			</ul>
		</div>
	</div> <!-- end entry__content -->
  
</div> <!-- end entry -->
<?php endif ?>

<?php endforeach ?>
<!-- end entry -->

</div> <!-- end featured__small -->
</div> <!-- end featured -->

</div> <!-- end col-full -->
</div> <!-- end pageheader-content row -->

</section> <!-- end s-pageheader -->

<section class="s-content">

<div class="row masonry-wrap">
            <div class="masonry">
			<div class="grid-sizer"></div>
		
			
			<?php foreach ($posts as $post): ?>
			<article class="masonry__brick entry format-standard" data-aos="fade-up">
			<div class="entry__thumb">
			<a href="single_post.php?post-slug=<?php echo $post['slug']; ?>" class="entry__thumb-link">
		<img src="<?php echo BASE_URL . '/static/images/' . $post['image']; ?>" class="post_image" alt="">
</a>
</div>
        <!-- Adicionado esta declaração if ... -->
		<?php if (isset($post['topic']['name'])): ?>
		
		<div class="entry__text">
                        <div class="entry__header">

						<div class="entry__date">
								<a href="single-standard.html"><?php echo date("F j, Y ", strtotime($post["created_at"])); ?></a>
</div>
								<h1 class="entry__title"><?php echo $post['title'] ?></h1>
							</div>
							<div class="entry__excerpt">
							<p>
                                Lorem ipsum Sed eiusmod esse aliqua sed incididunt aliqua incididunt mollit id et sit proident dolor nulla sed commodo est ad minim elit reprehenderit nisi officia aute incididunt velit sint in aliqua...
                            </p>
						</div>
						<div class="entry__meta">
                            <span class="entry__meta-links">
							<a href="<?php echo BASE_URL . 'filtered_posts.php?topic=' . $post['topic']['id'] ?>">
				<?php echo $post['topic']['name'] ?>
			</a>
			</span>
                        </div>
					</div>
					</article> <!-- end article -->
		<?php endif ?>

<?php endforeach ?>
	
</div>
</div>
</section>

<section class="s-extra">

<div class="row top">

	<div class="col-eight md-six tab-full popular">
		<h3>Posts Populares</h3>

		<div class="block-1-2 block-m-full popular__posts">
		<?php foreach ($posts as $post): ?>
		<article class="col-block popular__post">
                        <a href="#0" class="popular__thumb">
                            <img src="<?php echo BASE_URL . '/static/images/' . $post['image']; ?>" width="150" alt="">
                        </a>
                        <h5><a href="#0"><?php echo $post['title'] ?></a></h5>
                        <section class="popular__meta">
                            <span class="popular__author"><span>Por</span> <a href="#0"> Renan Rodrigues</a></span>
                            <span class="popular__date"><span>em</span> <?php echo date("F j, Y ", strtotime($post["created_at"])); ?></span>
                        </section>
					</article>
					<?php endforeach ?>
                </div> <!-- end popular_posts -->
            </div> <!-- end popular -->
			
	
	<div class="col-four md-six tab-full about">
		<h3>Sobre Depois da Escola</h3>

		<p>
		O Depois da Escola vem com intuito de a cada dia integrar a sua vida aos estudos e desenvolver facilidade com o seu aprendizagem com apenas um clique as suas portas são variadas. Estamos aqui não por nós mas por pessoas como você que buscam melhorar e desenvolver suas capacidades.
		</p>

		<ul class="about__social">
			<li>
				<a href="#0"><i class="fa fa-facebook" aria-hidden="true"></i></a>
			</li>
			<li>
				<a href="#0"><i class="fa fa-twitter" aria-hidden="true"></i></a>
			</li>
			<li>
				<a href="#0"><i class="fa fa-instagram" aria-hidden="true"></i></a>
			</li>
			<li>
				<a href="#0"><i class="fa fa-pinterest" aria-hidden="true"></i></a>
			</li>
		</ul> <!-- end header__social -->
	</div> <!-- end about -->

</div> <!-- end row -->

<div class="row bottom tags-wrap">
	<div class="col-full tags">
		<h3>Categorias</h3>

		<div class="tagcloud">
			<a href="#0">Desenvolvimento</a>
			<a href="#0">Tecnologia</a>
			<a href="#0">Dia a Dia</a>
			<a href="#0">Noite</a>
			<a href="#0">Amigos</a>
			<a href="#0">Viagem</a>
			<a href="#0">Exercícios</a>
			<a href="#0">Leitura</a>
			<a href="#0">Corrida</a>
			<a href="#0">Você mesmo</a>
			<a href="#0">Férias</a>
		</div> <!-- end tagcloud -->
	</div> <!-- end tags -->
</div> <!-- end tags-wrap -->

</section> <!-- end s-extra -->


<!-- s-footer
================================================== -->
<footer class="s-footer">

<div class="s-footer__main">
	<div class="row">
		
		<div class="col-two md-four mob-full s-footer__sitelinks">
				
			<h4>Links Rápidos</h4>

			<ul class="s-footer__linklist">
				<li><a href="#0">Home</a></li>
				<li><a href="#0">Blog</a></li>
				<li><a href="#0">Estilos</a></li>
				<li><a href="#0">Sobre</a></li>
				<li><a href="#0">Contato</a></li>
				<li><a href="#0">Políticas de Privacidade</a></li>
			</ul>

		</div> <!-- end s-footer__sitelinks -->

		<div class="col-two md-four mob-full s-footer__archives">
				
			<h4>Arquivos</h4>

			<ul class="s-footer__linklist">
				<li><a href="#0">Janeiro 2018</a></li>
				<li><a href="#0">Dezembro 2017</a></li>
				<li><a href="#0">Novembro 2017</a></li>
				<li><a href="#0">Outubro 2017</a></li>
				<li><a href="#0">Setembro 2017</a></li>
				<li><a href="#0">Agosto 2017</a></li>
			</ul>

		</div> <!-- end s-footer__archives -->

		<div class="col-two md-four mob-full s-footer__social">
				
			<h4>Social</h4>

			<ul class="s-footer__linklist">
				<li><a href="#0">Facebook</a></li>
				<li><a href="#0">Instagram</a></li>
				<li><a href="#0">Twitter</a></li>
				<li><a href="#0">Pinterest</a></li>
				<li><a href="#0">Google+</a></li>
				<li><a href="#0">LinkedIn</a></li>
			</ul>

		</div> <!-- end s-footer__social -->

		<div class="col-five md-full end s-footer__subscribe">
				
			<h4>Nossa newsletter</h4>

			<p>Sit vel delectus amet officiis repudiandae est voluptatem. </p>

			<div class="subscribe-form">
				<form id="mc-form" class="group" novalidate="true">

					<input type="email" value="" name="EMAIL" class="email" id="mc-email" placeholder="Email Address" required="">
		
					<input type="submit" name="subscribe" value="Enviar">
		
					<label for="mc-email" class="subscribe-message"></label>
		
				</form>
			</div>

		</div> <!-- end s-footer__subscribe -->

	</div>
</div> <!-- end s-footer__main -->

<div class="s-footer__bottom">
	<div class="row">
		<div class="col-full">
			<div class="s-footer__copyright">
				<span>© Copyright Depois da Escola 2018</span> 
				<span>Site criado por <a href="https://colorlib.com/">RR</a></span>
			</div>

			<div class="go-top">
				<a class="smoothscroll" title="Back to Top" href="#top"></a>
			</div>
		</div>
	</div>
</div> <!-- end s-footer__bottom -->

</footer> <!-- end s-footer -->


<!-- preloader
================================================== -->
<div id="preloader">
<div id="loader">
	<div class="line-scale">
		<div></div>
		<div></div>
		<div></div>
		<div></div>
		<div></div>
	</div>
</div>
</div>

		<!-- footer -->
		<?php include( ROOT_PATH . '/includes/footer.php') ?>
		<!-- // footer -->