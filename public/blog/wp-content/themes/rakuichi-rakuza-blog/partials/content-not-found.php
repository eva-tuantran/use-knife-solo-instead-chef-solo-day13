<?php
/** content-not-found.php
 *
 * The template for displaying a 'Nothing found' message.
 *
 * @author		Konstantin Obenland
 * @package		The Bootstrap
 * @since		1.0.0 - 07.02.2012
 */


tha_entry_before(); ?>
<article id="post-0" class="post no-results not-found">
	<?php tha_entry_top(); ?>
	
<div id="content" role="main">
	<header class="page-header">
		<h1 class="page-title" style="font-size:18px;"><?php printf( __( '「%s」を含んだ記事は見つかりませんでした', 'the-bootstrap' ), '<span>' . get_search_query() . '</span>'); ?></h1>
	</header>

	<div class="entry-content">
		<?php if ( is_search() ): ?>
		<p><?php _e( '検索キーワードを変更して検索をお試しください', 'the-bootstrap' ); ?></p>
		<?php get_search_form();
		endif;?>
	</div><!-- .entry-content -->
</div>

	<?php tha_entry_bottom(); ?>
</article><!-- #post-0 -->
<?php tha_entry_after();


/* End of file content-not-found.php */
/* Location: ./wp-content/themes/the-bootstrap/partials/content-not-found.php */
