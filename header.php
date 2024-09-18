<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<body>

	<head>
		<meta charset="<?php bloginfo('charset'); ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<title><?php wp_title(); ?></title>
		<?php wp_head(); ?>
	</head>
	<?php
	// Получаем текущий домен
	$current_domain = parse_url(home_url(), PHP_URL_HOST);

	// Получаем ссылку на каталог и блог из базы данных
	$catalog_url = get_field("catalog_link", "option");
	$blog_url = get_field("blog_link", "option");
	$favorits_url = get_field("favorits_link", "option");
	$cart_url = get_field("cart_link", "option");
	// Функция для замены домена в ссылке на текущий
	function replace_domain($url, $current_domain)
	{
		$url_domain = parse_url($url, PHP_URL_HOST);
		if ($url_domain && $url_domain !== $current_domain) {
			// Заменяем домен на текущий
			$url = str_replace($url_domain, $current_domain, $url);
		}
		return $url;
	}

	// Применяем функцию к нашим ссылкам
	$catalog_url = replace_domain($catalog_url, $current_domain);
	$blog_url = replace_domain($blog_url, $current_domain);
	$favorits_url = replace_domain($favorits_url, $current_domain);
	$cart_url = replace_domain($cart_url, $current_domain);
	?>

	<header class="header">
		<div class="header_top">
			<div class="header_top-wrapper">
				<div class="social-icons">
					<a href="<?php the_field("whatsapp", "option"); ?>" target="_blank">
						<img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/svg/WhatsApp.svg"
							alt="WhatsApp">
					</a>
					<a href="<?php the_field("Viber", "option"); ?>" target="_blank">
						<img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/svg/Viber.svg" alt="Viber">
					</a>
					<a href="<?php the_field("telegram", "option"); ?>" target="_blank">
						<img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/svg/Telegram.svg"
							alt="Telegram">
					</a>
					<a href="<?php the_field("vk", "option"); ?>" target="_blank">
						<img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/svg/VK.svg" alt="VK">
					</a>
				</div>
				<div class="logo_mob">
					<a href="<?php echo home_url(); ?>">
						<div class="logo">
							<img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/svg/logo.svg" alt="Logo">
						</div>
					</a>
				</div>
				<div class="contact-info">
					<a class="tel" href="tel:<?php the_field("tel_link", "option"); ?>" target="_blank">
						<span class="phone">
							<img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/svg/phone.svg"
								class="phone">
							</img> <?php the_field("tel", "option"); ?>
						</span>
					</a>
					<a class="mail" href="mailto:<?php the_field("email", "option"); ?>" target="_blank">
						<span class="email">
							<img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/svg/mail.svg"
								class="envelope">
							</img> <?php the_field("email", "option"); ?>
						</span>
					</a>
					<a class="cart_mobile" href="<?php echo esc_url($favorits_url); ?>" class="icon">
						<img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/svg/favorites.svg"
							class="heart"></img>
						<span class="badge favorites-badge" id="favorites-badge">0</span>
					</a>
					<a class="cart_mobile" href="<?php echo esc_url($cart_url); ?>" class="icon">
						<img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/svg/basket.svg"
							class="shopping-bag"></img>
						<span class="badge cart-badge" id="cart-badge">0</span>
					</a>
				</div>
			</div>
		</div>
		<div class="header_bottom">
			<div class="header_bottom-wrapper">
				<nav class="nav">
					<a href="<?php echo home_url(); ?>" class="nav-item"><img
							src="<?php echo esc_url(get_template_directory_uri()); ?>/img/svg/home.svg"
							class="home"></img> <span class="nav-text">Главная</span></a>
					<a href="<?php echo esc_url($catalog_url); ?>" class="nav-item">
						<img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/svg/cart.svg"
							class="shopping-cart">
						<span class="nav-text">КАТАЛОГ</span>
					</a>
					<a href="<?php echo esc_url($blog_url); ?>" class="nav-item">
						<img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/svg/blog.svg"
							class="bookmark">
						<span class="nav-text">БЛОГ</span>
					</a>
					<div class="search-item_mob">
						<form role="search" method="get" id="searchform" class="searchform"
							action="<?php echo esc_url(home_url('/')); ?>">
							<input type="text" value="<?php echo get_search_query(); ?>" name="s" id="s"
								class="search-input" placeholder="Поиск по сайту" />
							<button type="submit" class="search-button button-submit">
								<img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/svg/search.svg"
									class="search-svg"></img>
							</button>
							<div class="search-button visible-input">
								<img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/svg/search.svg"
									class="search-svg"></img>
							</div>
						</form>
						<span class="nav-text">ПОИСК</span>
					</div>
				</nav>
				<a href="<?php echo home_url(); ?>">
					<div class="logo">
						<img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/svg/logo.svg" alt="Logo">
					</div>
				</a>
				<div class="header-right">
					<div class="search-item">
						<form role="search" method="get" id="searchform" class="searchform"
							action="<?php echo esc_url(home_url('/')); ?>">
							<input type="text" value="<?php echo get_search_query(); ?>" name="s" id="s"
								class="search-input" placeholder="Поиск по сайту" />
							<button type="submit" class="search-button">
								<img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/svg/search.svg"
									class="search-svg"></img>
							</button>
						</form>
					</div>
					<a href="<?php echo esc_url($favorits_url); ?>" class="icon">
						<img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/svg/favorites.svg"
							class="heart"></img>
						<span class="badge favorites-badge" id="favorites-badge">0</span>
					</a>
					<a href="<?php echo esc_url($cart_url); ?>" class="icon">
						<img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/svg/basket.svg"
							class="shopping-bag"></img>
						<span class="badge cart-badge" id="cart-badge">0</span>
					</a>
				</div>
			</div>
		</div>
	</header>