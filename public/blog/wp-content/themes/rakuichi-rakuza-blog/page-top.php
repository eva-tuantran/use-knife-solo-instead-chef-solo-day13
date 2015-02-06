<?php
/** page.php
 *
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @author		Konstantin Obenland
 * @package		The Bootstrap
 * @since		1.0.0 - 07.02.2012
 */

get_header(); ?>

<div id="primary" class="span8">
	<?php tha_content_before(); ?>
	<div id="content" role="main">
		<?php tha_content_top();
		
		the_post();
		get_template_part( '/partials/content', 'page' );
		//comments_template();

		tha_content_bottom(); ?>
	</div><!-- #content -->
	<?php tha_content_after(); ?>


<?php $count = 1;
	query_posts("posts_per_page=9"); ?>
<?php if(have_posts()) :?>
<?php  while (have_posts()) : the_post(); ?>

<?php  if ($count == 1) : ?>
<a href="<?php the_permalink(); ?>" class="box_link">
	<div class="row-fluid info_box" style="border-top:0;">
	<div class="span6">
		<?php if ( has_post_thumbnail() ) : ?>
		<p><?php the_post_thumbnail( 'large' ); ?></p>
		<?php else : ?>
		<p>	<img src="http://<?php echo get_special_base_url(); ?>/wp-content/uploads/2013/03/coming_soon.png" /></p>
		<?php endif;?>
	</div>
	<div class="span6">
		<h3 class="topic_deco_blue"><?php the_title('','', true); ?></h3>
		<?php if ( 'post' == get_post_type() ) : ?>
		<div class="article_date" style="text-align:right;">
			<?php the_bootstrap_posted_on(); ?>
		</div><!-- .entry-meta -->
		<?php endif; ?>
	<?php the_excerpt(); ?>
	</div>
	</div>
</a>

	<h2 class="subtitle"><span>新着記事(top)</span></h2>
<?php  else : ?>
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
<?php endif;$count++; ?>
<?php endwhile;endif; ?>

</div><!-- #primary -->



<?php
get_sidebar();
get_footer();


/* End of file page.php */
/* Location: ./wp-content/themes/the-bootstrap/page.php */
