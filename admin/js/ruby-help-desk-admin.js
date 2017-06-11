(function( $ ) {
	'use strict';
	$(function() {
		$('.post-type-support_ticket #title-prompt-text').html('Ticket Subject');
		$('.ticket-status-color-field').wpColorPicker();


		//The WC+EDD Products sync logic
		$('#sync_wc_products').click(function(){

			$('#sync_wc_products').attr('disabled', 'disabled');
			$('#sync_wc_products_spinner').css('display', 'inline-block');
			$('#sync_wc_products_spinner_result').css('display', 'none');

			var data = {
						'action': 'sync_wc_products',
						'_wpnonce': rhd.wc_sync_nonce
			};

			$.post(ajaxurl, data, function(response) {
				if(response == '0'){
					$('#sync_wc_products_spinner_result').html(rhd.text_no_processed_products);
				}else{
					$('#sync_wc_products_spinner_result').html(response +' '+ rhd.text_processed_products);
				}
				$('#sync_wc_products_spinner_result').css('display', 'inline-block');
				$('#sync_wc_products').removeAttr('disabled');
				$('#sync_wc_products_spinner').css('display', 'none');
			});
		});



		$('#sync_edd_products').click(function(){

			$('#sync_edd_products').attr('disabled', 'disabled');
			$('#sync_edd_products_spinner').css('display', 'inline-block');
			$('#sync_edd_products_spinner_result').css('display', 'none');

			var data = {
						'action': 'sync_edd_products',
						'_wpnonce': rhd.edd_sync_nonce
			};

			$.post(ajaxurl, data, function(response) {
				if(response == '0'){
					$('#sync_edd_products_spinner_result').html(rhd.text_no_processed_products);
				}else{
					$('#sync_edd_products_spinner_result').html(response +' '+ rhd.text_processed_products);
				}
				$('#sync_edd_products_spinner_result').css('display', 'inline-block');
				$('#sync_edd_products').removeAttr('disabled');
				$('#sync_edd_products_spinner').css('display', 'none');
			});
		});

		/*
		* Custom Fields logic
		* @since 1.2.0
		*/
	 $( "#active_custom_fields" )
		 .accordion({
			 header: "> div > h3",
			 collapsible: true,
			 active: false,
		 })
		 .sortable({
			 axis: "y",
			 handle: "h3",
			 placeholder: "ui-state-highlight",
			 stop: function( event, ui ) {
				 // IE doesn't register the blur when sorting
				 // so trigger focusout handlers to remove .ui-state-focus
				 ui.item.children( "h3" ).triggerHandler( "focusout" );

				 // Refresh accordion to handle new order
				 $( this ).accordion( "refresh" );
			 }
		 });
		 $('.draggable-custom-field-item').click(function(e){
			 var label 					=  $(this).attr('data-label');
			 var type 					=  $(this).attr('data-type');
			 var default_value	=  $(this).attr('data-default');
			 var key 						=  $(this).attr('data-key');
			 var core 					=  $(this).attr('data-core');
			 var new_element = `<div class="group">
         <h3 class="form-element-{type}">{label}<b></b></h3>
         <div>
           <p>
             <label for="{key}-label">Label</label><br>
             <input id="{key}-label" type="text" name="rhd_custom_fields[{key}][label]" value="{label}">
           </p>
           <p>
             <label for="{key}-description">Description</label><br>
             <textarea id="{key}-description" name="rhd_custom_fields[{key}][description]" rows="4" cols="50"></textarea>
           </p>
           <p>
             <label for="{key}-size">Field size</label><br>
             <select id="{key}-size" name="rhd_custom_fields[{key}][size]">
               <option value="small">Small</option>
               <option value="medium">Medium</option>
               <option value="large">Large</option>
             </select>
           </p>
           <p>
             <label for="{key}-required">Required</label><br>
             <select id="{key}-required" name="rhd_custom_fields[{key}][required]">
               <option value="yes">Yes</option>
               <option value="no">No</option>
             </select>
           </p>
					 <input type="hidden" name="rhd_custom_fields[{key}][core]" value="{core}">
					 <input type="hidden" name="rhd_custom_fields[{key}][type]" value="{type}">
         </div>
       </div>`;
			 new_element = new_element.replace(/{label}/g, label).replace(/{type}/g, type).replace(/{key}/g, key).replace(/{core}/g, core);
			 $('#active_custom_fields').append(new_element);
			 $( "#active_custom_fields" ).accordion( "refresh" );
			 $('#active_custom_fields').sortable();
		 });




  });



})( jQuery );
