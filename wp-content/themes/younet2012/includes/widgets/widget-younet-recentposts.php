<?php
/*---------------------------------------------------------------------------------*/
/* Flickr recent posts */
/*---------------------------------------------------------------------------------*/
class Younet_recentposts extends WP_Widget {

	function Younet_recentposts() {
		$widget_ops = array( 'description' => 'This Recent posts widget fetches last posts.' );

		parent::WP_Widget(false, __( 'You Net - Recent Posts', 'woothemes' ),$widget_ops);      
	}

	function widget($args, $instance) {  
		extract( $args );
                $title = $instance['title'];
                $limit = $instance['limit']; if (!$limit) $limit = 5;
		
		echo $before_widget;
		echo $before_title; ?>
		
                <?php echo $after_title; ?>
                <?php if ($title): ?>
                    <h3><?php echo $title ?></h3>
		<?php else: ?>
                    <h3>Recent Posts</h3>
               <?php endif; ?>            
        <div class="wrap">
            <div class="fix"></div>
            
            <?php $the_query = new WP_Query('posts_per_page='.$limit); ?>
            <?php while ( $the_query->have_posts() ) : ?>
                <div class="RecentPostContainer">
                    <?php $the_query->the_post(); ?>
                    <div class="Date"><a href="<?php the_permalink(); ?>"><?php echo get_the_date(); ?> - <?php the_title(); ?></a></div>
                    <div class="Excerpt"><?php the_excerpt(); ?></div>    
                </div>
            <?php endwhile; ?>
            <div class="seeAll"><a href="/news">vedi tutte le news</a></div>
            <div class="fix"></div>
            <div class="shadow"></div>
        </div>

	   <?php			
	   echo $after_widget;
   }

   function update($new_instance, $old_instance) {                
       return $new_instance;
   }

   function form($instance) {        
		$number = esc_attr($instance['number']);
                $title = esc_attr($instance['title']);
                $limit = esc_attr($instance['limit']);
		?>
       <p>
	   	   <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title (optional):','woothemes'); ?></label>
	       <input type="text" name="<?php echo $this->get_field_name('title'); ?>"  value="<?php echo $title; ?>" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" />
       </p>
       <p>
	   	   <label for="<?php echo $this->get_field_id('limit'); ?>"><?php _e('Limit:','woothemes'); ?></label>
	       <input type="text" name="<?php echo $this->get_field_name('limit'); ?>"  value="<?php echo $limit; ?>" class="" size="3" id="<?php echo $this->get_field_id('limit'); ?>" />

       </p>        
     
		<?php
	}
} 

register_widget( 'Younet_recentposts' );
?>