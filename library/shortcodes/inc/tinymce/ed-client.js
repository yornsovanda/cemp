/**
 * Client Short code button
 */

( function() {
     tinymce.create( 'tinymce.plugins.client', {
        init : function( ed, url ) {
             ed.addButton( 'client', {
                title : 'Insert Client Message',
                image : url + '/ed-icons/biography.png',
                onclick : function() {
						var width = jQuery( window ).width(), H = jQuery( window ).height(), W = ( 720 < width ) ? 720 : width;
						W = W - 80;
						H = H - 84;
						tb_show( 'Client Message Options', '#TB_inline?width=' + W + '&height=' + H + '&inlineId=sc-client-form' );
                 }
             });
         },
         createControl : function( n, cm ) {
             return null;
         },
     });
	tinymce.PluginManager.add( 'client', tinymce.plugins.client );
	jQuery( function() {
		var form = jQuery( '<div id="sc-client-form"><table id="sc-client-table" class="form-table">\
							<tr>\
							<th><label for="sc-client-style">Client Message Style</label></th>\
							<td><select name="style" id="sc-client-style">\
							<option value="slide">Slide</option>\
							<option value="list">List</option>\
							</select>\
							</td>\
							</tr>\
							<tr>\
							<th><label for="sc-post-num">Number of client</label></th>\
							<td><input type="text" name="sc-post-num" id="sc-post-num" value="10" /><small> (-1 to show all.)</small></td>\
							</tr>\
							</table>\
							<p class="submit">\
							<input type="button" id="sc-client-submit" class="button-primary" value="Insert Line" name="submit" />\
							</p>\
							</div>' );
		var table = form.find( 'table' );
		form.appendTo( 'body' ).hide();
		form.find( '#sc-client-submit' ).click( function() {
			var value = table.find( '#sc-client-style' ).val(),
			post_num = table.find( '#sc-post-num' ).val(),
			shortcode = '[client style="' + value + '"';
			shortcode += ' post_num="' + post_num + '"';
			shortcode += ']';

			tinyMCE.activeEditor.execCommand( 'mceInsertContent', 0, shortcode );
			tb_remove();
		} );
	} );
 } )();