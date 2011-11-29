<?php get_header(); ?>
<?php 	$blog_cat = html_entity_decode(get_option('T_blog_cat'));
		$blog_ID = get_cat_ID($blog_cat); ?>

	<div id="content" class="<?php if(!is_category($blog_ID)) { ?>grid_12<?php }else{ ?>grid_8<?php } ?>">

		<?php if (have_posts()) : ?>

 	  <?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
 	  <?php /* If this is a category archive */ if (is_category()) { ?>
		<h2 class="pagetitle"><?php single_cat_title(); ?></h2>
 	  <?php /* If this is a tag archive */ } elseif( is_tag() ) { ?>
		<h2 class="pagetitle">Posts Tagged &#8216;<?php single_tag_title(); ?>&#8217;</h2>
 	  <?php /* If this is a daily archive */ } elseif (is_day()) { ?>
		<h2 class="pagetitle">Archive for <?php the_time('F jS, Y'); ?></h2>
 	  <?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
		<h2 class="pagetitle">Archive for <?php the_time('F, Y'); ?></h2>
 	  <?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
		<h2 class="pagetitle">Archive for <?php the_time('Y'); ?></h2>
	  <?php /* If this is an author archive */ } elseif (is_author()) { ?>
		<h2 class="pagetitle">Author Archive</h2>
 	  <?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
		<h2 class="pagetitle">Blog Archives</h2>
 	  <?php } ?>
 	  
 	  
 	  
 	  <?php if(!is_category($blog_ID)) {  // if not blog category ?>
 	  
 	  <?php $i=0;
			
		while (have_posts()) : the_post();$i++;?>	
						
			<div class="portfolio grid_4<?php if ($i == 1) { ?> alpha<?php } else if($i==3) {?> omega<?php $i = 0;} ?>">
				<h4><a href="<?php the_permalink(); ?>" class="thumb">
                    <?php get_the_image( array( 'custom_key' => array( 'thumbnail' ), 'default_size' => 'thumbnail', 'width' => '284', 'height' => '150', 'link_to_post' => false ) ); ?>						
						<span class="title"><?php the_title(); ?></span></a><span class="category"><?php the_category(' + '); ?></span></h4>
			</div>		

		<?php endwhile; ?>
	
		<div class="navigation">
			<div class="next"><?php next_posts_link('Next &rarr;') ?></div>
			<div class="prev"><?php previous_posts_link('&larr; Previous') ?></div>
		</div>	
 	  
 	  <?php } else {  // if blog ?>
 	  
 	 
		<?php while (have_posts()) : the_post(); ?>
		<div <?php post_class() ?>>
				<small><?php the_time('l, F jS, Y') ?></small>
				<h3 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
				
				
				<div class="entry">
					<?php the_content() ?>
				</div>

				<p class="postmetadata"><?php the_tags('Tags: ', ', ', '<br />'); ?> Posted in <?php the_category(', ') ?> | <?php edit_post_link('Edit', '', ' | '); ?>  <?php comments_popup_link('Post your Thoughts &rarr;', '1 Thought &rarr;', '% Thoughts &rarr;'); ?></p>

		</div>
		<hr class="dotted" />

		<?php endwhile; ?>
	
		<div class="navigation-archive">
			<div class="next"><?php next_posts_link('Next &rarr;') ?></div>
			<div class="prev"><?php previous_posts_link('&larr; Previous') ?></div>
		</div>	
		
		<?php } ?>
		
	
	<?php else :

		if ( is_category() ) { // If this is a category archive
			printf("<h2 class='center'>Sorry, but there aren't any posts in the %s category yet.</h2>", single_cat_title('',false));
		} else if ( is_date() ) { // If this is a date archive
			echo("<h2>Sorry, but there aren't any posts with this date.</h2>");
		} else if ( is_author() ) { // If this is a category archive
			$userdata = get_userdatabylogin(get_query_var('author_name'));
			printf("<h2 class='center'>Sorry, but there aren't any posts by %s yet.</h2>", $userdata->display_name);
		} else {
			echo("<h2 class='center'>No posts found.</h2>");
		}
		//get_search_form();

	endif;
?>

	</div>
<?php if(is_category($blog_ID)) { // if not blog category 
get_sidebar(); } ?>

<?php get_footer(); ?>
