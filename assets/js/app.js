jQuery( document ).ready( function() {
    jQuery( '#spyr_adp_link' ).click( function( e ) {
        var link = this;
        var rurl   = jQuery( "#rlink" ).val();
        // This is what we are sending the server
        var data = {
            action: 'rapid_download',
            rapidUrl: rurl,
        }
        // Change the anchor text of the link
        // To provide the user some immediate feedback
        jQuery( link ).text( 'uploading...' );
        jQuery( link ).attr("disabled", true);
        jQuery( link ).removeClass("base-core-button--alt-green");

        // Post to the server
        jQuery.ajax({
            url: ajaxurl,
            dataType: 'json',
            type: 'POST',
            data: data,
            success: function(data) {
                // If we are successful, add the success message and remove the link
                if( data.status == 200) {
                    jQuery( link ).attr("disabled", false);
                    jQuery( link ).addClass("base-core-button--alt-green");
                    jQuery( link).html("Process");
                    jQuery( "#rlink" ).removeAttr("value");
                }
            }
        });
        // Prevent the default behavior for the link
        e.preventDefault();
    });
});