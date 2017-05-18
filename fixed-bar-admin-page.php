<?php 
		$size = get_option('az_fixedbar_size');			 
		$color = get_option('az_fixedbar_color');
		$position = get_option('az_fixedbar_position');
		$pageID_inc = get_option('az_fixedbar_pageID_inc');
		$pageID_ex = get_option('az_fixedbar_pageID_ex');
		$frontpage = get_option('az_fixedbar_frontpage');
		
		if ( $frontpage ) $frontpage = 'checked';

		switch ($position) {
			case 'top' : $top="checked style='font-weight:bold;'";break;
			case 'left' : $left='checked';break;
			case 'right' : $right='checked';break;
			case 'bottom' : $bottom='checked';break;			
		}	
?>

<style>
#position-table input:checked{
	font-weight:bold;
}
</style>

<div class="wrap">
	<h2><?php _e('Fixed bar plugin options','fixed-bar'); ?></h2>
	
	<form action="" method="post">		
		<table class="form-table" id="position-table">		
			<tr>
				<th scope="row"><label for="size"><?php _e('Bar size','fixed-bar'); ?> :</label></th>
				<td> <input type="text" name="size" value="<?=$size?>">px </td>
			</tr>
			
			<tr>
				<th scope="row" style="vertical-align:middle;"><label for="position"><?php _e('Bar position','fixed-bar'); ?> :</label></th>
				<td> 
					<table style="width:300px">
						<tr>
							<td style="width:100px"></td>
							<td style="width:100px"><input type="radio" name="position" <?=$top?> value="top" />top	</td>
							<td style="width:100px"></td>
						</tr>
				
						<tr>
							<td style="width:100px"><input type="radio" name="position" <?=$left?> value="left" />left</td>
							<td style="width:100px"></td>
							<td style="width:100px"><input type="radio" name="position" <?=$right?> value="right" />right</td>
						</tr>
				
						<tr>
							<td style="width:100px"></td>
							<td style="width:100px"><input type="radio" name="position" <?=$bottom?> value="bottom" />bottom</td>
							<td style="width:100px"></td>
						</tr>
					</table>
				</td>
			</tr>
			
			<tr>
				<th scope="row"><label for="color"><?php _e('Bar color','fixed-bar'); ?> :</label></th>
				<td> 
					<input name="color" class="iris_color" id='color-picker' type="text" value="<?=$color?>" />
				</td>
			</tr>
		</table>
		
		<h2 class="title"><?php _e('Visibility','fixed-bar');?></h2><hr>
			<table class="form-table">	
				<tr>
					<th scope="row">
						<label for="pageID_inc"><?php _e('Page ID (ON)','fixed-bar'); ?> :</label>					
					</th>
										
					<td> 
						<input type="text" id="ID_inc" name="pageID_inc" size="60" value="<?=$pageID_inc?>" />
						<p class="description">
							<?php _e('ON Fixed bar only this pages. Page IDs, separated by commas','fixed-bar'); ?>
						</p>
					</td>
				</tr>
				
				<tr>
					<th scope="row">
						<label for="pageID_ex"><?php _e('Page ID (OFF)','fixed-bar'); ?> :</label>						
					</th>
									
					<td> 
						<input type="text" id="ID_ex" name="pageID_ex" size="60" value="<?=$pageID_ex?>" />
						<p class="description">
							<?php _e('OFF Fixed bar only this pages. Page IDs, separated by commas','fixed-bar'); ?>
						</p>
					</td>
				</tr>	
		
				<tr>
					<th scope="row"><label for="frontpage"><?php _e('Display bar on frontpage','fixed-bar'); ?> :</label></th>
					<td> <input type="checkbox" name="frontpage" <?=$frontpage?> /> </td>
				</tr>
			
			</table>		
				
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
