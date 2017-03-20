<?php
/*
Template Name: Page: Home
*/

get_header();

$id = get_the_ID();
$fp_gallery = get_meta($id, 'fp_gallery');

?>

<div class="wrapper">
	<div class="inner-wrapper">

		<?php
		 if (count($fp_gallery) > 1) : ?>
			<div class="row">
				<div class="columns small-12">
					<?php if (!empty($fp_gallery)) : ?>
						<div class="bordered-box flush">
							<span class="inner">
								<div class="cycle-slideshow fp-gallery"
									data-cycle-fx=fade
									data-cycle-timeout=4000
									data-cycle-pager-template=""
									data-cycle-auto-height
									>
									<div class="cycle-prev"></div>
		    						<div class="cycle-next"></div>
									<?php
									$count = 1;
									foreach($fp_gallery as $image) : ?>
									    <img src="<?php echo $image; ?>" alt="<?php echo __('Slide', theme_domain()) . ' ' . $count; ?> "/>
									<?php
									    $count++;
									endforeach;
									?>
								</div>
							</span>
						</div>
					<?php endif; ?>
				</div>
			</div>
		<?php endif; ?>

		<?php if (!empty(get_the_content())) : ?>
			<div class="row medium-padding-top medium-padding-bottom">
				<div class="columns small-12">
					<div class="content align-center">
						<?php the_content(); ?>
						<br/>
					</div>
				</div>
			</div>
		<?php endif; ?>

		<?php if (count(rk_get_option('site_social')) > 0) : ?>
			<div class="row">
				<div class="columns small-12 align-center">
					<hr/>
					<br/>
					<br/>
					<h4>
						<?php _e('Find us on social media', theme_domain()); ?>
					</h4>
					<?php include(locate_template('parts/tpl-social.php')); ?>
				</div>
			</div>
		<?php endif; ?>

	</div>
</div>

<?php
get_footer();
