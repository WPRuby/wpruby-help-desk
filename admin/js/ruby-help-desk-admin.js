(function( $ ) {
	'use strict';
	$(function() {
		$('.post-type-support_ticket #title-prompt-text').html('Ticket Subject');
		$('.ticket-status-color-field').wpColorPicker();


		//The WC+EDD Products sync logic
		$('#sync_wc_products').click(function(){

			$('#sync_wc_products').attr('disabled', 'disabled');
			$('#sync_wc_products_spinner').css('display', 'inline-block');

			var data = {
						'action': 'sync_wc_products',
			};

			// since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
			$.post(ajaxurl, data, function(response) {
				alert(response + ' Products synced successfully' );
				$('#sync_wc_products').removeAttr('disabled');
				$('#sync_wc_products_spinner').css('display', 'none');
			});



		});

  });



})( jQuery );
