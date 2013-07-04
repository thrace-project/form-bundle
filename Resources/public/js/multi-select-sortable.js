/**
 * Initialization of jquery multiselectsortable
 * 
 * @author Nikolay Georgiev
 * @version 1.0
 */
jQuery(document).ready(function(){
    jQuery('.multi-select-sortable-container').each(function(key, value){ 
        
        var createBtns = function ()
        {
            jQuery('.multi-select-element .delete-btn').button({
                icons: {
                    primary: "ui-icon-trash"
                },
                text: false
            });
        };
    
        createBtns();
        var element = jQuery(this);
        var options = jQuery(this).data('options'); 
        
        jQuery('body').bind('thrace.form.beforeSend', function(){
            jQuery('#multi-select-sortable-error-' + options.id).hide();
        });
    
        jQuery('#thrace-multi-select-sortable-error-cancel-' + options.id).click(function(){
            jQuery('#multi-select-sortable-error-' + options.id).fadeOut();
            return false;
        });
        
        jQuery("#multi-select-sortable-" + options.id).sortable({
            items: '.multi-select-element',
            forceHelperSize: true,
            forcePlaceholderSize: true,
            placeholder: "ui-state-highlight",
            beforeStop: function(event, ui) { alert('');
                var create = (ui.item.find('td').length > 0);
                jQuery('#multi-select-sortable-error-' + options.id).hide();

                if(create === false){
                    return;
                }

                var refId = ui.helper.data('referenceId');
                
                if(jQuery(this).find('#multi-select-element-' + refId).length > 0){
                    ui.item.remove();
                    jQuery('#multi-select-sortable-error-' + options.id).fadeIn();
                    return;
                }
                
                var prototype = element.data('prototype');
                var elementNum  = jQuery('#multi-select-sortable-' + options.id + ' .multi-select-element').length;
                var elementIdx = 0;
                
                if(elementNum > 0){
                    jQuery('#multi-select-sortable-' + options.id + ' .multi-select-element').each(function(){
                        var index = jQuery(this).data('index');
                        if(index >= elementIdx){
                            elementIdx = index + 1;
                        }
                    });
                }
              
         
                var formHtml = jQuery(prototype).html().replace(/__name__/g, elementIdx);

                var html = jQuery('<div id="multi-select-element-'+ refId +'" data-index="'+ elementIdx +'" class="ui-state-default multi-select-element">' + ui.helper.html() + 
                    '<a class="delete-btn" href="#" style="float:right"></a>'+ 
                    formHtml +'</div>');

                html.find('input:hidden').eq(1).val(refId);


                ui.item.remove();

                jQuery(this).append(html);

                createBtns();

                var elements = jQuery(this).find('.multi-select-element');

                jQuery.each(elements, function(k,v){
                    jQuery(this).find(':hidden').eq(0).val(k);
                });

            },
            update: function(event, ui) {
                
                var elements = jQuery('#multi-select-sortable-'+ options.id +'  .multi-select-element');
                
                jQuery.each(elements, function(k,v){
                    jQuery(this).find(':hidden').eq(0).val(k);
                });
            }

        });
        jQuery("#multi-select-sortable-" + options.id).disableSelection();
        
        jQuery(document).on('click', '.multi-select-element .delete-btn', function(){
            jQuery('#multi-select-sortable-error-' + options.id).hide();
            var parent = jQuery(this).parent().parent();
            jQuery(this).parent().fadeOut(function(){
                jQuery(this).remove();

                var elements = parent.parent().find('.multi-select-element');

                jQuery.each(elements, function(k,v){
                    jQuery(this).find(':hidden').eq(0).val(k);
                });
            });

            return false;
        });
    });
});



