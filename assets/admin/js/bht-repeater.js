jQuery(document).ready(function($){
	$(document).on('click', '#rwspt_addRow', function(){
		var itemLength = $('.rwspt_wraper .rwspt_item').length;
		if( itemLength < 4 ) {
			var rowSelector = $('.rwspt_wraper>.rwspt_item:first-child').clone();
			rowSelector.find('input, textarea, checkbox').val('');
			rowSelector.find('input[type=checkbox]').attr('checked', false);
			rowSelector.find('.rwspt_repeater_plan_feature').children('.rwspt_repeater_item:not(:first-child)').remove();
			rowSelector.find('.rwspt_features_class').attr('name', 'rwspt_meta_fields[rwspt_plan_features]['+itemLength+'][]');

			/*change checkbox key value*/
			rowSelector.find('.rwspt_plan_featured').attr('value', 'featured').attr('name', 'rwspt_meta_fields[rwspt_plan_featured][checkbox_'+ itemLength +']');
			/*End of change checkbox key value*/
			$('.rwspt_wraper').append(rowSelector);
		}
		else {
			alert( 'Maximum Plan Reached' );
		}

	});

	$(document).on('click','#rwspt_feature', function(){
		var rowSelector = $(this).siblings('.rwspt_repeater_plan_feature').children('.rwspt_repeater_item:first-child').clone();
		rowSelector.find('input').val('');
		$(this).siblings('.rwspt_repeater_plan_feature').append(rowSelector);
	});

});