<?php
/** index.php
 *
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @author		Konstantin Obenland
 * @package		The Bootstrap
 * @since		1.0.0 - 05.02.2012
 */
get_header(); ?>

<div id="primary" class="span8">
	<?php tha_content_before(); ?>
	<div id="content" role="main">
		<?php tha_content_top();
$count = 1;
if ( have_posts() ) :
	while ( have_posts() ) : the_post(); ?>

<?php  if ($count == 1) :
	if(1 >= get_query_var('paged')) :  ?>
	<a href="<?php the_permalink(); ?>" class="box_link">
		<div class="row-fluid info_box" style="border-top:0;">
		<div class="span6">
			<?php if ( has_post_thumbnail() ) : ?>
			<p><?php the_post_thumbnail( 'large' ); ?></p>
			<?php else : ?>
			<p><img src="http://<?php echo get_special_base_url(); ?>/wp-content/uploads/2013/03/coming_soon.png" /></p>
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
		<h2 class="subtitle"><span>新着記事</span></h2>
	<?php else : ?>
		<h2 class="subtitle"><span>新着記事</span></h2>
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
	<?php endif; ?>
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
<?php endif;$count++;
	endwhile;endif;

	the_bootstrap_content_nav( 'nav-below' );?>

	</div><!-- #content -->
	<?php tha_content_after(); ?>
</div><!-- #primary -->

<?php
get_sidebar();
get_footer();


/* End of file index.php */
/* Location: ./wp-content/themes/the-bootstrap/index.php */

