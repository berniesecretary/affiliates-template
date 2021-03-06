<?php
/**
* File for displaying content.
*
* @package steemtemplates
*/
?>
<?php global $steemtemplates_classes_post;?>
<article <?php post_class( $steemtemplates_classes_post ); ?>>
<?php if ( has_post_thumbnail() && ! post_password_required() ) : ?>
<div class="entry-thumbnail">
<?php the_post_thumbnail('featuredImageCropped'); ?>
</div>
<?php endif; ?>
<div class="stt_post_content_inner">
<?php $postid = ( isset( $post->ID ) ? get_the_ID() : NULL );
$var = get_post_meta($postid, 'ttr_post_title_checkbox',true);
 $var_all=steemtemplates_theme_option('ttr_all_post_title');
if($var != 'false' && $var_all):?>
<div class="stt_post_inner_box">
 <?php if(is_page()) {
echo "<h1".' class="stt_page_title">'; ?>
<?php $postid = ( isset( $post->ID ) ? get_the_ID() : NULL );
if(get_post_meta($postid,'ttr_post_link_enable_checkbox',true)!= 'false'):?>
<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', CURRENT_THEME, 'BlockTradesAffiliatesV1' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php endif; ?><?php the_title(); ?></a>
<?php  } else {
if((is_front_page() && is_home()) || is_home()){
$post_tag = 'h2'; 
}
else{
$post_tag = 'h1'; 
} 
echo "<$post_tag".' class="stt_post_title entry-title">'; ?>
<?php $postid = ( isset( $post->ID ) ? get_the_ID() : NULL );
if(get_post_meta($postid,'ttr_post_link_enable_checkbox',true)!= 'false'):?>
<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'BlockTradesAffiliatesV1' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php endif; ?><?php the_title(); ?></a>
<?php echo "</$post_tag>"; } ?>
</div>
<?php endif; ?>
<div class="stt_article">
<?php if ( 'post' == get_post_type() ) : ?>
<?php steemtemplates_posted_on(False,False); ?>
<?php endif; ?>
<?php if ( is_search() ) : ?>
<div class="entry-summary postcontent">
<?php the_excerpt(); ?>
</div>
<?php else : ?>
<div class="postcontent entry-content">
<?php if(steemtemplates_theme_option('ttr_read_more_button')):
the_content( '<span class="button">'.steemtemplates_theme_option('ttr_read_more').'</span>' );
else:
the_content( steemtemplates_theme_option('ttr_read_more') ); 
endif;?>
<div style="clear: both;"></div>
</div>
<?php endif;?>
<?php wp_link_pages( array( 'before' => '<span>' . __( 'Pages:', 'BlockTradesAffiliatesV1' ) . '</span>', 'after' => '' ) ); ?>
<?php $show_sep = false; ?>
<div class="postedon">
<?php if(steemtemplates_theme_option('ttr_remove_post_category')):?>
<?php if ( 'post' == get_post_type() ) : ?>
<?php
$categories_list = get_the_category_list( __( ', ', 'BlockTradesAffiliatesV1' ) );
if ( $categories_list ):
?>
<?php printf( __( '<span class="meta">Posted in </span> %2$s', 'BlockTradesAffiliatesV1' ), '', $categories_list );
$show_sep = true; ?>
<?php endif; ?>
<?php
$tags_list = get_the_tag_list( '', __( ', ', 'BlockTradesAffiliatesV1' ) );
if ( $tags_list ):
if ( $show_sep ) : ?>
<span class="meta-sep"> | </span>
<?php endif; ?>
<?php printf( __( 'Tagged %2$s', 'BlockTradesAffiliatesV1' ), 'entry-utility-prep entry-utility-prep-tag-links', $tags_list );
$show_sep = true; ?>
<?php endif; ?>
<?php endif;  ?>
<?php endif;  ?>
<?php if ( $show_sep ) : ?>
<span class="meta-sep"> | </span>
<?php endif; ?>
<?php if ( comments_open() ) : ?>
<?php comments_popup_link( '<span class="leave-reply">' . __( 'Leave a reply', 'BlockTradesAffiliatesV1' ) . '</span>', __( '<b>1</b> Reply', 'BlockTradesAffiliatesV1' ), __( '<b>%</b> Replies', 'BlockTradesAffiliatesV1' ) ); ?>
<?php endif; ?>
<?php if ( $post = get_post( $id )and $url = get_edit_post_link( $post->ID ) ) {
$link = __('Edit This', 'BlockTradesAffiliatesV1');
$post_type_obj = get_post_type_object( $post->post_type );
$link = '<span class="meta-sep"> | </span><a href="' . $url . '" title="' . esc_attr( $post_type_obj->labels->edit_item ) . '">' . $link . '</a>';
echo '<span class="edit-link">' . apply_filters( 'edit_post_link', $link, $post->ID ) .  '</span>';
}
?>
</div>
</div>
</div>
</article>