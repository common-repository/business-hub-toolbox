<div class="rwsec_settings">
	<label>
		<input type="radio" name="rwsec_add_setting" id = "rwsec_add_setting" value="pagination">
		<img src="<?php echo ECA_IMAGE_DIR.'/page.jpg';?>" class="<?php echo ( $position == 'pagination' ? 'rws-layout-image-selected' : '' )?> rws-layout-image"/>
	</label>
	<br>
	<label>
		<input type="radio" name="rwsec_add_setting" value="normal">
		<img src="<?php echo ECA_IMAGE_DIR.'/normal.jpg';?>" class="<?php echo ( $position == 'normal' ? 'rws-layout-image-selected' : '' )?> rws-layout-image" />
	</label>
	<br>
	<label>
		<input type="radio" name="rwsec_add_setting" value="round">
		<img src="<?php echo ECA_IMAGE_DIR.'/round.jpg';?>" class="<?php echo ( $position == 'round' ? 'rws-layout-image-selected' : '' )?> rws-layout-image" />
	</label>
</div>
<script type="text/javascript">
	jQuery(document).ready(function($) {
	  $('label img').click(function(){
	   var parent_element = $(this).parent().parent().parent();
	   parent_element.find('img.rws-layout-image-selected').removeClass('rws-layout-image-selected');
	   $(this).addClass ('rws-layout-image-selected') ;
	  });
	});
</script>