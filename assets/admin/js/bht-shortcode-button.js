jQuery(function($) {
	jQuery('#rwspt_insert').on('click', function () {
		var id = jQuery('#rwspt_select_id').val();
		if ('' === id) {
			jQuery('.rwspt_message').css('display', 'inline');
			return;
		}
		else {
			jQuery('.rwspt_message').css('display', 'none');
		}
		selectionText = '';
		if (typeof(tinyMCE.editors.content) != "undefined") {
			selectionText = (tinyMCE.activeEditor.selection.getContent()) ? tinyMCE.activeEditor.selection.getContent() : '';
		}
		window.send_to_editor('[rwspt-pricing-table id=' + id + ']');
		tb_remove();
	});
});