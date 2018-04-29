(function ($) {
  'use strict';
  $(function () {
    var replyWrap = $('#reply_to_ticket');
    var replyTextArea = $('#ticket_reply');

    $('.rhd_template_tag').click(function (e) {
      e.preventDefault();
      var tag = $(this).attr('data-value');
      /* Check if TinyMCE is loaded */
      if (typeof (tinyMCE) != 'undefined') {

        /* Check version of TinyMCE */
        if (tinymce.majorVersion < 4) {
          tinyMCE.execInstanceCommand('content', 'mceInsertContent', false, tag);
        } else {
          tinyMCE.get('content').insertContent(tag);
        }
      }
    });

    $('.rhd_template_unit').click(function (e) {

      e.preventDefault();
      var content = $(this).attr('data-content');
      if (replyWrap.hasClass('tmce-active')) {
        /* Check if TinyMCE is loaded */
        if (typeof (tinyMCE) != 'undefined') {

          /* Check version of TinyMCE */
          if (tinymce.majorVersion < 4) {
            tinyMCE.execInstanceCommand('ticket_reply', 'mceInsertContent', false, content);
          } else {
            tinyMCE.get('ticket_reply').insertContent(content);
          }
        }
      } else {
        replyTextArea.val(function (i, val) {
          return val + content;
        });
      }
    });


    $('.post-type-support_ticket #title-prompt-text').html(rhd.text_ticket_subject);
    $('.ticket-status-color-field').wpColorPicker();


    //The WC+EDD Products sync logic
    $('#sync_wc_products').click(function () {

      $('#sync_wc_products').attr('disabled', 'disabled');
      $('#sync_wc_products_spinner').css('display', 'inline-block');
      $('#sync_wc_products_spinner_result').css('display', 'none');

      var data = {
        'action': 'sync_wc_products',
        '_wpnonce': rhd.wc_sync_nonce
      };

      $.post(ajaxurl, data, function (response) {
        if (response == '0') {
          $('#sync_wc_products_spinner_result').html(rhd.text_no_processed_products);
        } else {
          $('#sync_wc_products_spinner_result').html(response + ' ' + rhd.text_processed_products);
        }
        $('#sync_wc_products_spinner_result').css('display', 'inline-block');
        $('#sync_wc_products').removeAttr('disabled');
        $('#sync_wc_products_spinner').css('display', 'none');
      });
    });


    $('#sync_edd_products').click(function () {

      $('#sync_edd_products').attr('disabled', 'disabled');
      $('#sync_edd_products_spinner').css('display', 'inline-block');
      $('#sync_edd_products_spinner_result').css('display', 'none');

      var data = {
        'action': 'sync_edd_products',
        '_wpnonce': rhd.edd_sync_nonce
      };

      $.post(ajaxurl, data, function (response) {
        if (response == '0') {
          $('#sync_edd_products_spinner_result').html(rhd.text_no_processed_products);
        } else {
          $('#sync_edd_products_spinner_result').html(response + ' ' + rhd.text_processed_products);
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
    $("#active_custom_fields")
      .accordion({
        header: "> div > h3",
        collapsible: true,
        active: false,
        heightStyle: "content",
      })
      .sortable({
        axis: "y",
        handle: "h3",
        placeholder: "ui-state-highlight",
        stop: function (event, ui) {
          // IE doesn't register the blur when sorting
          // so trigger focusout handlers to remove .ui-state-focus
          ui.item.children("h3").triggerHandler("focusout");

          // Refresh accordion to handle new order
          $(this).accordion("refresh");
        }
      });
    //init filed option sortable()
    $('.field_options').sortable();

    $('.draggable-custom-field-item').click(function (e) {
      var label = $(this).attr('data-label');
      var type = $(this).attr('data-type');
      var default_value = $(this).attr('data-default');
      var core = $(this).attr('data-core');
      var key = 'rhd_' + type + '_' + Math.random().toString(36).substring(2, 12);
      var options = '';
      var multiselect_fields = ['select', 'radio', 'checkbox'];
      if (multiselect_fields.indexOf(type) != -1) {
        options += '<p><label for="{key}-options">' + rhd.text_options + '</label><br>';
        options += '<ul class="field_options" id="{key}-options">';
        options += '<li><input name="rhd_custom_fields[{key}][options][]" class="code" value="Option 1" type="text" /><span class="delete_option dashicons dashicons-trash"></span><span class="dashicons  dashicons-menu"></span></li>';
        options += '<li><input name="rhd_custom_fields[{key}][options][]" class="code" value="Option 2" type="text" /><span class="delete_option dashicons dashicons-trash"></span><span class="dashicons  dashicons-menu"></span></li>';
        options += '<li><input name="rhd_custom_fields[{key}][options][]" class="code" value="Option 3" type="text" /><span class="delete_option dashicons dashicons-trash"></span><span class="dashicons  dashicons-menu"></span></li>';
        options += '</ul>';
        options += '<a class="add_option button-secondary" data-key="{key}" data-field="{key}-options" href="javascript:void(0)"><span class="dashicons dashicons-plus-alt"></span>' + rhd.add_option + '</a>';
        options += '</p>';

      }
      var new_element = `<div class="group">
         <h3 class="form-element-{type}">{label}<b></b><a href="javascript:void(0)" class="delete_custom_field"><span class="dashicons dashicons-trash"></span></a></h3>
         <div>
           <p>
             <label for="{key}-label">{text_label}</label><br>
             <input id="{key}-label" type="text" name="rhd_custom_fields[{key}][label]" value="{label}">
           </p>
           <p>
             <label for="{key}-description">{text_description}</label><br>
             <textarea id="{key}-description" name="rhd_custom_fields[{key}][description]" rows="4" cols="50"></textarea>
           </p>
           <p>
             <label for="{key}-size">{text_field_size}</label><br>
             <select id="{key}-size" name="rhd_custom_fields[{key}][size]">
               <option value="small">{text_small}</option>
               <option value="medium">{text_medium}</option>
               <option value="large">{text_large}</option>
             </select>
           </p>
           <p>
             <label for="{key}-required">{text_required}</label><br>
             <select id="{key}-required" name="rhd_custom_fields[{key}][required]">
               <option value="yes">Yes</option>
               <option value="no">No</option>
             </select>
           </p>
					 {options}
					 <input type="hidden" name="rhd_custom_fields[{key}][core]" value="{core}">
					 <input type="hidden" name="rhd_custom_fields[{key}][type]" value="{type}">
					 <input type="hidden" name="rhd_custom_fields[{key}][id]" value="{key}">
         </div>
       </div>`;
      new_element = new_element.replace(/{label}/g, label).replace(/{options}/g, options).replace(/{type}/g, type).replace(/{key}/g, key).replace(/{core}/g, core);
      //info: replace locale texts.
      new_element = new_element.replace(/{text_label}/g, rhd.text_label).replace(/{text_description}/g, rhd.text_description).replace(/{text_field_size}/g, rhd.text_field_size).replace(/{text_small}/g, rhd.text_small).replace(/{text_medium}/g, rhd.text_medium).replace(/{text_large}/g, rhd.text_large).replace(/{text_required}/g, rhd.text_required);
      $('#active_custom_fields').append(new_element);
      $('.field_options').sortable();

      $("#active_custom_fields").accordion("refresh");
      $('#active_custom_fields').sortable();
    });


    $('.delete_option').click(function (e) {
      e.preventDefault();
      $(this).parent().remove();
    });
    $('.delete_custom_field').click(function (e) {
      e.preventDefault();
      if (window.confirm(rhd.text_delete_confirmation)) {
        $(this).parent().parent().remove();
      }
    });

    jQuery('.add_option').click(function (e) {
      e.preventDefault();
      var key = $(this).attr('data-key');
      jQuery('#' + jQuery(this).attr('data-field')).append('<li><input name="rhd_custom_fields[' + key + '][options][]" class="code" value="" type="text" /><span class="delete_option dashicons dashicons-trash"></span><span class="dashicons  dashicons-menu"></span></li>');
      jQuery('.field_options').sortable();
      jQuery('.delete_option').click(function (e) {
        e.preventDefault();
        jQuery(this).parent().remove();
      });
      $('.delete_custom_field').click(function (e) {
        e.preventDefault();
        if (window.confirm(rhd.text_delete_confirmation)) {
          $(this).parent().parent().remove();
        }
      });
    });

  });


})(jQuery);
