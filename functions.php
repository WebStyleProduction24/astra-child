<?php



// регистрируем стили
add_action( 'wp_enqueue_scripts', 'register_astra_child_styles' );

// регистрируем файл стилей и добавляем его в очередь
function register_astra_child_styles() {
	wp_register_style( 'astra-child-css', get_stylesheet_directory_uri().'/style.css' );
	wp_enqueue_style( 'astra-child-css' );
}




// add_action('init', function() {
// 	pll_register_string('Adress', 'Plaza Calvo Sotelo, 3, 6B, Аликанте, Испания<br>Тел: <a href="tel:34937376226">+34 937 376 226</a> <br>Почта: <a href="mailto:info@sakc.info">info@sakc.info</a>', 'Text', true);
// });


//Создание таксономии для Недвижимости

add_action( 'init', 'create_taxonomy' );
function create_taxonomy(){

	// список параметров: wp-kama.ru/function/get_taxonomy_labels
	register_taxonomy( 'real_estate_taxonomy', [ 'real_estate' ], [ 
		'labels'				=> [
			'name'          => 'Типы недвижимости',
			'singular_name' => 'Тип недвижимости',
			'search_items'  => 'Искать тип недвижимости',
			'all_items'     => 'Все типы недвижимости',
			'view_item '    => 'Посмотреть тип недвижимости',
			'edit_item'     => 'Редактировать тип недвижимости',
			'update_item'   => 'Обновить тип недвижимости',
			'add_new_item'  => 'Добавить новый тип недвижимости',
			'new_item_name'	=> 'Создать новый тип недвижимости',
			'menu_name'     => 'Типы недвижимости',
		],
		'description'   => 'Каталог объектов недвижимости в Испании', // описание таксономии
		'public'        => true,
		'show_in_rest'  => null, // добавить в REST API
	] );
}


/* Регистрация произвольного типа записи kodex */

add_action('init', 'new_post_register');
function new_post_register()
{
	$labels = array(
		'name' 								=> 'Недвижимость', 
		'menu_name' 					=> 'Недвижимость',
		'singular_name' 			=> 'Объект недвижимости', 
		'add_new' 						=> 'Добавить объект',
		'add_new_item' 				=> 'Добавить новый объект',
		'edit_item' 					=> 'Редактировать объект',
		'new_item' 						=> 'Новый объект',
		'all_items' 					=> 'Все объекты',
		'view_item' 					=> 'Посмотреть объект',
		'search_items' 				=> 'Найти объект',
		'not_found' 					=> 'Ничего не найдено',
		'not_found_in_trash' 	=> 'В корзине ничего не найдено'
	);
	$args = array(
		'labels' 				=> $labels,
		'public' 				=> true,
		'has_archive' 	=> true,
		'menu_position' => 4,
		'supports' 			=> array('title', 'editor', 'thumbnail', 'custom-fields'),
		'menu_icon'			=> 'dashicons-building',
		'taxonomies' 		=> array('real_estate_taxonomy')
	);
	register_post_type('real_estate',$args);
}

//Регистрируем sidebar

add_action( 'widgets_init', 'real_estate_widgets' );
function real_estate_widgets(){
	register_sidebar( array(
		'name'          => 'Сайдбар объекта недвижимости',
		'id'            => "sidebar-real_estate",
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}


//Регистрируем шорткоды
function real_estate_objects_shortcode(){
	return real_estate_objects();
}
add_shortcode('real-estate-objects', 'real_estate_objects_shortcode');

function posts_real_estate_objects_shortcode(){
	return posts_real_estate_objects();
}
add_shortcode('posts-real-estate-objects', 'posts_real_estate_objects_shortcode');


//Вывод объектов недвижимости
function real_estate_objects() {
	ob_start();

	$reviews = new WP_Query(array(
		'post_type' => 'real_estate',
		'posts_per_page' => -1
	));

	echo "<ul>";

	if ( $reviews->have_posts() ) : while ( $reviews->have_posts() ) : $reviews->the_post();
		echo "<li class='cat-item'><a href=" . get_the_permalink() . ">" .get_the_title() . "</a></li>";
	endwhile; endif;

	echo "</ul>";

	return ob_get_clean();
}

//Отображение Оффера на объектах недвижимости
function real_estate_offer() {

	if (is_singular('real_estate') || is_tax() || is_archive('real_estate')) {

		global $post;

		echo "<div class='ast-single-post-order'>";
		echo "<h1 class='entry-title' itemprop='headline'>";
		echo 'Лучшая подборка объектов недвижимости "Лето 2020"';
		echo "</h1>";
		echo "</div>";

	}
}

//Отображение слайдера на странице недвижимости
function real_estate_slider() {

	if (is_singular('real_estate')) {

		add_filter( 'astra_featured_image_markup', 'function_to_add');

		function function_to_add() {
			return '';
		}

		global $post;

		if ( $slider = get_post_meta( $post->ID, 'slider', true ) ) :
			echo "<div class='mb-4'>". do_shortcode($slider). "</div>";
		endif;

	}

}

//Отображение типа недвижимости на странице объекта
function real_estate_type() {

	if (is_singular('real_estate')) {

		global $post;

		$cur_terms = get_the_terms( $post->ID, 'real_estate_taxonomy' );
		if( is_array( $cur_terms ) ){
			foreach( $cur_terms as $cur_term ){
				echo '<div class="mb-4 real-estate-type"><a href="'. get_term_link( $cur_term->term_id, $cur_term->taxonomy ) .'">'. $cur_term->name .'</a></div>';
			}
		}

	}

}


//Добавляем дополнительный класс на странице объекта недвижимости
function astra_primary_class( $class = '' ) {

	if (is_archive('real_estate') ||is_singular('real_estate') || is_tax() ) $class_astra_child = 'astra-child ';
	else $class_astra_child = '';

		// Separates classes with a single space, collates classes for body element.
	echo 'class="' . $class_astra_child . esc_attr( join( ' ', astra_get_primary_class( $class ) ) ) . '"';
}


//Выводим кастомные поля на странице объекта недвижимости
function custom_fields() {
	
	global $post;
	$string = '';

	if ( $number_object = get_post_meta( $post->ID, 'number_object', true ) ) $string .= "<div>Номер объекта: ". do_shortcode($number_object). "</div>";
	if ( $type = get_post_meta( $post->ID, 'type', true ) ) $string .= "<div>Тип - ". do_shortcode($type). "</div>";
	if ( $square = get_post_meta( $post->ID, 'square', true ) ) $string .= "<div>Площадь - ". do_shortcode($square). "</div>";
	if ( $rooms = get_post_meta( $post->ID, 'rooms', true ) ) $string .= "<div>". do_shortcode($rooms). "</div>";
	if ( $area = get_post_meta( $post->ID, 'area', true ) ) $string .= "<div>Район - ". do_shortcode($area). "</div>";

	if ( $string ) $string = "<div class='entry-content bold'><p>" . $string . "</div></p>";

	echo $string;

}

//Обрезаем длину цитаты постов в таксономиях
add_filter( 'excerpt_length', function(){
	if ( is_tax() || is_archive('real_estate') ) {
		return 30;
	}
} );



//Добавляем отображение пользовательских полей на архивах таксономии
add_action('astra_entry_content_before', 'astra_child_entry_content_before');
function astra_child_entry_content_before() {
	if ( is_tax() || is_archive('real_estate') ) {
		custom_fields();
	}	
}


//Добавляем оффер на странице архивов таксономии
add_action('astra_before_archive_title','astra_child_before_archive_title');
function astra_child_before_archive_title() {
	real_estate_offer();
}


//Удаляем отображдение заголовка архива на странице архива недвижимости
add_action( 'wp_loaded', function(){
	remove_action( 'astra_archive_header', 'astra_archive_page_info' );
} );


add_action('astra_archive_header', 'astra_child_archive_page_info');
function astra_child_archive_page_info() {


	if ( apply_filters( 'astra_the_title_enabled', true ) ) {

			// Author.
		if ( is_author() ) { ?>

			<section class="ast-author-box ast-archive-description">
				<div class="ast-author-bio">
					<?php do_action( 'astra_before_archive_title' ); ?>
					<h1 class='page-title ast-archive-title'><?php echo get_the_author(); ?></h1>
					<?php do_action( 'astra_after_archive_title' ); ?>
					<p><?php echo wp_kses_post( get_the_author_meta( 'description' ) ); ?></p>
					<?php do_action( 'astra_after_archive_description' ); ?>
				</div>
				<div class="ast-author-avatar">
					<?php echo get_avatar( get_the_author_meta( 'email' ), 120 ); ?>
				</div>
			</section>

			<?php

				// Category.
		} elseif ( is_category() ) {
			?>

			<section class="ast-archive-description">
				<?php do_action( 'astra_before_archive_title' ); ?>
				<h1 class="page-title ast-archive-title"><?php echo single_cat_title(); ?></h1>
				<?php do_action( 'astra_after_archive_title' ); ?>
				<?php echo wp_kses_post( wpautop( get_the_archive_description() ) ); ?>
				<?php do_action( 'astra_after_archive_description' ); ?>
			</section>

			<?php

				// Tag.
		} elseif ( is_tag() ) {
			?>

			<section class="ast-archive-description">
				<?php do_action( 'astra_before_archive_title' ); ?>
				<h1 class="page-title ast-archive-title"><?php echo single_tag_title(); ?></h1>
				<?php do_action( 'astra_after_archive_title' ); ?>
				<?php echo wp_kses_post( wpautop( get_the_archive_description() ) ); ?>
				<?php do_action( 'astra_after_archive_description' ); ?>
			</section>

			<?php

				// Search.
		} elseif ( is_search() ) {
			?>

			<section class="ast-archive-description">
				<?php do_action( 'astra_before_archive_title' ); ?>
				<?php
				/* translators: 1: search string */
				$title = apply_filters( 'astra_the_search_page_title', sprintf( __( 'Search Results for: %s', 'astra' ), '<span>' . get_search_query() . '</span>' ) );
				?>
				<h1 class="page-title ast-archive-title"> <?php echo $title; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> </h1>
				<?php do_action( 'astra_after_archive_title' ); ?>
			</section>

			<?php

				// Other.
		} elseif ( is_archive('real_estate') && !is_tax()) {
			?>

			<section class="ast-archive-description">
				<?php do_action( 'astra_before_archive_title' ); ?>
				<?php do_action( 'astra_after_archive_title' ); ?>
				<?php echo wp_kses_post( wpautop( get_the_archive_description() ) ); ?>
				<?php do_action( 'astra_after_archive_description' ); ?>
			</section>

			<?php
		} else {
			?>

			<section class="ast-archive-description">
				<?php do_action( 'astra_before_archive_title' ); ?>
				<?php the_archive_title( '<h1 class="page-title ast-archive-title">', '</h1>' ); ?>
				<?php do_action( 'astra_after_archive_title' ); ?>
				<?php echo wp_kses_post( wpautop( get_the_archive_description() ) ); ?>
				<?php do_action( 'astra_after_archive_description' ); ?>
			</section>

			<?php
		}
	}
}



//Добавляем блок мессенджеров в header

add_action( 'astra_masthead_content', 'messengers_wsp24', 9 );
function messengers_wsp24() {
	$string = '<div class="footer__icons-links">';
	$string .= '<div class="footer__icon-link"><a href="https://wa.me/+34660520536" target="_blank"><img src="https://sakc.info/wp-content/uploads/2020/07/whatsapp.png"></a></div>';
	$string .= '<div class="footer__icon-link"> <a href="https://telegram.me/PBIgroup_bot" target="_blank"><img src="https://sakc.info/wp-content/uploads/2020/07/telegram.png"></a></div>';
	$string .= '</div>';
	echo $string;
}