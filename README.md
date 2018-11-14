# Tutty Meta Box Framework
Create custom fields with simple and easy to use WordPress meta box framework.

## Fields
- Text
- Number
- Textarea
- Upload
- Select
- Checkbox
- Switcher
- Heading Box

## Installation
#### -) Usage as Plugin
* Download files from GitHub or WordPress plugin directory.
* Copy to wp-content/plugins folder
* Active plugin.

#### -) Theme Integration
* Download files from GitHub.
* Copy to your theme folder. ( wp-content/themes/your-theme )
* Add the following codes to theme function file. ( your-theme/functions.php )

```php
require_once get_template_directory_uri() .'/tutty-metabox/tutty-metabox.php';
```

## Create custom fields meta box
* Open ___tutty-metabox-fields.php___ in framework folder.

| Key       | Default    | Desc
| --------- | ---------- | -----
| id        | required   | Meta box ID
| post_type | null       | Meta box post type
| title     | null       | Meta box title
| priority  | low        | Meta box priority (___low, high___)
| context   | normal     | The context within the screen where the boxes should display. Available contexts vary from screen to screen. (___normal, side, advanced___)

```php
$fields[] = array(
    'id'       => 'post_settings', // Meta box ID
    'title'    => 'Post Settings', // Meta box title
    'priority' => 'high', // Meta box priority
    'fields'   => array( // Meta box fields
        array(
            'id'      => 'text_field', // Field ID
            'title'   => 'Text Field', // Field Title
            'type'    => 'text', // Field Type
        ),
    ),
);
```
### Text Field - #text
| Key     | Default    | Desc
| ------- | ---------- | -----
| id      | required   | Field unique ID
| title   | null       | Field title
| default | null       | Field default value
| attr    | null       | Standart html attributes
| desc    | null       | Description of field
| sanitize| true       | Sanitize of field

```php
array(
    'id'      => 'text_field',
    'title'   => 'Text Field',
    'type'    => 'text',
    'desc'    => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.',
    'attr'    => array(
        'placeholder' => 'Placeholder value...',
        'maxlength'   => 5
    ),
)
```

### Number Field - #number
| Key     | Default    | Desc
| ------- | ---------- | -----
| id      | required   | Field unique ID
| title   | null       | Field title
| default | null       | Field default value
| attr    | null       | Standart html attributes
| desc    | null       | Description of field
| sanitize| true       | Sanitize of field

```php
array(
    'id'      => 'number_field',
    'title'   => 'Number Field',
    'type'    => 'number',
    'desc'    => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.',
    'attr'    => array(
        'placeholder' => 'Placeholder value...',
        'min'         => 1000,
        'max'         => 2000,
    ),
)
```

### Textarea Field - #textarea
| Key     | Default    | Desc
| ------- | ---------- | -----
| id      | required   | Field unique ID
| title   | null       | Field title
| default | null       | Field default value
| attr    | null       | Standart html attributes
| desc    | null       | Description of field
| sanitize| true       | Sanitize of field

```php
array(
    'id'      => 'textarea_field',
    'title'   => 'Textarea Field',
    'type'    => 'textarea',
    'desc'    => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.',
)
```

### Upload Field - #upload
| Key          | Default      | Desc
| ------------ | ------------ | -----
| id           | required     | Field unique ID
| title        | null         | Field title
| default      | null         | Field default value
| button_title | Upload Image | Upload button title
| desc         | null         | Description of field
| sanitize     | true         | Sanitize of field

```php
array(
    'id'           => 'upload_field',
    'type'         => 'upload',
    'title'        => 'Upload Field',
    'button_title' => 'Upload'
),
```

### Select Field - #select
| Key     | Default    | Desc
| ------- | ---------- | -----
| id      | required   | Field unique ID
| title   | null       | Field title
| default | null       | Field default value
| attr    | null       | Standart html attributes
| desc    | null       | Description of field
| options | null       | Options of select box. (___categories, pages, post_types or custom options___)

```php
// You can use categories, pages, post_types
array(
    'id'      => 'category_select',
    'type'    => 'select',
    'title'   => 'Category Select',
    'options' => 'categories'
),

// Custom Select Box
array(
    'id'      => 'custom_select',
    'type'    => 'select',
    'title'   => 'Custom Select',
    'default' => 'turkish',
    'options' => array(
        'english' => 'English',
        'turkish' => 'Türkçe',
        'german'  => 'Deutsch',
    ),
),

// Custom Select Box
array(
    'id'      => 'custom_select',
    'type'    => 'select',
    'title'   => 'Custom Select',
    'default' => 1,
    'options' => [ 'English', 'Türkçe', 'Deutsch' ],
    'attr'    => array(
      'multiple' => 'only-key',
      'style'    => 'width:200px'
    ),
),
```

### Checkbox Field - #checkbox
| Key     | Default    | Desc
| ------- | ---------- | -----
| id      | required   | Field unique ID
| title   | null       | Field title
| default | null       | Field default value
| attr    | null       | Standart html attributes
| desc    | null       | Description of field
| options | null       | Options of select box. (___categories, pages, post_types or custom options___)

```php
// You can use categories, pages, post_types
array(
    'id'      => 'page_checkbox',
    'type'    => 'checkbox',
    'title'   => 'Page Checkbox',
    'options' => 'pages',
),

// Custom checkbox
array(
    'id'      => 'custom_checkbox',
    'type'    => 'checkbox',
    'title'   => 'Custom Checkbox',
    'options' => [ 'English', 'Türkçe', 'Deutsch' ],
    'default' => [ 1,2 ]
),
```

### Switcher Field - #switcher
| Key     | Default    | Desc
| ------- | ---------- | -----
| id      | required   | Field unique ID
| title   | null       | Field title
| default | null       | Field default value
| desc    | null       | Description of field

```php
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
```

### Heading Field - #heading
| Key     | Default    | Desc
| ------- | ---------- | -----
| title   | null       | Heading box title
| content | null       | Heading box content

```php
array(
    'type'    => 'heading',
    'title'   => 'Lorem Ipsum',
    'content' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.'
),
```
