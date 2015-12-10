<?php

class SimpleStaff {

	protected $post_type;

	public function __construct( $post_type ) {
		$this->post_type = $post_type;
	}

	public function run() {

		add_action( 'widgets_init', array( $this, 'register_widget_area' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue' ) );

		add_action( 'init', array( $this->post_type, 'register' ) );
		add_action( 'after_setup_theme', array( $this->post_type, 'load_templates' ) );
		add_action( 'pre_get_posts', array( $this->post_type, 'order_posts' ), 9999 );
		add_filter( 'manage_taxonomies_for_staff_columns', array( $this->post_type, 'admin_column' ) );
	}

	/**
	 * Register sidebar to show after staff archive/single
	 */
	public function register_widget_area() {
		register_sidebar( array(
			'id'            => 'after-staff',
			'name'          => __( 'After Staff', 'simple-staff' ),
			'description'   => __( 'This is a widget area which will show after the staff archive page or single staff entry content.', 'simple-staff' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="widget-title">',
			'after_title'   => '</h4>',
		) );
	}

	public function enqueue() {
		if ( ( is_post_type_archive( 'staff' ) || is_tax( 'department' ) ) ) {
			$js_file  = apply_filters( 'simple_staff_js', plugins_url( '/views/staff.js', __FILE__ ) );
			$css_file = apply_filters( 'simple_staff_css', plugins_url( '/views/staff.css', __FILE__ ) );
			wp_enqueue_script( 'staff-fader', $js_file, array( 'jquery' ), '1.1.0', true );
			wp_enqueue_style( 'staff-style', $css_file, array(), '1.1.0' );
		}
	}

}
