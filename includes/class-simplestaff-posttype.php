<?php

class SimpleStaff_PostType {

	protected $post_type = 'staff';
	protected $post_type_label;
	protected $taxonomy = 'department';
	protected $taxonomy_label;

	public function register() {
		$this->register_post_type();
		$this->register_taxonomy();
	}

	protected function register_post_type() {

		$this->post_type_label = array(
			'singular' => __( 'Staff', 'simple-staff' ),
			'plural'   => __( 'Staff', 'simple-staff' ),
		);

		$labels = array(
			'name'               => _x( '%2$s', 'Post Type General Name', 'simple-staff' ),
			'singular_name'      => _x( '%1$s', 'Post Type Singular Name', 'simple-staff' ),
			'menu_name'          => __( '%2$s', 'simple-staff' ),
			'name_admin_bar'     => __( '%1$s', 'simple-staff' ),
			'parent_item_colon'  => __( 'Parent %1$s:', 'simple-staff' ),
			'all_items'          => __( 'All %2$s', 'simple-staff' ),
			'add_new_item'       => __( 'Add New %1$s', 'simple-staff' ),
			'add_new'            => __( 'Add New', 'simple-staff' ),
			'new_item'           => __( 'New %1$s', 'simple-staff' ),
			'edit_item'          => __( 'Edit %1$s', 'simple-staff' ),
			'update_item'        => __( 'Update %1$s', 'simple-staff' ),
			'view_item'          => __( 'View %1$s', 'simple-staff' ),
			'search_items'       => __( 'Search %2$s', 'simple-staff' ),
			'not_found'          => __( 'Not found', 'simple-staff' ),
			'not_found_in_trash' => __( 'Not found in Trash', 'simple-staff' ),
		);

		foreach ( $labels as $key => $value ) {
			$labels[ $key ] = sprintf( $value, $this->post_type_label['singular'], $this->post_type_label['plural'] );
		}

		$supports = array(
			'title',
			'editor',
			'excerpt',
			'thumbnail',
			'page-attributes',
			'genesis-cpt-archives-settings',
			'genesis-simple-menus',
		);

		$args = array(
			'label'               => $this->post_type_label['plural'],
			'description'         => $this->post_type_label['plural'],
			'labels'              => $labels,
			'supports'            => $supports,
			'taxonomies'          => array( $this->taxonomy ),
			'hierarchical'        => true,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'menu_position'       => 10,
			'menu_icon'           => 'dashicons-groups',
			'show_in_admin_bar'   => true,
			'show_in_nav_menus'   => true,
			'can_export'          => true,
			'has_archive'         => true,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'capability_type'     => 'page',
		);

		$args = apply_filters( 'simplestaff_posttype_args', $args );
		register_post_type( $this->post_type, $args );

	}

	protected function register_taxonomy() {

		$this->taxonomy_label = array(
			'singular' => __( 'Department', 'simple-staff' ),
			'plural'   => __( 'Departments', 'simple-staff' ),
		);

		$labels = array(
			'name'                       => _x( '%2$s', 'Taxonomy General Name', 'simple-staff' ),
			'singular_name'              => _x( '%1$s', 'Taxonomy Singular Name', 'simple-staff' ),
			'menu_name'                  => __( '%2$s', 'simple-staff' ),
			'all_items'                  => __( 'All %2$s', 'simple-staff' ),
			'parent_item'                => __( 'Parent %1$s', 'simple-staff' ),
			'parent_item_colon'          => __( 'Parent %1$s:', 'simple-staff' ),
			'new_item_name'              => __( 'New %1$s Name', 'simple-staff' ),
			'add_new_item'               => __( 'Add New %1$s', 'simple-staff' ),
			'edit_item'                  => __( 'Edit %1$s', 'simple-staff' ),
			'update_item'                => __( 'Update %1$s', 'simple-staff' ),
			'view_item'                  => __( 'View %1$s', 'simple-staff' ),
			'separate_items_with_commas' => __( 'Separate %2$s with commas', 'simple-staff' ),
			'add_or_remove_items'        => __( 'Add or remove %2$s', 'simple-staff' ),
			'choose_from_most_used'      => __( 'Choose from the most used', 'simple-staff' ),
			'popular_items'              => __( 'Popular %1$ss', 'simple-staff' ),
			'search_items'               => __( 'Search %1$ss', 'simple-staff' ),
			'not_found'                  => __( 'Not Found', 'simple-staff' ),
		);

		foreach ( $labels as $key => $value ) {
			$labels[ $key ] = sprintf( $value, $this->taxonomy_label['singular'], $this->taxonomy_label['plural'] );
		}

		$rewrite = array(
			'slug'                       => 'department',
			'with_front'                 => true,
			'hierarchical'               => false,
		);
		$args = array(
			'labels'                     => $labels,
			'hierarchical'               => false,
			'public'                     => true,
			'show_ui'                    => true,
			'show_admin_column'          => true,
			'show_in_nav_menus'          => true,
			'show_tagcloud'              => false,
			'rewrite'                    => $rewrite,
		);
		$args = apply_filters( 'simplestaff_taxonomy_args', $args );
		register_taxonomy( $this->taxonomy, array( $this->post_type ), $args );

	}

	public function load_templates() {
		$parent = basename( get_template_directory() );
		if ( 'genesis' !== $parent ) {
			return;
		}
		add_filter( 'archive_template', array( $this, 'load_archive_template' ) );
		add_filter( 'single_template', array( $this, 'load_single_template' ) );
	}

	public function load_archive_template( $archive_template ) {
		if ( ( is_post_type_archive( $this->post_type ) || is_tax( $this->taxonomy ) ) && locate_template( '' !== 'archive-' . $this->post_type . '.php' ) ) {
			$archive_template = plugin_dir_path( dirname( __FILE__ ) ) . '/views/archive-' . $this->post_type . '.php';
		}
		return $archive_template;
	}

	public function load_single_template( $single_template ) {
		if ( is_singular( $this->post_type ) && locate_template( '' !== 'single-' . $this->post_type . '.php' ) ) {
			$single_template = plugin_dir_path( dirname( __FILE__ ) ) . '/views/single-' . $this->post_type . '.php';
		}
		return $single_template;
	}

	public function order_posts( $query ) {
		if ( $query->is_main_query() && ( is_post_type_archive( 'staff' ) || is_tax( 'department' ) ) ) {
			$query->set( 'orderby', 'menu_order' );
			$query->set( 'order', 'ASC' );
			$query->set( 'posts_per_page', -1 );
		}
	}

	// Show the department as a column
	function admin_column( $taxonomies ) {
		$taxonomies[] = 'department';
		return $taxonomies;
	}
}
