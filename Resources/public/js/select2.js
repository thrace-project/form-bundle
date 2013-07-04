/**
 * Initialization of jquery select2 widget
 * 
 * @author Nikolay Georgiev
 * @version 1.0
 */
jQuery(document).ready(function(){
    
    //Searching for select2 elements
    jQuery('.thrace-select2').each(function(key, value){
        var options = jQuery(this).data('options'); 
        var id = options._id;
        delete options._id;
        
        var firstOpt = jQuery('#' + id + ' option').eq(0); 
        
        if(firstOpt.text() === options.placeholder){
            firstOpt.text(''); 
            firstOpt.attr('disabled', false);
        }
        
        
        if(options.ajax != undefined){
        	
            options.initSelection = function (element, callback) {
                if(options.multiple === true){
                    var data = [];
                    jQuery(element.val().split(",")).each(function () {
                        data.push({id: this, text: this});
                    });
                } else {
                    var data = {id: element.val(), text: element.val()};
                }

                callback(data);
            };
        }
        
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

        jQuery('#' + id).select2(options);
    });
    
    // Searching for select2-dependent elements
    jQuery('.thrace-select2-dependent').each(function(key, value){
    	var options = jQuery(this).data('options'); 
    	
    	var firstEl = jQuery('#' + options.id + '_' + options.first_name);
    	var secondEl = jQuery('#' + options.id + '_' + options.second_name);   
    	
    	if(firstEl.val() != ''){
            buildSelectOptions(secondEl, options.dependent_source, firstEl.val(), options.multiple, options.dependent_value);
    	}
    	
    	firstEl.on('change', function(event){
            if(event.val == ''){
                if(options.multiple === false){
                    secondEl.html('<option></option>');
                } 
            
                secondEl.select2('val', null);

            } else {
                buildSelectOptions(secondEl, options.dependent_source, event.val, options.multiple, null);   			
            }

    	});
    });
});

function buildSelectOptions(element, url, term, multiple, dependent_value)
{
    jQuery.ajax({
        type: "GET",
        url: url,
        data: { term: term }
    }).done(function(response) {
        element.html(createSelectOptions(response, multiple));
    }).success(function(){
        element.select2('val', dependent_value);	
    });	
}

function createSelectOptions(data, multiple)
{
    var html = '';
    if(multiple === false){
        html += '<option></option>';
    }
    jQuery.each(data, function(){
        html += '<option value="'+ this.id +'">'+  this.text +'</option>';
    });

    return html;
}


