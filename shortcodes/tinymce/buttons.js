/* Curly Button */
(function() {  
    tinymce.create('tinymce.plugins.curly', {  
        init : function(ed, url) { 
            ed.addButton('curly', {  
                title : 'Curly Themes Shortcodes', 
                onclick : function() {
                	curly_show_builder();
                }  
            });  
        },  
        createControl : function(n, cm) {  
            return null;  
        },  
    });  
    tinymce.PluginManager.add('curly', tinymce.plugins.curly);  
})();