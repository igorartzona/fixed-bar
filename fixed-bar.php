<?php
/*
Plugin Name: fixed-bar
Plugin URI: http://artzona.org
Description: Описание плагина
Author: jvj
Author URI: http://artzona.org
Version: 1.1
*/

/*
	1. 	Локализация
	2.	Действия при активации и деинсталляции
	3. 	Регистрация стилей
	4. 	Подключение поля выбора цвета
	5.	Страница настроек плагина		
	6. 	Ссылка на настройки плагина
	7. 	Регистрация сайдбара	
	8.	Обработка POST запросов
	9. 	Добавление динамических стилей 
		10.	Добавление фиксированного блока	
	11.	Лицензия GPL
*/

/**	1.	-------------------------------------------------------------------------**/
	//локализация
	function load_fixedbar_languages() {
		load_plugin_textdomain( 'fixed-bar', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}
	add_action( 'plugins_loaded', 'load_fixedbar_languages' );
/**-------------------------------------------------------------------------**/

/**	2.	-------------------------------------------------------------------------**/
	//действия при установке и деинсталляции плагина
	function fixedbar_activate(){		
		
		$size = get_option('az_fixedbar_size');
		if (!$size) add_option('az_fixedbar_size',48);		
		
		$color = get_option('az_fixedbar_color');
		if (!$color) add_option('az_fixedbar_color','rgba(127,127,127,0.5)');
		
		$position = get_option('az_fixedbar_position');
		if (!$position) add_option('az_fixedbar_position','right');	
		
		add_option('az_fixedbar_frontpage','1');
	}
	
	function fixedbar_uninstall(){
		delete_option( 'az_fixedbar_size' );
		delete_option( 'az_fixedbar_fontsize' );
		delete_option( 'az_fixedbar_position' );
		delete_option( 'az_fixedbar_color' );
		delete_option( 'az_fixedbar_pageID_inc' );
		delete_option( 'az_fixedbar_pageID_ex' );
		delete_option( 'az_fixedbar_frontpage' );
	}

	register_activation_hook( __FILE__, 'fixedbar_activate' );
	register_uninstall_hook( __FILE__ , 'fixedbar_uninstall');
/**-------------------------------------------------------------------------**/

/**	3.	-------------------------------------------------------------------------**/
	// регистрируем стили
	function register_fixedbar_styles() {
		wp_register_style( 'fixed-bar-css', plugins_url( 'fixed-bar/css/fixed-bar-css.css' ) );
		wp_enqueue_style( 'fixed-bar-css' );
	}
	add_action( 'wp_enqueue_scripts', 'register_fixedbar_styles' ); 	
/**-------------------------------------------------------------------------**/

/**	4	-------------------------------------------------------------------------**/
	// Подключение поля выбора цвета
	// https://wp-kama.ru/id_4621/vyibora-tsveta-iris-color-picker-v-wordpress.html
	// http://automattic.github.io/Iris/

	function add_admin_iris_scripts( $hook ){
		// подключаем color piker
		wp_enqueue_script( 'wp-color-picker' );
		wp_enqueue_style( 'wp-color-picker' );

		// подключаем скрипт color pickera
		wp_enqueue_script('color-picker-script', plugins_url('js/color-picker.js', __FILE__), array('wp-color-picker'), false, 1 );
	}
	add_action( 'admin_enqueue_scripts', 'add_admin_iris_scripts' );
/**-------------------------------------------------------------------------**/ 


/**	5.	-------------------------------------------------------------------------**/
	// регистрируем страницу настроек плагина
	function register_fixedbar_page(){
		add_menu_page( 
			'fixedbar options', 'Fixed bar', 'manage_options', 'fixed-bar/fixed-bar-admin-page.php', '', 'dashicons-layout', 6 
		);
	}
	add_action( 'admin_menu', 'register_fixedbar_page' );
/**-------------------------------------------------------------------------**/ 

/**	6.	-------------------------------------------------------------------------**/
	// добавляем ссылку на настройки плагина
	function add_fixedbar_links ( $links ) {
		$mylinks = array(
			'<a href="'
				. admin_url( 'admin.php?page=fixed-bar/fixed-bar-admin-page.php' ) .'">'
				. __( 'Settings' , 'fixed-bar' ) .'</a>',
		);
		return array_merge( $links, $mylinks );
	}
	add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'add_fixedbar_links' );
/**-------------------------------------------------------------------------**/ 

/**	7.	-------------------------------------------------------------------------**/
	// добавляем сайдбар
	function az_fixedbar(){		
		//регистрация сайдбара
		if (function_exists('register_sidebar')) {
			register_sidebar(array(
				'name' => __('Fixed sidebar','fixed-bar'),
				'id' => 'sidebar-fixed',
				'description' => __('Add widgets here to appear in fixed sidebar','fixed-bar'),
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget' => '</aside>',
				'before_title' => '<span >',
				'after_title' => '</span>',
			));
		}		
	}
	add_action('init','az_fixedbar');
/**-------------------------------------------------------------------------**/

/**	8.	-------------------------------------------------------------------------**/ 
	//Обработка POST запросов
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		$size = intval($_POST['size']);
		$fontsize = intval($_POST['fontsize']);
		$color = sanitize_text_field ($_POST['color']);
		$position = sanitize_text_field ($_POST['position']);
		$pageID_inc = sanitize_text_field ($_POST['pageID_inc']);
		$pageID_ex = sanitize_text_field ($_POST['pageID_ex']);
		$frontpage = sanitize_text_field ($_POST['frontpage']);
		
		if ($size) {
			update_option('az_fixedbar_size',$size);
		} else $size = get_option('az_fixedbar_size');
		
		
		update_option('az_fixedbar_fontsize',$fontsize);
		
		
		if ($color) {
			update_option('az_fixedbar_color',$color);
		} else $color = get_option('az_fixedbar_color');
		
		if ($position) {
			update_option('az_fixedbar_position',$position);
		} else $position = get_option('az_fixedbar_position');
		
		
		update_option('az_fixedbar_pageID_inc',$pageID_inc);
		update_option('az_fixedbar_pageID_ex',$pageID_ex);
		update_option('az_fixedbar_frontpage',$frontpage);
			

	}

/**	9.	-------------------------------------------------------------------------**/ 
	//Добавление динамических стилей
	
	function add_select_page (){
		
		function add_fixed_style ($fixedbar_update_css){	
			$size = get_option('az_fixedbar_size');
			$fontsize = get_option('az_fixedbar_fontsize');
			$color = get_option('az_fixedbar_color');
			$position = get_option('az_fixedbar_position');
					
			if ( $position == 'top' or $position == 'bottom' ) { $blocksize = 'height'; } 
			elseif ( $position == 'left' or $position == 'right' ) { $blocksize = 'width'; }
					
				$fixedbar_update_css = "
					.az-position-".$position."{
						".$blocksize.": ".$size."px;
					}
					#az-fixed{
						background:".$color.";
					}					
				";

				if ($fontsize){
					$fixedbar_update_css .= "
						#az-fixed .widget {
						font-size: ".$fontsize."px;
						}
					";
				}
				
			wp_add_inline_style( 'fixed-bar-css', $fixedbar_update_css );
			
			/**	10.	-------------------------------------------------------------------------**/
				// добавляем фиксированный блок в подвал
				function az_add_fixedbar_to_footer() {	
					$position = get_option('az_fixedbar_position');
					echo '<div id="az-fixed" class="az-position-'.$position.'">
						  <div id="az-flex" class="az-flex-'.$position.'">';		
								dynamic_sidebar('sidebar-fixed');
					echo '</div>
						  </div>';
				}	
				add_action("wp_footer", "az_add_fixedbar_to_footer", 1);
			/**-------------------------------------------------------------------------**/ 
			
		}
		add_action( 'wp_enqueue_scripts', 'add_fixed_style' );
		
		$frontpage = get_option('az_fixedbar_frontpage');
		
		if ( !$frontpage ){
				if( is_front_page() ){
					remove_action( 'wp_enqueue_scripts', 'add_fixed_style' );
				} 
		} 
		
		$pageID_inc = get_option('az_fixedbar_pageID_inc');		
		$pageID_ex = get_option('az_fixedbar_pageID_ex');	
		
		if ( !empty($pageID_inc) ) {			
			$pageID_inc = explode(",", $pageID_inc );
			if( !is_page( array_map('intval', $pageID_inc) ) && (!is_front_page()) ){
				remove_action( 'wp_enqueue_scripts', 'add_fixed_style' );
			} 
		} else{
			if ( !empty($pageID_ex) ){
				$pageID_ex = explode(",", $pageID_ex );
				if( is_page( array_map('intval', $pageID_ex) ) ){
					remove_action( 'wp_enqueue_scripts', 'add_fixed_style' );
				}
			}
		}
		
		
		
		
	}	
	add_action( 'wp', 'add_select_page' );
/**-------------------------------------------------------------------------**/



/*  Copyright 2017  igor.artzona  (email: igor.artzona@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/ 
?>