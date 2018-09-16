	 <?php

/**
 * Content Import file is parse and process the Xml data from the content.xml file.
 * Also Site title and slogan are imported from the xml file.
 *
 * @package steemtemplates
 */
 
 /* steemtemplates_Parse_Content class is used to parse the data from content.xml file. After parsing xml data is converted to different arrays
    for examples pages after parsing store data in $all_pages array, menu data after parsing cconverted to $menu_info,
    sidebar data after parsing stroed into $all_sidebars array, contactform data after parsing stored into $contactus_info.*/
class steemtemplates_Parse_Content
{

    private $xml_content;

    function __construct($path)
    {
        $this->xml_content = simplexml_load_file($path);
        if (!$this->xml_content) {
            die("Unable to Import content");
        }
    }
    
    // get the site title from xml file
    public function get_site_title()
    {
        if (!isset($this->xml_content->sitetitle)) {
            return false;
        }
        $site_title = (string)$this->xml_content->sitetitle;       
        return $site_title;
    }
    
    // get the site slogan from xml file
    public function get_site_slogan()
    {
        if (!isset($this->xml_content->siteslogan)) {
            return false;
        }
        $site_slogan = (string)$this->xml_content->siteslogan;       
        return $site_slogan;
    }
    
     // get the blog page names
    public function get_blog_page_name(){
		if (!isset($this->xml_content->post_page_name)) {
			return false;
		}
		$tt_blog_page_name = (string)$this->xml_content->post_page_name;       
        return $tt_blog_page_name;
	}

    // get the pages from xml file
    public function get_pages_data()
    {
        if (!isset($this->xml_content->pages)
            || !isset($this->xml_content->pages->page)
        ) {
            return false;
        }

        $all_pages = array();
        foreach ($this->xml_content->pages->page as $page_node) {
            $this->parse_all_pages($page_node, $all_pages);
        }
        return $all_pages;
    }

    // get the menu from xml file 

    public function get_menu_data()
    {
        if (!isset($this->xml_content->menu)
            || !isset($this->xml_content->menu->menu_item)
        ) {
            return false;
        }
        $menu_info = array();
        foreach ($this->xml_content->menu->menu_item as $menu_item) {
            $this->parse_menu($menu_item, $menu_info);
        }
        return $menu_info;

    }

    // get the sidebar content from the xml file

    public function get_sidebar_data()
    {
        if (!isset($this->xml_content->sidebars)
            || !isset($this->xml_content->sidebars->sidebar)
        ) {
            return false;
        }

        $all_sidebars = array();
        foreach ($this->xml_content->sidebars->sidebar as $sidebar_node) {
            $all_blocks = array();
            $this->parse_all_blocks($sidebar_node, $all_blocks);
            $all_sidebars[] = array(
                'name' => (string)$sidebar_node->attributes()->name,
                'blocks' => $all_blocks
            );
        }
        return $all_sidebars;
    }
    
     // get the menu from xml file 

     // get the menu from xml file 

    public function get_contactusform_data($contact_form)
    {
        $contactus_info = array();
        $i =  0;
        
        	$i = $i+1;
        
        if (!isset($contact_form->ListViewItem))
        {
            return false;
        }
        
        $contactus = array();
       foreach ($contact_form->ListViewItem as $item) {
        	$item_name = preg_replace('/\s+/', '', $item);
        	/*if("Email" == (string)$item_name)
        	continue;*/
        	
            $this->parse_items($item_name, $item, $contactus);
        }
       return $contactus;

    }
    
     private function parse_items($item_name ,$item, &$contactus_info)
     {
       	  $item_id = 'ttr_'.$item_name;
    	  $item_req = $item_id.'req';
    	  $req = (string)$item->attributes()->Tag;
    	  $contentstring = (string)$item->attributes()->ContentStringFormat;
    	  $hidden = (string)$item->attributes()->IsTabStop;
    	  $form_item = null;
        if($req == "Mandate"){
				  $form_item = array(
				  "$item_id" => (string)$item,
				  "item_format" => $contentstring,
				  "$item_req" => 'on',
				  "is_hidden" => $hidden );
			  }
			  else{
				  $form_item = array(
				  "$item_id" => (string)$item,
				  "item_format" => $contentstring,
				  "$item_req" => 'off',
				  "is_hidden" => $hidden);
			  }
          $contactus_info[] = $form_item;
    }


    // Parse the pages from xml file

    private function parse_all_pages($page_node, &$all_pages)
    {
        $page = array(
            'meta_ID' => (string)$page_node->meta_ID,
            'name' => (string)$page_node->page_name,
            'template_name'=> (string)$page_node->page_template_name,
            'title' => (string)$page_node->page_title,
            'header_id' => (string)$page_node->page_header_id,
            'status' => (string)$page_node->page_status,
             'visibility' => (string)$page_node->page_title_visibility,
            'content' => (string)$page_node->page_content,
            'contact_forms' => $page_node->contactforms,
        );

        $all_pages[] = $page;

    }

    // Pares the menu from the xml file

    private function parse_menu($menu_item, &$menu_info)
    {
        $menu_item_info = array(
            'title' => (string)$menu_item->menu_item_title,
            'path' => (string)$menu_item->menu_item_path,
            'parent' => (string)$menu_item->menu_item_parent,
            'url' => (string)$menu_item->menu_item_url,
            'slug' => (string)$menu_item->menu_item_slug
        );

        $menu_info[] = $menu_item_info;

    }

    // parse the sidebar blocks from xml file

    private function parse_all_blocks($blocks_node, &$all_blocks)
    {
        if (!isset($blocks_node)) {
            return;
        }

        $widget_nodes = $blocks_node->xpath('./*[self::block]');
        $result = array();
        foreach ($widget_nodes as $node) {
            $block = array();
            $block['type'] = (string)$node->attributes()->type;
            $block['name'] = (string)$node->attributes()->name;
            $block['title'] = (string)$node->attributes()->title;
            $block['tt_blockID'] = (string)$node->attributes()->tt_blockID;
            if (isset($node->content)) {
                $block['content'] = (string)$node->content;
            }
            if (isset($node->widget_pages->widget_page)) {
                $page_list = array();
                foreach ($node->widget_pages->widget_page as $pages) {
                    $page_list[] = (string)$pages;
                }
                $block['show_on_page'] = $page_list;
            }
            $result[] = $block;
        }
        $all_blocks = array_merge($all_blocks, $result);
    }
}


/* steemtemplates_Import_Content class is used to process the parsed data. start_import() method is used to save the data into
 the database, and if the data is successfully saved into the database then it will reture the true, else return false. */
class steemtemplates_Import_Content
{
//Theme_Content_Import

    public $uploads;
    private $page_list , $slug_list = array();
    private $parser;

    public function start_import()
    {
    	global $tt_blog_page_title;
    	$success = true;
        $this->uploads = wp_upload_dir();
        $this->parser = new steemtemplates_Parse_Content(get_template_directory() . '/content/content.xml');
        // parses content.xml
        $pages_info = $this->parser->get_pages_data();
        $menu_info = $this->parser->get_menu_data();
        $sidebars_info = $this->parser->get_sidebar_data();
        $images = get_template_directory() . "/content/images";
        $title = $this->parser->get_site_title();
        $slogan = $this->parser->get_site_slogan();        	
        $tt_blog_page_title = $this->parser->get_blog_page_name();


        // if Images exists in content uploads it to the upload directory
        if (file_exists($images)) {
           $success = $success && $this->upload_images();
        }

        // if pages_info array is not empty start processing Pages
        if ($pages_info) {
            $success = $success && $this->insert_pages($pages_info);
        }

        // if menu_info array is not empty strat processing menu
        if ($menu_info) {
            $success = $success && $this->insert_menu($menu_info);
        }

        // if sidebar_info array is not empty start processing Sidebar blocks
        if ($sidebars_info) {
            $success = $success && $this->insert_sidebars($sidebars_info);
        }
        
         // if contactus_info array is not empty start processing Contact us form
        if ($contactus_info) {
            foreach($contactus_info as $num => $con)
        	{
        		foreach($con as $numm => $con_info)
        		{
            		$success = $success && $this->upadate_contactus_form($con_info);
				}
			}
        } 
        
        // if title set from steemtemplates , update it
        if ($title) {
           update_option('blogname', $title);
        }
        
        // if slogan set from steemtemplates , update it
        if ($slogan) {
            update_option('blogdescription', $slogan);
        }
        
         return $success;
        
    }
    
    // Managed tag array work
    private function save_contact_form($contact_form)
	{		
		$i =  100;
		$j = 0;
		$mail_arr = array();
		foreach($contact_form as $con_info)
		{	
			$i = $i+1;	
			$j += 1;
			$properties[] = '<div class="form-group"> ';
			foreach($con_info as $key => $value)
			{
			if ($key != 'item_format')
			{
				if ($value != 'on' && $value != 'off' && $value != 'True' && $value != 'False')
				{
					if($con_info['is_hidden'] == 'True'){
							$properties[] = '<label class="col-sm-4 control-label" hidden> ';
						}else{
							$properties[] = '<label class="col-sm-4 control-label"> ';
						}
					
					$properties[] = $value;
				}
				
				if(strpos($key,'req')==true && $value == 'on') 
				{
					$properties[] = ' (required) ';
					$properties[] = '</label> ';
					$properties[] = '<div class="col-sm-8"> ';
					if($con_info['item_format'] == "Email")
					{
					$properties[] = '[email* text-'.$i.' class:form-control ] ';
					}
					else
					{
						if($con_info['is_hidden'] == 'True'){
							$properties[] = '[hidden text text-'.$i.' class:form-control ] ';
						}else{
							$properties[] = '[text* text-'.$i.' class:form-control ] ';
						}
					
					}
					$mailtag = 'text-'.$i;
				}	
				elseif(strpos($key,'req')==true && $value == 'off')			
				{
					$properties[] = '</label> ';
					$properties[] = '<div class="col-sm-8"> ';
					if($con_info['item_format'] == "Email")
					{
					$properties[] = '[email* text-'.$i.' class:form-control ] ';
					}
					else
					{
					if($con_info['is_hidden'] == 'True'){
							$properties[] = '[hidden text text-'.$i.' class:form-control ] ';
						}else{
							$properties[] = '[text text-'.$i.' class:form-control ] ';
						}
					}
					if($con_info['is_hidden'] == 'True'){
							$mailtag = 'text';
						}else{
							$mailtag = 'text-'.$i;
						}
				}
				}
				if($mailtag){
					$mail_arr[$j] =  $mailtag;
					$mailtag = '';
					//$j++;
				}
				
			}
			$properties[] = '</div></div>';
			$properties[] = "\n";
		}
		
		$properties[] = '<div class="form-group"><label class="col-sm-4 control-label"> Message </label>';
		$properties[] = '<div class="col-sm-8"> [textarea* your-message class:form-control 40x4] </div></div>';
		$properties[] = "\n";
		
		$properties[] = '<div class="form-group"><label class="col-sm-4 control-label"> File </label>';
		$properties[] = '<div class="col-sm-8"><label class="contact_file btn-file"> [file your-file] Browse</label><span id="upload-file" class="filename"> No File Selected </span></div></div>';
		$properties[] = "\n";
		
		$properties[] = '<div class="form-group"><div class="col-sm-8 col-sm-offset-4">';
		$properties[] = '[submit id:submitform "Send Message"]';
		$properties[] = '</div></div>';
		
		$post_content = implode( $properties );
	    $contactform_arr = get_option('contact_form');
			$adminemail = $contactform_arr['0']['ttr_email'];
			if($adminemail)
			{
				$admin_email = $adminemail;
			}
			else
			{
				$admin_email = get_option('admin_email');
			}		
				
		// To set form tags		
		$post_mail = array(
			'subject' => sprintf(
				_x( '%1$s "%2$s"', 'mail subject', 'contact-form-7' ),
				get_bloginfo( 'name' ), '['.$mail_arr[3].']' ),
			'sender' => sprintf( '['.$mail_arr[1].'] <%s>', '['.$mail_arr[2].']' ),
			'body' =>
				sprintf( __( 'From: %s', 'contact-form-7' ),
					'['.$mail_arr[1].'] <['.$mail_arr[2].']>' ) . "\n"
				. sprintf( __( 'Subject: %s', 'contact-form-7' ),
					'['.$mail_arr[3].']' ) . "\n\n"
				. __( 'Message Body:', 'contact-form-7' )
					. "\n" . '[your-message]' . "\n\n"
				. '-- ' . "\n"
				. sprintf( __( 'This e-mail was sent from a contact form on %1$s (%2$s)',
					'contact-form-7' ), get_bloginfo( 'name' ), get_bloginfo( 'url' ) ),
			'recipient' => $admin_email,
			'additional_headers' => 'Reply-To: ['.$mail_arr[2].']',
			'attachments' => '[your-file]',
			'use_html' => 0,
			'exclude_blank' => 0,
		);

		
			$page_attributes =  array(
	                'post_type' => 'wpcf7_contact_form',
	                'post_name' => 'test_form',
	                'post_title' => 'Test Form',
	                'post_content' => $post_content,
	                'post_status' => 'publish'
	             );
			$pid = wp_insert_post( $page_attributes );
			$this->pid = $pid;
	
			if ( $pid ) 
			{		
			update_post_meta( $pid, '_form' , $post_content );	
			update_post_meta( $pid, '_mail' , $post_mail );
			}	

			return $pid;
}

    private function insert_pages($pages_info)
    {
    	global $tt_blog_page_title;
    	$result = true;
        $menu_order = 0;
        foreach ($pages_info as $num => $page) {
            $content = '';
            $inserted = false;
            if(array_key_exists('content', $page)){
					    $content = $this->set_image_src($page['content']);
					    }
					    
			$contact_forms = $page['contact_forms'];		
	        			
	        	foreach($contact_forms as $contact_info)		
	        	{		
	        	foreach($contact_info as $contact_form)
	        	{
	        	$contact_form_object = $this->parser->get_contactusform_data($contact_form);		
	        	if(!$contact_form_object)return;		
	        	$con_id = $contact_form['id'];   	       			
	        				
	        	$contact_form_id = $this->save_contact_form($contact_form_object); 		
	        	        			
	        	$content = str_replace($con_id, $contact_form_id, $content);		
	        	}
				}	        	
	        		
			$template_file_name = "page-templates/".$page['template_name'] . "_page.php";
            $meta_ID = $page['meta_ID'];
            $meta_class = $page['name'];
            //$meta_class = $page['title'];
            $id = $this->get_post_id('tt_pageID', $meta_ID);

            if (!empty($id)) {
                $page_attributes = array(
                    'ID' => $id,
                    'post_type' => 'page',
                    'post_name' => $page['name'],
                    'post_title' => $page['title'],
                    'page_title_visibility' => $page['visibility'],
                    'post_content' => $content,
                    'post_status' => $page['status'],
                    'menu_order' => ++$menu_order,
                );
                $post_id = wp_update_post($page_attributes);
                $vis = $page['visibility'];
                if ($post_id != 0){
                	 if (strtolower($page['header_id']) == "home"  ) {
					    update_option('page_on_front', $post_id);
			        	update_option('show_on_front', 'page');
		        	}
					update_post_meta($post_id, 'tt_pageID', $meta_ID);
                	update_post_meta($post_id, 'ttr_page_title_checkbox', $vis);
                	update_post_meta($post_id, '_wp_page_template', $template_file_name);
                	$inserted = true;
                }
                $id = null;
            } else {
                $page_attributes = array(
                    'post_type' => 'page',
                    'post_name' => $page['name'],
                    'post_title' => $page['title'],
                    'post_content' => $content,
                    'post_status' => $page['status'],
                    'menu_order' => ++$menu_order,
                );
                $post_id = wp_insert_post($page_attributes);
                if ($post_id != 0){
					 if (strtolower($page['header_id']) == "home" ) {
					    update_option('page_on_front', $post_id);
			        	update_option('show_on_front', 'page');
		        	}
                    add_post_meta($post_id, 'tt_pageID', $meta_ID, false);
	                add_post_meta($post_id, 'ttr_page_title_checkbox', $vis, false); 
	                add_post_meta($post_id, '_wp_page_template', $template_file_name);
	                $inserted = true;
	               }
                $id = null;
            }
            $this->page_list[$meta_class] = 'page-' . $post_id;
        	$this->slug_list[$meta_class] = $this->get_the_page_slug($post_id) ;
        	$result = $result && $inserted;
        }
        
        // Set the blog page
        $blog_title = get_the_title( get_option('page_for_posts', true) );
      	$blog = get_page_by_title($blog_title);
        
        if (!empty($blog)) {
        	wp_delete_post( $blog->ID, true );
        	delete_post_meta($blog->ID, 'tt_pageID', 'tt_page0');
        	delete_post_meta($blog->ID, 'tt_pageClass', $blog_title);
        	
        }
            $page_attributes = array(
                'post_type' => 'page',
                'post_name' => $tt_blog_page_title,
                'post_title' => 'Blog', 
                'post_content' => '',
                'post_status' => 'publish'
            );
            $blog_id = wp_insert_post($page_attributes);
            add_post_meta($blog_id, 'tt_pageID', 'tt_page0', false);
            add_post_meta($blog_id, 'tt_pageClass', $tt_blog_page_title, false);
            update_option('page_for_posts', $blog_id);
            
       return $result;
    }
    
    
function tt_img_src($match)  {
	$uploads =  wp_upload_dir();
            list($str, $src_attr, $quote, $filename, $png) = $match;
            return $src_attr . $quote . $uploads['url'] . '/' . $png . $quote;
 }

function tt_link_src($match) {
    		list($str, $href, $quote, $fun, $pagename) = $match;
            return $href . $quote . home_url( '/'. strtolower($pagename)) . $quote;
 }

    // Replaces the Img sources according to your 
    private function set_image_src($post)
    {
    	  $that = $this;
        $str = '<?php echo $theme_path_content; ?>';
        $post = str_replace($str, '', $post);
        $post = preg_replace_callback('/(src=)([\'"])([\/\\\]?images[\/\\\]?)(.*?)\2()/', array($this,'tt_img_src'), $post);
        
        $post = preg_replace_callback('/(HREF=)([\'"])([\/\\\]?[\'<][\'?]php echo get_permalink[\'(] get_page_by_path[\'(][\'"](.*?)[\'"][\')]\s[\')][\';][\'?][\'>][\'"][\/\\\]?)/', array($this,'tt_link_src'), $post);
        return $post;
      }
    
    // get the post ID of the page to check post already exist into the databse.
    private function get_post_id($key, $value)
    {
        global $wpdb;

        $sql = $wpdb->prepare("SELECT * FROM " . $wpdb->postmeta . " WHERE meta_key = %s AND meta_value = %s", $key, $value);

        $meta = $wpdb->get_results($sql);

        if (is_array($meta) && !empty($meta) && isset($meta[0])) {
            $meta = $meta[0];
        }
        if (is_object($meta)) {
            return $meta->post_id;
        } else {
            return false;
        }
    }
    
    // to get the page_slug of the page from the datbase.
    private function get_the_page_slug($id) 
    {
		$post_data = get_post($id, ARRAY_A);
		$slug = $post_data['post_name'];
		return $slug; 
	}
	
	// upload the images to wordpress directory
    private function upload_images()
    {
    	$result = true;
        $tt_images_dir = get_template_directory() . '/content/images/';
        $tt_content_images = opendir($tt_images_dir);
        while ($tt_read_image = readdir($tt_content_images)) {
            if ($tt_read_image != '.' && $tt_read_image != '..') {
                if (!file_exists($tt_read_image)) {
                  $result = $result && copy($tt_images_dir . $tt_read_image, $this->uploads['path'] . '/' . $tt_read_image);
                }
            }
        }
         return $result;
    }

    // generate the menu named Template_Menu and set it as default when theme is activated 
    private function insert_menu($menu_info)
    {
    	$result = true;
        $menuname = 'Template_Menu';
        $ttmenulocation = 'primary';
        $menu_exists = wp_get_nav_menu_object($menuname);
       	wp_delete_nav_menu($menuname);
        $menu_id = wp_create_nav_menu($menuname);
        $this->custom_menuID = $menu_id;
        $new_menu_obj = array();
        $nav_items_to_add = $menu_info;

         foreach ($nav_items_to_add as $slug => $nav_item) {
            $item = strtolower($nav_item['title']);
            $new_menu_obj[$item] = array();
            $nav_parent = $nav_item['parent'];
            $nav_parent_id = 0;
            if (array_key_exists('parent', $nav_item) && $nav_parent != "")
            {	
              $new_menu_obj[$item]['parent'] = $nav_item['parent'];
				      $nav_parent_id = $new_menu_obj[$nav_item['parent']]['id'];
			      }   
            $url = $nav_item['url'];
            $itemtype = array();
			$WooCommerce = false;
            		            
            if ($url == null && empty($url)) {
            	 $object_id = get_page_by_path($nav_item['title'])->ID;
            	if (array_key_exists($nav_item['slug'], $this->slug_list))
            	{
            		$slug = $this->slug_list[$nav_item['slug']];
            		$object_id =  get_page_by_path($slug)->ID;
            		} 
            		
            		if ($WooCommerce)
            		{
            		if($nav_item['title'] == 'WpShop')
            		{
            		$nav_item['title'] = 'Shop';
            		$object_id = get_page_by_path($nav_item['title'])->ID;
            		}
            		}
            		
            		if($nav_item['slug'] == 'blog-wp')
            		{
            		$object_id = get_page_by_path($nav_item['title'])->ID;
            		$nav_item['title'] = 'Blog';
            		} 

                $itemtype = array(
                    'menu-item-title' => $nav_item['title'],
                    'menu-item-object' => 'page',
                    'menu-item-parent-id' => $nav_parent_id,
                    'menu-item-object-id' => $object_id,
                    'menu-item-type' => 'post_type',
                    'menu-item-status' => 'publish');
            } else {
                $itemtype = array(
                    'menu-item-title' => $nav_item['title'],
                    'menu-item-object' => 'custom',
                   	'menu-item-parent-id' => $nav_parent_id,
                    'menu-item-object-id' => get_page_by_path($nav_item['title'])->ID,
                    'menu-item-type' => 'custom',
                    'menu-item-status' => 'publish',
                    'menu-item-url' => $url);
            }
            $wperror = $menu_item = wp_update_nav_menu_item($menu_id, 0, $itemtype);
            if ( is_wp_error( $menu_item ) ) {
			   $wperror = false;
			}
			else{
				$wperror = true;
				$new_menu_obj[$item]['id'] = $menu_item;
			}
            
            $result = $result && $wperror;
        }
       
        if (!has_nav_menu($ttmenulocation)) {
            $locations = get_theme_mod('nav_menu_locations');
            $locations[$ttmenulocation] = $menu_id;
            set_theme_mod('nav_menu_locations', $locations);
        }
        return $result;
    }

	// set the widgets to the respective sidebar
    private function insert_sidebars($sidebars_info)
    {
    	$result = true;
        foreach ($sidebars_info as $sidebar) {
            foreach ($sidebar['blocks'] as $block) {
                $listofpages = $block['show_on_page'];
                 $content = '';
                if(array_key_exists('content', $block)){
					        $content = $this->set_image_src($block['content']);
				        }
                $widget_added = $this->add_widget($sidebar['name'], $block['type'], $block['tt_blockID']);
                $update_added = $this->update_widget($widget_added[0], $block['title'], $content, $block['tt_blockID'], $listofpages);
                $result = $result && $widget_added[1] && $update_added;
            }
        }
        return $result;
    }

    private function add_widget($sidebar, $blocktype, $tt_blockID)
    {
    	$return_arr = array();

        $wp_sidebars = get_option('sidebars_widgets');

        if (!isset($wp_sidebars[$sidebar]) && !empty($wp_sidebars[$sidebar])) {
            return false;
        }

        if ($blocktype == 'custom_menu') {
            $type = 'nav_menu';
        } else {
            $type = 'text';
        }

        $wp_widget = get_option('widget_' . $type);
        $wp_widget = $wp_widget ? $wp_widget : array();

        // new widget id is always unique
        $new_widget_id = 0;
        
       foreach ($wp_widget as $widget_id => $widget) {

            if ($tt_blockID === $wp_widget[$widget_id]['tt_blockID'])
                unset($wp_widget[$widget_id]);

            if (is_int($widget_id))
                $new_widget_id = max($new_widget_id, $widget_id);
        }

        $new_widget_id++;
        $new_widget_name = $type . '-' . $new_widget_id;

        // gets widgets from the selected sidebar
        $wp_sidebar_widgets = $wp_sidebars[$sidebar];

        $wp_sidebar_widgets[] = $new_widget_name;

        // puts new sidebar widgets in the list of sidebars
        $wp_sidebars[$sidebar] = $wp_sidebar_widgets;

        update_option('sidebars_widgets', $wp_sidebars);

        // creates new widget
        $wp_widget[$new_widget_id] = array();

        if ($type == 'nav_menu') {
            $wp_widget[$new_widget_id]['source'] = 'Pages';
            $wp_widget[$new_widget_id]['nav_menu'] = 0;
        } else {
            $wp_widget[$new_widget_id]['text'] = '';
            $wp_widget[$new_widget_id]['filter'] = false;
        }

        $wp_widget[$new_widget_id]['tt_blockID'] = '';
        $wp_widget[$new_widget_id]['title'] = '';

        if (!isset($wp_widget['_multiwidget'])) {
            $wp_widget['_multiwidget'] = 1;
        }
		$return_arr[0] = $new_widget_name;
        $return_arr[1] = update_option('widget_' . $type, $wp_widget);
        
        return $return_arr;
    }

	// Set the value to the widgets 
    private function update_widget($widget_id, $title, $content = null, $tt_blockID, $listofpages)
    {
        if (!preg_match('/^(.*[^-])-([0-9]+)$/', $widget_id, $matches) || !isset($matches[1]) || !isset($matches[2])) {
            return false;
        }

        $type = $matches[1];
        $id = $matches[2];

        $wp_widget = get_option('widget_' . $type);

        if (!$wp_widget || !isset($wp_widget[$id])) {
            return false;
        }

        if (isset($title) && (strlen($title) > 0)) {
            $wp_widget[$id]['title'] = $title;
        }

        if (isset($tt_blockID) && (strlen($tt_blockID) > 0)) {
            $wp_widget[$id]['tt_blockID'] = $tt_blockID;
        }

        if (isset($content) && (strlen($content) > 0) && ($type == 'text')) {
            $wp_widget[$id]['text'] = $content;
        }
        if ($type == 'nav_menu') {
            $wp_widget[$id]['source'] = 'Custom Menu';
            $wp_widget[$id]['nav_menu'] = $this->custom_menuID;
            $wp_widget[$id]['style'] = 'default';
            $wp_widget[$id]['menustyle'] = 'vmenu';
            $wp_widget[$id]['alignment'] = 'default';
        }

        // added to hide the widget on the particular page
       foreach ($this->slug_list as $num => $slug_name) {
            if (in_array($slug_name, $listofpages)) {
                // page exist in pages_info array
                continue;
            }
            else {
              if($num == "Home"){
                 $wp_widget[$id]['page-front'] = 1;
              }
              $pageid = $this->page_list[$num];
                 $wp_widget[$id][$pageid] = 1;
              }
               $wp_widget[$id]['page-home'] = 1;
        }

         $result = update_option('widget_' . $type, $wp_widget);
         return $result;
    }
    
    // update the fields of the contact form according to current theme
     private function upadate_contactus_form($contactus_info){
     	$get_contact_array = get_option( 'contact_form');
    	$result = array_merge($get_contact_array, $contactus_info);
		$done = update_option( 'contact_form', $result );
		return $done;
		
	}
}

// instance created and start the importing process.
function steemtemplates_import_start()
{
    $tt_content_importer = new steemtemplates_Import_Content();
    $result = $tt_content_importer->start_import();
     return $result;
}

?>