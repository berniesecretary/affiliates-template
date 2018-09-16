<?php
/**
 * This file is used to add the static theme-options to the wordpress dashboard tab.
 * @package steemtemplates
 */
 
require_once(get_template_directory() . '/dynamic-options.php');
global $theme_options;
class steemtemplates_Theme_Options extends steemtemplates_Theme_Options_Dynamic
{

    public function __construct()
    {
        parent::__construct();
        $this->get_static_options();
        $this->sections['error'] = __('Error Page', "BlockTradesAffiliatesV1");
        $this->sections['maintenance'] = __('Maintenance', "BlockTradesAffiliatesV1");
        $this->sections['shortcodes'] = __('Shortcode', "BlockTradesAffiliatesV1");
        $this->sections['googlemap'] = __('GoogleMap', "BlockTradesAffiliatesV1");
        $this->sections['contactus'] = __('Contact Us', "BlockTradesAffiliatesV1");
		// $this->sections['seo'] = __('SEO', "BlockTradesAffiliatesV1");
        $this->sections['backuppage'] = __('Backup/Recovery', "BlockTradesAffiliatesV1");
        $this->sections['export_import'] = __('Export/Import', "BlockTradesAffiliatesV1");
        
        add_action('admin_menu', array(&$this, 'add_pages'));
        add_action('admin_init', array(&$this, 'register_settings'));

        if (!get_option('steemtemplates_theme_options')) {
            $this->initialize_settings();
        }

    }

    /**
     * Add options page
     *
     * @since 1.0
     */
    public function add_pages()
    {

        $admin_page = add_theme_page(__('Theme Options', "BlockTradesAffiliatesV1"), __('Theme Options', "BlockTradesAffiliatesV1"), 'manage_options', 'mytheme-options', array(&$this, 'display_page'));
        add_action('admin_print_scripts-' . $admin_page, array(&$this, 'scripts'));
        add_action('admin_print_styles-' . $admin_page, array(&$this, 'styles'));        
        $contactvar=get_option('contact_form',"ttr_test");
    	  if( $contactvar == "ttr_test" ) {
        $adminmail=get_option('admin_email');
        $default=array(0=>array('ttr_email'=>$adminmail),1=>array('ttr_captcha_public_key'=>''),2=>array('ttr_captcha_private_key'=>''),3=>array('ttr_contact_us_error_message'=>'Message was not sent. Try Again.'),4=>array('ttr_contact_us_success_message'=>'Thanks! Your message has been sent.'),5=>array('ttr_name'=>__('Name',"BlockTradesAffiliatesV1") ,'ttr_namereq' => 'on' ), 6=>array('ttr_subject' => __('Subject',"BlockTradesAffiliatesV1") , 'ttr_subjectreq' => 'on'));
        update_option( 'contact_form', $default );
        }
    }

    /**
     * Create settings field
     *
     * @since 1.0
     */
    public function create_setting($args = array())
    {

        $defaults = array(
            'id' => 'default_field',
            'title' => __('Default Field', "BlockTradesAffiliatesV1"),
            'desc' => __('This is a default description.', "BlockTradesAffiliatesV1"),
            'std' => '',
            'type' => 'text',
            'section' => 'general',
            'choices' => array(),
            'pattern' => '',
            'class' => '',
            'onclick' => ''
        );

        extract(wp_parse_args($args, $defaults));

        $field_args = array(
            'type' => $type,
            'id' => $id,
            'desc' => $desc,
            'std' => $std,
            'choices' => $choices,
            'label_for' => $id,
            'pattern' => $pattern,
            'class' => $class,
            'onclick' => $onclick
        );

        if ($type == 'checkbox')
            $this->checkboxes[] = $id;
        if ($type == 'media')
            $this->media[] = $id;
        add_settings_field($id, $title, array($this, 'display_setting'), 'mytheme-options', $section, $field_args);
    }

    /**
     *
     * Display options page
     *
     * @since 1.0
     */
    public function display_page()
    {
        if (get_bloginfo('version') >= 3.4) {
            $themename = wp_get_theme();
        }
		 
       //display URl error message 
        $error = get_settings_errors('steemtemplates_theme_options');
        if(!empty($error))
        {
            echo'<span id="errorMsg">'.settings_errors('steemtemplates_theme_options').'</span>'; 
        }
        elseif (isset($_GET['settings-updated']) && $_GET['settings-updated'] == true)
        {
            echo '<div class="updated fade"><p>' . __('Theme options updated.', "BlockTradesAffiliatesV1") . '</p></div>';
		}
        echo '<div id="admin_container" class="wrap">
	            <div class="icon-option"> </div>
	            <h1>' . __('Theme Options For', "BlockTradesAffiliatesV1") . '&nbsp;' . $themename . '</h1><br/>';

        echo '<form action="options.php" method="post">';
        settings_fields('steemtemplates_theme_options');
        echo '<div class="ui-tabs">
			<ul class="ui-tabs-nav">';

        foreach ($this->sections as $section_slug => $section) {
            echo '<li><a href="#' . $section_slug . '">' . $section . '</a></li>';
        }

        echo '</ul>';
        do_settings_sections($_GET['page']);
		echo '</div>';
		echo '<p class="submit">' .
            get_submit_button(__('Save Options', "BlockTradesAffiliatesV1"), 'button-primary', 'ttr_submit', false). '</p>';			
		echo '</form>';
        echo '</div>';
    }

    /**
     * Description for section
     *
     * @since 1.0
     */
    public function display_menu_section()
    {

        // code
    }
	 public function display_colors_section()
    {
       
    }

    public function display_contactus_section()
    {?>
		
       <div id="content">
                <?php
                $value_contact = get_option('contact_form');
                ?>
                    <table class="table">
                        <tbody>
                        <tr>
                            <td colspan="3"><?php echo(__("To use CONTACT FORM, apply shortcode [contact_us_form]","BlockTradesAffiliatesV1"));?></td>

                        </tr>
                        <tr>
                            <td><?php echo(__('Admin Email Address',"BlockTradesAffiliatesV1"));?></td>
                            <td colspan="2">
                                <input type="email" id="ttr_email" <?php if($value_contact[0]['ttr_email']){ ?> value="<?php print_r($value_contact[0]['ttr_email']); ?>" <?php } else {?> value="<?php print_r(get_option('admin_email')); ?>"<?php } ?> name="ttr_email" />

                            </td>

                        </tr>

                        <!-- Google Captcha -->
                        <tr>
                            <td><?php echo(__('Public Key For Google Captcha',"BlockTradesAffiliatesV1"));?></td>
                            <td colspan="2">
                                <input type="text" id="ttr_captcha_public_key" <?php if($value_contact[1]['ttr_captcha_public_key']){ ?> value="<?php print_r($value_contact[1]['ttr_captcha_public_key']); ?>" <?php }  ?>  name="ttr_captcha_public_key" />

                            </td>

                        </tr>

                        <tr>
                            <td><?php echo(__('Private Key For Google Captcha',"BlockTradesAffiliatesV1"));?></td>
                            <td colspan="2">
                                <input type="text" id="ttr_captcha_private_key" <?php if($value_contact[2]['ttr_captcha_private_key']){ ?> value="<?php print_r($value_contact[2]['ttr_captcha_private_key']); ?>" <?php }  ?>  name="ttr_captcha_private_key" />

                            </td>

                        </tr>

                        <!-- Contact Us Error Message -->
                        <tr>
                            <td><?php echo(__('Error Message',"BlockTradesAffiliatesV1"));?></td>
                            <td colspan="2">
                                <input type="textarea" id="ttr_contact_us_error_message" <?php if($value_contact[3]['ttr_contact_us_error_message']){ ?> value="<?php print_r($value_contact[3]['ttr_contact_us_error_message']); ?>" <?php } else {?> value="<?php echo(__("Message was not sent. Try Again.","BlockTradesAffiliatesV1"));?>"<?php } ?> name="ttr_contact_us_error_message" />

                            </td>

                        </tr>

                        <tr>
                            <td><?php echo(__('Success Message',"BlockTradesAffiliatesV1"));?></td>
                            <td colspan="2">
                                <input type="textarea" id="ttr_contact_us_success_message" <?php if($value_contact[4]['ttr_contact_us_success_message']){ ?> value="<?php print_r($value_contact[4]['ttr_contact_us_success_message']); ?>" <?php } else {?> value="<?php echo(__("Thanks! Your message has been sent.","BlockTradesAffiliatesV1")); ?>"<?php } ?>  name="ttr_contact_us_success_message" />

                            </td>

                        </tr>
                        <tr>
                            <td><?php echo(__('Field Name:',"BlockTradesAffiliatesV1"));?></td>
                           <!-- <td><?php echo(__('Field Type:',"BlockTradesAffiliatesV1"));?></td>-->
                            <td><?php echo(__('Required',"BlockTradesAffiliatesV1"));?></td>
                            <td><?php echo(__('Remove',"BlockTradesAffiliatesV1"));?></td>
                        </tr>

                        <?php if (is_array($value_contact)): ?>

                            <?php foreach($value_contact as $key=>$i)
                            {
                                foreach($value_contact[$key] as $newkey=>$j)
                                {
                                    if($newkey == 'ttr_email' || $newkey == 'ttr_emailreq' || $newkey == 'ttr_captcha_public_key' || $newkey == 'ttr_captcha_public_keyreq' || $newkey == 'ttr_captcha_private_key' || $newkey == 'ttr_captcha_private_keyreq' || $newkey == 'ttr_contact_us_error_message' || $newkey == 'ttr_contact_us_error_messagereq' || $newkey == 'ttr_contact_us_success_message' || $newkey == 'ttr_contact_us_success_messagereq')
                                        continue;
                                    ?>

                                    <?php 	if(strpos($newkey,'req')==false) { ?>

                                    <td><input name="<?php echo $newkey; ?>" id="<?php echo $newkey; ?>" type="<?php echo 'text'; ?>" value="<?php if ( $value_contact[$key][$newkey] != "") { print_r($value_contact[$key][$newkey]); } ?>" /></td>
                                <?php }?>

                                    <?php 	if(strpos($newkey,'req')!==false) { ?>
                                    <td>
                                        <?php if(isset($value_contact[$key][$newkey]) && $value_contact[$key][$newkey] == 'on') { $checked = "checked=\"checked\""; } else { $checked = ""; } ?>

                                        <div class="normal-toggle-button">
                                            <input type="checkbox" id="<?php echo $newkey; ?>"  name="<?php echo $newkey; ?>" <?php echo $checked; ?> />
                                        </div></td>
                                    <?php $url = get_template_directory_uri();?>
                                    <td><input type="image" src="<?php echo($url).'/images/cross.png'; ?>" class="removefield" /></td>
                                    </tr>
                                <?php } ?>

                                <?php }
                            }

                        endif;
                        ?>

                        <tr>
                            <td colspan="4"><input type="button" value="<?php echo(__('Add New Field',"BlockTradesAffiliatesV1"));?>" class="newfield button-secondary" /></td>
                        </tr>

                        </tbody>
                    </table>
				</div>
		
<?php
    }

  /*  public function display_seoenable_section()
    {

        $this->sections['seoenable'] = __('SEO Enable', "steemtemplates");
        $this->sections['seohome'] = __('Home', "steemtemplates");
        $this->sections['seogeneral'] = __('SEO General', "steemtemplates");
        $this->sections['seosocial'] = __('Web/Social', "steemtemplates");
        $this->sections['seositemap'] = __('Sitemap', "steemtemplates");
        $this->sections['seoadvanced'] = __('Advanced', "steemtemplates");

        $tabs = array('seoenable' => __('SEO Enable', 'steemtemplates'), 'seohome' => __('Home', 'steemtemplates'), 'seogeneral' => __('SEO General', 'steemtemplates'), 'seosocial' => __('Web/Social', 'steemtemplates'), 'seositemap' => __('Sitemap', 'steemtemplates'), 'seoadvanced' => __('Advanced', 'steemtemplates'));

        echo '<div id="tabseo" class="ui-tabs">';
        echo '<ul class="ui-tabs-nav">';
        foreach ($tabs as $section_slug => $section)
            echo '<li><a href="#' . $section_slug . '">' . $section . '</a></li>';
        echo '</ul>';
        foreach ($tabs as $section_slug => $section) {
            echo '<h4>' . $section . '</h4>';
            echo '<table class="form-table">';
            do_settings_fields($_GET['page'], $section_slug);
            echo '</table>';

        }
        echo '</div>';

    }*/

    public function display_backuppage_section()
    {

        $this->sections['backupsettings'] = __('Settings', "BlockTradesAffiliatesV1");
        $this->sections['backup'] = __('Backup', "BlockTradesAffiliatesV1");
        $this->sections['restore'] = __('Restore', "BlockTradesAffiliatesV1");
        $tabs = array('backupsettings' => 'Settings', 'backup' => 'Backup', 'restore' => 'Restore');

        echo '<div id="tabbackup" class="ui-tabs">';
        echo '<ul class="ui-tabs-nav">';
        foreach ($tabs as $section_slug => $section)
            echo '<li><a href="#' . $section_slug . '">' . $section . '</a></li>';
        echo '</ul>';
        foreach ($tabs as $section_slug => $section) {
            echo '<h4>' . $section . '</h4>';
            echo '<table class="form-table">';
            do_settings_fields($_GET['page'], $section_slug);
            echo '</table>';
        }
        echo '</div>';

    }
	public function display_export_import_section()
	{
	?>
		<table class="table">
	    	<tbody>        	
	            <tr>
		            <td>
		            <label><?php echo(__('Export theme options','BlockTradesAffiliatesV1'));?></label>             
	            	<input id="export_yes" class="button button-primary" type="button" name="exportt" value="<?php echo(__('Export Theme Option','BlockTradesAffiliatesV1'));?>" />	            	
	                </td>
	            </tr>
	            <tr>
	               <td>	               
	                <label id="select_file"><?php echo(__('Import theme options? ','BlockTradesAffiliatesV1'));?></label>
			       	<input type="file" name="importfile" id="importfile" style="height:auto;">
			       	<input id="import_options_yes" class="button button-primary" type="button" value="<?php echo(__('Import Theme Options','BlockTradesAffiliatesV1'));?>" name="import_options">			       
	                </td>
	            </tr>
			</tbody>
	    </table>
	<?php
	}
	
    /**
     * HTML output for text field
     *
     * @since 1.0
     */
    public function display_setting($args = array())
    {

        extract($args);
        
         $options = array();
       if (!get_option('steemtemplates_theme_options'))
		{
			foreach ($this->settings as $j => $settings) {
				$options[] = $settings;
				}
				
			if (!isset($options[$id]) && $type != 'heading')
            $options[$id] = $std;
            elseif (!isset($options[$id]))
            $options[$id] = 0;
		} 
	  else
		{
			$options = get_option('steemtemplates_theme_options');
			
			if (!isset($options[$id]) && $type != 'checkbox')
            $options[$id] = $std;
            elseif (!isset($options[$id]))
            $options[$id] = 0;
		}
	
        $field_class = '';
        if ($class != '')
            $field_class = ' ' . $class;

        switch ($type) {

            case 'checkbox':
                echo '<div class="normal-toggle-button">';
                echo '<input class="checkbox' . $field_class . 'id="' . $id . '" name="steemtemplates_theme_options[' . $id . ']" value="0" type="hidden"/> ';
                echo '<input class="checkbox' . $field_class . '" type="checkbox" id="' . $id . '" name="steemtemplates_theme_options[' . $id . ']" value="1" ' . checked($options[$id], 1, false) . ' /> ';
                echo '</div>';
                break;

            case 'select':
                echo '<select class="select' . $field_class . '" id="' . $id . '"  name="steemtemplates_theme_options[' . $id . ']">';

                foreach ($choices as $value => $label)
                    echo '<option value="' . esc_attr($label) . '"' . selected($options[$id], $label, false) . '>' . $label . '</option>';

                echo '</select>';

                if ($desc != '')
                    echo '<br /><span class="description">' . $desc . '</span>';

                break;

            case 'radio':
                $i = 0;
                foreach ($choices as $value => $label) {
                    echo '<input class="radio' . $field_class . '" type="radio" name="steemtemplates_theme_options[' . $id . ']" id="' . $id . $i . '" value="' . esc_attr($value) . '" ' . checked($options[$id], $value, false) . '> <label for="' . $id . $i . '">' . $label . '</label>';
                    if ($i < count($options) - 1)
                        echo '<br />';
                    $i++;
                }

                if ($desc != '')
                    echo '<br /><span class="description">' . $desc . '</span>';

                break;

            case 'textarea':
                echo '<textarea class="' . $field_class . '" id="' . $id . '" name="steemtemplates_theme_options[' . $id . ']" placeholder="' . $std . '" rows="5" cols="30">';

				if(get_bloginfo('version') >= '4.3')
				{
					echo format_for_editor($options[$id]);
					
				}
				
				echo '</textarea>';
				
                if ($desc != '')
                    echo '<br /><span class="description">' . $desc . '</span>';

                break;

            case 'password':
                echo '<input class="regular-text' . $field_class . '" type="password" id="' . $id . '" name="steemtemplates_theme_options[' . $id . ']" value="' . esc_attr($options[$id]) . '" />';

                if ($desc != '')
                    echo '<br /><span class="description">' . $desc . '</span>';

                break;

            case 'shortcode':
                echo '<span id="' . $id . '" ><b>' . $std . '</b></span>';

                if ($desc != '')
                    // echo '<br /><br /><span class="description">' . $desc . '</span>';

                    break;

            case 'colorpicker':
                $value = esc_attr($options[$id]);
                
                echo '<input class="colorwell" type="text" id="' . $id . '"name="steemtemplates_theme_options[' . $id . ']" placeholder="' . $std . '" value="' . $value . '" />';
                if ($desc != '')
                    echo '<br /><span class="description">' . $desc . '</span>';

                break;

            case 'media':

                echo '<input class="upload' . $field_class . '" type="text" id="' . $id . '" name="steemtemplates_theme_options[' . $id . ']" placeholder="' . $std . '" value="' . esc_attr($options[$id]) . '" />';
                echo '&nbsp;<input type="button" class="ttrbutton btn" value="' . __('Upload', "BlockTradesAffiliatesV1") . '"/>';
                if ($desc != '')
                    echo '<br /><span class="description">' . $desc . '</span>';

                break;

            case 'button':

                echo '<input class="button-secondary' . $field_class . '" type="button" id="' . $id . '" name="steemtemplates_theme_options[' . $id . ']" value="' . $std . '" onclick="' . $onclick . '"/> ';

                if ($desc != '')
                    echo '<br /><span class="description">' . $desc . '</span>';

                break;

            case 'file':

                echo '<input name="steemtemplates_theme_options[' . $id . ']" id="' . $id . '" type="file" />';

                if ($desc != '')
                    echo '<br /><span class="description">' . $desc . '</span>';

                break;

            /*case 'sitemaplink':
                steemtemplates_create_sitemap();
                echo '<a class="' . $field_class . '" href="../sitemap.xml"> <input class="button-secondary' . $field_class . '" type="button" value="' . esc_attr($options[$id]) . '"/></a>';

                if ($desc != '')
                    echo '<br /><span class="description">' . $desc . '</span>';

                break; */

            case 'text':
            default:
                if ($pattern != '') {
                    echo '<input class="regular-text' . $field_class . '" type="text" id="' . $id . '" name="steemtemplates_theme_options[' . $id . ']" placeholder="' . $std . '" value="' . esc_attr($options[$id]) . '" pattern="' . $pattern . '"/>';
                } else {
                    echo '<input class="regular-text' . $field_class . '" type="text" id="' . $id . '" name="steemtemplates_theme_options[' . $id . ']" placeholder="' . $std . '" value="' . esc_attr($options[$id]) . '"/>';
                }

                if ($desc != '')
                    echo '<br /><span class="description">' . $desc . '</span>';

                break;
        }

    }

    /* Settings and defaults */
    public function get_static_options()
    {

       /* Error page Settings
         ===========================================*/

        $this->settings['ttr_error_message_heading'] = array(
            'title' => __('Heading For Error Message', "BlockTradesAffiliatesV1"),
            'desc' => __('Change Text For Error Message', "BlockTradesAffiliatesV1"),
            'std' => __('This is somewhat embarrassing, isn&rsquo;t it?', "BlockTradesAffiliatesV1"),
            'type' => 'textarea',
            'section' => 'error'
        );
        $this->settings['ttr_error_message_content'] = array(
            'title' => __('Content For Error Message', "BlockTradesAffiliatesV1"),
            'desc' => __('Change text For Error Message', "BlockTradesAffiliatesV1"),
            'std' => __('It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching, or one of the links below, can help.', "BlockTradesAffiliatesV1"),
            'type' => 'textarea',
            'section' => 'error'
        );
        $this->settings['ttr_error_message'] = array(
            'title' => __('Enable Content', "BlockTradesAffiliatesV1"),
            'desc' => __('Hide/Show Error Message Text', "BlockTradesAffiliatesV1"),
            'std' => 1,
            'type' => 'checkbox',
            'section' => 'error'
        );
        $this->settings['ttr_error_search_box'] = array(
            'title' => __('Enable Search', "BlockTradesAffiliatesV1"),
            'desc' => __('Hide/Show Search Box', "BlockTradesAffiliatesV1"),
            'std' => 1,
            'type' => 'checkbox',
            'section' => 'error'
        );
        $this->settings['ttr_error_image'] = array(
            'title' => __('Content Image', "BlockTradesAffiliatesV1"),
            'desc' => __('Choose Error Image', "BlockTradesAffiliatesV1"),
            'std' => '',
            'type' => 'media',
            'section' => 'error'
        );
        $this->settings['ttr_error_image_enable'] = array(
            'title' => __('Enable Image In Content', "BlockTradesAffiliatesV1"),
            'desc' => __('Hide/Show error image', "BlockTradesAffiliatesV1"),
            'std' => 0,
            'type' => 'checkbox',
            'section' => 'error'
        );
        $this->settings['ttr_error_image_height'] = array(
            'title' => __('Content Image Height', "BlockTradesAffiliatesV1"),
            'desc' => __('Height Of The Error Image', "BlockTradesAffiliatesV1"),
            'std' => '',
            'pattern' => '\d+',
            'type' => 'text',
            'section' => 'error'
        );
        $this->settings['ttr_error_image_width'] = array(
            'title' => __('Content Image Width', "BlockTradesAffiliatesV1"),
            'desc' => __('Width of The Error Image', "BlockTradesAffiliatesV1"),
            'std' => '',
            'pattern' => '\d+',
            'type' => 'text',
            'section' => 'error'
        );
        $this->settings['ttr_error_home_redirect'] = array(
            'title' => __('Redirect To Home Page(If Error Page Occurs)', "BlockTradesAffiliatesV1"),
            'desc' => __('Redirect to Home Page While Error Occur', "BlockTradesAffiliatesV1"),
            'std' => 0,
            'type' => 'checkbox',
            'section' => 'error'
        );

        /* Maintenance Settings
        ==========================================*/

        $this->settings['ttr_mm_enable'] = array(
            'title' => __('Enable Maintenance Mode', "BlockTradesAffiliatesV1"),
            'desc' => __('Enable/Disable Maintenance Mode', "BlockTradesAffiliatesV1"),
            'std' => 0,
            'type' => 'checkbox',
            'section' => 'maintenance'
        );
        $this->settings['ttr_mm_title'] = array(
            'title' => __('Title for Maintenance Mode Page', "BlockTradesAffiliatesV1"),
            'desc' => __('Set the Title', "BlockTradesAffiliatesV1"),
            'std' => '',
            'type' => 'text',
            'section' => 'maintenance'
        );
        $this->settings['ttr_mm_content'] = array(
            'title' => __('Content for Maintenance Mode Page', "BlockTradesAffiliatesV1"),
            'desc' => __('Content for Maintenance Mode page', "BlockTradesAffiliatesV1"),
            'std' => '',
            'type' => 'textarea',
            'section' => 'maintenance'
        );
        $this->settings['ttr_mm_image'] = array(
            'title' => __('Background Image for Maintenance Mode', "BlockTradesAffiliatesV1"),
            'desc' => __('Select Image for Maintenance Mode Page', "BlockTradesAffiliatesV1"),
            'std' => '',
            'type' => 'media',
            'section' => 'maintenance'
        );

        /* GoogleMap Settings
        ==========================================*/

        $this->settings['ttr_googlemap_type'] = array(
            'title' => __('Choose the type of Google Map', "BlockTradesAffiliatesV1"),
            'desc' => __('Choose the type of Google Map', "BlockTradesAffiliatesV1"),
            'type' => 'select',
            'std' => 'Road',
            'choices' => array(
                'choice1' => __('ROAD', "BlockTradesAffiliatesV1"),
                'choice2' => __('SATELLITE', "BlockTradesAffiliatesV1"),
                'choice3' => __('HYBRID', "BlockTradesAffiliatesV1"),
                'choice4' => __('TERRAIN', "BlockTradesAffiliatesV1")),
            'section' => 'googlemap'
        );
       $this->settings['ttr_map_latitude'] = array(
            'title' => __('Set Latitude', "BlockTradesAffiliatesV1"),
            'desc' => __('Set Latitude', "BlockTradesAffiliatesV1"),
            'std' => '25.306944',
            'pattern' => '',
            'type' => 'text',
            'section' => 'googlemap'
        );

        $this->settings['ttr_map_longitude'] = array(
            'title' => __('Set Longitude', "BlockTradesAffiliatesV1"),
            'desc' => __('Set Longitude', "BlockTradesAffiliatesV1"),
            'std' => '-257.858333',
            'pattern' => '',
            'type' => 'text',
            'section' => 'googlemap'
        );
        $this->settings['ttr_map_width'] = array(
            'title' => __('Set Width of Map', "BlockTradesAffiliatesV1"),
            'desc' => __('Set Width of Map', "BlockTradesAffiliatesV1"),
            'std' => '400',
            'pattern' => '\d+',
            'type' => 'text',
            'section' => 'googlemap'
        );
        $this->settings['ttr_map_height'] = array(
            'title' => __('Set Height of Map', "BlockTradesAffiliatesV1"),
            'desc' => __('Set Height of Map', "BlockTradesAffiliatesV1"),
            'std' => '400',
            'pattern' => '\d+',
            'type' => 'text',
            'section' => 'googlemap'
        );
        $this->settings['ttr_marker_enable'] = array(
            'title' => __('Display Marker', "BlockTradesAffiliatesV1"),
            'desc' => __('Enable/Disable the Position Marker', "BlockTradesAffiliatesV1"),
            'std' => 1,
            'type' => 'checkbox',
            'section' => 'googlemap'
        );
        $this->settings['ttr_marker_text'] = array(
            'title' => __('Set Marker Label', "BlockTradesAffiliatesV1"),
            'desc' => __('Set Marker Label', "BlockTradesAffiliatesV1"),
            'std' => 'This is my location',
            'type' => 'text',
            'patter' => '\d+',
            'section' => 'googlemap'
        );
        $this->settings['ttr_googlemap_api'] = array(
            'title' => __('Set Google API Key', "BlockTradesAffiliatesV1"),
            'desc' => __('Set Google API Key', "BlockTradesAffiliatesV1"),
            'std' => '',
            'type' => 'text',
            'patter' => '\d+',
            'section' => 'googlemap'
        );

        /* Shortcodes Settings
           ==========================================*/

        $this->settings['ttr_google_docs_viewer_shortcode'] = array(
            'title' => __('Google Docs Viewer', "BlockTradesAffiliatesV1"),
            'desc' => __('To use Copy/Paste the above shortcode', "BlockTradesAffiliatesV1"),
            'type' => 'shortcode',
            'std' => '[pdf href="http://manuals.info.apple.com/en_US/Enterprise_Deployment_Guide.pdf"]Link text.[/pdf]',
            'section' => 'shortcodes'
        );
        $this->settings['ttr_displaying_recent_posts_shortcode'] = array(
            'title' => __('Displaying Related Posts', "BlockTradesAffiliatesV1"),
            'desc' => __('To use Copy/Paste the above shortcode', "BlockTradesAffiliatesV1"),
            'type' => 'shortcode',
            'std' => '[related_posts]',
            'section' => 'shortcodes'
        );
        $this->settings['ttr_google_adsense_shortcode'] = array(
            'title' => __('Google AdSense', "BlockTradesAffiliatesV1"),
            'desc' => __('To use Copy/Paste the above shortcode', "BlockTradesAffiliatesV1"),
            'type' => 'shortcode',
            'std' => '[adsense client="ca-pub-1234567890" slot="1234567" width=728 height=90]',
            'section' => 'shortcodes'
        );
        $this->settings['ttr_google_chart_shortcode'] = array(
            'title' => __('Google Chart', "BlockTradesAffiliatesV1"),
            'desc' => __('To use Copy/Paste the above shortcode', "BlockTradesAffiliatesV1"),
            'type' => 'shortcode',
            'std' => '[chart data="41.52,37.79,20.67,0.03" bg="F7F9FA" labels="Reffering+sites|Search+Engines|Direct+traffic|Other" colors="058DC7,50B432,ED561B,EDEF00" size="488x200" title="Traffic Sources" type="pie"]',
            'section' => 'shortcodes'
        );
        $this->settings['ttr_tweet_me_button_shortcode'] = array(
            'title' => __('Tweet Me Button', "BlockTradesAffiliatesV1"),
            'desc' => __('To use Copy/Paste the above shortcode', "BlockTradesAffiliatesV1"),
            'type' => 'shortcode',
            'std' => '[tweet]',
            'section' => 'shortcodes'
        );
        $this->settings['ttr_google_map_shortcode'] = array(
            'title' => __('Google Map', "BlockTradesAffiliatesV1"),
            'desc' => __('To use Copy/Paste the above shortcode', "BlockTradesAffiliatesV1"),
            'type' => 'shortcode',
            'std' => '[googlemap]',
            'section' => 'shortcodes'
        );
        $this->settings['ttr_youtube_shortcode'] = array(
            'title' => __('YouTube', "BlockTradesAffiliatesV1"),
            'desc' => __('To use Copy/Paste the above shortcode', "BlockTradesAffiliatesV1"),
            'type' => 'shortcode',
            'std' => '[youtube value="http://www.youtube.com/watch?v=1aBSPn2P9bg"]',
            'section' => 'shortcodes'
        );
        $this->settings['ttr_private_content_shortcode'] = array(
            'title' => __('Private Content', "BlockTradesAffiliatesV1"),
            'desc' => __('To use Copy/Paste the above shortcode', "BlockTradesAffiliatesV1"),
            'type' => 'shortcode',
            'std' => '[member]This text will be only displayed to registered users.[/member]',
            'section' => 'shortcodes'
        );
        $this->settings['ttr_paypal_shortcode'] = array(
            'title' => __('PayPal', "BlockTradesAffiliatesV1"),
            'desc' => __('To use Copy/Paste the above shortcode', "BlockTradesAffiliatesV1"),
            'type' => 'shortcode',
            'std' => '[donate account="paypal account" type="text" text="Donation"]',
            'section' => 'shortcodes'
        );
        $this->settings['ttr_contact_us_form_shortcode'] = array(
            'title' => __('Contact Us Form', "BlockTradesAffiliatesV1"),
            'desc' => __('To use Copy/Paste the above shortcode', "BlockTradesAffiliatesV1"),
            'type' => 'shortcode',
            'std' => '[contact_us_form]',
            'section' => 'shortcodes'
        );
        $this->settings['ttr_login_form_shortcode'] = array(
            'title' => __('Login Form', "BlockTradesAffiliatesV1"),
            'desc' => __('To use Copy/Paste the above shortcode', "BlockTradesAffiliatesV1"),
            'type' => 'shortcode',
            'std' => '[widget type="login_form" style="block" loginbutton="Log In" logoutbutton="Log Out"]',
            'section' => 'shortcodes'
        );
        $this->settings['ttr_custommenu_shortcode'] = array(
            'title' => __('Custom Menu', "BlockTradesAffiliatesV1"),
            'desc' => __('To use Copy/Paste the above shortcode', "BlockTradesAffiliatesV1"),
            'type' => 'shortcode',
            'std' => '[widget type="Custom_Menu" title="Menu" style="block" menustyle="hmenu" nav_menu="All Pages" alignment="nostyle" color1="#d80e0e" color2="#120ed8" color="#ecdd74"]',
            'section' => 'shortcodes'
        );
        $this->settings['ttr_archives_shortcode'] = array(
            'title' => __('Archives', "BlockTradesAffiliatesV1"),
            'desc' => __('To use Copy/Paste the above shortcode', "BlockTradesAffiliatesV1"),
            'type' => 'shortcode',
            'std' => '[widget type="WP_Widget_Archives"]',
            'section' => 'shortcodes'
        );
        $this->settings['ttr_calendar_shortcode'] = array(
            'title' => __('Calendar', "BlockTradesAffiliatesV1"),
            'desc' => __('To use Copy/Paste the above shortcode', "BlockTradesAffiliatesV1"),
            'type' => 'shortcode',
            'std' => '[widget type="WP_Widget_Calendar"]',
            'section' => 'shortcodes'
        );
        $this->settings['ttr_categories_shortcode'] = array(
            'title' => __('Categories', "BlockTradesAffiliatesV1"),
            'desc' => __('To use Copy/Paste the above shortcode', "BlockTradesAffiliatesV1"),
            'type' => 'shortcode',
            'std' => '[widget type="WP_Widget_Categories"]',
            'section' => 'shortcodes'
        );
        $this->settings['ttr_links_shortcode'] = array(
            'title' => __('Links', "BlockTradesAffiliatesV1"),
            'desc' => __('To use Copy/Paste the above shortcode', "BlockTradesAffiliatesV1"),
            'type' => 'shortcode',
            'std' => '[widget type="WP_Widget_Links"]',
            'section' => 'shortcodes'
        );
        $this->settings['ttr_meta_shortcode'] = array(
            'title' => __('Meta', "BlockTradesAffiliatesV1"),
            'desc' => __('To use Copy/Paste the above shortcode', "BlockTradesAffiliatesV1"),
            'type' => 'shortcode',
            'std' => '[widget type="WP_Widget_Meta"]',
            'section' => 'shortcodes'
        );
        $this->settings['ttr_pages_shortcode'] = array(
            'title' => __('Pages', "BlockTradesAffiliatesV1"),
            'desc' => __('To use Copy/Paste the above shortcode', "BlockTradesAffiliatesV1"),
            'type' => 'shortcode',
            'std' => '[widget type="WP_Widget_Pages"]',
            'section' => 'shortcodes'
        );
        $this->settings['ttr_recent_comments_shortcode'] = array(
            'title' => __('Recent Comments', "BlockTradesAffiliatesV1"),
            'desc' => __('To use Copy/Paste the above shortcode', "BlockTradesAffiliatesV1"),
            'type' => 'shortcode',
            'std' => '[widget type="WP_Widget_Recent_Comments"]',
            'section' => 'shortcodes'
        );
        $this->settings['ttr_recent_posts_shortcode'] = array(
            'title' => __('Recent Posts', "BlockTradesAffiliatesV1"),
            'desc' => __('To use Copy/Paste the above shortcode', "BlockTradesAffiliatesV1"),
            'type' => 'shortcode',
            'std' => '[widget type="WP_Widget_Recent_Posts"]',
            'section' => 'shortcodes'
        );
        $this->settings['ttr_rss_shortcode'] = array(
            'title' => __('RSS', "BlockTradesAffiliatesV1"),
            'desc' => __('To use Copy/Paste the above shortcode', "BlockTradesAffiliatesV1"),
            'type' => 'shortcode',
            'std' => '[widget type="WP_Widget_RSS"]',
            'section' => 'shortcodes'
        );
        $this->settings['ttr_search_shortcode'] = array(
            'title' => __('Search', "BlockTradesAffiliatesV1"),
            'desc' => __('To use Copy/Paste the above shortcode', "BlockTradesAffiliatesV1"),
            'type' => 'shortcode',
            'std' => '[widget type="WP_Widget_Search"]',
            'section' => 'shortcodes'
        );
        $this->settings['ttr_tagcloud_shortcode'] = array(
            'title' => __('Tag Cloud', "BlockTradesAffiliatesV1"),
            'desc' => __('To use Copy/Paste the above shortcode', "BlockTradesAffiliatesV1"),
            'type' => 'shortcode',
            'std' => '[widget type="WP_Widget_Tag_Cloud"]',
            'section' => 'shortcodes'
        );
        $this->settings['ttr_text_shortcode'] = array(
            'title' => __('Text', "BlockTradesAffiliatesV1"),
            'desc' => __('To use Copy/Paste the above shortcode', "BlockTradesAffiliatesV1"),
            'type' => 'shortcode',
            'std' => '[widget type="WP_Widget_Text"]',
            'section' => 'shortcodes'
        );

        /* SEO Enable Settings
        ===========================================*/

        /*$this->settings['ttr_seo_enable'] = array(
            'title' => __('Enable SEO Mode', "steemtemplates"),
            'desc' => __('Enable/Disable SEO Mode', "steemtemplates"),
            'std' => '',
            'type' => 'checkbox',
            'section' => 'seoenable'
        );*/

        /* SEO Home Settings
       ===========================================*/

       /* $this->settings['ttr_seo_home_title'] = array(
            'title' => __('Home Title', "steemtemplates"),
            'desc' => __('Set the title of home page ', "steemtemplates"),
            'std' => '',
            'type' => 'text',
            'section' => 'seohome'
        );

        $this->settings['ttr_seo_home_desc'] = array(
            'title' => __('Home Description', "steemtemplates"),
            'desc' => __('Set the description of home page', "steemtemplates"),
            'std' => '',
            'type' => 'textarea',
            'section' => 'seohome'
        );

        $this->settings['ttr_seo_home_keywords'] = array(
            'title' => __('Home Keywords (Comma Separated)', "steemtemplates"),
            'desc' => __('Set the keywords of home page', "steemtemplates"),
            'std' => '',
            'type' => 'textarea',
            'section' => 'seohome'
        );

        $this->settings['ttr_seo_rewrite_titles'] = array(
            'title' => __('Rewrite Titles Format', "steemtemplates"),
            'desc' => __('Enable/Disable Rewrite Titles Format', "steemtemplates"),
            'std' => 1,
            'type' => 'checkbox',
            'section' => 'seohome'
        );

        $this->settings['ttr_seo_capitalize_titles'] = array(
            'title' => __('Capitalize Titles', "steemtemplates"),
            'desc' => __('Enable/Disable for Capitalize Page Titles', "steemtemplates"),
            'std' => 1,
            'type' => 'checkbox',
            'section' => 'seohome'
        );
        $this->settings['ttr_seo_capitalize_category'] = array(
            'title' => __('Capitalize Category Titles', "steemtemplates"),
            'desc' => __('Enable/Disable for Capitalize Category Titles', "steemtemplates"),
            'std' => 1,
            'type' => 'checkbox',
            'section' => 'seohome'
        );
        $this->settings['ttr_seo_page_title'] = array(
            'title' => __('Page Title Format', "steemtemplates"),
            'desc' => __('Enable/Disable the Page Title Format', "steemtemplates"),
            'type' => 'select',
            'std' => '%page_title% | %blog_title%',
            'class' => 'ttr_seo_rewrite_titles_select',
            'choices' => array(
                'choice1' => __('%page_title%', "steemtemplates"),
                'choice2' => __('%blog_title%', "steemtemplates"),
                'choice3' => __('%page_title% | %blog_title%', "steemtemplates"),
                'choice4' => __('%blog_title% | %page_title%', "steemtemplates")),
            'section' => 'seohome'
        );
        $this->settings['ttr_seo_post_title'] = array(
            'title' => __('Post Title Format', "steemtemplates"),
            'desc' => __('Enable/Disable the Post Title Format', "steemtemplates"),
            'type' => 'select',
            'std' => '%page_title% | %blog_title%',
            'class' => 'ttr_seo_rewrite_titles_select',
            'choices' => array(
                'choice1' => __('%page_title%', "steemtemplates"),
                'choice2' => __('%blog_title%', "steemtemplates"),
                'choice3' => __('%page_title% | %blog_title%', "steemtemplates"),
                'choice4' => __('%blog_title% | %page_title%', "steemtemplates")),
            'section' => 'seohome'
        );

        $this->settings['ttr_seo_category_title'] = array(
            'title' => __('Category Title Format', "steemtemplates"),
            'desc' => __('Enable/Disable the Category Title Format', "steemtemplates"),
            'type' => 'select',
            'std' => '%category_title% | %blog_title%',
            'class' => 'ttr_seo_rewrite_titles_select',
            'choices' => array(
                'choice1' => __('%category_title%', "steemtemplates"),
                'choice2' => __('%blog_title%', "steemtemplates"),
                'choice3' => __('%category_title% | %blog_title%', "steemtemplates"),
                'choice4' => __('%blog_title% | %category_title%', "steemtemplates")),
            'section' => 'seohome'
        );
        $this->settings['ttr_seo_date_archive_title'] = array(
            'title' => __('Date Archive Title Format', "steemtemplates"),
            'desc' => __('Enable/Disable the Date Archive Title Format', "steemtemplates"),
            'type' => 'select',
            'std' => '%date% | %blog_title%',
            'class' => 'ttr_seo_rewrite_titles_select',
            'choices' => array(
                'choice1' => __('%date%', "steemtemplates"),
                'choice2' => __('%blog_title%', "steemtemplates"),
                'choice3' => __('%date% | %blog_title%', "steemtemplates"),
                'choice4' => __('%blog_title% | %date%', "steemtemplates")),
            'section' => 'seohome'
        );
        $this->settings['ttr_seo_anchor_archive_title'] = array(
            'title' => __('Author Archive Title Format', "steemtemplates"),
            'desc' => __('Enable/Disable the Author Archive Title Format', "steemtemplates"),
            'type' => 'select',
            'std' => '%author% | %blog_title%',
            'class' => 'ttr_seo_rewrite_titles_select',
            'choices' => array(
                'choice1' => __('%author%', "steemtemplates"),
                'choice2' => __('%blog_title%', "steemtemplates"),
                'choice3' => __('%author% | %blog_title%', "steemtemplates"),
                'choice4' => __('%blog_title% | %author%', "steemtemplates")),
            'section' => 'seohome'
        );
        $this->settings['ttr_seo_tag_title'] = array(
            'title' => __('Tag Title Format', "steemtemplates"),
            'desc' => __('Enable/Disable the Tag Title Format', "steemtemplates"),
            'type' => 'select',
            'std' => '%tag% | %blog_title%',
            'class' => 'ttr_seo_rewrite_titles_select',
            'choices' => array(
                'choice1' => __('%tag%', "steemtemplates"),
                'choice2' => __('%blog_title%', "steemtemplates"),
                'choice3' => __('%tag% | %blog_title%', "steemtemplates"),
                'choice4' => __('%blog_title% | %tag%', "steemtemplates")),
            'section' => 'seohome'
        );
        $this->settings['ttr_seo_search_title'] = array(
            'title' => __('Search Title Format', "steemtemplates"),
            'desc' => __('Enable/Disable the Search Title Format', "steemtemplates"),
            'type' => 'select',
            'std' => '%search% | %blog_title%',
            'class' => 'ttr_seo_rewrite_titles_select',
            'choices' => array(
                'choice1' => __('%search%', "steemtemplates"),
                'choice2' => __('%blog_title%', "steemtemplates"),
                'choice3' => __('%search% | %blog_title%', "steemtemplates"),
                'choice4' => __('%blog_title% | %search%', "steemtemplates")),
            'section' => 'seohome'
        );
        $this->settings['ttr_seo_404_title'] = array(
            'title' => __('404 Title Format', "steemtemplates"),
            'desc' => __('Enable/Disable the 404 Title Format', "steemtemplates"),
            'type' => 'select',
            'std' => 'Nothing found for %request_words%',
            'class' => 'ttr_seo_rewrite_titles_select',
            'choices' => array(
                'choice1' => __('%request_words%', "steemtemplates"),
                'choice2' => __('%blog_title%', "steemtemplates"),
                'choice3' => __('%request_words% | %blog_title%', "steemtemplates"),
                'choice4' => __('%blog_title% | %request_words%', "steemtemplates")),
            'section' => 'seohome'
        );*/
        /* SEO General Settings
       ===========================================*/


       /* $this->settings['ttr_seo_use_keywords'] = array(
            'title' => __('Use Meta Keywords', "steemtemplates"),
            'desc' => __('Enable/Disable Meta Keywords', "steemtemplates"),
            'std' => 1,
            'type' => 'checkbox',
            'section' => 'seogeneral'
        );
        $this->settings['ttr_seo_default_keywords'] = array(
            'title' => __('Set Default Keywords (Comma Separated)', "steemtemplates"),
            'desc' => __('Set Default Keywords', "steemtemplates"),
            'std' => '',
            'type' => 'text',
            'section' => 'seogeneral'
        );
        $this->settings['ttr_seo_categories_meta_keywords'] = array(
            'title' => __('Use Categories as Keywords', "steemtemplates"),
            'desc' => __('Enable/Disable use Categories as Keywords', "steemtemplates"),
            'std' => 1,
            'type' => 'checkbox',
            'class' => 'ttr_seo_use_keywords_select',
            'section' => 'seogeneral'
        );
        $this->settings['ttr_seo_tags_meta_keywords'] = array(
            'title' => __('Use Tags as Keywords', "steemtemplates"),
            'desc' => __('Enable/Disable use Tags as Keywords', "steemtemplates"),
            'std' => 1,
            'type' => 'checkbox',
            'class' => 'ttr_seo_use_keywords_select',
            'section' => 'seogeneral'
        );
        $this->settings['ttr_seo_autogenerate_description'] = array(
            'title' => __('Autogenerate Descriptions', "steemtemplates"),
            'desc' => __('Enable/Disable autogenerate descriptions', "steemtemplates"),
            'std' => '',
            'type' => 'checkbox',
            'section' => 'seogeneral'
        );
        $this->settings['ttr_seo_nonindex_post'] = array(
            'title' => __('Set No-Index for all Posts', "steemtemplates"),
            'desc' => __('Enable/Disable indexing for all post', "steemtemplates"),
            'std' => 1,
            'type' => 'checkbox',
            'section' => 'seogeneral'
        );
        $this->settings['ttr_seo_nonindex_page'] = array(
            'title' => __('Set No-Index for all Page', "steemtemplates"),
            'desc' => __('Enable/Disable indexing for all pages', "steemtemplates"),
            'std' => 1,
            'type' => 'checkbox',
            'section' => 'seogeneral'
        );
        $this->settings['ttr_seo_nofollow_post'] = array(
            'title' => __('Set No-Follow for all Posts', "steemtemplates"),
            'desc' => __('Enable/Disable No-Follow for all post', "steemtemplates"),
            'std' => 1,
            'type' => 'checkbox',
            'section' => 'seogeneral'
        );
        $this->settings['ttr_seo_nofollow_page'] = array(
            'title' => __('Set No-Follow for all Page', "steemtemplates"),
            'desc' => __('Enable/Disable No-Follow for all pages', "steemtemplates"),
            'std' => 1,
            'type' => 'checkbox',
            'section' => 'seogeneral'
        );*/

        /* SEO Web Social Settings
        ===========================================*/

       /* $this->settings['ttr_seo_google_webmaster'] = array(
            'title' => __('Google Webmaster Tools', "steemtemplates"),
            'desc' => __('For Google Webmaster Verification', "steemtemplates"),
            'std' => '',
            'type' => 'text',
            'section' => 'seosocial'
        );
        $this->settings['ttr_seo_bing_webmaster'] = array(
            'title' => __('Bing Webmaster Tools', "steemtemplates"),
            'desc' => __('For Bing Webmaster Verification', "steemtemplates"),
            'std' => '',
            'type' => 'text',
            'section' => 'seosocial'
        );
        $this->settings['ttr_seo_pinterst_webmaster'] = array(
            'title' => __('Pinterst Webmaster Tools', "steemtemplates"),
            'desc' => __('For Pinterst Webmaster Verification', "steemtemplates"),
            'std' => '',
            'type' => 'text',
            'section' => 'seosocial'
        );
        $this->settings['ttr_seo_google_plus'] = array(
            'title' => __('Google Plus Default Profile', "steemtemplates"),
            'desc' => __('For Google Analytics', "steemtemplates"),
            'std' => '',
            'type' => 'text',
            'section' => 'seosocial'
        );*/

        /* SEO Sitemap Settings
       ===========================================*/

        /*$this->settings['ttr_seo_include_page'] = array(
            'title' => __('Include Page types to Sitemap', "steemtemplates"),
            'desc' => __('Add/Remove Page types to sitemap', "steemtemplates"),
            'std' => 1,
            'type' => 'checkbox',
            'section' => 'seositemap'
        );
        $this->settings['ttr_seo_include_post'] = array(
            'title' => __('Include Post types to Sitemap', "steemtemplates"),
            'desc' => __('Add/Remove Post types to sitemap', "steemtemplates"),
            'std' => 1,
            'type' => 'checkbox',
            'section' => 'seositemap'
        );

        $this->settings['ttr_seo_view_sitemap'] = array(
            'title' => __('View the Sitemap', "steemtemplates"),
            'desc' => __('Click this button to view sitemap', "steemtemplates"),
            'std' => 'View Sitemap',
            'type' => 'sitemaplink',
            'section' => 'seositemap'
        );*/


        /* SEO Advanced Settings
       ===========================================*/

       /* $this->settings['ttr_seo_noindex_date_archive'] = array(
            'title' => __('Use No-index for Date Archive', "steemtemplates"),
            'desc' => __('Enable/Disable index for Date Archive', "steemtemplates"),
            'std' => 1,
            'type' => 'checkbox',
            'section' => 'seoadvanced'
        );
        $this->settings['ttr_seo_noindex_author_archive'] = array(
            'title' => __('Use No-index for Author Archive', "steemtemplates"),
            'desc' => __('Enable/Disable index for Author Archive', "steemtemplates"),
            'std' => 1,
            'type' => 'checkbox',
            'section' => 'seoadvanced'
        );
        $this->settings['ttr_seo_noindex_tag_archive'] = array(
            'title' => __('Use No-index for Tag Archive', "steemtemplates"),
            'desc' => __('Enable/Disable index for Tag Archive', "steemtemplates"),
            'std' => 1,
            'type' => 'checkbox',
            'section' => 'seoadvanced'
        );
        $this->settings['ttr_seo_noindex_categories'] = array(
            'title' => __('Use No-index for Categories Archive', "steemtemplates"),
            'desc' => __('Enable/Disable index for Categories Archive', "steemtemplates"),
            'std' => 1,
            'type' => 'checkbox',
            'section' => 'seoadvanced'
        );
        $this->settings['ttr_seo_nofollow_categories'] = array(
            'title' => __('Use No-follow for Categories Archive', "steemtemplates"),
            'desc' => __('Enable/Disable follow for Categories Archive', "steemtemplates"),
            'std' => 1,
            'type' => 'checkbox',
            'section' => 'seoadvanced'
        );

        $this->settings['ttr_seo_noindex_search'] = array(
            'title' => __('Use No-index for Search Archive', "steemtemplates"),
            'desc' => __('Enable/Disable index for Search Archive', "steemtemplates"),
            'std' => 1,
            'type' => 'checkbox',
            'section' => 'seoadvanced'
        );
        $this->settings['ttr_seo_nofollow_search'] = array(
            'title' => __('Use No-follow for Search Archive', "steemtemplates"),
            'desc' => __('Enable/Disable follow for Search Archive', "steemtemplates"),
            'std' => 1,
            'type' => 'checkbox',
            'section' => 'seoadvanced'
        );
        $this->settings['ttr_seo_additional_post_header'] = array(
            'title' => __('Additional Post Headers', "steemtemplates"),
            'desc' => __('Give any Additional Post Headers', "steemtemplates"),
            'std' => '',
            'type' => 'textarea',
            'section' => 'seoadvanced'
        );
        $this->settings['ttr_seo_additional_page_header'] = array(
            'title' => __('Additional Page Headers', "steemtemplates"),
            'desc' => __('Give any Additional Page Headers', "steemtemplates"),
            'std' => '',
            'type' => 'textarea',
            'section' => 'seoadvanced'
        );
        $this->settings['ttr_seo_additional_fpage_header'] = array(
            'title' => __('Additional Post Headers', "steemtemplates"),
            'desc' => __('Give any Additional Post Headers', "steemtemplates"),
            'std' => '',
            'type' => 'textarea',
            'section' => 'seoadvanced'
        );*/

        /* Backup Dashboard
       ===========================================*/

        $this->settings['ttr_ftp_server_address'] = array(
            'title' => __('FTP Server Address', "BlockTradesAffiliatesV1"),
            'desc' => __('Enter the FTP Address ', "BlockTradesAffiliatesV1"),
            'std' => '',
            'type' => 'text',
            'section' => 'backupsettings'
        );
        $this->settings['ttr_ftp_user_name'] = array(
            'title' => __('FTP User name', "BlockTradesAffiliatesV1"),
            'desc' => __('Enter the FTP username ', "BlockTradesAffiliatesV1"),
            'std' => '',
            'type' => 'text',
            'section' => 'backupsettings'
        );
        $this->settings['ttr_ftp_user_password'] = array(
            'title' => __('FTP User password', "BlockTradesAffiliatesV1"),
            'desc' => __('Enter the FTP password ', "BlockTradesAffiliatesV1"),
            'std' => '',
            'type' => 'password',
            'section' => 'backupsettings'
        );
        $this->settings['ttr_ftp_recipient_email'] = array(
            'title' => __('Email of recipient', "BlockTradesAffiliatesV1"),
            'desc' => __('Enter the name of email recipient ', "BlockTradesAffiliatesV1"),
            'std' => '',
            'type' => 'text',
            'section' => 'backupsettings'
        );
        $this->settings['ttr_ftp_check_connection'] = array(
            'title' => __('Check FTP Connection', "BlockTradesAffiliatesV1"),
            'desc' => __('Click to check the FTP Connection Status', "BlockTradesAffiliatesV1"),
            'std' => 'Test FTP Connection',
            'type' => 'button',
            'section' => 'backupsettings'
        );
        
        /* Backup Settings
       ===========================================*/

        $this->settings['ttr_manual_database_backup'] = array(
            'title' => __('Database Backup (.sql file)', "BlockTradesAffiliatesV1"),
            'desc' => __('Add/Remove database (.sql) file to Backup zip', "BlockTradesAffiliatesV1"),
            'std' => 1,
            'type' => 'checkbox',
            'section' => 'backup'
        );
        $this->settings['ttr_automatic_backup_recovery_enable'] = array(
            'title' => __('Enable Automatic Backup/Recovery Mode)', "BlockTradesAffiliatesV1"),
            'desc' => __('Enable/Disable Automatic Backup/Recovery Mode', "BlockTradesAffiliatesV1"),
            'std' => 1,
            'type' => 'checkbox',
            'section' => 'backup'
        );
        $this->settings['ttr_include_plugin_backup'] = array(
            'title' => __('Include Plugins', "BlockTradesAffiliatesV1"),
            'desc' => __('Include/Exclude plugins to Backup Zip', "BlockTradesAffiliatesV1"),
            'std' => 1,
            'type' => 'checkbox',
            'section' => 'backup'
        );
        $this->settings['ttr_include_theme_backup'] = array(
            'title' => __('Include Themes', "BlockTradesAffiliatesV1"),
            'desc' => __('Include/Exclude themes to Backup Zip', "BlockTradesAffiliatesV1"),
            'std' => 1,
            'type' => 'checkbox',
            'section' => 'backup'
        );
        $this->settings['ttr_include_uploads_backup'] = array(
            'title' => __('Include Uploads', "BlockTradesAffiliatesV1"),
            'desc' => __('Include/Exclude uploads to Backup Zip', "BlockTradesAffiliatesV1"),
            'std' => 1,
            'type' => 'checkbox',
            'section' => 'backup'
        );
        $this->settings['ttr_backup_folder_name'] = array(
            'title' => __('Backup Folder Name', "BlockTradesAffiliatesV1"),
            'desc' => __('Set the folder name to take the backup', "BlockTradesAffiliatesV1"),
            'std' => 'Backup',
            'type' => 'text',
            'section' => 'backup'
        );
        $this->settings['ttr_automatic_backup_interval'] = array(
            'title' => __('Automatic Backup intervals', "BlockTradesAffiliatesV1"),
            'desc' => __('Select the database interval to take backup', "BlockTradesAffiliatesV1"),
            'type' => 'select',
            'std' => '-Select-',
            'choices' => array(
                'choice1' => __('Every 10 mins', "BlockTradesAffiliatesV1"),
                'choice2' => __('Every hour', "BlockTradesAffiliatesV1"),
                'choice3' => __('Every 4 hours', "BlockTradesAffiliatesV1"),
                'choice4' => __('Every 8 hours', "BlockTradesAffiliatesV1"),
                'choice2' => __('Every 12 hours', "BlockTradesAffiliatesV1"),
                'choice3' => __('Daily', "BlockTradesAffiliatesV1"),
                'choice4' => __('Weekly', "BlockTradesAffiliatesV1")),
            'section' => 'backup'
        );
        $this->settings['ttr_storage_backup'] = array(
            'title' => __('Choose your Remote Storage', "BlockTradesAffiliatesV1"),
            'desc' => __('Set time to the backup', "BlockTradesAffiliatesV1"),
            'type' => 'select',
            'std' => '-Select-',
            'choices' => array(
                'choice1' => __('FTP', "BlockTradesAffiliatesV1"),
                'choice2' => __('Email', "BlockTradesAffiliatesV1")),
            'section' => 'backup'
        );
        $this->settings['ttr_backup_folder_name'] = array(
            'title' => __('Backup Folder Name', "BlockTradesAffiliatesV1"),
            'desc' => __('Set the folder name to take the backup', "BlockTradesAffiliatesV1"),
            'std' => 'Backup',
            'type' => 'text',
            'section' => 'backup'
        );


        /* Restore Settings
       ===========================================*/

        $this->settings['ttr_browse'] = array(
            'title' => __('Select Backup Folder', "BlockTradesAffiliatesV1"),
            'desc' => __('Select the folder(.zip file only)', "BlockTradesAffiliatesV1"),
            'std' => '',
            'type' => 'file',
            'section' => 'restore'
        );
        $this->settings['ttr_include_database_restore'] = array(
            'title' => __('Restore Database(.sql)', "BlockTradesAffiliatesV1"),
            'desc' => __('Enable/Disable to restore databases for Site', "BlockTradesAffiliatesV1"),
            'std' => 0,
            'type' => 'checkbox',
            'section' => 'restore'
        );
        $this->settings['ttr_include_theme_restore'] = array(
            'title' => __('Restore Themes', "BlockTradesAffiliatesV1"),
            'desc' => __('Enable/Disable to restore theme folder for Site', "BlockTradesAffiliatesV1"),
            'std' => 0,
            'type' => 'checkbox',
            'section' => 'restore'
        );
        $this->settings['ttr_include_plugins_restore'] = array(
            'title' => __('Restore Plugins', "BlockTradesAffiliatesV1"),
            'desc' => __('Enable/Disable to restore plugins folder for Site', "BlockTradesAffiliatesV1"),
            'std' => 0,
            'type' => 'checkbox',
            'section' => 'restore'
        );
        $this->settings['ttr_include_uploads_restore'] = array(
            'title' => __('Restore Uploads', "BlockTradesAffiliatesV1"),
            'desc' => __('Enable/Disable to restore uploads folder for Site', "BlockTradesAffiliatesV1"),
            'std' => 0,
            'type' => 'checkbox',
            'section' => 'restore'
        );
        $this->settings['ttr_include_uploads_restore'] = array(
            'title' => __('Restore Uploads', "BlockTradesAffiliatesV1"),
            'desc' => __('Enable/Disable to restore uploads folder for Site', "BlockTradesAffiliatesV1"),
            'std' => 0,
            'type' => 'checkbox',
            'section' => 'restore'
        );

    }

    /**
     * Initialize settings to their default values
     *
     * @since 1.0
     */
    public function initialize_settings()
    {

        $default_settings = array();
        foreach ($this->settings as $id => $setting) {
            if ($setting['type'] != 'heading')
                $default_settings[$id] = $setting['std'];
        }

        // update_option('steemtemplates_theme_options', $default_settings);
	}

    /**
     * Register settings
     *
     * @since 1.0
     */
    public function register_settings()
    {
       // settings validation callback array
		$args = array(
            'type' => 'array', 
            'sanitize_callback' => array(&$this,'validate_settings')
           );
    register_setting('steemtemplates_theme_options', 'steemtemplates_theme_options', $args);
        foreach ($this->sections as $slug => $title) {
            if ($slug == 'colors')
                add_settings_section($slug, $title, array(&$this, 'display_colors_section'), 'mytheme-options');
            elseif ($slug == 'contactus')
                add_settings_section($slug, $title, array(&$this, 'display_contactus_section'), 'mytheme-options');
			elseif ($slug == 'seo')
                add_settings_section($slug, $title, array(&$this, 'display_seoenable_section'), 'mytheme-options');
            elseif ($slug == 'backuppage')
                add_settings_section($slug, $title, array(&$this, 'display_backuppage_section'), 'mytheme-options');
            elseif ($slug == 'export_import')
                add_settings_section($slug, $title, array(&$this, 'display_export_import_section'), 'mytheme-options');     
            else
                add_settings_section($slug, $title, array(&$this, 'display_menu_section'), 'mytheme-options');
        }
        $this->get_static_options();

        foreach ($this->settings as $id => $setting) {
            $setting['id'] = $id;
            $this->create_setting($setting);
        }
    }

    public function scripts()
    {
        wp_register_script('uitabs', get_template_directory_uri() . '/js/uitabs.js', array('jquery', 'wp-color-picker'), '1.0.0', false);
        wp_enqueue_script('uitabs');
        $sections = array_merge($this->sections, array('seoenable' => 'SEO Enable', 'seohome' => 'Home', 'seogeneral' => 'SEO General', 'seosocial' => 'Web/Social', 'seositemap' => 'Sitemap', 'seoadvanced' => 'Advanced'), array('backupsettings' => 'Settings', 'backup' => 'Backup', 'restore' => 'Restore'));
        wp_localize_script('uitabs', 'pass_data', $sections);
        
        $translations = array_merge(array('tt_xmlerror' => (__('Please, select an xml file','BlockTradesAffiliatesV1')), 'tt_savechanges' => (__('No changes to export in Theme Options. Please save your changes properly.','BlockTradesAffiliatesV1'))));
        
        wp_register_script('import_export_js', get_template_directory_uri() . '/js/import-export.js', array(), 1.0, false);
		wp_localize_script('import_export_js', 'tt_ajax' , $translations);
		wp_enqueue_script('import_export_js');

    }

    public function styles()
    {

        wp_enqueue_style('wp-color-picker');
    }


    /**
     * Validate settings
     *
     * @since 1.0
     */
    public function validate_settings($input)
    {

        //if (!isset($input['reset_theme'])) {
        $options = get_option('steemtemplates_theme_options');

        foreach ($this->checkboxes as $id) {
            if (isset($options[$id]) && !isset($input[$id]))
                unset($options[$id]);
        }
        
        foreach ($this->media as $id) {
            if (isset($options[$id]) && !isset($input[$id]))
                unset($options[$id]);
        }
        // check url http:// validate
        foreach ($this->settings as  $key => $value)
        {
 			if($key == 'ttr_designedby_link_url')
            {
               if(!wp_http_validate_url($input['ttr_designedby_link_url']) )
               { 
                 add_settings_error('steemtemplates_theme_options','errorMsg',__("Please enter a valid URL", "BlockTradesAffiliatesV1"),'error') ;
			     return $options;
              }             
            }
        } 
        return $input;
    }
}

$theme_options = new steemtemplates_Theme_Options();
if ( isset($_POST['ttr_submit'])) { steemtemplates_contact_form_option_update(); }
function steemtemplates_contact_form_option_update()
{

    $post_val=array();
    foreach($_POST as $key=>$i)
    {

        if($key=='ttr_submit' || $key=='steemtemplates_theme_options' || $key=='_wp_http_referer' || $key=='_wpnonce' || $key=='action' || $key=='option_page' || $key=='importfile')
            continue;
        if(strpos($key,'req') == false)
        {

            $post_val_new=array();
            $post_val_new[$key] = $_POST[$key];

            if (isset($_POST[$key.'req']))
            {
                $post_val_new[$key.'req'] = $_POST[$key.'req'];

            }
            else
                $post_val_new[$key.'req']='off';

            array_push($post_val,$post_val_new);
        }
    }
    update_option('contact_form', $post_val);
}
?>