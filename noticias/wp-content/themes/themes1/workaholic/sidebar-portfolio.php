<div id="sidebar" class="grid_4">
	<div class="item portfolio">
		<h4>Similar Projects</h4>
		
		<?php
		$query = "showposts=10&orderby=rand&cat=";
		
		foreach((get_the_category()) as $category) { 
    		$query .= $category->cat_ID .","; 
		}
		
		query_posts($query);
		 ?>
		 <ul>
		 	<?php while (have_posts()) : the_post(); ?>
		 	<li><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title() ?></a>
		 		<?php the_excerpt(); ?>
		 	</li>
		 	<?php endwhile; wp_reset_query(); ?>		 
		 </ul>		
	</div>
</div>
