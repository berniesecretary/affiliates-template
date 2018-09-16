/**
 * tt_editor.js 1.0.0
 * TT edidor uses this file to initailze all the setting value 
 * @author steemtemplates
 * GPL Licensed
 */

	var test;
		
			jQuery(document).ready(function ($) {
				
			$('#myGrid').gridEditor({
					 new_row_layouts: [[12], [6,6], [4,4,4], [3,3,3,3], [8,4], [4,8]],	
					
				});
			$("#publish").click(function (event) {
			  	 	
			  	var currentTab = window.localStorage.getItem('activeTab');
				if(currentTab == '#tt_editor_tab2')
				{
			         var canvasContent = $('#myGrid').gridEditor('getHtml');
			         $('<textarea>').attr({
						    type: 'hidden',
						    id: 'content',
						    name: 'content',
						    class: 'wp-editor-area',
						    value: canvasContent,
						}).appendTo('#post');
				}
			     	
			        return;
			    });
			
    
           $('#tt_editor_tabs.nav-tabs li a[data-toggle="tab"]').on('click', function(e) {
           	
          var answer=confirm('Switching tabs will lose your content. Please either use default editor or custom editor.');

		    if (answer === true)
		     {
		      $(this).tab('show')
		     }
		     else 
		     {
		     return false;
		     }
    	 
    	   var activeTab = window.localStorage.getItem('activeTab');
    	   		   window.localStorage.setItem('activeTab', $(e.target).attr('href'));
       
          });
           
           var activeTab = window.localStorage.getItem('activeTab');
    
    
    	    if (activeTab)
    	     {
        		$('#tt_editor_tabs.nav-tabs li a[href="' + activeTab + '"]').tab('show');
    		 }
    		 
    		jQuery("#contextual-help-wrap").removeClass("hidden").addClass("tt_hide");
    		jQuery("#screen-options-wrap").removeClass("hidden").addClass("tt_hide");
});