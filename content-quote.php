<article id="post-<?php the_ID(); ?>"<?php post_class(); ?>>
<div class="stt_post">
<div class="postcontent">
<div class="entry-content">
<?php if(steemtemplates_theme_option('ttr_read_more_button')):
the_content( '<span class="button">'.steemtemplates_theme_option('ttr_read_more').'</span>' );
else:
the_content( steemtemplates_theme_option('ttr_read_more') ); 
endif;?>
<?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'BlockTradesAffiliatesV1' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
</div><!-- .entry-content -->
</div>
<div class="entry-meta">
<?php steemtemplates_entry_meta(); ?>
<?php if ( comments_open() && ! is_single() ) : ?>
<span class="comments-link">
<?php comments_popup_link( '<span class="leave-reply">' . __( 'Leave a comment', 'BlockTradesAffiliatesV1' ) . '</span>', __( 'One comment so far', 'BlockTradesAffiliatesV1' ), __( 'View all % comments', 'BlockTradesAffiliatesV1' ) ); ?>
</span><!-- .comments-link -->
<?php endif; // comments_open() ?>
<?php edit_post_link( __( 'Edit This', 'BlockTradesAffiliatesV1' ), '<span class="edit-link">', '</span>' ); ?>
</div><!-- .entry-meta -->
</div>
</article><!-- #post -->
