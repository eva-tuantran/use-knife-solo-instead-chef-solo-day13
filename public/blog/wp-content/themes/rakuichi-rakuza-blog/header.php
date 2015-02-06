<?php
/** header.php
 *
 * Displays all of the <head> section and everything up till </header>
 *
 * @author		Konstantin Obenland
 * @package		The Bootstrap
 * @since		1.0 - 05.02.2012
 */

?>
<!DOCTYPE html>
<html class="no-js" <?php language_attributes(); ?>>
	<head>
		<?php if(is_404()) : ?>
		<meta name="robots" content="noindex,nofollow" />
		<?php endif; ?>
		<?php tha_head_top(); ?>
		<link rel="profile" href="http://gmpg.org/xfn/11" />
		<meta charset="<?php bloginfo( 'charset' ); ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />

		<title><?php wp_title( '&laquo;', true, 'right' ); ?></title>

		<?php tha_head_bottom(); ?>
		<?php wp_head(); ?>
<script type='text/javascript'>
var googletag = googletag || {};
googletag.cmd = googletag.cmd || [];
(function() {
var gads = document.createElement('script');
gads.async = true;
gads.type = 'text/javascript';
var useSSL = 'https:' == document.location.protocol;
gads.src = (useSSL ? 'https:' : 'http:') + 
'//www.googletagservices.com/tag/js/gpt.js';
var node = document.getElementsByTagName('script')[0];
node.parentNode.insertBefore(gads, node);
})();
</script>
<script type='text/javascript'>
googletag.cmd.push(function() {
googletag.defineSlot('/64745063/(楽市楽座ブログ)ヘッダーバナー_468x60', [468, 60], 'div-gpt-ad-1397551141385-0').addService(googletag.pubads());
googletag.pubads().enableSingleRequest();
googletag.enableServices();
});
</script>
<script type='text/javascript'>
googletag.cmd.push(function() {
googletag.defineSlot('/64745063/(楽市楽座ブログ)レクタングル_300x250', [300, 250], 'div-gpt-ad-1397551349430-0').addService(googletag.pubads());
googletag.pubads().enableSingleRequest();
googletag.enableServices();
});
</script>
	</head>

	<body <?php body_class(); ?>>
		<div class="container">
<div class="row-fluid" id="header_part">
<div class="span12">

	<div id="head_logo_area">
		<div class="row-fluid">
			<div id="header_logo">
				<a href="http://<?php echo get_special_base_url(); ?>/"><img src="http://<?php echo get_special_base_url(); ?>/wp-content/uploads/2014/04/rakuichi-logo.png" alt="フリーマーケット情報の楽市楽座" /></a>
			</div>
			<div id="header_top_ad">
<!-- (楽市楽座ブログ)ヘッダーバナー_468x60 -->
<div id='div-gpt-ad-1397551141385-0' style='width:468px; height:60px; float:right;'>
<script type='text/javascript'>
googletag.cmd.push(function() { googletag.display('div-gpt-ad-1397551141385-0'); });
</script>
</div>

			</div>
		</div>
	</div>
	<div class="breadcrumbs">
	<a title="フリーマーケット情報の楽市楽座" href="http://www.rakuichi-rakuza.jp/"><i class="icon-home"></i> 楽市楽座</a>
	<?php if(function_exists('bcn_display'))
	{
		bcn_display();
	}?>
	</div>
</div>
</div>
			<div id="page" class="hfeed row">


<?php
tha_header_after();
/* End of file header.php */
/* Location: ./wpjcontent/themes/the-bootstrap/header.php */
