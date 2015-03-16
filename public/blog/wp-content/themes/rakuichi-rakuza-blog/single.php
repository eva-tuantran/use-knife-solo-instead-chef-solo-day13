<?php
/** single.php
 *
 * The Template for displaying all single posts.
 *
 * @author		Konstantin Obenland
 * @package		The Bootstrap
 * @since		1.0.0 - 05.02.2012
 */

get_header(); ?>

<section id="primary" class="span8">

	<?php tha_content_before(); ?>
	<div id="content" role="main">
		<?php tha_content_top();

		while ( have_posts() ) {
			the_post(); ?>


		<?php
            //特定の日時より後に投稿されたものに関してはwpautoopをOFFにする
            if(strtotime($post->post_date) > strtotime('2013-08-05 19:00:00')){
                remove_filter('the_content', 'wpautop');
            }
			get_template_part( '/partials/content', 'single' );
			//comments_template();
		} ?>


		<nav id="nav-single" class="pager">
			<h3 class="assistive-text"><?php _e( 'Post navigation', 'the-bootstrap' ); ?></h3>
			<span class="page_prev singlePager"><?php previous_post_link( '%link', sprintf( '<span class="meta-nav">&lt;&lt;</span> %1$s', '前の記事へ' ) ); ?></span>
			<span class="page_top singlePager"><a href="<?php echo 'http://'.get_special_base_url().'/'; ?>">トップへ</a></span>
			<span class="page_next singlePager"><?php next_post_link( '%link', sprintf( '%1$s <span class="meta-nav">&gt;&gt;</span>', '次の記事へ' ) ); ?></span>
		</nav><!-- #nav-single -->
		<?php tha_content_bottom(); ?>
	</div><!-- #content -->
	<?php tha_content_after(); ?>

<?php
$cat_now = get_the_category();
$cat_now = $cat_now[0];
$cat = $cat_now->cat_ID;
query_posts('showposts=3&orderby=rand&cat='.$cat);?>
<?php if(have_posts()):?>
<div class="widget widget_recent_entries articleBox">
<div>他の記事を見る</div>
<ul>
<?php while(have_posts()):the_post();?>
<li><a href="<?php the_permalink();?>"><?php the_title();?></a></li>
<?php endwhile;?>
</ul>
</div>
<?php endif;?>

</section><!-- #primary -->

<?php
get_sidebar();
get_footer();


/* End of file index.php */
/* Location: ./wp-content/themes/the-bootstrap/single.php */
