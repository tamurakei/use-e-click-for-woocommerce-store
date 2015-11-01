<?php
/*
  Plugin Name: Use E-click.jp (japanese Affiliate sevice) for Woocommerce Store UEAWS
  Plugin URI: http://www.shikumilab.jp/
  Description: Insert Affiliate tracking code at WooCommerce Thankyou Page.
  Author: Shikumilab , Inc
  Author URI: http://www.shikumilab.jp/
  Version: 1.0.0
*/

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

add_action( 'woocommerce_thankyou','add_e_click_affiliate_tracking_tag' , 0,1 ) ;
function add_e_click_affiliate_tracking_tag ($order_id) {
	global $woocommerce ;
    $order = new WC_Order($order_id);
	$advertiser_id = get_option('ueaws_ad_id');
    $order_total = $order->get_subtotal();;
	$tag = '<img src="https://www.e-click.jp/applications/applicate/' . $advertiser_id .'/'. $order_total . '/' . $order->id . '" height="1" width="1" />'.PHP_EOL ;
	echo $tag ;
}

// 管理画面でのテキスト設定
// Woocommerceメニュー下にサブメニューを追加:
add_action('admin_menu', 'admin_menu_ueaws');
function admin_menu_ueaws () {
    add_submenu_page('woocommerce','アフィリエイトサービス設定', 'アフィリエイトサービス設定',8,'use-e-click-for-woocommerce-store.php', 'ueaws_admin','',99 );
}

function ueaws_admin () {
    // 設定変更画面を表示する
?>
    <div class="wrap">
        <h2>e-click.jp Advertiser IDの登録</h2>
        <form method="post" action="options.php">
            <?php wp_nonce_field('update-options'); ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Advertiser ID</th>
                    <td><input type="text" name="ueaws_ad_id" id="ueaws_ad_id" value="<?php echo get_option('ueaws_ad_id'); ?>"  size="40" /></td>
                </tr>
            </table>
            <input type="hidden" name="action" value="update" />
            <input type="hidden" name="page_options" value="ueaws_ad_id" />
            <p class="submit">
                <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
            </p>
        </form>
    </div>
<?php
}
?>
<?php
if ( function_exists('register_uninstall_hook') ) {
    register_uninstall_hook(__FILE__, 'uninstall_hook_ueaws');
}
function uninstall_hook_ueaws () {
    delete_option('ueaws_ad_id');
}

?>