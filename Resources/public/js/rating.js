/**
 * Initialization of jquery rating widget
 * 
 * @author Nikolay Georgiev
 * @version 1.0
 */
jQuery(document).ready(function(){
	
    // Searching for rating elements
    jQuery('.thrace-rating').each(function(key, value){  
        var options = evaluateOptions(jQuery(this).data('options'));
        var el = jQuery('#' + options.id);
        var currentValue = parseInt(el.val());
        
        options.score = function() {
            if(!isNaN(currentValue)){
                return el.val();
            }
        };
        
        options.click = function(score, evt) {
            el.val(score);
        };
        
        jQuery('#thrace-rating-widget-' + options.id).raty(options);
    });

});

function evaluateOptions (options){
    jQuery.each(options, function(k,v){
        if(typeof(v) === 'string' && isNaN(v)){
            if(v.match('^function')){
                eval('options.'+ k +' = ' + v);
            }
        } else if(jQuery.isPlainObject(v) || jQuery.isArray(v)){
            evaluateOptions(v);
        }
    });
    
    return options;
}

