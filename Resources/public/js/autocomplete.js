/**
 * Initialization of jquery autocomplete
 * 
 * @author Nikolay Georgiev
 * @version 1.0
 */
jQuery(document).ready(function(){
    
	// building categories
    jQuery.widget( "custom.catcomplete", jQuery.ui.autocomplete, {
    	_renderMenu: function( ul, items ) {
            var that = this,
            currentCategory = "";
            jQuery.each( items, function( index, item ) {
                if ( item.category != currentCategory ) {
                    ul.append( "<li class='ui-autocomplete-category'>" + item.category + "</li>" );
                    currentCategory = item.category;
                }
                that._renderItemData( ul, item );
            });
        }
    });
    
    //Searching for autocomplete elements
    jQuery('.thrace-autocomplete').each(function(key, value){
        var options = jQuery(this).data('options'); 
        var el = jQuery('#' + options.id);
        
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

        if(options.use_categories){
            el.catcomplete(options);
        } else {
            el.autocomplete(options);
        }
    });
}); 


