/**
 * Initialization of jquery slider range
 * 
 * @author Nikolay Georgiev
 * @version 1.0
 */
jQuery(document).ready(function(){
    
	// Searching for slider range elements
    jQuery('.thrace-slider-range').each(function(key, value){
    	var options = jQuery(this).data('options'); 
        
        var value_1 = jQuery('#' + options.id + '_' + options.first_name); 
        var value_2 = jQuery('#' + options.id + '_' + options.second_name); 
        
        options.values = [parseFloat(value_1.val()), parseFloat(value_2.val())];

        if(!isNaN(options.values[0]) && !isNaN(options.values[1])){ 
            if(options.values[0] >= options.min){
            	value_1.val(options.values[0]); 
            } else {
            	options.values[0] = options.min;
            	value_1.val(options.min); 
            }
            
            if(options.values[1] <= options.max){
            	value_2.val(options.values[1]); 
            } else {
            	options.values[1] = options.max;
            	value_2.val(options.max); 
            }
           
        } else { 
            options.values[0] = options.min;
            options.values[1] = options.max;
        } 
        
        var label = jQuery('#thrace-slider-range-tpl-' + options.id);
        html = label.html().replace('__value_1__', '<span id="'+ options.id +'_value_1" class="slider-value">' + options.values[0] + '</span>');
        html = html.replace('__value_2__', '<span id="'+ options.id +'_value_2" class="slider-value">' + options.values[1] + '</span>');
        label.html(html);

        options.slide = function(event, ui){
            value_1.val(ui.values[0]);
            value_2.val(ui.values[1]);

            jQuery('#' + options.id +'_value_1').text(ui.values[0]);
            jQuery('#' + options.id +'_value_2').text(ui.values[1]);
        };

        jQuery('#thrace-slider-range-' + options.id).slider(options);

    });
});


