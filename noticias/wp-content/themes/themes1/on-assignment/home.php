<?php get_header(); ?>

<!-- Pagination -->
<?php if ( $paged < 1 ) { ?>

<?php if ( !$gpp || $gpp['gpp_welcome'] == 'true' ) { include (TEMPLATEPATH . '/apps/welcome.php'); } ?>

<?php if ( $gpp['gpp_slider'] == 'true' ) { include (TEMPLATEPATH . '/apps/slider.php'); } ?>

<?php if ( $gpp['gpp_slider_posts'] == 'true' ) { include (TEMPLATEPATH . '/apps/slider-posts.php'); } ?>

<!-- End Pagination -->
<?php } ?>

<?php if(!$gpp || $gpp['gpp_category_columns']<>"" ) { include ('category-columns.php'); } ?>

<!-- Footer -->
<?php get_footer(); ?>