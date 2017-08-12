<?php
/*
Plugin Name: Fixed-bar
Plugin URI: http://artzona.org
Description: Плагин Fixed Bar добавляет настраиваемую фиксированную панель на ваш сайт.  
Author: jvj
Author URI: http://artzona.org
Version: 2.3
*/

/*
	1. 	Локализация
	2.	Действия при активации и деинсталляции
	3. 	Регистрация стилей
	4. 	Подключение поля выбора цвета
	5.	Страница настроек плагина		
	6. 	Ссылка на настройки плагина
	7. 	Регистрация сайдбара	
	8. 	Добавление динамических стилей 
		9.	Добавление фиксированного блока	
	10.	Лицензия GPL
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
		if ( !get_option('az_fixedbar_size') ) add_option('az_fixedbar_size',48);		
		if ( !get_option('az_fixedbar_background') ) add_option('az_fixedbar_background','rgba(127,127,127,0.5)');
		if ( !get_option('az_fixedbar_position') ) add_option('az_fixedbar_position','right');
		
		$open_button_title = __('Open Fixed Bar','fixed-bar');
		if ( !get_option('az_fixedbar_open_button_title') ) add_option('az_fixedbar_open_button_title',$open_button_title);	
		
		$barcaption = __('Fixed Bar caption','fixed-bar');
		if ( !get_option('az_fixedbar_barcaption') ) add_option('az_fixedbar_barcaption',$barcaption);
		
		if ( !get_option('az_fixedbar_size_select') ) add_option('az_fixedbar_size','px');
		
		add_option('az_fixedbar_frontpage','on');
		add_option('az_fixedbar_bodymargin','');
		add_option('az_fixedbar_mobileview','on');
		add_option('az_fixedbar_fullwidth','on');		
		
		//add_option('az_fixedbar_close_button','')
		if ( !get_option('az_fixedbar_basis') ) add_option('az_fixedbar_basis','0');
		if ( !get_option('az_fixedbar_basis_select') ) add_option('az_fixedbar_basis_select','px');
		
	}
	
	function fixedbar_uninstall(){
		delete_option( 'az_fixedbar_size' );
		delete_option( 'az_fixedbar_fontsize' );
		delete_option( 'az_fixedbar_position' );
		delete_option( 'az_fixedbar_background' );
		delete_option( 'az_fixedbar_pageID_inc' );
		delete_option( 'az_fixedbar_pageID_ex' );
		delete_option( 'az_fixedbar_frontpage' );
		delete_option( 'az_fixedbar_close_button' );
		delete_option( 'az_fixedbar_open_button_title' );
		delete_option( 'az_fixedbar_bodymargin' );
		delete_option( 'az_fixedbar_mobileview' );
		delete_option( 'az_fixedbar_size_select	' );
		delete_option( 'az_fixedbar_font_select	' );
		delete_option( 'az_fixedbar_fullwidth' );
		delete_option( 'az_fixedbar_barcaption' );
		delete_option( 'az_fixedbar_basis' );
		delete_option( 'az_fixedbar_basis_select' );
	}

	register_activation_hook( __FILE__, 'fixedbar_activate' );
	register_uninstall_hook( __FILE__ , 'fixedbar_uninstall');
/**-------------------------------------------------------------------------**/



/**	3.	-------------------------------------------------------------------------**/
	// регистрируем стили и скрипты (фронт-енд)
	function register_fixedbar_styles() {
		wp_register_style( 'fixed-bar-css', plugins_url( 'fixed-bar/css/fixed-bar-css.css' ) );
		wp_enqueue_style( 'fixed-bar-css' );
		wp_enqueue_script('fixedbar-frontend', plugins_url('fixed-bar/js/frontend.js'), array('jquery') );				
	}
	add_action( 'wp_enqueue_scripts', 'register_fixedbar_styles' ); 	
/**-------------------------------------------------------------------------**/



/**	4	-------------------------------------------------------------------------**/
	// Подключение скриптов админки
	// https://wp-kama.ru/id_4621/vyibora-tsveta-iris-color-picker-v-wordpress.html
	// http://automattic.github.io/Iris/
	// https://github.com/kallookoo/wp-color-picker-alpha

	function add_fixedbar_admin_scripts( $hook ){
		//подключение скриптов админки
		wp_enqueue_script( 'fixedbar-backend', plugins_url('/js/backend.js',__FILE__) );
		
		//подключение прозрачного iris
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'wp-color-picker-alpha', plugins_url('fixed-bar/js/wp-color-picker-alpha.min.js'), array( 'wp-color-picker' ), '1.2.2', 'in_footer' );
	}
	add_action( 'admin_enqueue_scripts', 'add_fixedbar_admin_scripts' );
/**-------------------------------------------------------------------------**/ 



/**	5.	-------------------------------------------------------------------------**/
	// регистрируем страницу настроек плагина
	function register_fixedbar_page(){
		add_menu_page( 
			'fixedbar options', 'Fixed bar', 'manage_options', 'fixed-bar/fixed-bar-admin-page.php', '', 'dashicons-layout', 122 
		);
	}
	add_action( 'admin_menu', 'register_fixedbar_page' );
	
	
	function az_fixedbar_settings() {	
		register_setting( 'az-fixedbar-settings-group', 'az_fixedbar_size' );
		register_setting( 'az-fixedbar-settings-group', 'az_fixedbar_fontsize' );
		register_setting( 'az-fixedbar-settings-group', 'az_fixedbar_position' );
		register_setting( 'az-fixedbar-settings-group', 'az_fixedbar_background' );
		register_setting( 'az-fixedbar-settings-group', 'az_fixedbar_pageID_inc' );
		register_setting( 'az-fixedbar-settings-group', 'az_fixedbar_pageID_ex' );
		register_setting( 'az-fixedbar-settings-group', 'az_fixedbar_frontpage' );
		register_setting( 'az-fixedbar-settings-group', 'az_fixedbar_open_button_title' );
		register_setting( 'az-fixedbar-settings-group', 'az_fixedbar_close_button' );
		register_setting( 'az-fixedbar-settings-group', 'az_fixedbar_bodymargin' );
		register_setting( 'az-fixedbar-settings-group', 'az_fixedbar_mobileview' );
		register_setting( 'az-fixedbar-settings-group', 'az_fixedbar_size_select' );
		register_setting( 'az-fixedbar-settings-group', 'az_fixedbar_font_select' );
		register_setting( 'az-fixedbar-settings-group', 'az_fixedbar_fullwidth' );
		register_setting( 'az-fixedbar-settings-group', 'az_fixedbar_barcaption' );
		register_setting( 'az-fixedbar-settings-group', 'az_fixedbar_basis' );
		register_setting( 'az-fixedbar-settings-group', 'az_fixedbar_basis_select' );
	}
	add_action( 'admin_init', 'az_fixedbar_settings' );
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
	//Добавление динамических стилей
	
	function add_select_page (){
		
		function add_fixed_style ($fixedbar_update_css){	
			$size = get_option('az_fixedbar_size');
			$fontsize = get_option('az_fixedbar_fontsize');
			$background = get_option('az_fixedbar_background');
			$position = get_option('az_fixedbar_position');
			$bodymargin = get_option('az_fixedbar_bodymargin');
			$fixedbar_size_select = get_option('az_fixedbar_size_select');
			$fixedbar_font_select = get_option('az_fixedbar_font_select');
			$fixedbar_fullwidth = get_option('az_fixedbar_fullwidth');
			$basis = get_option('az_fixedbar_basis');
			$basis_select = get_option('az_fixedbar_basis_select');
			
			
			if ( $position == 'top' or $position == 'bottom' ) { 
				$blocksize = 'height';
				$fs = 'width';
			}	elseif ( $position == 'left' or $position == 'right' ) { 
					$blocksize = 'width'; 
					$fs = 'height';
				}
			
			if ( $fixedbar_fullwidth == 'on' ) {	$fixedbarfull = $fs.": 100%";	} else $fixedbarfull = '';
			
				$fixedbar_update_css = "
					.az-position-".$position."{
						".$blocksize.": ".$size.$fixedbar_size_select.";
						".$fixedbarfull.";						
					}					
					#az-fixed{
						background:".$background.";
					}
					#az-open{
						".$position.": 0;
					}
				";

				if ($fontsize){
					$fixedbar_update_css .= "
						#az-fixed .widget {
							font-size: ".$fontsize.$fixedbar_font_select.";
						}
					";
				}
				
				if ($basis != '0' ){
					$fixedbar_update_css .= "
						#az-fixed .widget {
							flex-basis: ".$basis.$basis_select.";
						}
					";
				}
				
				
				if ($bodymargin){
					$fixedbar_update_css .= "
						body {
							margin-".$position.": ".$size.$fixedbar_size_select." !important;
						}
					";
				}
				
				$mobileview = get_option('az_fixedbar_mobileview');
				if ( $mobileview == 'on' ){
					$fixedbar_update_css .= "
						@media only screen and (max-device-width: 1024px){
							#az-fixed {
								display:none;
							}
						}
					";
				}
				
				
			wp_add_inline_style( 'fixed-bar-css', $fixedbar_update_css );
			
			/**	9.	-------------------------------------------------------------------------**/
				// добавляем фиксированный блок в подвал
				function az_add_fixedbar_to_footer() {	
					$position = get_option('az_fixedbar_position');
					$barcaption = get_option('az_fixedbar_barcaption');
					echo '<div id="az-fixed" class="az-position-'.$position.'">';
						if ( get_option('az_fixedbar_close_button')=='on' ){
							echo '
							<div id="fixedbar-caption-wrap">
								<div id="fixedbar-caption">'.$barcaption.'</div>
								<button id="az-closed" title="'.__('Close','fixed-bar').'">x</button>
							</div>
							';
						}
						echo '<div id="az-flex" class="az-flex-'.$position.'">';		
								dynamic_sidebar('sidebar-fixed');
					echo '	  </div>								
						 </div>
						  <button id="az-open" class="dashicons-before dashicons-layout" title="'.get_option('az_fixedbar_open_button_title').'" style="display:none;"> </button>
						  ';
				}	
				add_action("wp_footer", "az_add_fixedbar_to_footer", 1);
			/**-------------------------------------------------------------------------**/ 
			
		}
		add_action( 'wp_enqueue_scripts', 'add_fixed_style' );
		
		//Управление видимостью Fixed-bar на выбранных страницах
		
		if ( !get_option('az_fixedbar_frontpage') ){
			if( is_front_page() ) remove_action( 'wp_enqueue_scripts', 'add_fixed_style' );
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