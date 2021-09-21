<?php
/**
 * Plugin Name: cartepvctwo
 * Plugin URI: null
 * Description: plugin
 * Version: 1.0.0
 * Author URI: enjana
 * Requires PHP: 7.0
  */

  define('VER','1.0.0');
/*
function addjquery(){
	wp_enqueue_script( 'addjquery',plugin_dir_url( __FILE__ ).'js/jquery.min.js','',VER );
}
add_action("wp_enqueue_scripts", "addjquery");
*/
function hook_csxxs() {
    ?>

        <meta name="google-site-verification" content="hvwwT6dwJAVV5UXInKXkuQaZBSZYzCTF4TdMsxVV-jE" />
    <?php
}
add_action('wp_head', 'hook_csxxs');
function bootsjs(){
	wp_enqueue_script( 'bootsjs',plugin_dir_url( __FILE__ ).'js/bootstrap.min.js','',VER );
}
add_action("wp_enqueue_scripts", "bootsjs");

function bootsjsbundle(){
	wp_enqueue_script( 'bootsjsbundle',plugin_dir_url( __FILE__ ).'js/bootstrap.bundle.min.js','',VER );
}
add_action("wp_enqueue_scripts", "bootsjsbundle");

function prixgenjs(){
	wp_enqueue_script( 'prixgenjs',plugin_dir_url( __FILE__ ).'js/prixgen.js','',VER );
	wp_localize_script('prixgenjs', 'me_url_php', array(
   		 'pluginsUrl' => plugin_dir_url( __FILE__ ),
	));
}
add_action("wp_enqueue_scripts", "prixgenjs");


function bootscss(){
	wp_enqueue_style( 'bootscss',plugin_dir_url( __FILE__ ).'css/bootstrap.min.css.css','',VER );
}
add_action("wp_enqueue_scripts", "bootscss");

function tie_style(){
	wp_enqueue_style( 'tie_style',plugin_dir_url( __FILE__ ).'css/tie_style.css','',VER );
}
add_action("wp_enqueue_scripts", "tie_style");


add_filter('the_content', 'zafiltre');

function zafiltre($content)
{
    return $content;
}
/*
function appli(){    
    include "html.html";
}
add_action('wp_footer','appli');
*/

add_action( 'woocommerce_before_calculate_totals', 'add_custom_price', 20, 1);
function add_custom_price($cart_obj){
	
}

/* andrana add to cart */
add_action('woocommerce_before_add_to_cart_button','wdm_add_custom_fields');
/**
 * Adds custom field for Product
 * @return [type] [description]
 */
function wdm_add_custom_fields()
{

    global $product;

    ob_start();

    ?>
        <div class="wdm-custom-fields">
            <?php
			include "html.html";
			?>
        </div>
        <div class="clear"></div>
	<br>
    <?php

    $content = ob_get_contents();
    ob_end_flush();

    return $content;
}   // ------- ajout champ text

add_filter('woocommerce_add_cart_item_data','wdm_add_item_data',10,3);

/**
 * Add custom data to Cart
 * @param  [type] $cart_item_data [description]
 * @param  [type] $product_id     [description]
 * @param  [type] $variation_id   [description]
 * @return [type]                 [description]
 */
function wdm_add_item_data($cart_item_data, $product_id, $variation_id)
{
    if(isset($_REQUEST['quantite']) or isset($_REQUEST['ecri_nb']))
    {
        $cart_item_data['quantite'] = sanitize_text_field($_REQUEST['quantite']);
		$cart_item_data['ecri_nb'] = sanitize_text_field($_REQUEST['ecri_nb']);
    }

    return $cart_item_data;
}   // ------------ ajout dans panier

add_filter('woocommerce_get_item_data','wdm_add_item_meta',10,2);



/**
 * Display information as Meta on Cart page
 * @param  [type] $item_data [description]
 * @param  [type] $cart_item [description]
 * @return [type]            [description]
 */
function wdm_add_item_meta($item_data, $cart_item)
{

    if(array_key_exists('quantite', $cart_item) or array_key_exists('ecri_nb', $cart_item) )
    {
        $custom_details = $cart_item['quantite'];
		$custom_details2 = $cart_item['ecri_nb'];

        $item_data[] = array(
            'key'   => 'quantite',
            'value' => $custom_details
        );
		$item_data[] = array(
            'key'   => 'name test pax',
            'value' => $custom_details2
        );
    }

    return $item_data;
}   // affichage dans cart 


add_action( 'woocommerce_checkout_create_order_line_item', 'wdm_add_custom_order_line_item_meta',10,4 );

function wdm_add_custom_order_line_item_meta($item, $cart_item_key, $values, $order)
{

    if(array_key_exists('quantite', $values) or array_key_exists('ecri_nb', $values))
    {
        $item->add_meta_data('quantite',$values['quantite']);
		$item->add_meta_data('ecri_nb',$values['ecri_nb']);
    }
}   // ajout ligne pour le détai dans panier

