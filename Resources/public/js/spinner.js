/**
 * Initialization of jquery spinner widget
 * 
 * @author Nikolay Georgiev
 * @version 1.0
 */
var Spinner = function(options){
	this.options = evaluateOptions(options);
	this.el = jQuery('#' + options.id);
	this.initialize = function(){
		this.el.spinner(this.options);
	};        
};

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
	
jQuery(document).ready(function(){
	
    //Searching for spinner widgets
    jQuery('.thrace-spinner').each(function(key, value){
    	new Spinner(jQuery(this).data('options')).initialize();
    });
}); 

