<?php
// dashicon reference: http://calebserna.com/dashicons-cheatsheet/
function vig_custom_post_types() {
  $args = array(
		'label'                 => __( 'Sitewide Information', 'vig' ),
		'labels'                => $labels,
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 1,
		'menu_icon'             => 'dashicons-admin-settings',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'post',
    'capabilities' => array(
      'create_posts' => 'do_not_allow',
    ),
		'show_in_rest'          => true,
		'rewrite'               => array( 'slug' => 'sitewide-information' ),
	);
	register_post_type( 'sitew', $args );

  // Staff
  $args = array(
		'label'                 => __( 'Our Staff', 'vig' ),
		'labels'                => $labels,
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 1,
		'menu_icon'             => 'dashicons-admin-users',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => true,
		'publicly_queryable'    => true,
		'capability_type'       => 'post',
		'show_in_rest'          => true,
		'rewrite'               => array( 'slug' => 'our-staff' ),
	);
	register_post_type( 'our-staff', $args );

  // Donor Stories
  $args = array(
		'label'                 => __( 'Donor Stories', 'vig' ),
		'labels'                => $labels,
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 1,
		'menu_icon'             => 'dashicons-id-alt',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => true,
		'publicly_queryable'    => true,
		'capability_type'       => 'post',
		'show_in_rest'          => true,
		'rewrite'               => array( 'slug' => '/for-donors/our-donors/donor-stories' ),
	);
	register_post_type( 'donor-stories', $args );



  // Donor Stories
  $args = array(
		'label'                 => __( 'Committee', 'vig' ),
		'labels'                => $labels,
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 1,
		'menu_icon'             => 'dashicons-id-alt',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => true,
		'publicly_queryable'    => true,
		'capability_type'       => 'post',
		'show_in_rest'          => true,
		'rewrite'               => array( 'slug' => '/committee' ),
	);
	register_post_type( 'Committee', $args );


  // Assitance Blocks
  $args = array(
		'label'                 => __( 'Asssitance Blocks', 'vig' ),
		'labels'                => $labels,
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-id-alt',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => true,
		'publicly_queryable'    => true,
		'capability_type'       => 'post',
		'show_in_rest'          => true,
		'rewrite'               => array( 'slug' => '/blocks' ),
	);
	register_post_type( 'assistance-blocks', $args );


  // Funds List Blocks
  $args = array(
		'label'                 => __( 'Funders', 'vig' ),
		'labels'                => $labels,
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-id-alt',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => false,
		'exclude_from_search'   => true,
		'publicly_queryable'    => true,
		'capability_type'       => 'post',
		'show_in_rest'          => true,
		'rewrite'               => array( 'slug' => '/our-funders' ),
	);
	register_post_type( 'funders', $args );

  // External Links
  $args = array(
		'label'                 => __( 'External Links', 'vig' ),
		'labels'                => $labels,
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 10,
		'menu_icon'             => 'dashicons-admin-links',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => false,
		'exclude_from_search'   => true,
		'publicly_queryable'    => true,
		'capability_type'       => 'post',
		'show_in_rest'          => true,
		'rewrite'               => array( 'slug' => '/external-links' ),
	);
	register_post_type( 'external', $args );
}
add_action( 'init', 'vig_custom_post_types', 0 );
?>
