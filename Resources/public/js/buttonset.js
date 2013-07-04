/**
 * Initialization of jquery buttonset
 * 
 * @author Nikolay Georgiev
 * @version 1.0
 */
jQuery(document).ready(function(){
    
    //Searching for buttonset elements
    jQuery('.thrace-buttonset').each(function(key, value){
        var options = jQuery(this).data('options');
        
        var evaluateFn = function(options){
            jQuery.each(options, function(k,v){
                if(typeof(v) == 'string' && isNaN(v)){
                    if(v.match('^function')){
                        eval('options.'+ k +' = ' + v);
                    }
                } else if(jQuery.isPlainObject(v) || jQuery.isArray(v)){
                    evaluateFn(v);
                }
            });
        };
        
        evaluateFn(options);
        
        jQuery('#' + options.id + '-buttonset').buttonset(options);
    });
});


