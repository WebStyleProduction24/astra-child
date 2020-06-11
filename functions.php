<?php

add_action('init', function() {
pll_register_string('Adress', 'Plaza Calvo Sotelo, 3, 6B, Аликанте, Испания<br>Тел: <a href="tel:34937376226">+34 937 376 226</a> <br>Почта: <a href="mailto:info@sakc.info">info@sakc.info</a>', 'Text', true);
});


//Создание таксономии для Недвижимости

add_action( 'init', 'real_estate' );

function real_estate() {

}