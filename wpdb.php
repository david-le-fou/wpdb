<?php
/*
Plugin Name: wpdb enjana
Plugin URI: https://github.com/david-le-fou/wpdb.git
Description: utilisation wpdb
Author: David le fou
Version: 1.0.0
*/

////////////////////////////////////////////////
// appele hook avec le fonction add_action() 
// hooks 2 type:
// Les Actions : à des moments clés, on peut lancer notre propre fonction pour faire des choses supplémentaires dans WordPress ;
// Les Filtres : qui permettent d’intercepter une valeur afin de la modifier.
// ACTION ET FILTRE IMPORTAN A RETENIR
//ACTION
//     wp_footer -ajouter un action footer
//     wp_head -ajouter un action  header
//      wp_enqueue_scripts -ajouter un script
//      wp_enqueue_style -ajouter un style
//FILTRE
//     body_class -ajouter une nouvelle classe à body
//     the_content -modifier le contenu d’un article avant de l’afficher
//     wp_title -Filtre le texte du titre de la page. - il faut ajouter dans le fichier page.php ou head.php wp_title()
//////////////////////////////////////////////
add_filter( 'the_content', 'filtre_article', 1 );
function filtre_article( $content ) {
    $content .= " <h1>filtre article</h1>";
    return $content;
}
////////////////////////////////////////////////
function filtre_body_class( $classes ) {
    $classes[] = 'classiko';
      
    return $classes;
}
add_filter( 'body_class','filtre_body_class' );
////////////////////////////////////////////////////
function change_the_title($title) {
    return 'My modified title';
}
add_filter('wp_title', 'change_the_title');
///////////////////////////////////////////////
function header_enjana(){
    $texte = "<div class='mon_header'>enjana";
    $texte .= "</div>";
    echo $texte;
}
add_action('wp_head','header_enjana');//ajouter sur header
////////////////////////////////////////////////////////
function footer_enjana(){
    $texte = "<hr><div class='footer'>";
    $texte .="</div>";
    $texte .="<p class='copy'> &copy; Copyrigth 20".date("y")."</p>";
    echo $texte;
}
add_action('wp_footer','footer_enjana');//ajouter sur footer
////////////////////////////////////////////////////////
function dire_bonjour(){
	echo '<p class="test123"> Hello World !!</p>';
}
add_action( 'init', 'dire_bonjour');//ajouter sur tt page back &site
/////////////////////////////////////////////////////////
function dire_aurevoir(){
	echo '<p class="test55"> See ya World !!</p>';
}
add_action('wp','dire_aurevoir');//seulment dans les site
/////////////////////////////////////////////////////
define('VER','1.0.0');
define('directory','/wp-content/plugins/wpdb');

function addCss(){
	wp_enqueue_style( 'style',directory.'/css/style.css','',VER );
}
add_action("wp_enqueue_scripts", "addCss"); 
/////////////////////////////////////////////////////////
function addjquery(){
	wp_enqueue_script( 'script_jquery',directory.'/js/jquery.js','',VER );
}
add_action("wp_enqueue_scripts", "addjquery");
///////////////////////////////////////////////////////////
function wpbd_result(){
    global $wpdb;
    $rows =  $wpdb->get_results( "SELECT * FROM `wp_posts` WHERE `post_type` LIKE 'page'");
    foreach ( $rows as $page )
        {
            echo $page->ID.'<br/>';
            echo $page->post_title.'<br/>';
        }
}
add_action('wp','wpbd_result');
/////////////////////////////////////////////////////////////////
//Exécute une requête de base de données MySQL, en utilisant la connexion à la base de données actuelle.
/////////////////////////////////////////////////////////////////
// $wpdb->query() -exécuter n'importe quelle requête $ wpdb -> query ( " SELECT * FROM wp_posts " );
// $wpdb->insert() -insérer des données dans une table… protection sql ? $ wpdb -> insert ( 'wp_posts' , array ( 'post_title' => 'test' , 'ID' => 5 ), array ( '%s' , '%d' ) );
// $wpdb->update() -mettre à jour une ligne existante $ wpdb -> update ( 'wp_posts' , array ( 'post_title' => 'test2' ), array ( 'ID' => 5 ), array ( '%s' ) );
// $wpdb->delete() -utilisée pour supprimer des lignes d'un tableau. $wpdb->delete( $table, $where, $where_format = null );
// $wpdb->get_var() -obtenir une seule variable $ wpdb -> get_var ( "SELECT post_title FROM wp_posts WHERE ID = 1" );
// $wpdb->get_row() -obtient une ligne en tant qu'assoc. déployer $ wpdb -> get_row ( "SELECT * FROM wp_posts WHERE ID = 1" );
// $wpdb->get_col() -obtenir une colonne entière $ wpdb -> get_col ( "SELECT post_title FROM wp_posts" );
// $wpdb->get_results() -exécuter une requête et obtenir les résultats sous forme de tableau associatif $ wpdb -> get_results ( " SELECT * FROM wp_posts " );
// $wpdb->replace()
// $wpdb->flush(); -Vous pouvez effacer le cache des résultats SQL
////////////////////////////////////////////////////////////////////
define( 'BLOCK_LOAD', true );
define('nom_site','cartepvctwo');
require_once( $_SERVER['DOCUMENT_ROOT'] . '/'.nom_site.'/wp-config.php' );
require_once( $_SERVER['DOCUMENT_ROOT'] .'/'.nom_site.'/wp-includes/wp-db.php' );
$wpdb = new wpdb( DB_USER, DB_PASSWORD, DB_NAME, DB_HOST);
