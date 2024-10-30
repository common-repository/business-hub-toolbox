<?php
	if( !isset( $rwspt_meta_data ) ){ 
		$rwspt_meta_data = new stdClass();
		$rwspt_meta_data->rwspt_plan_name		= [''];
		$rwspt_meta_data->rwspt_plan_desc		= [''];
		$rwspt_meta_data->rwspt_plan_icon		= [''];
		$rwspt_meta_data->rwspt_price_sym		= [''];
		$rwspt_meta_data->rwspt_plan_price		= [''];
		$rwspt_meta_data->rwspt_plan_duration	= [''];
		$rwspt_meta_data->rwspt_plan_featured	= new stdClass();
		$rwspt_meta_data->rwspt_button_text		= [''];
		$rwspt_meta_data->rwspt_button_url		= [''];
		$rwspt_meta_data->rwspt_open_link		= [''];
		$rwspt_meta_data->rwspt_plan_features	=[['']];
	}

	if(isset($rwspt_meta_data) && (!isset($rwspt_meta_data->rwspt_plan_featured))){
		$rwspt_meta_data->rwspt_plan_featured	= new stdClass();
	}

?>
<div class="rwspt_wraper">
	<?php 
		foreach($rwspt_meta_data->rwspt_plan_name as $key=>$val) {
	?>
		<div class="rwspt_item">
			<img class="rwspt_remove_plan" src="<?php echo ECA_IMAGE_DIR.'/Close.png';?>" onClick="this.parentNode.parentNode.removeChild(this.parentNode);">
			<table class="form-table">
				<thead>
					<tr>
						<th><?php _e( 'Plan Details', 'business-hub-toolbox' ); ?></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><?php _e( 'Plan Name', 'business-hub-toolbox' ); ?></td>
						<td>
							<input id="rwspt_plan_name" name= "rwspt_meta_fields[rwspt_plan_name][]" type="text" value="<?php echo esc_attr( $rwspt_meta_data->rwspt_plan_name[$key] ); ?>">
						</td>
					</tr>

					<tr>
						<td><?php _e( 'Plan Description', 'business-hub-toolbox' ); ?></td>
						<td>
							<input id="rwspt_plan_name" name= "rwspt_meta_fields[rwspt_plan_desc][]" type="text" value="<?php echo esc_attr( $rwspt_meta_data->rwspt_plan_desc[$key] ); ?>" size="35">
						</td>
					</tr>

					<tr>
						<td><?php _e( 'Font Awesome icon', 'business-hub-toolbox' ); ?></td>
						<td>
							<input id="rwspt_plan_icon" name= "rwspt_meta_fields[rwspt_plan_icon][]" type="text" value="<?php echo esc_attr( $rwspt_meta_data->rwspt_plan_icon[$key] ); ?>">
							<br/>
						<span><i><?php _e( 'Eg. fa-tasks', 'business-hub-toolbox' ); ?></i></span>
						</td>
					</tr>

					<tr>
						<td><?php _e( 'Currency  Symbol', 'business-hub-toolbox' ); ?></td>
						<td>
							<input id="rwspt_price_sym" name= "rwspt_meta_fields[rwspt_price_sym][]" type="text" value="<?php echo esc_attr( $rwspt_meta_data->rwspt_price_sym[$key] ); ?>" size="5"><br/>
						<span><i><?php _e( 'Eg. $', 'business-hub-toolbox' ); ?></i></span>
						</td>
					</tr>

					<tr>
						<td><?php _e( 'Price', 'business-hub-toolbox' ); ?></td>
						<td>
							<input id="rwspt_plan_price" name= "rwspt_meta_fields[rwspt_plan_price][]" type="text" value="<?php echo esc_attr( $rwspt_meta_data->rwspt_plan_price[$key] ); ?>" size="5">
						</td>
					</tr>


					<tr>
						<td><?php _e( 'Duration', 'business-hub-toolbox' ); ?></td>
						<td>
							<select id="rwspt_plan_duration" name="rwspt_meta_fields[rwspt_plan_duration][]">
								<option value=''><?php _e('Select One', 'business-hub-toolbox'); ?></option>
								<option <?php selected( $rwspt_meta_data->rwspt_plan_duration[$key], 'mo'); ?> value="mo">
									<?php _e('Month', 'business-hub-toolbox'); ?>
								</option>
								<option <?php selected( $rwspt_meta_data->rwspt_plan_duration[$key], 'yr'); ?> value="yr">
									<?php _e('Year', 'business-hub-toolbox'); ?>
								</option>
							</select>
						</td>
					</tr>

					<tr>
						<td><?php _e( 'Featured?', 'business-hub-toolbox' ); ?></td>
						<td>
							<input class="rwspt_plan_featured" id="rwspt_plan_featured" name= "rwspt_meta_fields[rwspt_plan_featured][<?php echo 'checkbox_'.$key; ?>]" type="checkbox" value="featured"  
							<?php
							
								$rwspt_plan_featured =(array)$rwspt_meta_data->rwspt_plan_featured;
								if ( isset( $rwspt_plan_featured['checkbox_'.$key] ) && ( $rwspt_plan_featured['checkbox_'.$key] == 'featured' ) ){
		  							echo 'checked';
		  						}
							?>
							 >
						</td>
					</tr>

					<tr>
						<td><?php _e( 'Button Text', 'business-hub-toolbox' ); ?></td>
						<td>
							<input id="rwspt_button_text" name= "rwspt_meta_fields[rwspt_button_text][]" type="text" value="<?php echo esc_attr( $rwspt_meta_data->rwspt_button_text[$key] ); ?>">
						</td>
					</tr>

					<tr>
						<td><?php _e( 'Button URL', 'business-hub-toolbox' ); ?></td>
						<td>
							<input id="rwspt_button_url" name= "rwspt_meta_fields[rwspt_button_url][]" type="text" value="<?php echo esc_url( $rwspt_meta_data->rwspt_button_url[$key] ); ?>">
						</td>
					</tr>

					<tr>
						<td><?php _e( 'Open Link', 'business-hub-toolbox' ); ?></td>
						<td>
							<select id="rwspt_open_link" name="rwspt_meta_fields[rwspt_open_link][]">
								<option value=''><?php _e('Select One', 'business-hub-toolbox'); ?></option>
								<option <?php selected( $rwspt_meta_data->rwspt_open_link[$key], 'same'); ?> value="same"><?php _e('Same Tab', 'business-hub-toolbox'); ?></option>
								<option <?php selected( $rwspt_meta_data->rwspt_open_link[$key], 'new'); ?> value="new"><?php _e('New Tab', 'business-hub-toolbox'); ?></option>
							</select>
						</td>
					</tr>
				</tbody>
			</table>
			<div class="rwspt_repeater_plan_feature">
				<?php 
					$rwspt_meta_features = $rwspt_meta_data->rwspt_plan_features[$key];
					foreach( $rwspt_meta_features as $rwspt_inner_item ) { 
				?>
					<div class="rwspt_repeater_item">
						<label><?php _e( 'Features', 'business-hub-toolbox' ); ?></label>
						<input class="rwspt_features_class" name="rwspt_meta_fields[rwspt_plan_features][<?php echo $key; ?>][]" type="text" value="<?php echo esc_attr( $rwspt_inner_item ); ?>" size="35">
						<button class="button rwspt_remove_feature" onClick="this.parentNode.parentNode.removeChild(this.parentNode);">
							<?php _e( 'Delete Feature', 'business-hub-toolbox' ); ?>
						</button><br/>
					</div>
				<?php } ?>
			</div><br/>
			<button type="button" class="button" name="rwspt_feature" id="rwspt_feature">
				<?php _e( 'Add More Feature', 'business-hub-toolbox' ); ?>
			</button>
		</div>

	<?php }  ?>	
</div>
<button type="button" class="button-primary" name="rwspt_addRow" id="rwspt_addRow">
	<?php _e( 'Add Plan', 'business-hub-toolbox' ); ?>
</button>

