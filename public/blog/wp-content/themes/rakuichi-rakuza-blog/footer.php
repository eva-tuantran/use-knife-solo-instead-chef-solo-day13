<?php
/** footer.php
 *
 * @author		Konstantin Obenland
 * @package		The Bootstrap
 * @since		1.0.0	- 05.02.2012
 */
?>
			</div><!-- #page -->

			<?php	tha_footer_before(); ?>
				<footer id="colophon" role="contentinfo" class="">
					<?php tha_footer_top(); ?>
					<div id="page-footer">
						<?php wp_nav_menu( array(
							'container'			=>	'nav',
							'container_class'	=>	'subnav',
							'theme_location'	=>	'footer-menu',
							'menu_class'		=>	'credits nav nav-pills pull-left',
							'depth'				=>	3,
							'fallback_cb'		=>	'the_bootstrap_credits',
							'walker'			=>	new The_Bootstrap_Nav_Walker,
						) );
						?>
					<p id="copyright"><a href="http://aucfan.com">&copy; 2013<?php //echo date('Y'); ?> Aucfan Co.,Ltd.</a></p>			
					</div><!-- #page-footer -->
					<?php tha_footer_bottom(); ?>
				</footer><!-- #colophon -->
				<?php tha_footer_after(); ?>

		</div><!-- .container -->


	<!-- <?php printf( __( '%d queries. %s seconds.', 'the-bootstrap' ), get_num_queries(), timer_stop(0, 3) ); ?> -->
	<?php wp_footer(); ?>
	<script type="text/javascript" src="http://aucfan.com/inc/analytics.js"></script>
	</body>
</html>
<?php


/* End of file footer.php */
/* Location: ./wp-content/themes/the-bootstrap/footer.php */