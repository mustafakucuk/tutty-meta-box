jQuery(document).ready( function($) {
    function media_upload(button_class) {
        var _tutty_upload = true,
        _orig_send_attachment = wp.media.editor.send.attachment;

        $('body').on('click', button_class, function(e) {
			_tutty_upload = true;
			var tutty_upload_relation = $(this).data('relation');
            wp.media.editor.send.attachment = function(props, attachment){
                if ( _tutty_upload ) {
					$(tutty_upload_relation).val(attachment.url);
					$(tutty_upload_relation).trigger('change');
                } else {
                    return _orig_send_attachment.apply( button_id, [props, attachment] );
                }
            }
            wp.media.editor.open(button_class);
            return false;
        });
    }
    media_upload('.tutty_upload_button');
});