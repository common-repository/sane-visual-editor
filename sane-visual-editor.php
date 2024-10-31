<?php
/*
Plugin Name: Sane Visual Editor
Description: Locks down the TinyMCE visual editor with a sane set of buttons that will help your authors to not insert disruptive styles.
Version: 1.0
Author: Matt Wiebe
Author URI: http://somadesign.ca/
License: GPL v2
*/

/**
 * Overrides TinyMCE Advanced to provide sane defaults
 * AKA don't let your client blow up the site with bad HTML
 * Keep it simple, keep it safe.
 *
 * @author Matt Wiebe
 * @link http://somadesign.ca/
 * @copyright 2011
 */

class SD_Tiny {
	private static $row_1 = array(
		'formatselect',
		'separator',
		'bold',
		'italic',
		'strikethrough',
		'separator',
		'bullist',
		'numlist',
		'blockquote',
		'separator',
		'link',
		'unlink',
		'separator',
		'spellchecker',
		'separator',
		'fullscreen',
		'wp_adv'
	);
	private static $row_2 = array(
		'styleselect',
		'separator',
		'pastetext',
		'pasteword',
		'removeformat',
		'separator',
		'charmap',
		'separator',
		'indent',
		'outdent',
		'wp_help'
	);
	
	private static $all = array( 'wp_adv', 'bold', 'italic', 'strikethrough', 'underline', 'bullist', 'numlist', 'outdent', 'indent', 'justifyleft', 'justifycenter', 'justifyright', 'justifyfull', 'cut', 'copy', 'paste', 'link', 'unlink', 'image', 'wp_more', 'wp_page', 'search', 'replace', 'fontselect', 'fontsizeselect', 'wp_help', 'fullscreen', 'styleselect', 'formatselect', 'forecolor', 'backcolor', 'pastetext', 'pasteword', 'removeformat', 'cleanup', 'spellchecker', 'charmap', 'print', 'undo', 'redo', 'tablecontrols', 'cite', 'ins', 'del', 'abbr', 'acronym', 'attribs', 'layer', 'advhr', 'code', 'visualchars', 'nonbreaking', 'sub', 'sup', 'visualaid', 'insertdate', 'inserttime', 'anchor', 'styleprops', 'emotions', 'media', 'blockquote', 'separator', '|' );
	
	public static function init() {
		add_filter( 'mce_buttons', array(__CLASS__, 'mce_buttons'), 1001 );
		add_filter( 'mce_buttons_2', array(__CLASS__, 'mce_buttons_2'), 1001 );
		add_filter( 'tiny_mce_before_init', array(__CLASS__, 'before_init') );
	}
	
	public static function mce_buttons($original) {
		return self::maintain_new_buttons( self::$row_1, $original);
	}
	
	public static function mce_buttons_2($original) {
		return self::maintain_new_buttons( self::$row_2, $original);
	}
	
	public static function before_init($init_array) {
		$init_array['theme_advanced_blockformats'] = 'p,h2,h3,h4,pre';
		return $init_array;
	}
	
	// make sure we maintain any non-default buttons added by 3rd party plugins
	private static function maintain_new_buttons($mine, $theirs) {
		if ( is_array($theirs) && ! empty($theirs) ) {
			$extras = array_diff($theirs, self::$all);
			return array_merge( $mine, $extras);
		}
		return $mine;
	}
}
add_action( 'admin_init', array('SD_Tiny', 'init') );
