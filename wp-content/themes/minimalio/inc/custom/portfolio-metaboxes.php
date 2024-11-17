<?php

defined( 'ABSPATH' ) || exit;

/** Hover image metabox */

add_action( 'add_meta_boxes', 'minimalio_hover_image_add_metabox' );
function minimalio_hover_image_add_metabox() {
	add_meta_box( 'hoverimagediv', __( 'hover Image', 'minimalio' ), 'minimalio_hover_image_metabox', 'portfolio', 'side', 'low' );
}

function minimalio_hover_image_metabox( $post ) {
	global $content_width, $_wp_additional_image_sizes;

	$image_id = get_post_meta( $post->ID, '_hover_image_id', true );

	$old_content_width = $content_width;
	$content_width     = 254;

	if ( $image_id && get_post( $image_id ) ) {

		if ( ! isset( $_wp_additional_image_sizes['post-thumbnail'] ) ) {
			$thumbnail_html = wp_get_attachment_image( $image_id, [ $content_width, $content_width ] );
		} else {
			$thumbnail_html = wp_get_attachment_image( $image_id, 'post-thumbnail' );
		}

		if ( ! empty( $thumbnail_html ) ) {
			$minimalio_content  = $thumbnail_html;
			$minimalio_content .= '<p class="hide-if-no-js"><a href="javascript:;" id="remove_hover_image_button" >' . esc_html__( 'Remove hover image', 'minimalio' ) . '</a></p>';
			$minimalio_content .= '<input type="hidden" id="upload_hover_image" name="_hover_cover_image" value="' . esc_attr( $image_id ) . '" />';
		}

		$content_width = $old_content_width;
	} else {

		$minimalio_content  = '<img src="" style="width:' . esc_attr( $content_width ) . 'px;height:auto;border:0;display:none;" />';
		$minimalio_content .= '<p class="hide-if-no-js"><a title="' . esc_attr__( 'Set hover image', 'minimalio' ) . '" href="javascript:;" id="upload_hover_image_button" id="set-hover-image" data-uploader_title="' . esc_attr__( 'Choose an image', 'minimalio' ) . '" data-uploader_button_text="' . esc_attr__( 'Set hover image', 'minimalio' ) . '">' . esc_html__( 'Set hover image', 'minimalio' ) . '</a></p>';
		$minimalio_content .= '<input type="hidden" id="upload_hover_image" name="_hover_cover_image" value="" />';

	}

	echo ( $minimalio_content );
}

add_action( 'save_post', 'minimalio_hover_image_save', 10, 1 );
function minimalio_hover_image_save( $post_id ) {
	if ( isset( $_POST['_hover_cover_image'] ) ) {
		$image_id = (int) $_POST['_hover_cover_image'];
		update_post_meta( $post_id, '_hover_image_id', $image_id );
	}
}

/** Hover metabox scripts */
function minimalio_hover_metabox_enqueue( $hook ) {
	if ( 'post.php' === $hook || 'post-new.php' === $hook ) {
		wp_enqueue_script( 'hover-metabox', get_template_directory_uri() . '/assets/dist/admin/minimalio-metabox.min.js', [ 'jquery', 'jquery-ui-sortable' ] );
	}
}
add_action( 'admin_enqueue_scripts', 'minimalio_hover_metabox_enqueue' );



/** Vimeo metabox */

add_action( 'add_meta_boxes', 'minimalio_vimeo_add_metabox' );
function minimalio_vimeo_add_metabox() {
	add_meta_box( 'vimeoiddiv', __( 'Vimeo ID', 'minimalio' ), 'minimalio_vimeo_id_metabox', 'portfolio', 'side', 'low' );
}

function minimalio_vimeo_id_metabox( $post ) {

	// Use get_post_meta to retrieve an existing value from the database.
	$value = get_post_meta( $post->ID, '_vimeo_id', true );

	// Display the form, using the current value.

	$minimalio_content  = '<label for="vimeo_id_field">' . _e( 'Paste video Number ID', 'minimalio' ) . '</label>';
	$minimalio_content .= '<input type="text" id="vimeo_id_field" name="vimeo_id_field" value="' . esc_attr( $value ) . '" size="25" />';

	echo ( $minimalio_content );
}

add_action( 'save_post', 'minimalio_vimeo_id_save', 10, 1 );
function minimalio_vimeo_id_save( $post_id ) {

	if ( isset( $_POST['vimeo_id_field'] ) ) {
		$vimeo_id_data = sanitize_text_field( $_POST['vimeo_id_field'] );
		update_post_meta( $post_id, '_vimeo_id', $vimeo_id_data );
	}
}


/** Hover video metabox */

add_action( 'add_meta_boxes', 'minimalio_hover_video_add_metabox' );
function minimalio_hover_video_add_metabox() {
	add_meta_box( 'hovervideodiv', __( 'hover video', 'minimalio' ), 'minimalio_hover_video_metabox', 'portfolio', 'side', 'low' );
}

function minimalio_hover_video_metabox( $post ) {
	global $content_width, $_wp_additional_image_sizes;

	$video_id = get_post_meta( $post->ID, '_hover_video_id', true );

	$old_content_width = $content_width;
	$content_width     = 254;

	if ( $video_id && get_post( $video_id ) ) {

		$video_url = wp_get_attachment_url( $video_id );

			$minimalio_content  = '<video src="' . esc_attr( $video_url ) . '"></video>';
			$minimalio_content .= '<p class="hide-if-no-js"><a href="javascript:;" id="remove_hover_video_button" >' . esc_html__( 'Remove hover video', 'minimalio' ) . '</a></p>';
			$minimalio_content .= '<input type="hidden" id="upload_hover_video" name="_hover_cover_video" value="' . esc_attr( $video_id ) . '" />';

		$content_width = $old_content_width;
	} else {

		$minimalio_content  = '<video src="" style="width:' . esc_attr( $content_width ) . 'px;height:auto;border:0;display:none;"></video>';
		$minimalio_content .= '<p class="hide-if-no-js"><a title="' . esc_attr__( 'Set hover video', 'minimalio' ) . '" href="javascript:;" id="upload_hover_video_button" id="set-hover-image" data-uploader_title="' . esc_attr__( 'Choose an image', 'minimalio' ) . '" data-uploader_button_text="' . esc_attr__( 'Set hover video', 'minimalio' ) . '">' . esc_html__( 'Set hover video', 'minimalio' ) . '</a></p>';
		$minimalio_content .= '<input type="hidden" id="upload_hover_video" name="_hover_cover_video" value="" />';

	}

	echo ( $minimalio_content );
}

add_action( 'save_post', 'minimalio_hover_video_save', 10, 1 );
function minimalio_hover_video_save( $post_id ) {
	if ( isset( $_POST['_hover_cover_video'] ) ) {
		$video_id = (int) $_POST['_hover_cover_video'];
		update_post_meta( $post_id, '_hover_video_id', $video_id );
	}
}

// /** Hover metabox scripts */
// function minimalio_hover_video_metabox_enqueue( $hook ) {
// 	if ( 'post.php' === $hook || 'post-new.php' === $hook ) {
// 		wp_enqueue_script( 'hover-video-metabox', get_template_directory_uri() . '/assets/dist/admin/metabox-video.min.js', [ 'jquery', 'jquery-ui-sortable' ] );
// 	}
// }
// add_action( 'admin_enqueue_scripts', 'minimalio_hover_video_metabox_enqueue' );
