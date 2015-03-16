<?php
/** 404.php
 *
 * The template for displaying 404 pages (Not Found).
 *
 * @author		Konstantin Obenland
 * @package		The Bootstrap
 * @since		1.0.0 - 07.02.2012
 */

get_header(); ?>

<section id="primary" class="span8">

	<?php tha_content_before(); ?>
	<div id="content" role="main">
		<?php tha_content_top(); ?>
		
		<?php tha_entry_before(); ?>
		<article id="post-0" class="post error404 not-found">
			<?php tha_entry_top(); ?>
			<header class="page-header">
				<h1 class="entry-title"><span style="color:#E6006E;">Not Found</span><br /> <?php _e( 'お探しの記事は見つかりませんでした。', 'the-bootstrap' ); ?></h1>
			</header><!-- .page-header -->

			<div class="entry-content">

				<p><?php //_e( 'なれたと思ったら夢だった、という方はオークファンのトピックに戻ってオークション情報を収集しましょう。', 'the-bootstrap' ); ?></p>
				<p><a href="/">トップへ</a></p>
<!-- 404 animation -->
<script type="text/javascript" charset="utf-8" src="http://<?php echo get_special_base_url(); ?>/wp-content/themes/the-bootstrap/js/published/404_animation_edgePreload.js"></script>
<style>
    .edgeLoad-EDGE-109228010 { visibility:hidden; }
</style>
<div id="Stage" class="EDGE-109228010" style="height:200px;width:300px;margin:0 auto;line-height:7.5em">	
    <div id="Stage_Ellipse" class="edgeLoad-EDGE-109228010"></div>
    <div id="Stage_EllipseCopy" class="edgeLoad-EDGE-109228010"></div>
    <div id="Stage_EllipseCopy2" class="edgeLoad-EDGE-109228010"></div>
    <div id="Stage_Text" class="edgeLoad-EDGE-109228010">4</div>
    <div id="Stage_TextCopy" class="edgeLoad-EDGE-109228010">0</div>
    <div id="Stage_TextCopy2" class="edgeLoad-EDGE-109228010">4</div>
</div>
<!-- /404 animation -->


				<?php
				//get_search_form();
				
				the_widget( 'WP_Widget_Recent_Posts', array( 'number' => 10 ), array( 'widget_id' => '404' ) );
				
				the_widget( 'WP_Widget_Categories', array(
					'title'	=>	__( 'カテゴリー', 'the-bootstrap' ),
				) );
				
				$archive_content = sprintf( _x( 'Try looking in the monthly archives. %1$s', '%1$s: smilie', 'the-bootstrap' ), convert_smilies( ':)' ) );
			/* アーカイブとタグは非表示
				the_widget( 'WP_Widget_Archives', array(
					'count'		=>	0,
					'dropdown'	=>	1
				), array(
					'after_title'	=>	"</h2><p>{$archive_content}</p>"
				) );
				
				the_widget( 'WP_Widget_Tag_Cloud' ); 
			*/
			?>
			
			</div><!-- .entry-content -->
			<?php tha_entry_bottom(); ?>
		</article><!-- #post-0 .post .error404 .not-found -->
		<?php tha_entry_after(); ?>
		
		<?php tha_content_bottom(); ?>
	</div><!-- #content -->
	<?php tha_content_after(); ?>
</section><!-- #primary -->

<?php
get_sidebar();
get_footer();


/* End of file 404.php */
/* Location: ./wp-content/themes/the-bootstrap/404.php */
