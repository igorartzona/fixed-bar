<style>
#th_ID_inc, #th_ID_ex {
    border-left: 4px double #777;
    padding-left: 1em;
}

/*--responsive tabs--*/

	.az-admin-wrap{
	  min-width: 320px;
	  max-width: 98%;
	  padding: 10px;
	  margin: 0 auto;
	  background: #fff;
	  font-size:1.2em;
	}

	.az-admin-wrap fieldset{
		border:1px dotted #e5e5e5;
		padding:10px;
		background:#E2E8E9;
		box-shadow: 0 1px 1px rgba(0, 0, 0, 0.04);
	}
	
	.az-admin-wrap legend{	margin:10px 0; }
	
	
	.az-admin-title{background:#BD2447;color:white;padding:0.5em;}

	*, *:before, *:after {margin: 0;padding: 0;box-sizing: border-box;}

	.az-admin-wrap p {margin: 0 0 20px;line-height: 1.5;}	

	.az-admin-wrap section {
	  display: none;
	  padding: 20px 10px;
	  border-top: 1px solid #ddd;
	  background:#fff;
	}

	#tab1,#tab2,#tab3,#tab4 {display: none;}

	.az-admin-wrap label {
	  display: inline-block;
	  margin: 0 0 -1px;
	  padding: 15px 25px;
	  font-weight: 600;
	  text-align: center;
	  // color: #bbb;
	  border: 1px solid transparent;
	}

	.az-admin-wrap label:hover {color: #888;cursor: pointer;}

	.tabs:checked + label {
	  color: #555;
	  border: 1px solid #ddd;
	  border-top: 2px solid #BD2447;
	  border-bottom: 1px solid #fff;
	  background:#fff;
	}
	

	#tab1:checked ~ #content1,
	#tab2:checked ~ #content2,
	#tab3:checked ~ #content3,
	#tab4:checked ~ #content4{
	  display: block;
	}
	
	.wp-admin select{
		vertical-align:top;
	}

	@media screen and (max-width: 650px) {
	#az-admin-wrap{font-size:1em;}
	.tab-label{margin:0 auto;width:100%;min-height:44px;vertical-align:middle;}
	#az-admin-wrap select{font-size:0.9em;width:98%;}
	
	.form-table, .form-table td, .form-table td p, .form-table th, .form-table label {font-size: 10px;}
	.form-table tr{height:44px;}
	.form-table td, .form-table th{display:block;float:left;}
	}

	@media screen and (min-device-width: 650px) and (max-device-width: 1280px) {
			.form-table td, .form-table th{display:block;float:left;}
	}
	
/*--responsive tabs end--*/


</style>

<?php

/*-- Add page "settings"" to admin panel --
	add_action('admin_init', 'az_settings');
	function az_settings(){ 	
			register_setting( 'az_tab1_group', 'az_theme_options' );	
			add_settings_section( 'az_tab1', '','', 'az_theme_id' );	
			add_settings_field('az_tab1_field1', __( 'Revision control', 'az-base-pro' ), 'fill_az_tab1_field1', 'az_theme_id', 'az_tab1' );
			
			add_settings_section( 'az_tab3', '','az_tab3_description', 'az_theme_id3' );	
			add_settings_field('az_tab3_field1', __( 'Press button to delete theme data from DB', 'az-base-pro' ), 'fill_az_tab3_field1', 'az_theme_id3', 'az_tab3' );
		}
		
	
	function az_theme_function(){			
	
		global $select_options,$radio_options;
		if ( ! isset( $_REQUEST['settings-updated'] ) ) $_REQUEST['settings-updated'] = false;	
		?>		
		<div class="wrap">		
		
		<?php if ( false !== $_REQUEST['settings-updated'] ) : ?>
			<div id="message" class="updated">
			
				<?php 
					$val = get_option('az_theme_options');
					if ( isset($val['az_clear_DB']) ){						
						delete_option('az_theme_options');
						remove_theme_mods();
						_e( '<p>Theme data is successful delete!</p>', 'az-base-pro' );						
					} else	{ ?>
						<p><strong><?php _e( 'Options saved', 'az-base-pro' ); ?></strong></p>					
					<?php }
				?>			
				
			</div>
			<?php endif; ?>
			<div class="az-admin-wrap">

				<form action="options.php" method="POST" >	
				<fieldset>
					<legend>
						<img src="<?php echo get_template_directory_uri(); ?>/img/logo_stork.png" width="24" height="24" alt="logo_stork">
						<span class="az-admin-title"><?php echo get_admin_page_title() ?></span>
					</legend>
					
					<div class="notice notice-warning">
						<?php _e( 'Warning! Be careful by system settings!', 'az-base-pro' ); ?>
					</div>
					
				<!-- http://codepen.io/oknoblich/pen/tfjFl	-->						
					  
					 					  
					 <input id="tab1" type="radio" name="tabs" checked class="tabs">
					  <label for="tab1" class="tab-label">
						<span class="tab1-title">
							<?php _e( 'System settings', 'az-base-pro' ); ?>
						</span>
					  </label>						
					  
					  <input id="tab3" type="radio" name="tabs" class="tabs">
					  <label for="tab3" class="tab-label">
						<span class="tab3-title">
							<?php _e( 'Clean theme data ', 'az-base-pro' ); ?>
						</span>
					  </label> 	  
					  
					  
					  <section id="content1">						
							<?php settings_fields( 'az_tab1_group' ); ?>
							<?php do_settings_sections( 'az_theme_id' ); ?>
							<?php submit_button(); ?>						
					  </section>
						
					  <section id="content3">						
							<?php do_settings_sections( 'az_theme_id3' ); ?>	
					  </section>
		
					
				</fieldset>	
				</form>			
			</div>
		
		</div>
		<?php
	} 
	
		function az_tab3_description(){
				echo '<img style="float:left;" src="'.get_template_directory_uri().'/img/cleanup64.png">';			
				 _e( 'Recommended delete data before uninstall theme', 'az-base-pro' );			
		}
		
		function fill_az_tab3_field1(){			
			submit_button(__('Clean DB','az-base-pro'),'button-clean','az_theme_options[az_clear_DB]');			
		}
*/	
?>


<?php if ( ! isset( $_REQUEST['settings-updated'] ) ) $_REQUEST['settings-updated'] = false; ?>


<div class="wrap">

	<?php if ( false !== $_REQUEST['settings-updated'] ) : ?>
		<div id="message" class="updated">
			<p><strong><?php _e( 'Options saved', 'fixed-bar' ); ?></strong></p>				
		</div>
	<?php endif; ?>

	
		<form action="options.php" method="post">
		<?php wp_nonce_field('update-options'); ?>
		
		<?php settings_fields( 'az-fixedbar-settings-group' ); ?>
		<?php do_settings_sections( 'az-fixedbar-settings-group' ); ?>
			
			<div class="az-admin-wrap">
			<fieldset>
				<legend>
					<img src="<?php echo plugins_url('/img/logo_stork.png',__FILE__);?>" width="32" height="32" alt="logo_stork">
					<span class="az-admin-title">
						<?php _e('Fixed bar plugin options','fixed-bar'); ?>
					</span>
				</legend>
				
				<input id="tab1" type="radio" name="tabs" checked class="tabs">
					<label for="tab1" class="tab-label">
						<span class="tab1-title">
							<?php _e('Settings','fixed-bar');?>
						</span>
					 </label>
					 
				<input id="tab2" type="radio" name="tabs" class="tabs">
					<label for="tab2" class="tab-label">
						<span class="tab2-title">
							<?php _e('Visibility on page','fixed-bar');?>
						</span>
					 </label>
					 
				<input id="tab3" type="radio" name="tabs" class="tabs">
					<label for="tab3" class="tab-label">
						<span class="tab3-title">
							<?php _e('"Open\Close" button','fixed-bar');?>
						</span>
					</label>
					
				<input id="tab4" type="radio" name="tabs" class="tabs">
					<label for="tab4" class="tab-label">
						<span class="tab4-title">
							<?php _e('Mobile settings','fixed-bar');?>
						</span>
					</label>
				
				<section id="content1">						
					<table class="form-table" id="position-table">		
						<tr>
							<th scope="row"><label for="az_fixedbar_size"><?php _e('Bar size','fixed-bar'); ?> :</label></th>
							<td>
								<input type="text" name="az_fixedbar_size" value="<?php echo get_option('az_fixedbar_size'); ?>">
								<select name="az_fixedbar_size_select">
									<?php 
										switch ( get_option('az_fixedbar_size_select') ) {
											case 'px' : $px_selected="selected";break;
											case '%' : 	$percent_selected='selected';break;									
										}
									?>
									<option value='px' <?php if ( isset($px_selected) ) echo $px_selected;?> >
										px
									</option>
									<option value='%'  <?php if ( isset($percent_selected) ) echo $percent_selected;?> >
										%
									</option>
								</select>
							</td>
						</tr>
				
						<tr>
							<th scope="row"><label for="az_fixedbar_fontsize"><?php _e('Font size','fixed-bar'); ?> :</label></th>
							<td> 
								<input type="text" name="az_fixedbar_fontsize" value="<?php echo get_option('az_fixedbar_fontsize'); ?>">
								<select name="az_fixedbar_font_select">
									<?php 
										switch ( get_option('az_fixedbar_font_select') ) {
											case 'px' : $px_selected="selected";break;
											case 'em' : $em_selected='selected';break;									
										}
									?>
									<option value='px' <?php if ( isset($px_selected) ) echo $px_selected;?> >px</option>
									<option value='em' <?php if ( isset($em_selected) ) echo $em_selected;?> >em</option>
								</select>								
								<p class="description">
										<?php _e('Set 0 to default (Theme size)','fixed-bar'); ?>
								</p>
							</td>
						</tr>
						
						<tr>
							<th scope="row"><label for="az_fixedbar_basis"><?php _e('Fixed bar widgets size','fixed-bar'); ?> :</label></th>
							<td> 
								<input type="text" name="az_fixedbar_basis" value="<?php echo get_option('az_fixedbar_basis'); ?>">
								<select name="az_fixedbar_basis_select">
									<?php 
										switch ( get_option('az_fixedbar_basis_select') ) {
											case 'px' : $basis_px_selected="selected";break;
											case '%' : $basis_percent_selected='selected';break;							
										}
									?>
									<option value='px' 
										<?php if ( isset($basis_px_selected) ) echo $basis_px_selected;?> >px
									</option>
									<option value='%' 
										<?php if ( isset($basis_percent_selected) ) echo $basis_percent_selected;?> >%
									</option>
								</select>								
								<p class="description">
										<?php _e('Set 0 to default','fixed-bar'); ?>
								</p>
							</td>
						</tr>
				
						<?php 			
							switch ( get_option('az_fixedbar_position') ) {
								case 'top' : $top="checked";break;
								case 'left' : $left='checked';break;
								case 'right' : $right='checked';break;
								case 'bottom' : $bottom='checked';break;			
							}	
						?>
				
						<tr>
							<th scope="row" style="vertical-align:middle;"><label for="az_fixedbar_position"><?php _e('Bar position','fixed-bar'); ?> :</label></th>
							<td> 
								<table style="width:300px">
									<tr>
										<td style="width:100px"></td>
										<td style="width:100px"><input type="radio" name="az_fixedbar_position" <?php if(isset($top)) echo $top;?> value="top" />top	</td>
										<td style="width:100px"></td>
									</tr>
							
									<tr>
										<td style="width:100px"><input type="radio" name="az_fixedbar_position" <?php if(isset($left)) echo $left;?> value="left" />left</td>
										<td style="width:100px"></td>
										<td style="width:100px"><input type="radio" name="az_fixedbar_position" <?php if(isset($right)) echo $right;?> value="right" />right</td>
									</tr>
							
									<tr>
										<td style="width:100px"></td>
										<td style="width:100px"><input type="radio" name="az_fixedbar_position" <?php if(isset($bottom)) echo $bottom;?> value="bottom" />bottom</td>
										<td style="width:100px"></td>
									</tr>
								</table>
							</td>
						</tr>
				
						<tr>
							<th scope="row"><label for="az_fixedbar_background"><?php _e('Bar color','fixed-bar'); ?> :</label></th>
							<td> 
								<input name="az_fixedbar_background" class="color-picker" id='color-picker' type="text" data-alpha="true" value="<?php echo get_option('az_fixedbar_background'); ?>" />
							</td>
						</tr>
				
						<tr>
							<th scope="row"><label for="az_fixedbar_bodymargin"><?php _e('Adapt template','fixed-bar'); ?> :</label></th>
							<td> 
								<input type="checkbox" name="az_fixedbar_bodymargin" <?php if ( get_option('az_fixedbar_bodymargin') == 'on' ) echo 'checked';?> />
								<p class="description">
										<?php _e('Added Fixed bar size margin in body tag','fixed-bar'); ?>
								</p>
							</td>
							
						</tr>
						
						<tr>
							<th scope="row"><label for="az_fixedbar_fullwidth"><?php _e('Stretch Fixed bar','fixed-bar'); ?> :</label></th>
							<td> 
								<input type="checkbox" name="az_fixedbar_fullwidth" <?php if ( get_option('az_fixedbar_fullwidth') == 'on' ) echo 'checked';?> />
							</td>
						</tr>
						
					</table>					
				</section>
				
				<section id="content2">	
					<table class="form-table">	
						<tr>
							<th scope="row" id="th_ID_inc">
								<label for="az_fixedbar_pageID_inc"><?php _e('Page ID (ON)','fixed-bar'); ?> :</label>					
							</th>
												
							<td> 
								<input type="text" id="ID_inc" name="az_fixedbar_pageID_inc" size="60" value="<?php echo get_option('az_fixedbar_pageID_inc'); ?>" />
								<p class="description">
									<?php _e('ON Fixed bar only this pages. Page IDs, separated by commas','fixed-bar'); ?>
								</p>
							</td>
						</tr>
					
						<tr>
							<th scope="row" id="th_ID_ex">
								<label for="az_fixedbar_pageID_ex"><?php _e('Page ID (OFF)','fixed-bar'); ?> :</label>						
							</th>
											
							<td> 
								<input type="text" id="ID_ex" name="az_fixedbar_pageID_ex" size="60" value="<?php echo get_option('az_fixedbar_pageID_ex'); ?>" />
								<p class="description">
									<?php _e('OFF Fixed bar only this pages. Page IDs, separated by commas','fixed-bar'); ?>
								</p>
							</td>
						</tr>	
			
						<tr>
							<th scope="row"><label for="az_fixedbar_frontpage"><?php _e('Display bar on frontpage','fixed-bar'); ?> :</label></th>
							<td> 
								<input type="checkbox" name="az_fixedbar_frontpage" <?php if ( get_option('az_fixedbar_frontpage') == 'on' ) echo 'checked';?> />
							</td>
						</tr>
				
					</table>
										
				</section>
				
				<section id="content3">						
					<table class="form-table">
						<tr>
							<th scope="row" >
								<label for="az_fixedbar_barcaption"><?php _e('Fixed bar caption','fixed-bar'); ?> :</label>	
							</th>
											
							<td> 
								<input type="text" id="barcaption" name="az_fixedbar_barcaption" size="60" value="<?php echo get_option('az_fixedbar_barcaption'); ?>" />
							</td>
						</tr>
						
						<tr>
							<th scope="row" >
								<label for="az_fixedbar_close_button"><?php _e('View "Close" button','fixed-bar'); ?> :</label>	
							</th>
												
							<td> 
								<input type="checkbox" id="close_button" name="az_fixedbar_close_button" <?php if ( get_option('az_fixedbar_close_button') == 'on' ) echo 'checked';?> />
							</td>
						</tr>
					
						<tr>
							<th scope="row" >
								<label for="az_fixedbar_open_button_title"><?php _e('"Open" button title','fixed-bar'); ?> :</label>				
							</th>
											
							<td> 
								<input type="text" id="open_button_title" name="az_fixedbar_open_button_title" size="60" value="<?php echo get_option('az_fixedbar_open_button_title'); ?>" />
							</td>
						</tr>

						
					</table>					
				</section>
				
				<section id="content4">						
					<table class="form-table">	
						<tr>
							<th scope="row" >
								<label for="az_fixedbar_mobileview"><?php _e('Hidden fixedbar in mobile version','fixed-bar'); ?> :</label>	
							</th>
												
							<td> 
								<input type="checkbox" name="az_fixedbar_mobileview" <?php if ( get_option('az_fixedbar_mobileview') == 'on' ) echo 'checked';?> />
							</td>
						</tr>										
					</table>					
				</section>
				
			</fieldset>	
			</div>		

	
			<input type="hidden" name="action" value="update" />		
			<input type="hidden" name="page_options" value="az_fixedbar_size,az_fixedbar_fontsize,az_fixedbar_position,az_fixedbar_background,az_fixedbar_pageID_inc,az_fixedbar_pageID_ex,az_fixedbar_frontpage,az_fixedbar_open_button_title,az_fixedbar_close_button,az_fixedbar_bodymargin,az_fixedbar_mobileview,az_fixedbar_size_select,az_fixedbar_font_select,az_fixedbar_fullwidth,az_fixedbar_barcaption,az_fixedbar_basis,az_fixedbar_basis_select" />
			
			<?php submit_button();?>
		</form>
	
</div>

<!-------------------------------------------------------->
<div style="margin:5px;">
	<a href="http://www.artzona.org" target="_blank">
		<img width="88" height="31" border="0" src="http://artzona.org/img/artzona88x31.gif" alt="Artzona banner" title="Artzona" style="float:right;">
	</a>
</div>
<div style="clear:both;"></div>
