<?php
/**
 * Posts Loop
 *
 * This file is responsible for outputting the
 * blog posts as well as filter options (if
 * the user is viewing the frontpage). 
 *
 * In the event that the html needs to be modified,
 * this template may be duplicated inside a child theme
 * and edited there.
 *
 * @package      Shaken Grid (Premium)
 * @since        1.0
 * @alter        2.0
 *
 ***************************************************************
 ***************************************************************
 *
 * Post Filters
 *
 * Displays filter options if on frontpage and if they aren't 
 * disabled in the theme options. The filters are based on
 * the categories. Each post has its category slug assigned
 * as class names. The Isotope plugin handles the filtering.
 */ ?>

<?php if(is_home() && !of_get_option('hide_filters')) { ?>
	<div id="filtering-nav">
		<a href="#" class="filter-btn"><span><?php _e('Filter', 'shaken'); ?></span></a>
      	<ul>
   			<li><a href="#" data-filter="*"><?php _e('All', 'shaken'); ?></a></li>
        	<?php
         	$args=array(
          		'orderby' => 'name',
          		'hierarchical' => 0
          	);
          	$categories=get_categories($args);
          	foreach($categories as $category) {  ?>
            	<li><a href="#" data-filter=".<?php echo $category->category_nicename; ?>"><?php echo $category->name; ?></a></li>
        	<?php } ?>
    	</ul>
        <div class="clearfix"></div>
	</div><!-- #filtering-nav -->
<?php } ?>

<?php 
/**
 * Display ALL posts
 *
 * If this is the homepage and the "show all posts on blog" option
 * is checked in the theme options, then display all posts on one 
 * page without pagination.
 */ 
if( is_home() && !is_search() && ( of_get_option( 'show_all' ) || of_get_option( 'frontpage_category' ) ) ):
	
	$query_string = false;
	
	if( of_get_option('show_all') ){
		$query_string = 'posts_per_page=-1';
	}
	
	if( of_get_option('frontpage_category') && of_get_option('frontpage_category') != 'all' ){
	
		if(of_get_option('show_all')){
			$query_string .= '&';
		}
		
		$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
		$query_string .= 'cat='.of_get_option('frontpage_category').'&paged='.$paged;
	}
	
	if( $query_string ){
		query_posts($query_string);
	}
	
endif;

/* Say hello to the Loop... */
if ( have_posts() ) : 

/* Anything placed in #sort is positioned by jQuery Masonry */ ?>
<div class="sort">
    
    <?php // Display sidebar if it has widgets assigned to it
    if( is_active_sidebar( 'gallery-sidebar' ) ) : ?>
        <div class="all box col2" id="gallery-sidebar">
            <div class="box-content">
                <?php get_sidebar(); ?>
            </div>
        </div>
    <?php endif; ?>
    
    <?php // Display ads set in theme options
    get_template_part( 'includes/ads'); ?>
    
    <?php while ( have_posts() ) : the_post(); 
    	
    	global $my_size, $force_feat_img, $embed_code, $vid_url;
    	
        // Gather custom fields
        $embed_code = get_post_meta($post->ID, 'soy_vid', true);
        $vid_url = get_post_meta($post->ID, 'soy_vid_url', true);
        $force_feat_img = get_post_meta($post->ID, 'soy_hide_vid', true);
        $show_title = get_post_meta($post->ID, 'soy_show_title', true);
        $show_desc = get_post_meta($post->ID, 'soy_show_desc', true);
        $box_size = get_post_meta($post->ID, 'soy_box_size', true); 
        
        if( $box_size == 'Medium (485px)' ){
            $my_size = 'col3';
            $embed_size = '495';
        } else if( $box_size == 'Large (700px)' ){
            $my_size = 'col4';
            $embed_size = '700';
        } else if( $box_size == 'Tiny (135px)' ){
            $my_size = 'col1';
            $embed_size = '145';
        }else{
            $my_size = 'col2';
            $embed_size = '310';
        }
        
        /* Check whether content is being displayed
         * This determines whether a border should be applied
         * above the postmeta section
        */
        if($show_title != 'No'){
            $content_class = 'has-content';
        } else if($show_desc != 'No' && $post->post_content){
            $content_class = 'has-content';
        }else {
            $content_class = 'no-content';
        }
        
        // Assign categories as class names to enable filtering
        $category_classes = '';
        
        foreach( ( get_the_category() ) as $category ) {
            $category_classes .= $category->category_nicename . ' ';
        } 
    ?>
    
    <div class="all box <?php echo $category_classes . $my_size; ?>">
        
        <div <?php post_class( 'box-content '.$content_class ) ?>>
            <?php 
            // Display video if available
            if( ( $embed_code || $vid_url ) && !$force_feat_img ):
            
            	if( $vid_url ){
            		echo '<div class="vid-container">'.apply_filters('the_content', '[embed width="' . $embed_size . '"]' . $vid_url . '[/embed]').'</div>';
            	} else {
            		echo '<div class="vid-container">'.$embed_code.'</div>';
            	} 
            
            // Display gallery
            elseif( has_post_format( 'gallery' ) && !$force_feat_img ):
            
            	get_template_part( 'includes/loop-gallery' );
            
            // Display featured image
            elseif ( has_post_thumbnail() ): ?>
            
                <div class="img-container">    
                    <?php 
                    // Display the appropriate sized featured image
                    if( $my_size != 'col2' ): ?>
                        <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail($my_size, array( 'class' => 'feat-img' ) ); ?></a>
                    <?php else: ?>
                        <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('post-thumbnail', array( 'class' => 'feat-img' ) ); ?></a>
                    <?php endif;

                   // Display View/Share/Comment buttons
                    if( !of_get_option( 'hide_action_buttons' ) ) :                    
                    	get_template_part( 'includes/action-buttons' );               

		    endif; ?>
 	         </div><!-- #img-container -->
 
             <?php if( has_post_format( 'gallery' ) ) get_template_part( 'includes/gallery-list' ); ?>
            <?php endif; // #has_post_thumbnail() ?>
            

            
            <div class="post-content">
            
	            <?php // Display post title
	            if( $show_title != 'No' && !has_post_format('quote') ): ?>
	                <h2><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" rel="bookmark">
	                	<?php the_title(); ?>
	                </a></h2>
	            <?php endif; 
	            
	            // Display post content
	            if( is_search() && $show_desc != 'No' ):  
	            
	            	the_excerpt();  // Only display excerpts for search results

	            elseif( $show_desc != 'No' ):
	            
	                if( has_excerpt() ){ 
	                    the_excerpt();         
			} else{
	                    the_content(__('Leia + &rarr;', 'shaken'));
	                }
	                
	            endif; ?>

	                         

	            <?php edit_post_link(__('Edite este post (só administradores)', 'shaken')); ?>    
            </div><!-- #entry -->
            
            <?php // Display post footer
            if( $my_size != 'col1' ): ?>
                <div class="post-footer">
                   <!-- <span class="category-ic"><?php the_category(', '); ?></span> -->
                    <a href="<?php echo wp_get_shortlink(); ?>" class="shortlink tooltip" title="Shortlink"><?php _e('Shortlink', 'shaken'); ?></a>
</div>  		
            <?php endif; ?>
          

        </div><!-- #box-content -->
    </div><!-- #box -->
    <?php endwhile; ?>
</div><!-- #sort -->

<?php // Display pagination when applicable
if (  $wp_query->max_num_pages > 1 ) : ?>
	<div id="nav-below" class="navigation">
        <div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> + antigos', 'shaken') ); ?></div>
        <div class="nav-next"><?php previous_posts_link( __( '+ recentes <span class="meta-nav">&rarr;</span>', 'shaken') ); ?></div>
        <div class="clearfix"></div>
    </div><!-- #nav-below -->
<?php endif; ?>

<?php else :
/* If there are no posts */ ?>
<div id="sort">
    <div class="box">
        <h2><?php _e('Nenhum post encontrado', 'shaken'); ?></h2>
        <?php get_search_form(); ?>
    </div>
</div><!-- #sort -->
<?php endif; ?>