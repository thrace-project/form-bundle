/**
 * Initialization of jquery tinymce
 * 
 * @author Nikolay Georgiev
 * @version 1.0
 */
jQuery(document).ready(function(){
    // Searching for tinymce elements
    jQuery('.thrace-tinymce').each(function(key, value){  
        var options = jQuery(this).data('options'); 
        var element = jQuery('#' + options.id);
        tinymce.baseURL = "/plugins/tinymce/js/tinymce";
        var defaults = new Object();
        defaults.selector = '#' + options.id;
        defaults.theme = options.theme;
        defaults.skin = options.skin;
        defaults.width = options.width;
        defaults.height = options.height;
        defaults.readonly = options.readOnly;
        defaults.plugins = [
            "advlist autolink lists link image charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars code fullscreen",
            "insertdatetime media nonbreaking save table contextmenu directionality",
            "emoticons template paste textcolor"
        ];
        defaults.toolbar1 = "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image";
        defaults.toolbar2 = "print preview media | forecolor backcolor";
        defaults.content_css = options.content_css ? options.base_url + options.content_css : null;
        defaults.relative_urls = false;
        defaults.convert_urls = true;  
        defaults.language = options.lang;
        defaults.image_advtab = true;
        
        delete options.id;
        
        var configs = jQuery.extend(options, defaults); 
        
        tinymce.init(configs);
    });
 
});