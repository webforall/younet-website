<?php 
/**
 * Woothemes Tumblog Functionality
 * Custom RSS Feed
 *
 * @version 2.0.0
 *
 * @package WooFramework
 * @subpackage Tumblog
 */
 
header('Content-Type: ' . feed_content_type('rss-http') . '; charset=' . get_option('blog_charset'), true);
$more = 1;

echo '<?xml version="1.0" encoding="'.get_option('blog_charset').'"?'.'>'; ?>

<rss version="2.0"
	xmlns:content="http://purl.org/rss/1.0/modules/content/"
	xmlns:wfw="http://wellformedweb.org/CommentAPI/"
	xmlns:dc="http://purl.org/dc/elements/1.1/"
	xmlns:atom="http://www.w3.org/2005/Atom"
	xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"
	xmlns:slash="http://purl.org/rss/1.0/modules/slash/"
	<?php do_action('rss2_ns'); ?>
>

<channel>
	<title><?php bloginfo_rss('name'); wp_title_rss(); ?></title>
	<atom:link href="<?php self_link(); ?>" rel="self" type="application/rss+xml" />
	<link><?php bloginfo_rss('url') ?></link>
	<description><?php bloginfo_rss("description") ?></description>
	<lastBuildDate><?php echo mysql2date('D, d M Y H:i:s +0000', get_lastpostmodified('GMT'), false); ?></lastBuildDate>
	<?php the_generator( 'rss2' ); ?>
	<language><?php echo get_option('rss_language'); ?></language>
	<sy:updatePeriod><?php echo apply_filters( 'rss_update_period', 'hourly' ); ?></sy:updatePeriod>
	<sy:updateFrequency><?php echo apply_filters( 'rss_update_frequency', '1' ); ?></sy:updateFrequency>
	<?php do_action('rss2_head'); ?>
	<?php $tumblog_items = array(	'articles'	=> get_option('woo_articles_term_id'),
							'images' 	=> get_option('woo_images_term_id'),
							'audio' 	=> get_option('woo_audio_term_id'),
							'video' 	=> get_option('woo_video_term_id'),
							'quotes'	=> get_option('woo_quotes_term_id'),
							'links' 	=> get_option('woo_links_term_id')
							);
	?>
	<?php while( have_posts()) : the_post(); ?>
	<?php $id = get_the_ID(); ?>
           	
    <?php 
    // Test for Post Formats
	if (get_option('woo_tumblog_content_method') == 'post_format') {
	    
	    if ( has_post_format( 'aside' , $id )) {
  	    	$tumblog_results = 'article';
  	    	$sentinel = true;
	    } elseif (has_post_format( 'image' , $id )) {
	    	$tumblog_results = 'image';
	    	$sentinel = true;
	    } elseif (has_post_format( 'audio' , $id )) {
	    	$tumblog_results = 'audio';
	    	$sentinel = true;
	    } elseif (has_post_format( 'video' , $id )) {
	    	$tumblog_results = 'video';
	    	$sentinel = true;
	    } elseif (has_post_format( 'quote' , $id )) {
	    	$tumblog_results = 'quote';
	    	$sentinel = true;
	    } elseif (has_post_format( 'link' , $id )) {
	    	$tumblog_results = 'link';
	    	$sentinel = true;
	    } else {
	    	$tumblog_results = 'default';
	    	$sentinel = false;
	    }
	
	} else {
    	//switch between tumblog taxonomies
		$tumblog_list = get_the_term_list( $id, 'tumblog', '' , '|' , ''  );
		$tumblog_list = strip_tags($tumblog_list);
		$tumblog_array = explode('|', $tumblog_list);
		$tumblog_results = '';
		$sentinel = false;
		foreach ($tumblog_array as $location_item) {
		    $tumblog_id = get_term_by( 'name', $location_item, 'tumblog' );
		    if ( $tumblog_items['articles'] == $tumblog_id->term_id && !$sentinel ) {
		    	$tumblog_results = 'article';
		    	$sentinel = true;
		    } elseif ($tumblog_items['images'] == $tumblog_id->term_id && !$sentinel ) {
		    	$tumblog_results = 'image';
		    	$sentinel = true;
		    } elseif ($tumblog_items['audio'] == $tumblog_id->term_id && !$sentinel) {
		    	$tumblog_results = 'audio';
		    	$sentinel = true;
		    } elseif ($tumblog_items['video'] == $tumblog_id->term_id && !$sentinel) {
		    	$tumblog_results = 'video';
		    	$sentinel = true;
		    } elseif ($tumblog_items['quotes'] == $tumblog_id->term_id && !$sentinel) {
		    	$tumblog_results = 'quote';
		    	$sentinel = true;
		    } elseif ($tumblog_items['links'] == $tumblog_id->term_id && !$sentinel) {
		    	$tumblog_results = 'link';
		    	$sentinel = true;
		    } else {
		    	$tumblog_results = 'default';
		    	$sentinel = false;
		    }	    		
		}  
	}         	
    ?>
	<?php if ($tumblog_results == 'article') { ?> 
    	<item>
			<title><?php the_title_rss() ?></title>
			<link><?php the_permalink_rss() ?></link>
			<comments><?php comments_link(); ?></comments>
			<pubDate><?php echo mysql2date('D, d M Y H:i:s +0000', get_post_time('Y-m-d H:i:s', true), false); ?></pubDate>
			<dc:creator><?php the_author() ?></dc:creator>
			<?php the_category_rss(); ?>
			<?php $postid = get_the_ID(); ?>
			<guid isPermaLink="false"><?php the_guid(); ?></guid>
			<?php if (get_option('rss_use_excerpt')) : ?>
			<description><![CDATA[<?php woo_custom_rss_default_output($postid);the_excerpt_rss();woo_custom_rss_comments_link(); ?>]]></description>
			<?php else : ?>
			<description><![CDATA[<?php woo_custom_rss_default_output($postid);the_excerpt_rss();woo_custom_rss_comments_link(); ?>]]></description>
			<?php if ( strlen( $post->post_content ) > 0 ) : ?>
			<content:encoded><![CDATA[<?php woo_custom_rss_default_output($postid);the_content_feed('rss2');woo_custom_rss_comments_link(); ?>]]></content:encoded>
			<?php else : ?>
			<content:encoded><![CDATA[<?php woo_custom_rss_default_output($postid);the_excerpt_rss();woo_custom_rss_comments_link(); ?>]]></content:encoded>
			<?php endif; ?>
			<?php endif; ?>
			<wfw:commentRss><?php echo get_post_comments_feed_link(null, 'rss2'); ?></wfw:commentRss>
			<slash:comments><?php echo get_comments_number(); ?></slash:comments>
			<?php rss_enclosure(); ?>
			<?php do_action('rss2_item'); ?>
		</item>			
    <?php } elseif ($tumblog_results == 'image') { ?>
    		<item>
			<title><?php the_title_rss() ?></title>
			<link><?php the_permalink_rss() ?></link>
			<comments><?php comments_link(); ?></comments>
			<pubDate><?php echo mysql2date('D, d M Y H:i:s +0000', get_post_time('Y-m-d H:i:s', true), false); ?></pubDate>
			<dc:creator><?php the_author() ?></dc:creator>
			<?php the_category_rss(); ?>
			<?php $postid = get_the_ID(); ?>
			<guid isPermaLink="false"><?php the_guid(); ?></guid>
			<?php if (get_option('rss_use_excerpt')) : ?>
			<description><![CDATA[<?php woo_custom_rss_image_output($postid);the_excerpt_rss();woo_custom_rss_comments_link(); ?>]]></description>
			<?php else : ?>
			<description><![CDATA[<?php woo_custom_rss_image_output($postid);the_excerpt_rss();woo_custom_rss_comments_link(); ?>]]></description>
			<?php if ( strlen( $post->post_content ) > 0 ) : ?>
			<content:encoded><![CDATA[<?php woo_custom_rss_image_output($postid);the_content_feed('rss2');woo_custom_rss_comments_link(); ?>]]></content:encoded>
			<?php else : ?>
			<content:encoded><![CDATA[<?php woo_custom_rss_image_output($postid);the_excerpt_rss();woo_custom_rss_comments_link(); ?>]]></content:encoded>
			<?php endif; ?>
			<?php endif; ?>
			<wfw:commentRss><?php echo get_post_comments_feed_link(null, 'rss2'); ?></wfw:commentRss>
			<slash:comments><?php echo get_comments_number(); ?></slash:comments>
			<?php rss_enclosure(); ?>
			<?php do_action('rss2_item'); ?>
		</item>		
    <?php } elseif ($tumblog_results == 'video') { ?>
    	<item>
			<title><?php the_title_rss() ?></title>
			<link><?php the_permalink_rss() ?></link>
			<comments><?php comments_link(); ?></comments>
			<pubDate><?php echo mysql2date('D, d M Y H:i:s +0000', get_post_time('Y-m-d H:i:s', true), false); ?></pubDate>
			<dc:creator><?php the_author() ?></dc:creator>
			<?php the_category_rss(); ?>
			<?php $postid = get_the_ID(); ?>
			<guid isPermaLink="false"><?php the_guid(); ?></guid>
			<?php if (get_option('rss_use_excerpt')) : ?>
			<description><![CDATA[<?php woo_custom_rss_video_output($postid); the_excerpt_rss();woo_custom_rss_comments_link(); ?>]]></description>
			<?php else : ?>
			<description><![CDATA[<?php woo_custom_rss_video_output($postid); the_excerpt_rss();woo_custom_rss_comments_link(); ?>]]></description>
			<?php if ( strlen( $post->post_content ) > 0 ) : ?>
			<content:encoded><![CDATA[<?php woo_custom_rss_video_output($postid); the_content_feed('rss2');woo_custom_rss_comments_link(); ?>]]></content:encoded>
			<?php else : ?>
			<content:encoded><![CDATA[<?php woo_custom_rss_video_output($postid); the_excerpt_rss();woo_custom_rss_comments_link(); ?>]]></content:encoded>
			<?php endif; ?>
			<?php endif; ?>
			<wfw:commentRss><?php echo get_post_comments_feed_link(null, 'rss2'); ?></wfw:commentRss>
			<slash:comments><?php echo get_comments_number(); ?></slash:comments>
			<?php rss_enclosure(); ?>
			<?php do_action('rss2_item'); ?>
		</item>	
    			
    <?php } elseif ($tumblog_results == 'link') { ?>
    	<item>
			<title><?php the_title_rss() ?></title>
			<link><?php the_permalink_rss() ?></link>
			<comments><?php comments_link(); ?></comments>
			<pubDate><?php echo mysql2date('D, d M Y H:i:s +0000', get_post_time('Y-m-d H:i:s', true), false); ?></pubDate>
			<dc:creator><?php the_author() ?></dc:creator>
			<?php the_category_rss(); ?>
			<?php $postid = get_the_ID(); ?>
			<guid isPermaLink="false"><?php the_guid(); ?></guid>
			<?php if (get_option('rss_use_excerpt')) : ?>
			<description><![CDATA[<?php woo_custom_rss_link_output($postid); the_excerpt_rss();woo_custom_rss_comments_link(); ?>]]></description>
			<?php else : ?>
			<description><![CDATA[<?php woo_custom_rss_link_output($postid); the_excerpt_rss();woo_custom_rss_comments_link(); ?>]]></description>
			<?php if ( strlen( $post->post_content ) > 0 ) : ?>
			<content:encoded><![CDATA[<?php woo_custom_rss_link_output($postid); the_content_feed('rss2');woo_custom_rss_comments_link(); ?>]]></content:encoded>
			<?php else : ?>
			<content:encoded><![CDATA[<?php woo_custom_rss_link_output($postid); the_excerpt_rss();woo_custom_rss_comments_link(); ?>]]></content:encoded>
			<?php endif; ?>
			<?php endif; ?>
			<wfw:commentRss><?php echo get_post_comments_feed_link(null, 'rss2'); ?></wfw:commentRss>
			<slash:comments><?php echo get_comments_number(); ?></slash:comments>
			<?php rss_enclosure(); ?>
			<?php do_action('rss2_item'); ?>
		</item>			
    <?php } elseif ($tumblog_results == 'audio') { ?>
   		<item>
			<title><?php the_title_rss() ?></title>
			<link><?php the_permalink_rss() ?></link>
			<comments><?php comments_link(); ?></comments>
			<pubDate><?php echo mysql2date('D, d M Y H:i:s +0000', get_post_time('Y-m-d H:i:s', true), false); ?></pubDate>
			<dc:creator><?php the_author() ?></dc:creator>
			<?php the_category_rss(); ?>
			<?php $postid = get_the_ID(); ?>
			<guid isPermaLink="false"><?php the_guid(); ?></guid>
			<?php if (get_option('rss_use_excerpt')) : ?>
			<description><![CDATA[<?php woo_custom_rss_audio_output($postid); the_excerpt_rss();woo_custom_rss_comments_link(); ?>]]></description>
			<?php else : ?>
			<description><![CDATA[<?php woo_custom_rss_audio_output($postid); the_excerpt_rss();woo_custom_rss_comments_link(); ?>]]></description>
			<?php if ( strlen( $post->post_content ) > 0 ) : ?>
			<content:encoded><![CDATA[<?php woo_custom_rss_audio_output($postid); the_content_feed('rss2');woo_custom_rss_comments_link(); ?>]]></content:encoded>
			<?php else : ?>
			<content:encoded><![CDATA[<?php woo_custom_rss_audio_output($postid); the_excerpt_rss();woo_custom_rss_comments_link(); ?>]]></content:encoded>
			<?php endif; ?>
			<?php endif; ?>
			<wfw:commentRss><?php echo get_post_comments_feed_link(null, 'rss2'); ?></wfw:commentRss>
			<slash:comments><?php echo get_comments_number(); ?></slash:comments>
			<?php rss_enclosure(); ?>
			<?php do_action('rss2_item'); ?>
		</item>		
    <?php } elseif ($tumblog_results == 'quote') { ?>
    	<item>
			<title><?php the_title_rss() ?></title>
			<link><?php the_permalink_rss() ?></link>
			<comments><?php comments_link(); ?></comments>
			<pubDate><?php echo mysql2date('D, d M Y H:i:s +0000', get_post_time('Y-m-d H:i:s', true), false); ?></pubDate>
			<dc:creator><?php the_author() ?></dc:creator>
			<?php the_category_rss(); ?>
			<?php $postid = get_the_ID(); ?>
			<guid isPermaLink="false"><?php the_guid(); ?></guid>
			<?php if (get_option('rss_use_excerpt')) : ?>
			<description><![CDATA[<?php woo_custom_rss_quote_output($postid); the_excerpt_rss();woo_custom_rss_comments_link(); ?>]]></description>
			<?php else : ?>
			<description><![CDATA[<?php woo_custom_rss_quote_output($postid); the_excerpt_rss();woo_custom_rss_comments_link(); ?>]]></description>
			<?php if ( strlen( $post->post_content ) > 0 ) : ?>
			<content:encoded><![CDATA[<?php woo_custom_rss_quote_output($postid); the_content_feed('rss2');woo_custom_rss_comments_link(); ?>]]></content:encoded>
			<?php else : ?>
			<content:encoded><![CDATA[<?php woo_custom_rss_quote_output($postid); the_excerpt_rss();woo_custom_rss_comments_link(); ?>]]></content:encoded>
			<?php endif; ?>
			<?php endif; ?>
			<wfw:commentRss><?php echo get_post_comments_feed_link(null, 'rss2'); ?></wfw:commentRss>
			<slash:comments><?php echo get_comments_number(); ?></slash:comments>
			<?php rss_enclosure(); ?>
			<?php do_action('rss2_item'); ?>
		</item>					
    <?php } else { ?>
    	<item>
			<title><?php the_title_rss() ?></title>
			<link><?php the_permalink_rss() ?></link>
			<comments><?php comments_link(); ?></comments>
			<pubDate><?php echo mysql2date('D, d M Y H:i:s +0000', get_post_time('Y-m-d H:i:s', true), false); ?></pubDate>
			<dc:creator><?php the_author() ?></dc:creator>
			<?php the_category_rss(); ?>
			<?php $postid = get_the_ID(); ?>
			<guid isPermaLink="false"><?php the_guid(); ?></guid>
			<?php if (get_option('rss_use_excerpt')) : ?>
			<description><![CDATA[<?php woo_custom_rss_default_output($postid);the_excerpt_rss();woo_custom_rss_comments_link(); ?>]]></description>
			<?php else : ?>
			<description><![CDATA[<?php woo_custom_rss_default_output($postid);the_excerpt_rss();woo_custom_rss_comments_link(); ?>]]></description>
			<?php if ( strlen( $post->post_content ) > 0 ) : ?>
			<content:encoded><![CDATA[<?php woo_custom_rss_default_output($postid);the_content_feed('rss2');woo_custom_rss_comments_link(); ?>]]></content:encoded>
			<?php else : ?>
			<content:encoded><![CDATA[<?php woo_custom_rss_default_output($postid);the_excerpt_rss();woo_custom_rss_comments_link(); ?>]]></content:encoded>
			<?php endif; ?>
			<?php endif; ?>
			<wfw:commentRss><?php echo get_post_comments_feed_link(null, 'rss2'); ?></wfw:commentRss>
			<slash:comments><?php echo get_comments_number(); ?></slash:comments>
			<?php rss_enclosure(); ?>
			<?php do_action('rss2_item'); ?>
		</item>		
	<?php } ?>
	
	<?php endwhile; ?>
</channel>
</rss>

<?php 

function woo_custom_rss_default_output($post_id) {
	?><?php woo_custom_rss_category_link($post_id); ?><?php
}

function woo_custom_rss_image_output($post_id) {

if (get_option('woo_image_link_to') == 'image') {
  					?><?php woo_custom_rss_category_link($post_id); ?><p><a href="<?php echo get_post_meta($post_id, "image", true); ?>" title="image" rel="lightbox"><?php woo_image('key=image&width='.get_option('woo_single_w').'px&link=img'); ?></a></p><?php  
  					} else { ?>
    	    		<?php woo_custom_rss_category_link($post_id); ?><p><a href="<?php the_permalink(); ?>" title="image">
    	    		<?php echo woo_image('key=image&width='.get_option('woo_single_w').'px&link=img'); ?>
    	    		</a></p><?php }
}

function woo_custom_rss_video_output($post_id) {
	?>
	<?php woo_custom_rss_category_link($post_id); ?><p><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title(); ?>" target="_blank"><?php echo _e('View Video', 'woothemes'); ?></a></p><p><?php echo woo_get_embed('video-embed', '400', ''); ?></p>
	<?php
}


function woo_custom_rss_quote_output($post_id) {
	?>
	<?php woo_custom_rss_category_link($post_id); ?><p><cite><?php echo get_post_meta($post_id,'quote-copy',true); _e(' ~ ', 'woothemes'); ?><a href="<?php echo get_post_meta($post_id,'quote-url',true); ?>" title="<?php the_title(); ?>"><?php echo get_post_meta($post_id,'quote-author',true); ?></a></cite></p>
	<?php
}

function woo_custom_rss_link_output($post_id) {
	?>
	<?php woo_custom_rss_category_link($post_id); ?><p><a href="<?php echo get_post_meta($post_id,'link-url',true); ?>" rel="bookmark" title="<?php the_title(); ?>" target="_blank"><?php echo get_post_meta($post_id,'link-url',true); ?></a></p>
	<?php
}

function woo_custom_rss_audio_output($post_id) {
	
					//Post Args
					$args = array(
						'post_type' => 'attachment',
						'numberposts' => -1,
						'post_status' => null,
						'post_parent' => $post_id
					);
					//Get attachements 
					$attachments = get_posts($args);
					if ($attachments) {
						foreach ($attachments as $attachment) {
							$link_url= $attachment->guid;
						}
					}
					else {
						$link_url = get_post_meta($post_id,'audio',true);
					}
					if(!empty($link_url)) {
					?>
						<?php woo_custom_rss_category_link($post_id); ?><p><a href="<?php echo $link_url; ?>" rel="bookmark" title="<?php the_title(); ?>" target="_blank"><?php echo _e('Play Audio', 'woothemes'); ?></a></p>
					<?php }
}

function woo_custom_rss_category_link($post_id) {
	?><p>Posted in <?php the_category(',','multiple',$post_id); ?></p><?php
}

function woo_custom_rss_comments_link() {
	?><p><?php comments_popup_link(__('Leave a Comment', 'woothemes'), __('Leave a Comment', 'woothemes'), __('Leave a Comment', 'woothemes')); ?></p><?php
}

?>