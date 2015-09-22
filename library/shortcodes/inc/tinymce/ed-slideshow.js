/**
 * slideshow Short code button
 */

( function() {
     tinymce.create( 'tinymce.plugins.slideshow', {
        init : function( ed, url ) {
             ed.addButton( 'slideshow', {
                title : 'Insert Slideshow',
                image : url + '/ed-icons/slideshow.png',
                onclick : function() {
						var width = jQuery( window ).width(), H = jQuery( window ).height(), W = ( 720 < width ) ? 720 : width;
						W = W - 80;
						H = H - 84;
						tb_show( 'Slideshow Options', '#TB_inline?width=' + W + '&height=' + H + '&inlineId=sc-slideshow-form' );
                 }
             });
         },
         createControl : function( n, cm ) {
             return null;
         },
     });
	tinymce.PluginManager.add( 'slideshow', tinymce.plugins.slideshow );
	jQuery( function() {
		var form = jQuery( '<div id="sc-slideshow-form"><table id="sc-slideshow-table" class="form-table">\
							<tr>\
							<th><label for="sc-slide-effect">Slide effect</label></th>\
							<td>\
							<select name="sc-slide-effect" id="sc-slide-effect">\
							<option value="fade" selected>Fade</option>\
							<option value="slide">Slide</option>\
							</select>\
							</td>\
							</tr>\
							<tr>\
							<th><label for="sc-slide-number">Number of slide</label></th>\
							<td><input type="text" name="sc-slide-number" id="sc-slide-number" value="5" /></td>\
							</tr>\
							</table>\
							<p class="submit">\
							<input type="button" id="sc-slideshow-submit" class="button-primary" value="Insert Slideshow" name="submit" />\
							</p>\
							</div>' );
		var table = form.find( 'table' );
		form.appendTo( 'body' ).hide();
		form.find( '#sc-slideshow-submit' ).click( function() {
			var slide_effect = table.find( '#sc-slide-effect' ).val(),
			slide_number = table.find( '#sc-slide-number' ).val(),
			shortcode = '[slideshow';
			if (slide_number) {
				shortcode += ' slide_number="' + slide_number + '"';
			} else {
				shortcode += ' slide_number="5"'; 
			}
			shortcode += ' slide_effect="' + slide_effect + '" ]';
				

			tinyMCE.activeEditor.execCommand( 'mceInsertContent', 0, shortcode );
			tb_remove();
		} );
	} );
 } )();