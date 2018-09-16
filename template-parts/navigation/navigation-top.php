<?php $theme_path_content = get_template_directory_uri().'/content'; ?>
<nav id="stt_menu" class="main-navigation navbar-default navbar" role="navigation" aria-label="<?php esc_attr_e( 'Top Menu', 'BlockTradesAffiliatesV1' ); ?>">
<div id="stt_menu_inner_in">
<div class="stt_menu_element_alignment container">
</div>
<div id="navigationmenu">
<div class="navbar-header">
<button id="nav-expander" class="navbar-toggle" data-target=".navbar-collapse" type="button" aria-controls="top-menu" aria-expanded="false" data-toggle="collapse">
<span class="stt_menu_toggle_button">
<span class="sr-only">
</span>
<span class="icon-bar">
</span>
<span class="icon-bar">
</span>
<span class="icon-bar">
</span>
</span>
<span class="stt_menu_button_text">
Menu
</span>
</button>
</div>
<?php wp_nav_menu( array(
'theme_location'  => 'primary',
'menu_id'         => 'top-menu',
'menu_class'      => 'stt_menu_items nav navbar-nav nav-center',
'container_class' => 'menu-center collapse navbar-collapse',
'walker' 			=>  new steemtemplates_Walker_Vertical_Nav_Menu()
) ); ?>
<?php if ( ( is_home() && is_front_page() ) && has_custom_header() ) : ?>
<a href="#content" class="menu-scroll-down"><span class="screen-reader-text"><?php _e( 'Scroll down to content', 'BlockTradesAffiliatesV1' ); ?></span></a>
<?php endif; ?>
</div>
</div>
</nav><!-- #site-navigation -->