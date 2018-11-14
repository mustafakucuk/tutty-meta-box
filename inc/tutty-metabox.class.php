<?php if( ! defined( 'ABSPATH' ) ) { die; }

class Tutty_MetaBox {

    public $metabox;

    public function __construct( $metabox )
    {
        $this->metabox = $metabox;
        add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
        add_action( 'save_post', array( $this, 'save_meta_box' ), 10, 2 );
    }

    public function get_post( $post, $depth = '' )
    {
        if( $depth != '' && isset( $_POST[$post][$depth] ) || $depth == '' && isset( $_POST[$post] ) ){
            return ( $depth != '' ? $_POST[$post][$depth] : $_POST[$post] );
        }
    }

    public function add_meta_box()
    {
        foreach( $this->metabox as $metabox_value ) {
            $metabox_value = array_merge( array(
                'title'    => 'Tutty Meta Box',
                'context'  => 'normal',
                'priority' => 'low',
                'post_type' => null,
            ), $metabox_value );
            add_meta_box( $metabox_value['id'], $metabox_value['title'], array( $this, 'render_metabox' ), $metabox_value['post_type'], $metabox_value['context'], $metabox_value['priority'], $metabox_value );
        }
    }

    public function save_meta_box( $post_id )
    {
        if ( !isset( $_POST['tutty_meta_box_nonce'] ) || !wp_verify_nonce( $_POST['tutty_meta_box_nonce'], basename( __FILE__ ) ) ){
            return;
        }
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ){
            return;
        }
        if ( ! current_user_can( 'edit_post', $post_id ) ){
            return;
        }
                
        $metaboxes = $this->metabox;

        foreach( $metaboxes as $metabox ) {
            $metabox_id = $metabox['id'];
            $fields = $metabox['fields'];
            $field_value = $this->get_post( $metabox_id );
            foreach( $fields as $field ) {
                if( ! is_array( $field_value[$field['id']] ) ) {
                    if( ! isset( $field['sanitize'] ) || $field['sanitize'] == true ) {
                        $field_value[$field['id']] = wp_filter_nohtml_kses( $field_value[$field['id']] );
                    }
                }
                update_post_meta( $post_id, $metabox_id, $field_value );

            }
        }

    }

    public function render_metabox( $post, $callback )
    {
        $fields     = $callback['args']['fields'];
        $metabox_id = $callback['args']['id'];
        $meta_value = get_post_meta( $post->ID, $metabox_id, true );
        print_r($meta_value);

        foreach( $fields as $field ) {
            $field_id = ( isset( $field['id'] ) ? $field['id'] : '' );
            $default_value = ( isset( $field['default'] ) ? $field['default'] : '' );
            $field_value = ( is_array( $meta_value ) && isset( $meta_value[$field_id] ) ? $meta_value[$field_id] : $default_value );
            $this->render_element( $field, $field_value, $metabox_id );
        }
    }

    public function element_attr( $field ) 
    {
        $attr = ( isset( $field['attr'] ) ? $field['attr'] : [] );

        $atts = '';

        if( ! empty( $attr ) ) {
            foreach( $attr as $key => $value ) {
                if( $value == 'only-key' ) {
                    $atts .= ' ' . $key;
                } else {
                    $atts .=  ' ' . $key . '="'.$value.'"';
                }
            }
        }

        return $atts;
    }

    public function element_data( $option )
    {
        $options = [];

        switch( $option ) {
            case 'categories':
            case 'category':
                foreach( get_categories() as $category ) {
                    $options[$category->term_id] = $category->name;
                }
            break;
            
            case 'pages':
            case 'page':
                foreach( get_pages() as $page ) {
                    $options[$page->ID] = $page->post_title;
                }
            break;

            case 'post_types':
            case 'post_type':
                foreach( get_post_types( array( 'show_in_nav_menus' => true ) ) as $post_type ) {
                    $options[$post_type] = $post_type;
                }
            break;            
        }

        return $options;
    }

    public function render_element( $field, $field_value = '', $metabox_id )
    {
        wp_nonce_field( basename( __FILE__ ), 'tutty_meta_box_nonce' );
        $type = $field['type'];
        $class = ( isset( $field['class'] ) ? ' ' . $field['class'] : '' );
        $id    = ( isset( $field['id'] ) ? $field['id'] : '' );
        $multiple = ( isset( $field['attr']['multiple'] ) ? true : false );
        $name = $metabox_id . "[$id]";
        $name = ( $multiple ? $name . '[]' : $name );
        $out  = '<div class="tutty-element'.$class.' tutty-element-'.$type.'">';
        if( isset( $field['title'] ) && $type != 'heading' ) {
            $out .= '<div class="tutty-element-title"><label for="'.$id.'">'.$field['title'].'</label></div>';
        }
        
        $out .= '<div class="tutty-element-f">';
        switch( $type ) {
            case 'text' :
                $out .= '<input type="text" name="'.$name.'" id="'.$id.'" value="'.$field_value.'" '.$this->element_attr( $field ).'>';
            break;
            
            case 'number' :
                $out .= '<input type="number" name="'.$name.'" id="'.$id.'" value="'.$field_value.'" '.$this->element_attr( $field ).'>';
            break;
            
            case 'select' :
                $options = ( is_array( $field['options'] ) ? $field['options'] : $this->element_data( $field['options'] ) );
                if( ! empty( $options ) ) {
                    $out .= '<select name="'.$name.'" id="'.$id.'" '.$this->element_attr( $field ).'>';
                        if( ! empty( $options ) ) {
                            foreach( $options as $key => $option ) {
                                $selected = ( $multiple && is_array( $field_value ) && ! empty( $field_value ) && in_array( $key, $field_value ) ? 'selected' : ( $key == $field_value ? 'selected' : '' ) );
                                $out .= '<option value="'.$key.'" '.$selected.' >'.$option.'</option>';
                            }
                        } else {
                            $out .= $this->select_data( $field['options'] );
                        }
                    $out .= '</select>';
                } else {
                    $out .= '<label>Error! No data found.</label>';
                }
            break;

            case 'switcher' :
                $out .= '<input type="checkbox" id="'.$id.'" name="'.$name.'" '.( $field_value === 'on' ? 'checked' : '' ).' /><label for="'.$id.'"></label>';
            break;

            case 'checkbox' :
                $options = ( is_array( $field['options'] ) ? $field['options'] : $this->element_data( $field['options'] ) );
                if( isset( $field['label'] ) ) {
                    $out .= '<label for="'.$id.'"><input type="checkbox" id="'.$id.'" name="'.$name.'" '.( $field_value === 'on' ? 'checked' : '' ).'/>'.$field['label'].'</label>';
                }

                if( ! empty( $options ) ) {
                    foreach( $options as $key => $option ) {
                        $checked = ( is_array( $field_value ) && in_array( $key, $field_value ) ? 'checked' : ( $field_value != '' && $field_value == $key ? 'checked' : '' ) );
                        $id = "{$id}_$key";
                        $out .= '<label for="'.$id.'"><input type="checkbox" id="'.$id.'" name="'.$name.'[]" value="'.$key.'" '.$checked.'/>'.$option.'</label>';
                    }
                }
            break;

            case 'textarea' :
                $out .= '<textarea name="'.$name.'" id="'.$id.'" '.$this->element_attr( $field ).'>'.$field_value.'</textarea>';
            break;

            case 'upload' :
                $button_title = ( isset( $field['button_title'] ) && $field['button_title'] != '' ? $field['button_title'] : 'Upload Image' );
                $out          .= '<input type="text" name="'.$name.'" class="'.$id.'" id="'.$id.'" value="'.$field_value.'">';
                $out          .= '<input type="button" class="button button-primary tutty_upload_button" data-relation=".'.$id.'" value="'.$button_title.'">';
            break;            

            case 'heading' :
                $out .= '<div class="tutty-heading">';
                if( isset( $field['title'] ) ){
                    $out .= '<span class="tutty-heading-title">'.$field['title'].'</span>';
                }
                if( isset( $field['content'] ) ){
                    $out .= '<span class="tutty-heading-content">'.$field['content'].'</span>';
                }
                $out .= '</div>';
            break;

            default:
            $out .= '<label>Error! Invalid type.</label>';
            break;
        }
        $out .= '</div>';

        if( isset( $field['desc'] ) ) {
            $out .= '<div class="tutty-element-desc"><p>'.$field['desc'].'</p></div>';
        }


        $out .= '</div>';
        
        echo $out;

    }

}