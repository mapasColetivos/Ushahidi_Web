<?php global $gpp; ?>
<?php get_header(); ?>

<!-- Pagination -->
<?php if ( $paged < 1 ) { ?>

<?php if(!$gpp || $gpp['gpp_slideshow']<>"" ) { include (TEMPLATEPATH . '/apps/slideshow.php'); } ?>

<?php if ( $gpp['gpp_video'] == 'true' ) { include (TEMPLATEPATH . '/apps/video-home.php'); } ?>

<!-- Workspace Slider -->
<?php if(!$gpp || $gpp['gpp_slider']<>"" ) { include ('slider.php'); } ?>

<?php if ( $gpp['gpp_slider_posts'] == 'true' ) { include (TEMPLATEPATH . '/apps/slider-posts.php'); } ?>

<!-- Workspace Featured Module -->
<?php if(!$gpp || $gpp['gpp_featured']<>"" ) { include ('featured.php'); } ?>

<!-- End Pagination -->
<?php } ?>

<?php if ( $gpp['gpp_blog'] == 'true' ) { include (TEMPLATEPATH . '/apps/blog.php'); } ?>

<?php if(!$gpp || $gpp['gpp_category_columns']<>"" ) { include (TEMPLATEPATH . '/apps/category-columns.php'); } ?>

<!-- Footer -->
<?php get_footer(); ?>