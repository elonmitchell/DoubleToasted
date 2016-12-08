<?php

/**
 * BuddyPress - Activity Stream (Single Item) - Used with BP-Editable Plugin
 *
 * This template is used by activity-loop.php and AJAX functions to show
 * each activity. The only difference between this and entry.php is we've
 * removed the "animate-post" class from the parent li element
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 */

?>

<?php do_action( 'bp_before_activity_entry' ); ?>

<li class="<?php bp_activity_css_class(); ?>" id="activity-<?php bp_activity_id(); ?>">

	<div class="activity-avatar rounded">

		<a href="<?php bp_activity_user_link(); ?>">

			<?php bp_activity_avatar(); ?>

		</a>
    
	</div>

	<div class="activity-content">
		
		<div class="activity-header fl-left">

			<?php bp_activity_action(array('no_timestamp' => true)); ?>

		</div>
		
		<?php if ( bp_activity_has_content() ) : ?>

			<div class="activity-inner fl-left">

				<?php bp_activity_content_body(); ?>

			</div>

		<?php endif; ?>

		<?php do_action( 'bp_activity_entry_content' ); ?>

		<div class="activity-meta fl-left">
		
			<?php if ( bp_get_activity_type() == 'activity_comment' ) : ?>

				<a href="<?php bp_activity_thread_permalink(); ?>" class="view bp-secondary-action" title="<?php _e( 'View Conversation', 'buddypress' ); ?>"><?php _e( 'View Conversation', 'buddypress' ); ?></a>

			<?php endif; ?>

			<?php if ( is_user_logged_in() ) : ?>
			
				<?php if ( bp_activity_can_favorite() ) : ?>

					<?php
					
						$my_fav_count = bp_activity_get_meta( bp_get_activity_id(), 'favorite_count' );
						
						if (!$my_fav_count >= 1) {
							$my_fav_count = 0;
						}					


						// This function passes a postid to the favorite function - which updates the post meta for the associated blog post
						// This is needed primarily for sorting blog posts by "most liked" (or toasted as it were)
						global $activities_template;
						$current = $activities_template->current_activity;

						if ($activities_template->activities[$current]->type == 'new_blog_post') {
							$postid = $activities_template->activities[$current]->secondary_item_id;
						}
						
						else {
							$postid = 'false';
						}

					?>

					<?php if ( !bp_get_activity_is_favorite() ) : ?>

						<a href="<?php bp_activity_favorite_link(); ?>" postid="<?php echo $postid; ?>" class="fav bp-secondary-action dt-fav-count" title="<?php esc_attr_e( 'Mark as Favorite', 'buddypress' ); ?>" count="<?php echo $my_fav_count; ?>"><?php echo $my_fav_count; ?> Toast</a>

					<?php else : ?>

						<a href="<?php bp_activity_unfavorite_link(); ?>" postid="<?php echo $postid; ?>" class="unfav bp-secondary-action dt-fav-count" title="<?php esc_attr_e( 'Remove Favorite', 'buddypress' ); ?>" count="<?php echo $my_fav_count; ?>"><?php echo $my_fav_count; ?> Toasted</a>

					<?php endif; ?>

				<?php endif; ?>

				<?php if ( bp_activity_can_comment() ) : ?>
				
					<?php if ($activities_template->activities[$current]->type == 'bbp_reply_create' || $activities_template->activities[$current]->type == 'bbp_topic_create') { ?>

						<a href="<?php echo bp_activity_get_permalink($activities_template->activities[$current]->id); ?>" class="dt-reply-to-forum" id="acomment-comment-<?php bp_activity_id(); ?>"><?php echo 'Reply'; ?></a>

					<?php } else { ?>
					
						<a href="<?php bp_activity_comment_link(); ?>" class="acomment-reply bp-primary-action" id="acomment-comment-<?php bp_activity_id(); ?>"><?php printf( __( '<span>%s</span> Reply', 'buddypress' ), bp_activity_get_comment_count() ); ?></a>
						
					<?php } ?>

				<?php endif; ?>

				<?php if ( bp_activity_user_can_delete() ) bp_activity_delete_link(); ?>

					<?php do_action( 'bp_activity_entry_meta' ); ?>

				<?php endif; ?>
				
				<?php 
				
					$timestamp = bp_insert_activity_meta(false);
					echo $timestamp;
				
				?>
				
		</div>
    
	</div>

	<?php do_action( 'bp_before_activity_entry_comments' ); ?>

	<?php if ( ( is_user_logged_in() && bp_activity_can_comment() ) || bp_is_single_activity() ) : ?>

		<div class="activity-comments">

			<?php bp_activity_comments(); ?>

			<?php if ( is_user_logged_in() ) : ?>

				<form action="<?php bp_activity_comment_form_action(); ?>" method="post" id="ac-form-<?php bp_activity_id(); ?>" class="ac-form"<?php bp_activity_comment_form_nojs_display(); ?>>
					<div class="ac-reply-avatar rounded"><?php bp_loggedin_user_avatar( 'width=' . BP_AVATAR_THUMB_WIDTH . '&height=' . BP_AVATAR_THUMB_HEIGHT ); ?></div>
					<div class="ac-reply-content">
						<div class="ac-textarea">
							<textarea id="ac-input-<?php bp_activity_id(); ?>" class="ac-input" name="ac_input_<?php bp_activity_id(); ?>"></textarea>
						</div>
						<input type="submit" name="ac_form_submit" value="<?php _e( 'Post', 'buddypress' ); ?>" /> &nbsp; <a href="#" class="ac-reply-cancel"><?php _e( 'Cancel', 'buddypress' ); ?></a>
						<input type="hidden" name="comment_form_id" value="<?php bp_activity_id(); ?>" />
					</div>

					<?php do_action( 'bp_activity_entry_comments' ); ?>

					<?php wp_nonce_field( 'new_activity_comment', '_wpnonce_new_activity_comment' ); ?>

				</form>

			<?php endif; ?>

		</div>

	<?php endif; ?>

	<?php do_action( 'bp_after_activity_entry_comments' ); ?>
<div class="activity-timeline"></div>
</li>

<?php do_action( 'bp_after_activity_entry' ); ?>