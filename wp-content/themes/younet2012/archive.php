<?php get_header(); ?>
    
    <div id="content" class="col-full">
		<div id="main" class="col-left">
            
            <?php if (get_option('woo_woo_tumblog_switch') == 'true') { ?>
				<?php get_template_part( 'loop', 'tumblog' ); ?>
    		<?php } else { ?>
    			<?php get_template_part( 'loop', 'default' ); ?>
    		<?php } ?>
    		
			<?php woo_pagenav(); ?>
                
		</div><!-- /#main -->

        <?php get_sidebar(); ?>

    </div><!-- /#content -->
		
<?php get_footer(); ?>