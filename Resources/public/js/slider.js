/**
 * Initialization of jquery slider
 * 
 * @author Nikolay Georgiev
 * @version 1.0
 */
jQuery(document).ready(function(){
    
    // Searching for slider elements
    jQuery('.thrace-slider').each(function(key, value){
        var options = jQuery(this).data('options'); 
        var hiddenEl = jQuery('#' + options.id);
        var initial = parseFloat(hiddenEl.val());

        if(!isNaN(initial)){
            if(initial >= options.min && initial <= options.max){
                options.value = initial;
            } else {
                options.value = options.min;
                hiddenEl.val(options.min);
            }
            
        } else {
            options.value = options.min;
        }

        var label = jQuery('#thrace-slider-tpl-' + options.id);
        var html = label.html().replace('__value__', '<span id="'+ options.id +'_value" class="slider-value">' + options.value + '</span>');
        label.html(html);

        options.slide = function(event, ui){
            hiddenEl.val(ui.value);
            jQuery('#' + options.id + '_value').text(ui.value);
            options.value = ui.value;
        };

        jQuery('#thrace-slider-' + options.id).slider(options);
		
    });
});


