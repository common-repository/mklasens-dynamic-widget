<?php
defined( 'ABSPATH' ) or die( 'You can\'t access this file directly!');
/**
 * Plugin Name: mklasen's Dynamic Widget
 * Plugin URI: http://plugins.mklasen.com/dynamic-widget/
 * Description: Add per-page/post configurable WYSIWYG editors as a widget to your sidebar.
 * Version: 2.0.3
 * Author: Marinus Klasen
 * Author URI: http://mklasen.com
 * License: GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html


 Copyright 2015  Marinus Klasen  (email : marinus@mklasen.nl)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

 */

 	require_once(plugin_dir_path( __FILE__ ).'widget.php');


	class MK_Dynamic_Widget {
		public function __construct() {
			add_action( 'add_meta_boxes', array($this, 'add_meta_box' ));
			add_action( 'save_post', array($this, 'save_post' ));
			add_action( 'widgets_init', array($this, 'add_widget' ));
		}

		public function add_meta_box() {
			$screens = get_post_types();
			foreach ( $screens as $screen ) {
				add_meta_box(
					'mklasen_add_dynamic_widget_content',
					__( 'Dynamic Widget', 'mklasens-dynamic-widget-textdomain' ),
					function() {
						$currentContent = get_post_meta(get_the_ID(), 'mklasens-dynamic-text-content', true);
						wp_editor( htmlspecialchars_decode($currentContent), 'mklasens-dynamic-text-editor', $settings = array('textarea_name'=>'mklasens-dynamic-text-input', 'media_buttons' => true) );
					},
					$screen,
					'side'
				);
			}
		}

		public function save_post() {
			if (isset($_POST['mklasens-dynamic-text-input'])) {
        $data = $_POST['mklasens-dynamic-text-input'];
        update_post_meta(get_the_ID(), 'mklasens-dynamic-text-content', $data);
	    }
		}

		public function add_widget() {
			register_widget( 'mkDynamicWidget' );
		}
	}

  $mk_dynamic_widget = new MK_Dynamic_Widget();
