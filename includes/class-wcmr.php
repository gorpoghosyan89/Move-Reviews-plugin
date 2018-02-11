<?php
/**
 * WooCommerce Move Reviews Class
 *
 * @package   WooCommerce Move Reviews
 * @author    Captain Theme <info@captaintheme.com>
 * @license   GPL-2.0+
 * @link      http://captaintheme.com
 * @copyright 2014 Captain Theme
 * @since     1.0.1
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

/**
 * WPMR Class
 *
 * @package  WooCommerce Move Reviews
 * @author   Captain Theme <info@captaintheme.com>
 * @since    1.0.0
 */

class WCMR {

	const VERSION = '1.0.1';

	protected $plugin_slug = 'woocommerce-move-reviews';

	protected static $instance = null;

	private function __construct() {

    add_action( 'admin_menu', array( $this, 'add_metabox' ) );
    add_action( 'edit_comment', array( $this, 'update_comment' ) );

	}

	/**
	 * Start the Class when called
	 *
	 * @package WooCommerce Move Reviews
	 * @author  Captain Theme <info@captaintheme.com>
	 * @since   1.0.0
	 */

	public static function get_instance() {

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;

	}


  /**
	 * Move Reviews
	 *
	 * @package WooCommerce Move Reviews
	 * @author  Captain Theme <info@captaintheme.com>
	 * @since   1.0.1
	 */

  public function update_comment($id) {

  	if ( empty( $_POST['wcmr_select_product']) OR !is_numeric($_POST['wcmr_select_product'])) return;

  	global $wpdb;

  	$pid = $wpdb->get_var("SELECT comment_post_ID FROM $wpdb->comments WHERE comment_id='".$id."'");
  	$wpdb->query("UPDATE $wpdb->posts SET comment_count=comment_count-1 WHERE ID='".$pid."'");
  	$wpdb->query("UPDATE $wpdb->posts SET comment_count=comment_count+1 WHERE ID='".$_POST['wcmr_select_product']."'");
  	$wpdb->query("UPDATE $wpdb->comments SET comment_post_ID='".$_POST['wcmr_select_product']."' WHERE comment_ID='".$id."'");

  }

  public function add_metabox() {
  	add_meta_box('commentmovediv', 'Move Review', array( $this, 'display_metabox' ), 'comment','normal');
  }

  public function display_metabox() {
  	?>

  	<label for="wcmr_select_product">
  	<select name="wcmr_select_product" id="wcmr_select_product">
  		<option>Select a Product</option>
  	<?php
  		global $post;
  		$posts = get_posts('numberposts=-1&post_type=product');
  		foreach($posts as $post) {
  			echo '<option value="'.$post->ID.'">'.the_title('','',FALSE).'</option>';
  		}
  	?>
  	</select>
  	</label>
  	<?php
  }

}
