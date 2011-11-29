<div class="additional-content">
	<h5><?php echo Kohana::lang('ui_main.how_to_report'); ?></h5>
	<ol>
		<?php if (!empty($phone_array)) 
		{ ?><li><?php echo Kohana::lang('ui_main.report_option_1')." "; ?> <?php foreach ($phone_array as $phone) {
			echo "<strong>". $phone ."</strong>";
			if ($phone != end($phone_array)) {
				echo " or ";
			}
		} ?></li><?php } ?>
		<?php if (!empty($report_email)) 
		{ ?><li><?php echo Kohana::lang('ui_main.report_option_2')." "; ?> <a href="mailto:<?php echo $report_email?>"><?php echo $report_email?></a></li><?php } ?>
		<?php if (!empty($twitter_hashtag_array)) 
					{ ?><li><?php echo Kohana::lang('ui_main.report_option_3')." "; ?> <?php foreach ($twitter_hashtag_array as $twitter_hashtag) {
		echo "<strong>". $twitter_hashtag ."</strong>";
		if ($twitter_hashtag != end($twitter_hashtag_array)) {
			echo " or ";
		}
		} ?></li><?php
		} ?><li><a href="<?php echo url::site() . 'reports/submit/'; ?>"><?php echo Kohana::lang('ui_main.report_option_4'); ?></a></li>
	</ol>

</div>

<!-- submit incident -->
<?php echo $submit_btn; ?>
<!-- / submit incident -->