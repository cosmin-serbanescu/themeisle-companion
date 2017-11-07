<?php
/**
 * Orbit Fox Elementor Features Widget
 *
 * @link       https://themeisle.com
 * @since      1.0.0
 *
 * @package    Elementor_Widgets_OBFX_Module
 */
namespace Elementor;


if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

/**
 * Class OBFX_Elementor_Widget_Features
 *
 * @package Elementor_Widgets_OBFX_Module
 */
class OBFX_Elementor_Widget_Posts_Grid extends Widget_Base {
	/**
	 * Set the widget ID
	 *
	 * @return string
	 */
	public function get_id() {
		return 'obfx-widget-posts-grid';
	}

	/**
	 * Widget title.
	 *
	 * @return string
	 */
	public function get_title() {
		return __( 'Post Type Grid', 'themeisle-companion' );
	}

	/**
	 * Widget icon.
	 *
	 * @return string
	 */
	public function get_icon() {
		return 'eicon-posts-grid';
	}

	/**
	 * Widget name.
	 *
	 * @return string
	 */
	public function get_name() {
		return 'obfx-posts-grid';
	}

	/**
	 * Widget Category.
	 *
	 * @return array
	 */
	public function get_categories() {
		return [ 'obfx-elementor-widgets' ];
	}

	/**
	 * Get post types.
	 */
	private function grid_get_all_post_types() {
		$options = array();
		$exclude = array( 'attachment', 'elementor_library' ); // excluded post types

		$args = array(
			'public' => true,
		);

		foreach ( get_post_types( $args, 'objects' ) as $post_type ) {
			// Check if post type name exists.
			if ( ! isset( $post_type->name ) ) {
				continue;
			}

			// Check if post type label exists.
			if ( ! isset( $post_type->label ) ) {
				continue;
			}

			// Check if post type is excluded.
			if ( in_array( $post_type->name, $exclude ) === true ) {
				continue;
			}

			$options[$post_type->name] = $post_type->label;
		}

		return $options;
	}

	/**
	 * Register Elementor Controls.
	 */
	protected function _register_controls() {
	    // Content.
		$this->grid_options_section();
		$this->grid_image_section();
		$this->grid_title_section();
		$this->grid_meta_section();
		$this->grid_content_section();
		// Style.
		$this->grid_options_style_section();
		$this->grid_image_style_section();
		$this->grid_title_style_section();
		$this->grid_meta_style_section();
		$this->grid_content_style_section();
	}

	/**
	 * Content > Grid.
	 */
	private function grid_options_section() {
		$this->start_controls_section(
			'section_grid',
			[
				'label' => __( 'Grid Options', 'themeisle-companion' ),
			]

		);

		// Post type.
		$this->add_control(
			'grid_post_type',
			[
				'type'    => Controls_Manager::SELECT,
				'label'   => '<i class="fa fa-tag"></i> ' . __( 'Post Type', 'themeisle-companion' ),
				'default' => 'post',
				'options' => $this->grid_get_all_post_types(),
			]
		);

		// Style.
		$this->add_control(
			'grid_style',
			[
				'type'    => Controls_Manager::SELECT,
				'label'   => '<i class="fa fa-paint-brush"></i> ' . __( 'Style', 'themeisle-companion' ),
				'default' => 'grid',
				'options' => [
					'grid'  => __( 'Grid', 'themeisle-companion' ),
					'list' => __( 'List', 'themeisle-companion' ),
				],
			]
		);

		// Items.
		$this->add_control(
			'grid_items',
			[
				'type'        => Controls_Manager::NUMBER,
				'label'       => '<i class="fa fa-th-large"></i> ' . __( 'Items', 'themeisle-companion' ),
				'placeholder' => __( 'How many items?', 'themeisle-companion' ),
				'default'     => __( '3', 'themeisle-companion' ),
			]
		);

		// Columns.
		$this->add_responsive_control(
			'grid_columns',
			[
				'type'        => Controls_Manager::SELECT,
				'label'       => '<i class="fa fa-columns"></i> ' . __( 'Columns', 'themeisle-companion' ),
				'default' => 3,
                'tablet_default' => 2,
                'mobile_default'=> 1,
				'options' => [
					1 => 1,
					2 => 2,
					3 => 3,
					4 => 4,
					5 => 5,
				],
			]
		);

		// Order by.
		$this->add_control(
			'grid_order_by',
			[
				'type'    => Controls_Manager::SELECT,
				'label'   => '<i class="fa fa-sort"></i> ' . __( 'Order by', 'themeisle-companion' ),
				'default' => 'date',
				'options' => [
					'date'          => __( 'Date', 'themeisle-companion' ),
					'title'         => __( 'Title', 'themeisle-companion' ),
					'modified'      => __( 'Modified date', 'themeisle-companion' ),
					'comment_count' => __( 'Comment count', 'themeisle-companion' ),
					'rand'          => __( 'Random', 'themeisle-companion' ),
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Content > Image Options.
	 */
	private function grid_image_section() {
		$this->start_controls_section(
			'section_grid_image',
			[
				'label' => __( 'Image', 'themeisle-companion' ),
			]

		);

		// Hide image.
		$this->add_control(
			'grid_image_hide',
			[
				'label' => '<i class="fa fa-minus-circle"></i> ' . __( 'Hide', 'themeisle-companion' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => '',
			]
		);

		// Image ratio.
		$this->add_responsive_control(
			'grid_image_height',
			[
				'label' => '<i class="fa fa-arrows-h"></i> ' . __( 'Image height', 'themeisle-companion' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 240,
				],
				'tablet_default' => [
					'size' => 240,
				],
				'mobile_default' => [
					'size' => 240,
				],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 1000,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .obfx-grid-col-image' => 'height: {{SIZE}}{{UNIT}};'
				],
			]
		);

		// Image link.
		$this->add_control(
			'grid_image_link',
			[
				'label' => '<i class="fa fa-link"></i> ' . __( 'Link', 'themeisle-companion' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Content > Title Options.
	 */
	private function grid_title_section() {
		$this->start_controls_section(
			'section_grid_title',
			[
				'label'     => __( 'Title', 'themeisle-companion' ),
			]

		);

		// Hide title.
		$this->add_control(
			'grid_title_hide',
			[
				'label' => '<i class="fa fa-minus-circle"></i> ' . __( 'Hide', 'themeisle-companion' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => '',
			]
		);

		// Title tag.
		$this->add_control(
			'grid_title_tag',
			[
				'type'    => Controls_Manager::SELECT,
				'label'   => '<i class="fa fa-code"></i> ' . __( 'Tag', 'themeisle-companion' ),
				'default' => 'h2',
				'options' => [
					'h1' => 'H1',
					'h2' => 'H2',
					'h3' => 'H3',
					'h4' => 'H4',
					'h5' => 'H5',
					'h6' => 'Hh6',
                    'span' => 'span',
					'p' => 'p',
                    'div' => 'div',
				],
			]
		);

		// Title link.
		$this->add_control(
			'grid_title_link',
			[
				'label' => '<i class="fa fa-link"></i> ' . __( 'Link', 'themeisle-companion' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Content > Meta Options.
	 */
	private function grid_meta_section() {
		$this->start_controls_section(
			'section_grid_meta',
			[
				'label'     => __( 'Meta', 'themeisle-companion' ),
			]

		);

		// Hide content.
		$this->add_control(
			'grid_meta_hide',
			[
				'label' => '<i class="fa fa-minus-circle"></i> ' . __( 'Hide', 'themeisle-companion' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => '',
			]
		);

		// Meta.
		$this->add_control(
			'grid_meta_display',
			[
				'label' => '<i class="fa fa-info-circle"></i> ' . __( 'Display', 'themeisle-companion' ),
				'label_block' => true,
				'type' => Controls_Manager::SELECT2,
				'default' => [ 'author', 'date' ],
				'multiple' => true,
				'options' => [
					'author' => __( 'Author', 'themeisle-companion' ),
					'date' => __( 'Date', 'themeisle-companion' ),
					'category' => __( 'Category', 'themeisle-companion' ),
					'tags' => __( 'Tags', 'themeisle-companion' ),
					'comments' => __( 'Comments', 'themeisle-companion' ),
				],
			]
		);

		// No. of Categories.
		$this->add_control(
			'grid_meta_categories_max',
			[
				'type'        => Controls_Manager::NUMBER,
				'label'       => __( 'No. of Categories', 'themeisle-companion' ),
				'placeholder' => __( 'How many categories to display?', 'themeisle-companion' ),
				'default'     => __( '1', 'themeisle-companion' ),
				'condition' => [
					'grid_meta_display' => 'category',
				],
			]
		);

		// No. of Tags.
		$this->add_control(
			'grid_meta_tags_max',
			[
				'type'        => Controls_Manager::NUMBER,
				'label'       => __( 'No. of Tags', 'themeisle-companion' ),
				'placeholder' => __( 'How many tags to display?', 'themeisle-companion' ),
				'condition' => [
					'grid_meta_display' => 'tags',
				],
			]
		);

		// Remove meta icons.
		$this->add_control(
			'grid_meta_remove_icons',
			[
				'label' => '<i class="fa fa-minus-circle"></i> ' . __( 'Remove icons', 'themeisle-companion' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => '',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Content > Content Options.
	 */
	private function grid_content_section() {
		$this->start_controls_section(
			'section_grid_content',
			[
				'label'     => __( 'Content', 'themeisle-companion' ),
			]

		);

		// Hide content.
		$this->add_control(
			'grid_content_hide',
			[
				'label' => '<i class="fa fa-minus-circle"></i> ' . __( 'Hide', 'themeisle-companion' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => '',
			]
		);

		// Length.
		$this->add_control(
			'grid_content_length',
			[
				'type'        => Controls_Manager::NUMBER,
				'label'       => '<i class="fa fa-arrows-h"></i> ' . __( 'Length (words)', 'themeisle-companion' ),
				'placeholder' => __( 'Length of content (words)', 'themeisle-companion' ),
				'default'     => __( '55', 'themeisle-companion' ),
			]
		);

		// Price.
		$this->add_control(
			'grid_content_price',
			[
				'label' => '<i class="fa fa-usd"></i> ' . __( 'Price', 'themeisle-companion' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'condition' => [
					'section_grid.grid_post_type' => 'product',
				],
			]
		);

		// Read more button hide.
		$this->add_control(
			'grid_content_default_btn',
			[
				'label' => '<i class="fa fa-check-square"></i> ' . __( 'Button', 'themeisle-companion' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => '',
				'condition' => [
					'section_grid.grid_post_type!' => 'product',
				],
			]
		);

		// Default button text.
		$this->add_control(
			'grid_content_default_btn_text',
			[
				'type'        => Controls_Manager::TEXT,
				'label'       => __( 'Button text', 'themeisle-companion' ),
				'placeholder' => __( 'Read more', 'themeisle-companion'),
				'default'     => __( 'Read more', 'themeisle-companion'),
				'condition' => [
                    'grid_content_default_btn!' => '',
					'section_grid.grid_post_type!' => 'product',
				],
			]
		);

		// Add to cart button hide.
		$this->add_control(
			'grid_content_product_btn',
			[
				'label' => '<i class="fa fa-check-square"></i> ' . __( 'Button', 'themeisle-companion' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'condition' => [
					'section_grid.grid_post_type' => 'product',
				],
			]
		);

		// Button alignment.
		$this->add_responsive_control(
			'grid_content_btn_alignment',
			[
				'label'     => __( 'Button alignment', 'themeisle-companion' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'left'    => [
						'title' => __( 'Left', 'themeisle-companion' ),
						'icon'  => 'fa fa-align-left',
					],
					'center'  => [
						'title' => __( 'Center', 'themeisle-companion' ),
						'icon'  => 'fa fa-align-center',
					],
					'right'   => [
						'title' => __( 'Right', 'themeisle-companion' ),
						'icon'  => 'fa fa-align-right',
					],
					'justify' => [
						'title' => __( 'Justified', 'themeisle-companion' ),
						'icon'  => 'fa fa-align-justify',
					],
				],
				'default'   => 'left',
				'tablet_default'   => 'left',
				'mobile_default'   => 'center',
				'selectors' => [
					'{{WRAPPER}} .obfx-grid-footer' => 'text-align: {{VALUE}};',
				],
				'condition' => [
					'grid_content_btn!' => '',
				],
			]
		);

		// Content alignment.
		$this->add_responsive_control(
			'grid_content_alignment',
			[
				'label'     => '<i class="fa fa-align-right"></i> ' . __( 'Alignment', 'themeisle-companion' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'left'    => [
						'title' => __( 'Left', 'themeisle-companion' ),
						'icon'  => 'fa fa-align-left',
					],
					'center'  => [
						'title' => __( 'Center', 'themeisle-companion' ),
						'icon'  => 'fa fa-align-center',
					],
					'right'   => [
						'title' => __( 'Right', 'themeisle-companion' ),
						'icon'  => 'fa fa-align-right',
					],
				],
				'default'   => 'left',
				'tablet_default'   => 'left',
				'mobile_default'   => 'center',
				'selectors' => [
					'{{WRAPPER}} .obfx-grid-col-content' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Style > Grid options.
	 */
	private function grid_options_style_section() {
	    // Tab.
		$this->start_controls_section(
			'section_grid_style',
			[
				'label' => __( 'Grid Options', 'themeisle-companion' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		// Columns margin.
		$this->add_control(
			'grid_style_columns_margin',
			[
				'label'     => __( 'Columns margin', 'elementor-pro' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'size' => 15,
				],
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .obfx-grid-wrapper' => 'padding-right: calc( {{SIZE}}{{UNIT}} ); padding-left: calc( {{SIZE}}{{UNIT}} );',
					'{{WRAPPER}} .obfx-grid-container' => 'margin-left: calc( -{{SIZE}}{{UNIT}} ); margin-right: calc( -{{SIZE}}{{UNIT}} );',
				],
			]
		);

		// Row margin.
		$this->add_control(
			'grid_style_rows_margin',
			[
				'label'     => __( 'Rows margin', 'elementor-pro' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'size' => 30,
				],
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .obfx-grid-wrapper' => 'padding-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		// Background.
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'grid_style_background',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .obfx-grid',
			]
		);

		// Items options.
		$this->add_control(
			'grid_items_style_heading',
			[
				'label'   => __( 'Items', 'themeisle-companion' ),
				'type'    => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		// Items internal padding.
		$this->add_control(
			'grid_items_style_padding',
			[
				'label'      => __( 'Padding', 'themeisle-companion' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .obfx-grid-col' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		// Items border radius.
		$this->add_control(
			'grid_items_style_border_radius',
			[
				'label'      => __( 'Border Radius', 'themeisle-companion' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .obfx-grid-col' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		// Background for items options.
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'grid_items_style_background',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .obfx-grid-col',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Style > Image.
	 */
	private function grid_image_style_section() {
		// Tab.
		$this->start_controls_section(
			'section_grid_image_style',
			[
				'label' => __( 'Image', 'themeisle-companion' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'section_grid_image.grid_image_hide' => '',
				],
			]
		);

		// Image border radius.
		$this->add_control(
			'grid_image_style_border_radius',
			[
				'label'      => __( 'Border Radius', 'themeisle-companion' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .obfx-grid-col-image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'section_grid_image.grid_image_hide' => '',
				],
			]
		);

		// Image box shadow.
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'grid_image_style_box_shadow',
				'selector'  => '{{WRAPPER}} .obfx-grid-col-image',
				'separator' => '',
				'condition' => [
					'section_grid_image.grid_image_hide' => '',
				],
			]
		);

		// Image margin.
		$this->add_control(
			'grid_image_style_margin',
			[
				'label'      => __( 'Margin', 'themeisle-companion' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .obfx-grid-col-image' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'section_grid_image.grid_image_hide' => '',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Style > Title.
	 */
	private function grid_title_style_section() {
		// Tab.
		$this->start_controls_section(
			'section_grid_title_style',
			[
				'label' => __( 'Title', 'themeisle-companion' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'section_grid_title.grid_title_hide' => '',
				],
			]
		);

		// Title typography.
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'grid_title_style_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .obfx-grid-title',
			]
		);

		// Title color.
		$this->add_control(
			'grid_title_style_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Color', 'themeisle-companion' ),
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .obfx-grid-title' => 'color: {{VALUE}};',
					'{{WRAPPER}} .obfx-grid-title a' => 'color: {{VALUE}};',
				],
			]
		);

		// Title margin.
		$this->add_control(
			'grid_title_style_margin',
			[
				'label'      => __( 'Margin', 'themeisle-companion' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .obfx-grid-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Style > Meta.
	 */
	private function grid_meta_style_section() {
		// Tab.
		$this->start_controls_section(
			'section_grid_meta_style',
			[
				'label' => __( 'Meta', 'themeisle-companion' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'section_grid_meta.grid_meta_hide' => '',
				],
			]
		);

		// Meta typography.
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'grid_meta_style_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .obfx-grid-meta',
			]
		);

		// Meta color.
		$this->add_control(
			'grid_meta_style_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Color', 'themeisle-companion' ),
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .obfx-grid-meta' => 'color: {{VALUE}};',
					'{{WRAPPER}} .obfx-grid-meta a' => 'color: {{VALUE}};',
				],
			]
		);

		// Meta margin.
		$this->add_control(
			'grid_meta_style_margin',
			[
				'label'      => __( 'Margin', 'themeisle-companion' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .obfx-grid-meta' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Style > Content.
	 */
	private function grid_content_style_section() {
		// Tab.
		$this->start_controls_section(
			'section_grid_content_style',
			[
				'label' => __( 'Content', 'themeisle-companion' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		// Content typography.
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'grid_content_style_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .obfx-grid-content',
				'condition' => [
					'section_grid_content.grid_content_hide' => '',
				],
			]
		);

		// Content color.
		$this->add_control(
			'grid_content_style_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Color', 'themeisle-companion' ),
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .obfx-grid-content' => 'color: {{VALUE}};',
				],
				'condition' => [
					'section_grid_content.grid_content_hide' => '',
				],
			]
		);

		// Content margin
		$this->add_control(
			'grid_content_style_margin',
			[
				'label'      => __( 'Margin', 'themeisle-companion' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .obfx-grid-content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'section_grid_content.grid_content_hide' => '',
				],
			]
		);

		// Heading for price options.
		$this->add_control(
			'grid_content_price_style_heading',
			[
				'label'   => __( 'Price', 'themeisle-companion' ),
				'type'    => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'section_grid_content.grid_content_price' => 'yes',
					'section_grid.grid_post_type' => 'product',
				],
			]
		);

		// Price typography.
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'grid_content_price_style_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .obfx-grid-price',
				'condition' => [
					'section_grid_content.grid_content_price' => 'yes',
					'section_grid.grid_post_type' => 'product',
				],
			]
		);

		// Price color.
		$this->add_control(
			'grid_content_price_style_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Color', 'themeisle-companion' ),
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .obfx-grid-price' => 'color: {{VALUE}};',
				],
				'condition' => [
					'section_grid_content.grid_content_price' => 'yes',
					'section_grid.grid_post_type' => 'product',
				],
			]
		);

		// Price bottom margin.
		$this->add_control(
			'grid_content_price_style_margin',
			[
				'label'      => __( 'Margin', 'themeisle-companion' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .obfx-grid-price' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'section_grid_content.grid_content_price' => 'yes',
					'section_grid.grid_post_type' => 'product',
				],
			]
		);

		// Buttons options.
		$this->grid_content_style_button();

		$this->end_controls_section();
	}

	/**
	 * Tabs for the Style > Button section.
	 */
	private function grid_content_style_button() {
	    // Heading for button options.
		$this->add_control(
			'grid_button_style_heading',
			[
				'label'   => __( 'Button', 'themeisle-companion' ),
				'type'    => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'section_grid_content.grid_content_default_btn!' => '',
					'section_grid_content.grid_content_product_btn!' => '',
				],
			]
		);

		$this->start_controls_tabs( 'grid_button_style' );

		// Normal tab.
		$this->start_controls_tab(
			'grid_button_style_normal',
			[
				'label' => __( 'Normal', 'themeisle-companion' ),
				'condition' => [
					'section_grid_content.grid_content_default_btn!' => '',
					'section_grid_content.grid_content_product_btn!' => '',
				],
			]
		);

		// Normal text color.
		$this->add_control(
			'grid_button_style_normal_text_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Text Color', 'themeisle-companion' ),
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .obfx-grid-footer a' => 'color: {{VALUE}};',
				],
				'condition' => [
					'section_grid_content.grid_content_default_btn!' => '',
					'section_grid_content.grid_content_product_btn!' => '',
				],
			]
		);

		// Normal background color.
		$this->add_control(
			'grid_button_style_normal_bg_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Background Color', 'themeisle-companion' ),
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .obfx-grid-footer a' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'section_grid_content.grid_content_default_btn!' => '',
					'section_grid_content.grid_content_product_btn!' => '',
				],
			]
		);

		// Normal box shadow.
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'grid_button_style_normal_box_shadow',
				'selector'  => '{{WRAPPER}} .obfx-grid-footer a',
				'separator' => '',
				'condition' => [
					'section_grid_content.grid_content_default_btn!' => '',
					'section_grid_content.grid_content_product_btn!' => '',
				],
			]
		);

		$this->end_controls_tab();

		// Hover tab.
		$this->start_controls_tab(
			'grid_button_style_hover',
			[
				'label' => __( 'Hover', 'themeisle-companion' ),
				'condition' => [
					'section_grid_content.grid_content_default_btn!' => '',
					'section_grid_content.grid_content_product_btn!' => '',
				],
			]
		);

		// Hover text color.
		$this->add_control(
			'grid_button_style_hover_text_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Text Color', 'themeisle-companion' ),
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .obfx-grid-footer a:hover' => 'color: {{VALUE}};',
				],
				'condition' => [
					'section_grid_content.grid_content_default_btn!' => '',
					'section_grid_content.grid_content_product_btn!' => '',
				],
			]
		);

		// Hover background color.
		$this->add_control(
			'grid_button_style_hover_bg_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Background Color', 'themeisle-companion' ),
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .obfx-grid-footer a:hover' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'section_grid_content.grid_content_default_btn!' => '',
					'section_grid_content.grid_content_product_btn!' => '',
				],
			]
		);

		// Hover box shadow.
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'grid_button_style_hover_box_shadow',
				'selector'  => '{{WRAPPER}} .obfx-grid-footer a:hover',
				'separator' => '',
				'condition' => [
					'section_grid_content.grid_content_default_btn!' => '',
					'section_grid_content.grid_content_product_btn!' => '',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		// Button padding.
		$this->add_control(
			'grid_button_style_padding',
			[
				'label'      => __( 'Button padding', 'themeisle-companion' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .obfx-grid-footer a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'section_grid_content.grid_content_default_btn!' => '',
					'section_grid_content.grid_content_product_btn!' => '',
				],
			]
		);

		// Button border radius.
		$this->add_control(
			'grid_button_style_border_radius',
			[
				'label'      => __( 'Button border radius', 'themeisle-companion' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .obfx-grid-footer a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'section_grid_content.grid_content_default_btn!' => '',
					'section_grid_content.grid_content_product_btn!' => '',
				],
			]
		);
	}

	/**
	 * Display categories in meta section.
	 */
	protected function metaGridCategories() {
		$settings = $this->get_settings();
		$post_type_category = get_the_category();
		$maxCategories = $settings['grid_meta_categories_max'] ? $settings['grid_meta_categories_max'] : '-1';
		$i = 0; // counter

		if ( $post_type_category ) { ?>
			<span class="obfx-grid-categories">
                <?php
                echo ( $settings['grid_meta_remove_icons'] == '' ) ? '<i class="fa fa-bookmark"></i>' : '';

                foreach ( $post_type_category as $category ) {
                    if ( $i == $maxCategories ) break;
                    ?>
                    <span class="obfx-grid-categories-item"><a href="<?php echo get_category_link( $category->term_id ); ?>" title="<?php echo $category->name; ?>"><?php echo $category->name; ?></a></span>
                    <?php
                    $i++;
                } ?>
            </span>
		<?php
	    }
    }

	/**
	 * Display tags in meta section.
	 */
	protected function metaGridTags() {
		$settings = $this->get_settings();
		$post_type_tags = get_the_tags();
		$maxTags = $settings['grid_meta_tags_max'] ? $settings['grid_meta_tags_max'] : '-1';
		$i = 0; // counter

		if ( $post_type_tags ) { ?>
            <span class="obfx-grid-tags">
                <?php
                echo ( $settings['grid_meta_remove_icons'] == '' ) ? '<i class="fa fa-tags"></i>' : '';

				foreach ( $post_type_tags as $tag ) {
					if ( $i == $maxTags )  break;
					?>
                    <span class="obfx-grid-tags-item"><a href="<?php echo get_tag_link( $tag->term_id ); ?>" title="<?php echo $tag->name; ?>"><?php echo $tag->name; ?></a></span>
					<?php
					$i++;
				} ?>
            </span>
			<?php
		}
	}

	/**
	 * Render image of post type.
	 */
	protected function renderImage() {
		$settings = $this->get_settings();

		// Only in editor.
		if ( $settings['grid_image_hide'] !== 'yes' ) {
		    /*if ( Plugin::$instance->editor->is_edit_mode() ) {*/
            // Check if post type has featured image.
            if ( has_post_thumbnail() ) {

                if ( $settings['grid_image_link'] == 'yes' ) { ?>
                    <div class="obfx-grid-col-image">
                        <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
	                        <?php
	                        the_post_thumbnail( 'full', array(
			                        'class' => 'img-responsive',
			                        'alt'	=> get_the_title( get_post_thumbnail_id() )
		                        )
	                        );
	                        ?>
                        </a>
                    </div>
                <?php } else { ?>
                    <div class="obfx-grid-col-image">
	                    <?php
	                    the_post_thumbnail( 'full', array(
			                    'class' => 'img-responsive',
			                    'alt'	=> get_the_title( get_post_thumbnail_id() )
		                    )
	                    );
	                    ?>
                    </div>
                <?php }
            }
        }
    }

	/**
	 * Render title of post type.
	 */
	protected function renderTitle() {
		$settings = $this->get_settings();

		if ( $settings['grid_title_hide'] !== 'yes' ) { ?>
            <<?php echo $settings['grid_title_tag']; ?> class="entry-title obfx-grid-title">
			<?php if ( $settings['grid_title_link'] == 'yes' ) { ?>
                <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title();
					?></a>
			<?php } else {
				the_title();
			} ?>
            </<?php echo $settings['grid_title_tag']; ?>>
		<?php }
    }

	/**
	 * Render meta of post type.
	 */
	protected function renderMeta() {
		$settings = $this->get_settings();

		if ( $settings['grid_meta_hide'] !== 'yes' ) {
		    if ( ! empty( $settings['grid_meta_display'] ) ) { ?>
                <div class="entry-meta obfx-grid-meta">

		        <?php foreach ( $settings['grid_meta_display'] as $meta ) {

		            switch ( $meta ):
                        // Author
                        case 'author': ?>
                            <span class="obfx-grid-author">
                                <?php
                                echo ( $settings['grid_meta_remove_icons'] == '' ) ? '<i class="fa fa-user"></i>' : '';

                                echo get_the_author();
                                ?>
                            </span>
                        <?php
                        // Date
                        break; case 'date' : ?>
                            <span class="obfx-grid-date">
                                <?php
                                echo ( $settings['grid_meta_remove_icons'] == '' ) ? '<i class="fa fa-calendar"></i>' : '';

                                echo get_the_date(); ?>
                            </span>
			            <?php
                        // Category
                        break; case 'category' :
			                $this->metaGridCategories();

                        // Tags
			            break; case 'tags' :
			                $this->metaGridTags();

                        // Comments/Reviews
                        break; case 'comments' : ?>
                            <span class="obfx-grid-comments">
                                <?php
                                echo ( $settings['grid_meta_remove_icons'] == '' ) ? '<i class="fa fa-comment"></i>' : '';

                                if ( $settings['grid_post_type'] == 'product' ) {
	                                echo comments_number( __( 'No reviews','themeisle-companion' ), __( '1 review','themeisle-companion' ), __( '% reviews','themeisle-companion' ));
                                } else {
	                                echo comments_number( __( 'No comments','themeisle-companion' ), __( '1 comment','themeisle-companion' ), __( '% comments','themeisle-companion' ));
                                }
                                ?>
                            </span>
                        <?php
                        break; endswitch;
			    } // end foreach ?>

                </div>
            <?php
		    }
		}
	}

	/**
	 * Display price if post type is product.
	 */
    protected function renderPrice() {
        $settings = $this->get_settings();
        $product = wc_get_product( get_the_ID() );

        if ( $settings['grid_post_type'] == 'product' && $settings['grid_content_price'] == 'yes' ) { ?>
            <div class="obfx-grid-price">
                <?php
					$price = $product->get_price_html();
					if ( ! empty( $price ) ) {
						echo wp_kses( $price, array(
							'span' => array(
								'class' => array(),
							),
							'del' => array(),
						) );
					}
                ?>
            </div>
        <?php
        }
    }

	/**
	 * Display Add to Cart button.
	 */
	protected function renderAddToCart() {
		$product = wc_get_product( get_the_ID() );

		echo apply_filters( 'woocommerce_loop_add_to_cart_link',
			sprintf( '<a href="%s" title="%s" rel="nofollow" class="button"><i class="fa fa-cart-plus"></i> %s</a>',
				esc_url( $product->add_to_cart_url() ),
				esc_attr( $product->add_to_cart_text() ),
				esc_html( $product->add_to_cart_text() )
			), $product );
	}

	/**
	 * Render content of post type.
	 */
	protected function renderContent() {
		$settings = $this->get_settings();

		if ( $settings['grid_content_hide'] !== 'yes' ) { ?>
            <div class="entry-content obfx-grid-content">
                <?php if ( empty ( $settings['grid_content_length'] ) ) {
	                the_excerpt();
                } else {
                    echo wp_trim_words( get_the_excerpt(),$settings['grid_content_length'] );
                }
                ?>
            </div>
		<?php }
    }

	/**
	 * Render button of post type.
	 */
	protected function renderButton() {
		$settings = $this->get_settings();

		if ( $settings['grid_post_type'] == 'product' && $settings['grid_content_product_btn'] == 'yes' && ! empty ( $settings['grid_content_product_btn_text'] ) ) { ?>
            <div class="obfx-grid-footer">
                <?php $this->renderAddToCart(); ?>
            </div>
        <?php } else if ( $settings['grid_content_default_btn'] == 'yes' && ! empty ( $settings['grid_content_default_btn_text'] ) ) { ?>
            <div class="obfx-grid-footer">
                <a href="<?php echo get_the_permalink(); ?>" title="<?php echo $settings['grid_content_default_btn_text']; ?>"><?php echo $settings['grid_content_default_btn_text']; ?></a>
            </div>
        <?php
		}
    }

	/**
	 * Render function to output the post type grid.
	 */
	protected function render() {
        // Get settings.
		$settings = $this->get_settings();

		// Output.
		echo '<div class="obfx-grid">';
		echo '<div class="obfx-grid-container' . ( ! empty( $settings['grid_style'] ) && $settings['grid_style'] == 'list'  ? ' obfx-grid-style-' . $settings['grid_style'] : '' ) . ( ! empty( $settings['grid_columns_mobile'] ) ? ' obfx-grid-mobile-' . $settings['grid_columns_mobile'] : '' ) . ( ! empty( $settings['grid_columns_tablet'] ) ? ' obfx-grid-tablet-' . $settings['grid_columns_tablet'] : '' ) . ( ! empty( $settings['grid_columns'] ) ? ' obfx-grid-desktop-' . $settings['grid_columns'] : '' ) .'">';

		// Arguments for query.
		$args = array();

		// Display only published posts.
		$args['post_status'] = 'publish';

		// Ignore sticky posts.
		$args['ignore_sticky_posts'] = 1;

		// Check if post type exists.
		if ( ! empty( $settings['grid_post_type'] ) && post_type_exists( $settings['grid_post_type'] ) ) {
		    $args['post_type'] = $settings['grid_post_type'];
		}

		// Items to display.
		if ( ! empty( $settings['grid_items'] ) &&  intval( $settings['grid_items'] ) == $settings['grid_items']  ) {
			$args['posts_per_page'] = $settings['grid_items'];
		}

		// Order by.
		if ( ! empty( $settings['grid_order_by'] ) ) {
			$args['orderby'] = $settings['grid_order_by'];
		}

        // Query.
        $query = new \WP_Query( $args );

        // Query results.
        if ( $query->have_posts() ) {
            while ( $query->have_posts() ) {
                $query->the_post();

	            echo '<div class="obfx-grid-wrapper">';
                echo '<article class="obfx-grid-col">';

                // Image.
	            $this->renderImage();

	            echo '<div class="obfx-grid-col-content">';
                // Title.
                $this->renderTitle();

                // Meta.
                $this->renderMeta();

	            // Price.
	            if ( class_exists( 'WooCommerce' ) ) {
		            $this->renderPrice();
	            }

                // Content.
                $this->renderContent();

                // Button.
                $this->renderButton();

	            echo '</div><!-- .obfx-grid-col-content -->';
                echo '</article>';
	            echo '</div>';

            } // end while;
        } // end if;

        // Restore original data.
        wp_reset_postdata();

		echo '</div><!-- .obfx-grid-container -->';
		echo '</div><!-- .obfx-grid -->';
	}
}

