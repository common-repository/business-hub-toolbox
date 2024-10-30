<?php
add_shortcode( 'rwspt-pricing-table', 'bht_pricing_table' );

function bht_pricing_table( $atts ) {
    ob_start(); 
    extract(shortcode_atts(
                    array(
                        'id' => '',
                    ), 
                    $atts
                )
            );
    $rwspt_args = array(
						'p' => $id, 
						'post_type' => 'rws-pricing-table'
					);
	$rwspt_plans = new WP_Query($rwspt_args);
?>


<?php if( $rwspt_plans->have_posts() ) {
		while( $rwspt_plans->have_posts() ) {
			$rwspt_plans->the_post();
			$rwspt_plans_meta = get_post_meta( get_the_id(), 'rwspt_meta_fields', true );
			$rwspt_plans_meta_details = get_post_meta( get_the_id(), 'rwspt_details', true );  
			$rwspt_plans_meta = json_decode($rwspt_plans_meta);
			$rwspt_count = count($rwspt_plans_meta->rwspt_plan_name);
			if( $rwspt_count == 1 ) { ?>
				<section class="rwspt-pricing-table-wrapper one">
			<?php } 
			elseif( $rwspt_count == 2 ) { ?>
				<section class="rwspt-pricing-table-wrapper two">
			<?php } 
			elseif( $rwspt_count == 3 ) { ?>
				<section class="rwspt-pricing-table-wrapper three">
			<?php } elseif( $rwspt_count == 4 ) { ?>
				<section class="rwspt-pricing-table-wrapper four">
			<?php } ?>
		<header class="entry-header">
		  <h2 class="entry-title"> <?php the_title( ); ?> </h2>
		  <hr/>
		  <p><?php echo esc_html( $rwspt_plans_meta_details ); ?></p> 
		</header>

			<?php
			
				foreach( $rwspt_plans_meta->rwspt_plan_name as $key=>$val ) {
					
					if( isset( $rwspt_plans_meta->rwspt_plan_featured ) ) {
						$rwspt_plan_featured =(array)$rwspt_plans_meta->rwspt_plan_featured;
					} ?>
					<div class="pricing-column-wrapper">
			
					

						<div class="rwspt-price-column <?php if( isset( $rwspt_plan_featured['checkbox_'.$key] ) && ( $rwspt_plan_featured['checkbox_'.$key] == 'featured' ) ) echo 'active-plan'; ?>">

							<div class="rwspt-price-header">
								<i class="fa <?php echo $rwspt_plans_meta->rwspt_plan_icon[$key]; ?> fa-5x"></i>
								<?php if( !empty($rwspt_plans_meta->rwspt_plan_name[$key]) ) { ?>
										<span>
											<?php echo esc_html( $rwspt_plans_meta->rwspt_plan_name[$key] ); ?>
										</span>
								<?php 
										} 
										if(!empty( $rwspt_plans_meta->rwspt_plan_desc[$key] )) {
								?>
											<p>
												<?php echo esc_html( $rwspt_plans_meta->rwspt_plan_desc[$key] ); ?>
											</p>
									<?php } ?>
							</div>

							<div class="rwspt-price">
								<?php if( !empty( $rwspt_plans_meta->rwspt_price_sym[$key] ) ) { ?>
									<span class="rwspt-price-prefix">
										<?php echo esc_html( $rwspt_plans_meta->rwspt_price_sym[$key] ); ?>
									</span>
								<?php 
									} 
									if( !empty( $rwspt_plans_meta->rwspt_plan_price[$key] ) ) {
								?>
									<span class="rwspt-price-number">
										<?php echo esc_html( $rwspt_plans_meta->rwspt_plan_price[$key] ); ?>
									</span>
								<?php
									}
									if( !empty( $rwspt_plans_meta->rwspt_plan_duration[$key] ) ) {
								?>
			                        <span class="rwspt-price-suffix">
			                        	<?php 
			                        		if( $rwspt_plans_meta->rwspt_plan_duration[$key] == 'mo' ) {
			                        			_e( '/ MO', 'business-hub-toolbox' );
			                        		}
			                        		else {
			                        			_e( '/ YR', 'business-hub-toolbox' );
			                        		}
			                        	?>
			                        </span>
		                        <?php } ?>
							</div>

							<?php if( !empty( $rwspt_plans_meta->rwspt_plan_features[$key][0] ) ) { ?>
								<div class="rwspt-price-table-content">
                                    <div class="option-list">
                                        <ul>
                                        	<?php 
												$rwspt_meta_features = $rwspt_plans_meta->rwspt_plan_features[$key];
												foreach( $rwspt_meta_features as $rwspt_inner_item=>$rwspt_inner_item_val ) { 
											?>
                                            	<li><i class="fa fa-check"></i><?php echo esc_html( $rwspt_meta_features[$rwspt_inner_item] ); ?></li>
                                        	<?php } ?>
                                        </ul>
                                    </div>
                                </div>
                            <?php } 
                             if(!empty( $rwspt_plans_meta->rwspt_button_text[$key] )) { ?>
                            	<a class="rwspt-btn-business" href="<?php echo esc_url( $rwspt_plans_meta->rwspt_button_url[$key] ); ?>" target="<?php echo ( $rwspt_plans_meta->rwspt_open_link[$key] == 'same' ) ? '_self' : '_blank'; ?>">
                            		<?php echo esc_html( $rwspt_plans_meta->rwspt_button_text[$key] ); ?>
                            	</a>
                            <?php } ?>
						</div>
					</div>
					<?php
						} ?>
						</section>	
				<?php	}	
				}
				?>
		

<?php
    $rwspt_plan = ob_get_clean();
	return $rwspt_plan;
} 