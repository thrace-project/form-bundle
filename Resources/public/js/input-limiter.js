/**
 * Initialization of input limiter widget
 * 
 * @author Nikolay Georgiev
 * @version 1.0
 */
jQuery(document).ready(function(){
    
    // Searching for input limiter elements
    jQuery('.thrace-input-limiter').each(function(key, value){  
        var options = evaluateOptions(jQuery(this).data('options'));
        jQuery('#' + options.id).inputlimiter(options);
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