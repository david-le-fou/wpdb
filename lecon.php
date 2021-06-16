<?php

//chemin absolu vers wp-load.php, ou relatif à ce script
//par exemple, ../wp-core/wp-load.php
include( 'trunk/wp-load.php' ); 

// récupère l'objet de base de données WPDB, en utilisant la base de données de WP
//plus d'infos : http://codex.wordpress.org/Class_Reference/wpdb
global $wpdb ;

//créer un nouvel objet de base de données en utilisant une base de données différente
//$mydb = new wpdb('username','password','database','localhost');

//fonctionnalité de base

// exécuter n'importe quelle requête
$wpdb->query( "SELECT * FROM wp_posts" );

// exécuter une requête et obtenir les résultats sous forme de tableau associatif
$wpdb->get_results( "SELECT * FROM wp_posts" );

// obtenir une seule variable
$wpdb->get_var( "SELECT post_title FROM wp_posts WHERE ID = 1" );

// obtient une ligne en tant qu'assoc. déployer
$wpdb->get_row( "SELECT * FROM wp_posts WHERE ID = 1" );

// obtenir une colonne entière
$wpdb->get_col( "SELECT post_title FROM wp_posts" );

//insérer des données dans une table… protection sql ?
$wpdb->insert( 'wp_posts', array( 'post_title' => 'test', 'ID' => 5 ), array( '%s', '%d') );

//mettre à jour une ligne existante
$wpdb->update( 'wp_posts', array( 'post_title' => 'test2'), array( 'ID' => 5 ), array( '%s' ) );

// échapper aux requêtes
$wpdb->query( $wpdb->prepare( "MISE À JOUR DANS wp_posts set post_title = %s WHERE ID = %d", 'test2', 5 ) );

//deux étapes pour insérer un message…

//définir la publication… tous les champs facultatifs
$post = tableau( 
		'post_title' => 'test',
		'post_type' => 'gare',
		'post_status' => 'publier',
		'post_author' => 'greg',
);

//insérer
$id = wp_insert_post( $post );

//stocker la paire clé/valeur
update_post_meta( $id, 'expiration', '201101010' );

//récupérer la paire clé/valeur
$meta = get_post_meta( $id, 'expiration', true );

//recherche de publications par paire clé/valeur
$posts = get_posts( 'expiration=20110110' );

//associer des termes de taxonomie à un article
wp_set_post_terms( $id, array( 'rouge', 'bleu', 'vert'), 'couleurs' );

//requête des articles par terme de taxonomie
$posts = get_posts( 'color=red' );

//assistants de création de taxonomie/types de publication
// affichera un plugin que vous déposez simplement dans /wp-content/plugins et activez
//http://themergency.com/generators/wordpress-custom-taxonomy/
//http://themergency.com/generators/wordpress-custom-post-types/

// Cache

//stocke une valeur dans le cache
wp_cache_set( 'unique_key', $data );

//récupérer la valeur du cache
$data = wp_cache_get( 'unqiue_key' );

/* autres choses à faire
1) Installez W3 Total Cache pour obtenir la mise en cache de la base de données et des objets
2) Utilisez l'interface utilisateur frontale / administrateur pour parcourir / trier les données
*/