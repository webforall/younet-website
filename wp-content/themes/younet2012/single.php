<?php get_header(); ?>
<?php global $woo_options; ?>
       
    <div id="content" class="col-full">
		<div id="main" class="col-left">
		           
			<?php if (get_option('woo_woo_tumblog_switch') == 'true') { ?>
				<?php get_template_part( 'loop', 'tumblog' ); ?>
    		<?php } else { ?>
    			<?php get_template_part( 'loop', 'default' ); ?>
    		<?php } ?>
        
		</div><!-- #main -->

        <?php get_sidebar(); ?>

    </div><!-- #content -->
		
<?php get_footer(); ?>