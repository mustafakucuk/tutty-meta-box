<?php if( ! defined( 'ABSPATH' ) ) { die; }


$fields = array();

$fields[] = array(
    'id'     => 'post_settings',
    'title'  => 'Post Settings',
    'priority' => 'high',
    'fields' => array(
        array(
            'id'      => 'number_fields',
            'title'   => 'Number Field',
            'type'    => 'number',
        ),
        array(
            'id'      => 'text_field',
            'title'   => 'Text Field',
            'type'    => 'text',
        ),
        array(
            'id'      => 'text_field_default',
            'title'   => 'Text Field with Default',
            'default' => 'This is a default value.',
            'type'    => 'text',
        ),
        array(
            'id'      => 'text_field_maxlength',
            'title'   => 'Text Field maxlength',
            'type'    => 'text',
            'attr'    => array(
                'placeholder' => 'Placeholder value...',
                'maxlength'   => 5
            ),
        ),
        array(
            'id'      => 'text_field_readonly',
            'default' => 'This readonly text field.',            
            'title'   => 'Text Field Readonly',
            'type'    => 'text',
            'attr'    => array(
                'readonly' => 'only-key'
            ),
        ),
        array(
            'id'       => 'textarea_field',
            'title'    => 'Textarea Field',
            'type'     => 'textarea',
            'sanitize' => false
        ),
        array(
            'id'      => 'category_select',
            'desc'    => 'This is a category select box.',
            'title'   => 'Category Select',
            'type'    => 'select',
            'options' => 'categories'
        ),
        array(
            'id'      => 'category_select_multiple',
            'desc'    => 'This is a multiple category select box.',
            'title'   => 'Multiple Select',
            'type'    => 'select',
            'attr'    => array(
                'multiple' => 'only-key',
                'style'    => 'width:200px'
            ),
            'options' => 'categories'
        ),
        array(
            'id'      => 'page_select',
            'desc'    => 'This is a page select box.',
            'title'   => 'Page Select',
            'type'    => 'select',
            'options' => 'pages'
        ),
        array(
            'id'      => 'custom_select',
            'desc'    => 'This is a custom select box with default option.',
            'title'   => 'Custom Select',
            'type'    => 'select',
            'default' => 'turkish',
            'options' => array(
                'english' => 'English',
                'turkish' => 'Türkçe',
                'german'  => 'Deutsch',
            ),
        ),
        array(
            'type'    => 'heading',
            'title'   => 'Lorem Ipsum',
            'content' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.'
        ),
        array(
            'id'      => 'upload_field',
            'type'    => 'upload',
            'title'   => 'Upload Field',
        ),
        array(
            'id'      => 'page_checkbox',
            'type'    => 'checkbox',
            'title'   => 'Page Checkbox',
            'options' => 'pages',
        ),
        array(
            'id'      => 'custom_checkbox',
            'type'    => 'checkbox',
            'title'   => 'Custom Checkbox',
            'options' => [ 'English', 'Türkçe', 'Deutsch' ],
            'default' => [ 1,2 ]
        ),
        array(
            'id'      => 'switcher_field',
            'type'    => 'switcher',
            'title'   => 'Switcher Field',
        ),
        array(
            'id'      => 'switcher_field_default',
            'desc'    => 'This is a switcher field with default value.',
            'type'    => 'switcher',
            'title'   => 'Switcher Field',
            'default' => 'on'
        ),
    )
);

new Tutty_MetaBox( $fields );