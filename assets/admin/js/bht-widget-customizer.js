jQuery(document).ready( function($) {
    function media_upload(button_class) {
        var _custom_media = true,
        _orig_send_attachment = wp.media.editor.send.attachment;

        jQuery('body').on('click', button_class, function(e) {
            var button_id ='#'+$(this).attr('id');
            var self = $(button_id);
            var send_attachment_bkp = wp.media.editor.send.attachment;
            var button = $(button_id);
            var id = button.attr('id').replace('_button', '');
            _custom_media = true;
            wp.media.editor.send.attachment = function(props, attachment){
                if ( _custom_media  ) {
                    jQuery('.custom_media_id').val(attachment.id);
                    jQuery('.custom_media_url').val(attachment.url);
                    jQuery('.custom_media_image').attr('src',attachment.url).css('display','block');
                } else {
                    return _orig_send_attachment.apply( button_id, [props, attachment] );
                }
            }
            wp.media.editor.open(button);
                return false;
        });
    }
    media_upload('.custom_media_button.button');

    jQuery('.meta_box_clear_logo_button').click(function() {
        jQuery('#event_logo').val(''); 
        jQuery('#rws_logo_event').hide();
    });

    var rwsec_select_value = jQuery('#widgets-right select.ec-dropdown').val();
    if ( rwsec_select_value == 'calendar')
    {
        jQuery(".ec_post_number").hide();
    }
    else
    {
        jQuery(".ec_post_number").show();
    }
        
});

jQuery( document ).on( 'widget-updated widget-added change' , function( event, $widget ){
    var rwsec_select_value = jQuery('#widgets-right select.ec-dropdown').val();
    if ( rwsec_select_value == 'calendar')
    {
        jQuery(".ec_post_number").hide();
    }
    else
    {
        jQuery(".ec_post_number").show();
    }
});