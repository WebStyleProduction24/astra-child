<?php

add_action('init', function() {
	pll_register_string('Adress', 'Plaza Calvo Sotelo, 3, 6B, Аликанте, Испания<br>Тел: <a href="tel:34937376226">+34 937 376 226</a> <br>Почта: <a href="mailto:info@sakc.info">info@sakc.info</a>', 'Text', true);
});


//Создание таксономии для Недвижимости

add_action( 'init', 'create_taxonomy' );
function create_taxonomy(){

	// список параметров: wp-kama.ru/function/get_taxonomy_labels
	register_taxonomy( 'real_estate_taxonomy', [ 'real_estate' ], [ 
		'labels'				=> [
			'name'          => 'Классы недвижимости',
			'singular_name' => 'Класс недвижимости',
			'search_items'  => 'Искать класс недвижимости',
			'all_items'     => 'Все классы недвижимости',
			'view_item '    => 'Посмотреть класс недвижимости',
			'edit_item'     => 'Редактировать класс недвижимости',
			'update_item'   => 'Обновить класс недвижимости',
			'add_new_item'  => 'Добавить новый класс недвижимости',
			'new_item_name'	=> 'Создать новый класс недвижимости',
			'menu_name'         => 'Классы недвижимости',
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
		'not_found' 					=>  'Ничего не найдено',
		'not_found_in_trash' 	=> 'В корзине ничего не найдено'
	);
	$args = array(
		'labels' 				=> $labels,
		'public' 				=> true,
		'has_archive' 	=> true,
		'menu_position' => 4,
		'supports' 			=> array('title', 'editor', 'thumbnail', 'custom-fields'),
		'menu_icon'			=> 'dashicons-building'
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

//Отображение Оффера на странице объекта недвижимости
function real_estate_offer() {

	if (is_singular('real_estate')) {

		add_filter( 'astra_featured_image_markup', 'function_to_add');

		function function_to_add() {
			return '';
		}

		global $post;

		echo "<div class='ast-single-post-order'>";
		echo "<h1 class='entry-title' itemprop='headline'>";
		echo 'Лучшая подборка объектов недвижимости "Лето 2020"';
		echo "</h1>";
		echo "</div>";

		$cur_terms = get_the_terms( $post->ID, 'real_estate_taxonomy' );
		if( is_array( $cur_terms ) ){
			foreach( $cur_terms as $cur_term ){
				echo '<a href="'. get_term_link( $cur_term->term_id, $cur_term->taxonomy ) .'">'. $cur_term->name .'</a>';
			}
		}

		if ( $slider = get_post_meta( $post->ID, 'slider', true ) ) :
			echo "<div>". do_shortcode($slider). "</div>";
		endif;

	}
}; 