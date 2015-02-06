<?php
/** content.php
 *
 * The default template for displaying content
 *
 * @author		Konstantin Obenland
 * @package		The Bootstrap
 * @since		1.0.0 - 05.02.2012
 */
//global $i_loop_count;
//if(!isset($i_loop_count) || 0 == $i_loop_count){ $i_loop_count = 1; }

tha_entry_before(); ?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php tha_entry_top(); ?>
	

<a href="<?php the_permalink(); ?>" class="box_link">
<div class="row-fluid info_box">
<div class="span4">
	<?php if ( has_post_thumbnail() ) : ?>
	<p><?php the_post_thumbnail( 'thumbnail' ); ?></p>
	<?php else : ?>
	<p><img src="http://<?php echo get_special_base_url(); ?>/wp-content/uploads/2013/03/coming_soon.png" /></p>
	<?php endif;?>

	<?php if ( 'post' == get_post_type() ) : ?>
	<div class="article_date">
		<?php the_bootstrap_posted_on(); ?>
	</div><!-- .entry-meta -->
	<?php endif; ?>
</div>
<div class="span8">
<h3 class="topic_deco_blue"><?php the_title('','', true); ?></h3>
<?php the_excerpt(); ?>
</div>
</div>
</a>

	<?php tha_entry_bottom(); ?>
</article><!-- #post-<?php the_ID(); ?> -->
<?php tha_entry_after();


/* End of file content.php */
/* Location: ./wp-content/themes/the-bootstrap/partials/content.php */
