<?php 
/*
 * Returns the ads set in the theme options panel
 * @since 1.6.0
 *
*/

if(is_home() && of_get_option('ads_home')): else: ?>
        
    <?php if(of_get_option('ad_one_img') || of_get_option('ads_custom')): ?>
        
        <div class="all box <?php echo of_get_option('ads_size'); ?>">
        <div class="box-content">
        
            <?php /* Image 1 */ ?>
            <?php if(of_get_option('ad_one_img')) { ?>
                <a href="<?php echo of_get_option('ad_one_link'); ?>">
                    <img src="<?php echo of_get_option('ad_one_img'); ?>" alt="" class="loop-ad" />
                </a>
            <?php } ?>
            
            <?php /* Image 2 */ ?> 
            <?php if(of_get_option('ad_two_img')) { ?>
                <a href="<?php echo of_get_option('ad_two_link'); ?>">
                    <img src="<?php echo of_get_option('ad_two_img'); ?>" alt="" class="loop-ad" />
                </a>
            <?php } ?>
            
            <?php /* Image 3 */ ?>
            <?php if(of_get_option('ad_three_img')) { ?>     
                <a href="<?php echo of_get_option('ad_three_link'); ?>">
                    <img src="<?php echo of_get_option('ad_three_img'); ?>" alt="" class="loop-ad" />
                </a>
            <?php } ?>
             
            <?php /* Custom Ad Code */ ?>
            <?php if(of_get_option('ads_custom')){ ?>
                <div class="custom-ads">
                    <?php echo of_get_option('ads_custom'); ?>
                </div>
            <?php } ?>
        </div><!-- #box-content -->
        </div><!-- #box -->
        
<?php endif; endif;?>