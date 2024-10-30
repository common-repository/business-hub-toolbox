(function() {
     /* Register the buttons */
     tinymce.create('tinymce.plugins.MyButtons', {
          init : function(ed, url) {
               /**
               * Inserts shortcode content
               */
               ed.addButton( 'button_eek', {
                    title : 'Insert shortcode',
                    type: 'menubutton',
                    text: 'Shortcode',
                    menu: [
			                {
			                    text: 'Display Upcoming Events',
			                    onclick : function() {
			                         ed.selection.setContent('[rwsec-display-upcoming-events posts="5"]');
			                    }
			                }
			           ]
                    
               });
          },
          createControl : function(n, cm) {
               return null;
          },
     });
     /* Start the buttons */
     tinymce.PluginManager.add( 'my_button_script', tinymce.plugins.MyButtons );
})();


