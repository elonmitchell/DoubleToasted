<?php
/**
 * @package Frank
 */
/*
Template Name: Audio Archive
*/
?>

<?php get_header(); ?>

<img src="../wp-content/themes/toasted/images/audio_top_image.gif" class="top-banner">
<div class="archive podcast-archive main new-audio-format">

	<div class="content">

		<!-- This page no longer is used as a typical "archive" page - we're running a new query as written below -->

		<?php $new_audio_query = new WP_Query( array('post_type' => array('dt-audio','dt_shows') )); ?>

			<?php if ( $new_audio_query->have_posts() ) : ?>

				<div class="archive-posts large-12 medium-12 columns">

					<div class="overflow">
						<div class="large-3 medium-3 small-12 columns">

							<h1 class="page-title">Audio</h1>
							<p class="dt-crumbs"><a href="/audiocasts/">Audio</a> > All Audiocasts</p>

						</div>
						<div class="large-9 medium-9 small-12 columns dt-audio-filter-feeds">
							<form method="get" id="dt-posts-custom-search" class="fl-right" action=""><input type="text" placeholder="Search" name="s" id="s" /></form>

							<div class="categories">
								<div class="drop">Categories<span>v</span></div>
								<div class="dropdown">
									<div class="tooltip"></div>
									<ul id="dt-posts-order-by" data-type="dt-audio" data-category="false" data-meta="<?php echo wp_create_nonce('dt-ajax-sort-posts'); ?>">
										<li data-orderby="newest" data-order="desc">Most Recent</li>
										<li data-orderby="popular">Most Popular</li>
										<li data-orderby="name" data-order="asc">Sort A to Z</li>
										<li data-orderby="name" data-order="desc">Sort Z to A</li>
									</ul>
								</div>
							</div>

							<!--<select id="dt-posts-order-by" type="dt-audio" category="false" meta="<?php /*echo wp_create_nonce( 'dt-ajax-sort-posts' ); */?>">
								<option value="newest">Newest</option>
								<option value="oldest">Oldest</option>
								<option value="popular">Most Popular</option>
								<option value="toasty">Most Toasted</option>
							</select>-->

							<div class="categories">
                                <div class="drop">Choose a Show<span>v</span></div>
                                <div class="dropdown">
                                    <div class="tooltip"></div>
									<ul id="dt-posts-series-order-by" type="dt-audio-default" category="false" meta="<?php echo wp_create_nonce( 'dt-ajax-sort-posts' ); ?>">
									<?php
											// List All Show Names (Series) for Sorting
											$tax_terms = get_terms('series');
											foreach ($tax_terms as $term) {
												echo '<li data-orderby="', $term->slug, '">', $term->name, '</li>';
											}
									?>
									</ul>
								</div>
                            </div>
							<a class="fl-right dt-rss-feed" href="/audiocasts/feed/" target="_blank">FEED</a>
						</div>
					</div>

					<div class="show-more-wrap">

						<?php while ( $new_audio_query->have_posts() ): ?>

							<?php $new_audio_query->the_post(); ?>

							<?php $soundcloud_link = get_post_meta( $post->ID, '_lac0509_dt-audio-url', true ); ?>
							<?php if (!empty($soundcloud_link)) { ?>

							<div class="post columns end animate-post">

								<a class="dt-archive-thumb-small">

									<div class="dt-archive-audio-player"><?php echo wp_oembed_get( $soundcloud_link ); ?></div>

									<div class="dt-post-thumb">

										<?php the_post_thumbnail('sm-archive'); ?>

									</div>

									<div class="dt-post-info">

										<?php

											echo '<span style="font-weight:600;font-size:17px;line-height:20px;">', get_the_title(), '</span><br />';
											remove_filter( 'the_excerpt', 'polldaddy_show_rating' );
											the_excerpt();

										?>

										<div class="dt-post-meta">

											<?php

												// Get Favorite Count
												if ( bp_has_activities( '&action=new_blog_post&secondary_id=' . $post->ID ) ) {
													while ( bp_activities() ) : bp_the_activity();

													$my_fav_count = bp_activity_get_meta( bp_get_activity_id(), 'favorite_count' );
													if (!$my_fav_count >= 1)
														$my_fav_count = 0;
													echo '<span class="dt-archive-toasts">', $my_fav_count, '</span>';
													endwhile;

												}

												// Get Comment Count
												echo '<span class="dt-archive-com-count">', get_comments_number(), '</span>';

											?>

										</div>
									</div>
								</a>
							</div>
							<div class="divider"></div>

							<?php } ?>

						<?php endwhile; ?>

					</div>

					<?php if ($new_audio_query->max_num_pages > 1) : ?>

						<div style="clear:both;" id="load-more-dt-posts" class="load-more"
							 data-currentpage="1"
							 data-lastpage="<?php echo $wp_query->max_num_pages; ?>"
							 data-type="dt-audio"
							 data-category="false"
							 data-meta="<?php echo wp_create_nonce( 'dt-ajax-load-more-reviews' ); ?>">

							<img src="/wp-content/themes/toasted/images/load-more-spin.gif" width="75">
							<a href="#!">Show More</a>

						</div>

					<?php endif; ?>

				</div>

				<?php else : ?>

				<div class="archive-none large-12 columns">

					<h1><?php _e( 'No podcasts added yet.', 'frank_theme' ); ?></h1>
					<p><?php _e( 'Try searching the site above.', 'frank_theme' ); ?></p>

				</div>

			<?php endif; ?>
			<div class="audio-caricature caricature caricature-3"></div>
	</div>

</div><!-- .archive.main -->

<?php get_footer(); ?>