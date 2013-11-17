/**
 * Initialization of jquery select2 widget
 * 
 * @author Nikolay Georgiev
 * @version 1.0
 */

//Create namespace
window.ThraceForm = window.ThraceForm || {};

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

ThraceForm.select2 = function (collection){ 
	var collection = (collection == undefined) ? jQuery('.thrace-select2') : collection;
	//Searching for select2 elements
    collection.each(function(key, value){
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
        
        
        
        evaluateFn(options);

        jQuery('#' + id).select2(options);
    });
};

ThraceForm.select2Dependant = function(collection){
	
	var collection = (collection == undefined) ? jQuery('.thrace-select2-dependent') : collection;

    collection.each(function(key, value){
    	var options = jQuery(this).data('options'); 
    	evaluateFn(options);
    	
    	var firstElId = '#' + options.id + '_' + options.first_name;
    	var firstEl = jQuery(firstElId);
    	var secondEl = jQuery('#' + options.id + '_' + options.second_name);   
    	
    	if(firstEl.val() != ''){
            buildSelectOptions(secondEl, options.dependent_source, firstEl.val(), options.multiple, options.dependent_value);
    	}
    	
    	jQuery(document).on('change', firstElId, function(event){
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
};
	
// Init on document ready
jQuery(document).ready(function(){
	ThraceForm.select2();
	ThraceForm.select2Dependant();
});

jQuery(document).on('thrace.form.select2.init', function(event, collection){
	ThraceForm.select2(collection);
});

jQuery(document).on('thrace.form.select2_dependant.init', function(event, collection){
	ThraceForm.select2Dependant(collection);
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


