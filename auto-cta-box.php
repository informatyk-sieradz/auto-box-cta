<?php
/*
Plugin Name: Auto CTA Box
Description: Adds customizable CTA boxes to WordPress posts with category-based CTAs and click statistics.
Version: 2.3
Author: Informatyk-Sieradz.pl
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/

if (!defined('ABSPATH')) exit;

function isb_cta_get_translations() {
    return array(
        'pl' => array(
            'title' => 'To jest przykładowy box CTA',
            'description' => 'Tutaj możesz dodać własny tekst zachęcający użytkownika do działania.',
            'button' => 'Dowiedz się więcej',
        ),
        'en' => array(
            'title' => 'This is a sample CTA box',
            'description' => 'You can place your own call to action message here.',
            'button' => 'Learn more',
        ),
        'de' => array(
            'title' => 'Dies ist eine Beispiel-CTA-Box',
            'description' => 'Hier können Sie Ihren eigenen Call-to-Action-Text hinzufügen.',
            'button' => 'Mehr erfahren',
        ),
        'ru' => array(
            'title' => 'Это пример блока CTA',
            'description' => 'Здесь вы можете добавить собственный призыв к действию.',
            'button' => 'Подробнее',
        ),
        'fr' => array(
            'title' => 'Ceci est un exemple de bloc CTA',
            'description' => 'Vous pouvez ajouter ici votre propre appel à l’action.',
            'button' => 'En savoir plus',
        ),
        'es' => array(
            'title' => 'Este es un ejemplo de bloque CTA',
            'description' => 'Aquí puedes agregar tu propio mensaje de llamada a la acción.',
            'button' => 'Más información',
        ),
    );
}

function isb_cta_admin_translations() {
    return array(
        'pl' => array(
            'page_title' => 'Auto CTA Box',
            'main_settings' => 'Ustawienia główne',
            'category_list' => 'Obecne kategorie w tym WordPressie',
            'global_preview' => 'Podgląd globalnego CTA',
            'category_settings' => 'CTA dla kategorii',
            'category_preview' => 'Podgląd CTA dla tej kategorii',
            'statistics' => 'Statystyki kliknięć',
            'enable' => 'Włącz CTA',
            'language' => 'Język interfejsu i domyślnych tekstów',
            'positions' => 'Pozycja CTA',
            'start' => 'Na początku artykułu',
            'middle' => 'W środku artykułu',
            'end' => 'Na końcu artykułu',
            'multiple_positions' => 'Możesz zaznaczyć więcej niż jedną pozycję.',
            'title' => 'Tytuł CTA',
            'description' => 'Opis CTA',
            'button_text' => 'Tekst przycisku',
            'button_url' => 'Link przycisku',
            'bg_color' => 'Kolor tła CTA',
            'text_color' => 'Kolor tekstu',
            'button_color' => 'Kolor przycisku',
            'button_text_color' => 'Kolor tekstu przycisku',
            'border_radius' => 'Zaokrąglenie rogów',
            'title_size' => 'Rozmiar tytułu',
            'description_size' => 'Rozmiar opisu',
            'button_size' => 'Rozmiar tekstu przycisku',
            'save' => 'Zapisz ustawienia',
            'category' => 'Kategoria',
            'category_id' => 'ID',
            'category_name' => 'Nazwa kategorii',
            'category_slug' => 'Slug',
            'category_count' => 'Liczba wpisów',
            'use_custom_cta' => 'Włącz osobne CTA dla tej kategorii',
            'clicks' => 'Kliknięcia',
            'global_cta' => 'CTA globalne',
            'no_categories' => 'Brak kategorii.',
            'note' => 'Jeśli wpis należy do kilku kategorii, wtyczka użyje pierwszej kategorii, dla której włączono osobne CTA. Jeśli żadna kategoria nie ma własnego CTA, użyte zostanie CTA globalne.',
        ),
        'en' => array(
            'page_title' => 'Auto CTA Box',
            'main_settings' => 'Main settings',
            'category_list' => 'Current WordPress categories',
            'global_preview' => 'Global CTA preview',
            'category_settings' => 'Category CTAs',
            'category_preview' => 'Category CTA preview',
            'statistics' => 'Click statistics',
            'enable' => 'Enable CTA',
            'language' => 'Interface and default text language',
            'positions' => 'CTA position',
            'start' => 'At the beginning of the article',
            'middle' => 'In the middle of the article',
            'end' => 'At the end of the article',
            'multiple_positions' => 'You can select more than one position.',
            'title' => 'CTA title',
            'description' => 'CTA description',
            'button_text' => 'Button text',
            'button_url' => 'Button URL',
            'bg_color' => 'CTA background color',
            'text_color' => 'Text color',
            'button_color' => 'Button color',
            'button_text_color' => 'Button text color',
            'border_radius' => 'Border radius',
            'title_size' => 'Title font size',
            'description_size' => 'Description font size',
            'button_size' => 'Button font size',
            'save' => 'Save settings',
            'category' => 'Category',
            'category_id' => 'ID',
            'category_name' => 'Category name',
            'category_slug' => 'Slug',
            'category_count' => 'Posts count',
            'use_custom_cta' => 'Enable custom CTA for this category',
            'clicks' => 'Clicks',
            'global_cta' => 'Global CTA',
            'no_categories' => 'No categories found.',
            'note' => 'If a post belongs to multiple categories, the plugin will use the first category with custom CTA enabled. If no category CTA is enabled, the global CTA will be used.',
        ),
    );
}

function isb_cta_get_language() {
    $language = get_option('isb_cta_language', 'pl');
    $translations = isb_cta_get_translations();
    return isset($translations[$language]) ? $language : 'pl';
}

function isb_cta_get_default_text($field) {
    $language = isb_cta_get_language();
    $translations = isb_cta_get_translations();
    return isset($translations[$language][$field]) ? $translations[$language][$field] : '';
}

function isb_cta_admin_text($key) {
    $language = isb_cta_get_language();
    $texts = isb_cta_admin_translations();

    if (!isset($texts[$language])) {
        $language = 'en';
    }

    return isset($texts[$language][$key]) ? $texts[$language][$key] : $key;
}

add_action('admin_menu', 'isb_cta_add_settings_page');

function isb_cta_add_settings_page() {
    add_options_page(
        'Auto CTA Box',
        'Auto CTA Box',
        'manage_options',
        'auto-cta-box',
        'isb_cta_render_settings_page'
    );
}

add_action('admin_init', 'isb_cta_register_settings');

function isb_cta_register_settings() {
    register_setting('isb_cta_settings_group', 'isb_cta_enabled');
    register_setting('isb_cta_settings_group', 'isb_cta_language');
    register_setting('isb_cta_settings_group', 'isb_cta_positions');

    register_setting('isb_cta_settings_group', 'isb_cta_title');
    register_setting('isb_cta_settings_group', 'isb_cta_description');
    register_setting('isb_cta_settings_group', 'isb_cta_button_text');
    register_setting('isb_cta_settings_group', 'isb_cta_button_url');

    register_setting('isb_cta_settings_group', 'isb_cta_bg_color');
    register_setting('isb_cta_settings_group', 'isb_cta_text_color');
    register_setting('isb_cta_settings_group', 'isb_cta_button_color');
    register_setting('isb_cta_settings_group', 'isb_cta_button_text_color');

    register_setting('isb_cta_settings_group', 'isb_cta_border_radius');
    register_setting('isb_cta_settings_group', 'isb_cta_title_size');
    register_setting('isb_cta_settings_group', 'isb_cta_description_size');
    register_setting('isb_cta_settings_group', 'isb_cta_button_size');

    register_setting('isb_cta_settings_group', 'isb_cta_category_enabled');
    register_setting('isb_cta_settings_group', 'isb_cta_category_title');
    register_setting('isb_cta_settings_group', 'isb_cta_category_description');
    register_setting('isb_cta_settings_group', 'isb_cta_category_button_text');
    register_setting('isb_cta_settings_group', 'isb_cta_category_button_url');
}

function isb_cta_render_settings_page() {
    $language = isb_cta_get_language();
    $positions = get_option('isb_cta_positions', array('end'));

    if (!is_array($positions)) {
        $positions = array('end');
    }

    $category_enabled = get_option('isb_cta_category_enabled', array());
    $category_title = get_option('isb_cta_category_title', array());
    $category_description = get_option('isb_cta_category_description', array());
    $category_button_text = get_option('isb_cta_category_button_text', array());
    $category_button_url = get_option('isb_cta_category_button_url', array());

    if (!is_array($category_enabled)) $category_enabled = array();
    if (!is_array($category_title)) $category_title = array();
    if (!is_array($category_description)) $category_description = array();
    if (!is_array($category_button_text)) $category_button_text = array();
    if (!is_array($category_button_url)) $category_button_url = array();

    $categories = get_categories(array(
        'hide_empty' => false,
    ));

    $stats = get_option('isb_cta_click_stats', array());

    if (!is_array($stats)) {
        $stats = array();
    }

    $defaults_for_js = array(
        'title' => isb_cta_get_default_text('title'),
        'description' => isb_cta_get_default_text('description'),
        'button' => isb_cta_get_default_text('button'),
        'url' => 'https://example.com',
    );
    ?>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const defaults = <?php echo wp_json_encode($defaults_for_js); ?>;

        function getField(name) {
            return document.getElementsByName(name)[0] || null;
        }

        function getFieldValue(name, fallback) {
            const field = getField(name);
            if (!field) return fallback;
            return field.value.trim() !== '' ? field.value : fallback;
        }

        function setText(selector, value) {
            document.querySelectorAll(selector).forEach(function (el) {
                el.textContent = value;
            });
        }

        function setHref(selector, value) {
            document.querySelectorAll(selector).forEach(function (el) {
                el.setAttribute('href', value || defaults.url);
            });
        }

        function updateCtaStyles() {
            const bgColor = getFieldValue('isb_cta_bg_color', '#f8f8f8');
            const textColor = getFieldValue('isb_cta_text_color', '#111111');
            const buttonColor = getFieldValue('isb_cta_button_color', '#111111');
            const buttonTextColor = getFieldValue('isb_cta_button_text_color', '#ffffff');

            const borderRadius = getFieldValue('isb_cta_border_radius', '12');
            const titleSize = getFieldValue('isb_cta_title_size', '28');
            const descriptionSize = getFieldValue('isb_cta_description_size', '17');
            const buttonSize = getFieldValue('isb_cta_button_size', '16');

            document.querySelectorAll('.isb-cta-box').forEach(function (box) {
                box.style.background = bgColor;
                box.style.color = textColor;
                box.style.borderRadius = borderRadius + 'px';
            });

            document.querySelectorAll('.isb-cta-preview-title').forEach(function (title) {
                title.style.color = textColor;
                title.style.fontSize = titleSize + 'px';
            });

            document.querySelectorAll('.isb-cta-preview-description').forEach(function (desc) {
                desc.style.color = textColor;
                desc.style.fontSize = descriptionSize + 'px';
            });

            document.querySelectorAll('.isb-cta-button').forEach(function (button) {
                button.style.background = buttonColor;
                button.style.color = buttonTextColor;
                button.style.fontSize = buttonSize + 'px';
            });
        }

        function updateGlobalPreview() {
            const title = getFieldValue('isb_cta_title', defaults.title);
            const description = getFieldValue('isb_cta_description', defaults.description);
            const buttonText = getFieldValue('isb_cta_button_text', defaults.button);
            const buttonUrl = getFieldValue('isb_cta_button_url', defaults.url);

            setText('.isb-cta-box[data-cta-preview="global"] .isb-cta-preview-title', title);
            setText('.isb-cta-box[data-cta-preview="global"] .isb-cta-preview-description', description);
            setText('.isb-cta-box[data-cta-preview="global"] .isb-cta-button', buttonText);
            setHref('.isb-cta-box[data-cta-preview="global"] .isb-cta-button', buttonUrl);
        }

        function updateCategoryPreview(catId) {
            const title = getFieldValue('isb_cta_category_title[' + catId + ']', defaults.title);
            const description = getFieldValue('isb_cta_category_description[' + catId + ']', defaults.description);
            const buttonText = getFieldValue('isb_cta_category_button_text[' + catId + ']', defaults.button);
            const buttonUrl = getFieldValue('isb_cta_category_button_url[' + catId + ']', defaults.url);

            const selector = '.isb-cta-box[data-cta-preview="cat_' + catId + '"]';

            setText(selector + ' .isb-cta-preview-title', title);
            setText(selector + ' .isb-cta-preview-description', description);
            setText(selector + ' .isb-cta-button', buttonText);
            setHref(selector + ' .isb-cta-button', buttonUrl);
        }

        function updateAllPreviews() {
            updateCtaStyles();
            updateGlobalPreview();

            document.querySelectorAll('[data-isb-cat-id]').forEach(function (el) {
                updateCategoryPreview(el.getAttribute('data-isb-cat-id'));
            });
        }

        [
            'isb_cta_bg_color',
            'isb_cta_text_color',
            'isb_cta_button_color',
            'isb_cta_button_text_color',
            'isb_cta_border_radius',
            'isb_cta_title_size',
            'isb_cta_description_size',
            'isb_cta_button_size',
            'isb_cta_title',
            'isb_cta_description',
            'isb_cta_button_text',
            'isb_cta_button_url'
        ].forEach(function (name) {
            const field = getField(name);
            if (field) {
                field.addEventListener('input', updateAllPreviews);
                field.addEventListener('change', updateAllPreviews);
            }
        });

        document.querySelectorAll('[data-isb-cat-id]').forEach(function (wrapper) {
            const catId = wrapper.getAttribute('data-isb-cat-id');

            [
                'isb_cta_category_title[' + catId + ']',
                'isb_cta_category_description[' + catId + ']',
                'isb_cta_category_button_text[' + catId + ']',
                'isb_cta_category_button_url[' + catId + ']'
            ].forEach(function (name) {
                const field = getField(name);
                if (field) {
                    field.addEventListener('input', function () {
                        updateCategoryPreview(catId);
                        updateCtaStyles();
                    });

                    field.addEventListener('change', function () {
                        updateCategoryPreview(catId);
                        updateCtaStyles();
                    });
                }
            });
        });

        updateAllPreviews();
    });
    </script>

    <div class="wrap">
        <h1><?php echo esc_html(isb_cta_admin_text('page_title')); ?></h1>

        <form method="post" action="options.php">
            <?php settings_fields('isb_cta_settings_group'); ?>

            <h2><?php echo esc_html(isb_cta_admin_text('main_settings')); ?></h2>

            <table class="form-table">
                <tr>
                    <th scope="row"><?php echo esc_html(isb_cta_admin_text('enable')); ?></th>
                    <td>
                        <input type="checkbox" name="isb_cta_enabled" value="1" <?php checked(get_option('isb_cta_enabled', '1'), '1'); ?>>
                    </td>
                </tr>

                <tr>
                    <th scope="row"><?php echo esc_html(isb_cta_admin_text('language')); ?></th>
                    <td>
                        <select name="isb_cta_language">
                            <option value="pl" <?php selected($language, 'pl'); ?>>Polski</option>
                            <option value="en" <?php selected($language, 'en'); ?>>English</option>
                            <option value="de" <?php selected($language, 'de'); ?>>Deutsch</option>
                            <option value="ru" <?php selected($language, 'ru'); ?>>Русский</option>
                            <option value="fr" <?php selected($language, 'fr'); ?>>Français</option>
                            <option value="es" <?php selected($language, 'es'); ?>>Español</option>
                        </select>
                    </td>
                </tr>

                <tr>
                    <th scope="row"><?php echo esc_html(isb_cta_admin_text('positions')); ?></th>
                    <td>
                        <label><input type="checkbox" name="isb_cta_positions[]" value="start" <?php checked(in_array('start', $positions, true)); ?>> <?php echo esc_html(isb_cta_admin_text('start')); ?></label><br><br>
                        <label><input type="checkbox" name="isb_cta_positions[]" value="middle" <?php checked(in_array('middle', $positions, true)); ?>> <?php echo esc_html(isb_cta_admin_text('middle')); ?></label><br><br>
                        <label><input type="checkbox" name="isb_cta_positions[]" value="end" <?php checked(in_array('end', $positions, true)); ?>> <?php echo esc_html(isb_cta_admin_text('end')); ?></label>
                        <p class="description"><?php echo esc_html(isb_cta_admin_text('multiple_positions')); ?></p>
                    </td>
                </tr>

                <tr>
                    <th scope="row"><?php echo esc_html(isb_cta_admin_text('title')); ?></th>
                    <td><input type="text" name="isb_cta_title" class="regular-text" value="<?php echo esc_attr(get_option('isb_cta_title', isb_cta_get_default_text('title'))); ?>"></td>
                </tr>

                <tr>
                    <th scope="row"><?php echo esc_html(isb_cta_admin_text('description')); ?></th>
                    <td><textarea name="isb_cta_description" rows="4" class="large-text"><?php echo esc_textarea(get_option('isb_cta_description', isb_cta_get_default_text('description'))); ?></textarea></td>
                </tr>

                <tr>
                    <th scope="row"><?php echo esc_html(isb_cta_admin_text('button_text')); ?></th>
                    <td><input type="text" name="isb_cta_button_text" class="regular-text" value="<?php echo esc_attr(get_option('isb_cta_button_text', isb_cta_get_default_text('button'))); ?>"></td>
                </tr>

                <tr>
                    <th scope="row"><?php echo esc_html(isb_cta_admin_text('button_url')); ?></th>
                    <td><input type="url" name="isb_cta_button_url" class="regular-text" value="<?php echo esc_url(get_option('isb_cta_button_url', 'https://example.com')); ?>"></td>
                </tr>

                <tr>
                    <th scope="row"><?php echo esc_html(isb_cta_admin_text('bg_color')); ?></th>
                    <td><input type="color" name="isb_cta_bg_color" value="<?php echo esc_attr(get_option('isb_cta_bg_color', '#f8f8f8')); ?>"></td>
                </tr>

                <tr>
                    <th scope="row"><?php echo esc_html(isb_cta_admin_text('text_color')); ?></th>
                    <td><input type="color" name="isb_cta_text_color" value="<?php echo esc_attr(get_option('isb_cta_text_color', '#111111')); ?>"></td>
                </tr>

                <tr>
                    <th scope="row"><?php echo esc_html(isb_cta_admin_text('button_color')); ?></th>
                    <td><input type="color" name="isb_cta_button_color" value="<?php echo esc_attr(get_option('isb_cta_button_color', '#111111')); ?>"></td>
                </tr>

                <tr>
                    <th scope="row"><?php echo esc_html(isb_cta_admin_text('button_text_color')); ?></th>
                    <td><input type="color" name="isb_cta_button_text_color" value="<?php echo esc_attr(get_option('isb_cta_button_text_color', '#ffffff')); ?>"></td>
                </tr>

                <tr>
                    <th scope="row"><?php echo esc_html(isb_cta_admin_text('border_radius')); ?></th>
                    <td><input type="number" name="isb_cta_border_radius" value="<?php echo esc_attr(get_option('isb_cta_border_radius', '12')); ?>" min="0" max="60"> px</td>
                </tr>

                <tr>
                    <th scope="row"><?php echo esc_html(isb_cta_admin_text('title_size')); ?></th>
                    <td><input type="number" name="isb_cta_title_size" value="<?php echo esc_attr(get_option('isb_cta_title_size', '28')); ?>" min="10" max="80"> px</td>
                </tr>

                <tr>
                    <th scope="row"><?php echo esc_html(isb_cta_admin_text('description_size')); ?></th>
                    <td><input type="number" name="isb_cta_description_size" value="<?php echo esc_attr(get_option('isb_cta_description_size', '17')); ?>" min="10" max="50"> px</td>
                </tr>

                <tr>
                    <th scope="row"><?php echo esc_html(isb_cta_admin_text('button_size')); ?></th>
                    <td><input type="number" name="isb_cta_button_size" value="<?php echo esc_attr(get_option('isb_cta_button_size', '16')); ?>" min="10" max="50"> px</td>
                </tr>
            </table>

            <hr>

            <h2><?php echo esc_html(isb_cta_admin_text('category_list')); ?></h2>

            <table class="widefat striped" style="max-width:950px;">
                <thead>
                    <tr>
                        <th><?php echo esc_html(isb_cta_admin_text('category_id')); ?></th>
                        <th><?php echo esc_html(isb_cta_admin_text('category_name')); ?></th>
                        <th><?php echo esc_html(isb_cta_admin_text('category_slug')); ?></th>
                        <th><?php echo esc_html(isb_cta_admin_text('category_count')); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($categories)) : ?>
                        <?php foreach ($categories as $category) : ?>
                            <tr>
                                <td><?php echo esc_html($category->term_id); ?></td>
                                <td><?php echo esc_html($category->name); ?></td>
                                <td><?php echo esc_html($category->slug); ?></td>
                                <td><?php echo esc_html($category->count); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr><td colspan="4"><?php echo esc_html(isb_cta_admin_text('no_categories')); ?></td></tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <hr>

            <h2><?php echo esc_html(isb_cta_admin_text('global_preview')); ?></h2>

            <div style="background:#fff;border:1px solid #ccd0d4;padding:25px;margin:20px 0;border-radius:8px;max-width:950px;">
                <?php
                echo isb_cta_build_box(array(
                    'key' => 'global',
                    'title' => get_option('isb_cta_title', isb_cta_get_default_text('title')),
                    'description' => get_option('isb_cta_description', isb_cta_get_default_text('description')),
                    'button_text' => get_option('isb_cta_button_text', isb_cta_get_default_text('button')),
                    'button_url' => get_option('isb_cta_button_url', 'https://example.com'),
                ), true);
                ?>
            </div>

            <hr>

            <h2><?php echo esc_html(isb_cta_admin_text('category_settings')); ?></h2>
            <p><?php echo esc_html(isb_cta_admin_text('note')); ?></p>

            <?php if (!empty($categories)) : ?>
                <?php foreach ($categories as $category) :
                    $cat_id = (int) $category->term_id;
                ?>
                    <div data-isb-cat-id="<?php echo esc_attr($cat_id); ?>" style="background:#fff;border:1px solid #ccd0d4;padding:20px;margin:20px 0;border-radius:8px;">
                        <h3><?php echo esc_html($category->name); ?></h3>

                        <p>
                            <label>
                                <input type="checkbox" name="isb_cta_category_enabled[<?php echo esc_attr($cat_id); ?>]" value="1" <?php checked(isset($category_enabled[$cat_id]) && $category_enabled[$cat_id] === '1'); ?>>
                                <?php echo esc_html(isb_cta_admin_text('use_custom_cta')); ?>
                            </label>
                        </p>

                        <table class="form-table">
                            <tr>
                                <th scope="row"><?php echo esc_html(isb_cta_admin_text('title')); ?></th>
                                <td>
                                    <input type="text" name="isb_cta_category_title[<?php echo esc_attr($cat_id); ?>]" class="regular-text" value="<?php echo esc_attr(isset($category_title[$cat_id]) ? $category_title[$cat_id] : ''); ?>">
                                </td>
                            </tr>

                            <tr>
                                <th scope="row"><?php echo esc_html(isb_cta_admin_text('description')); ?></th>
                                <td>
                                    <textarea name="isb_cta_category_description[<?php echo esc_attr($cat_id); ?>]" rows="3" class="large-text"><?php echo esc_textarea(isset($category_description[$cat_id]) ? $category_description[$cat_id] : ''); ?></textarea>
                                </td>
                            </tr>

                            <tr>
                                <th scope="row"><?php echo esc_html(isb_cta_admin_text('button_text')); ?></th>
                                <td>
                                    <input type="text" name="isb_cta_category_button_text[<?php echo esc_attr($cat_id); ?>]" class="regular-text" value="<?php echo esc_attr(isset($category_button_text[$cat_id]) ? $category_button_text[$cat_id] : ''); ?>">
                                </td>
                            </tr>

                            <tr>
                                <th scope="row"><?php echo esc_html(isb_cta_admin_text('button_url')); ?></th>
                                <td>
                                    <input type="url" name="isb_cta_category_button_url[<?php echo esc_attr($cat_id); ?>]" class="regular-text" value="<?php echo esc_url(isset($category_button_url[$cat_id]) ? $category_button_url[$cat_id] : ''); ?>">
                                </td>
                            </tr>
                        </table>

                        <h4><?php echo esc_html(isb_cta_admin_text('category_preview')); ?></h4>

                        <div style="background:#f6f7f7;border:1px solid #dcdcde;padding:20px;margin-top:15px;border-radius:8px;">
                            <?php
                            echo isb_cta_build_box(array(
                                'key' => 'cat_' . $cat_id,
                                'title' => !empty($category_title[$cat_id]) ? $category_title[$cat_id] : isb_cta_get_default_text('title'),
                                'description' => !empty($category_description[$cat_id]) ? $category_description[$cat_id] : isb_cta_get_default_text('description'),
                                'button_text' => !empty($category_button_text[$cat_id]) ? $category_button_text[$cat_id] : isb_cta_get_default_text('button'),
                                'button_url' => !empty($category_button_url[$cat_id]) ? $category_button_url[$cat_id] : 'https://example.com',
                            ), true);
                            ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <p><?php echo esc_html(isb_cta_admin_text('no_categories')); ?></p>
            <?php endif; ?>

            <?php submit_button(isb_cta_admin_text('save')); ?>
        </form>

        <hr>

        <h2><?php echo esc_html(isb_cta_admin_text('statistics')); ?></h2>

        <table class="widefat striped" style="max-width:950px;">
            <thead>
                <tr>
                    <th><?php echo esc_html(isb_cta_admin_text('category')); ?></th>
                    <th><?php echo esc_html(isb_cta_admin_text('clicks')); ?></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?php echo esc_html(isb_cta_admin_text('global_cta')); ?></td>
                    <td><?php echo esc_html(isset($stats['global']) ? (int) $stats['global'] : 0); ?></td>
                </tr>

                <?php foreach ($categories as $category) :
                    $cat_key = 'cat_' . (int) $category->term_id;
                ?>
                    <tr>
                        <td><?php echo esc_html($category->name); ?></td>
                        <td><?php echo esc_html(isset($stats[$cat_key]) ? (int) $stats[$cat_key] : 0); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php
}

function isb_cta_get_cta_data_for_post($post_id) {
    $category_enabled = get_option('isb_cta_category_enabled', array());
    $category_title = get_option('isb_cta_category_title', array());
    $category_description = get_option('isb_cta_category_description', array());
    $category_button_text = get_option('isb_cta_category_button_text', array());
    $category_button_url = get_option('isb_cta_category_button_url', array());

    if (!is_array($category_enabled)) {
        $category_enabled = array();
    }

    $categories = get_the_category($post_id);

    if (!empty($categories)) {
        foreach ($categories as $category) {
            $cat_id = (int) $category->term_id;

            if (isset($category_enabled[$cat_id]) && $category_enabled[$cat_id] === '1') {
                return array(
                    'key' => 'cat_' . $cat_id,
                    'title' => !empty($category_title[$cat_id]) ? $category_title[$cat_id] : isb_cta_get_default_text('title'),
                    'description' => !empty($category_description[$cat_id]) ? $category_description[$cat_id] : isb_cta_get_default_text('description'),
                    'button_text' => !empty($category_button_text[$cat_id]) ? $category_button_text[$cat_id] : isb_cta_get_default_text('button'),
                    'button_url' => !empty($category_button_url[$cat_id]) ? $category_button_url[$cat_id] : 'https://example.com',
                );
            }
        }
    }

    return array(
        'key' => 'global',
        'title' => get_option('isb_cta_title', isb_cta_get_default_text('title')),
        'description' => get_option('isb_cta_description', isb_cta_get_default_text('description')),
        'button_text' => get_option('isb_cta_button_text', isb_cta_get_default_text('button')),
        'button_url' => get_option('isb_cta_button_url', 'https://example.com'),
    );
}

function isb_cta_build_box($cta_data, $preview = false) {
    $title = isset($cta_data['title']) ? $cta_data['title'] : isb_cta_get_default_text('title');
    $description = isset($cta_data['description']) ? $cta_data['description'] : isb_cta_get_default_text('description');
    $button_text = isset($cta_data['button_text']) ? $cta_data['button_text'] : isb_cta_get_default_text('button');
    $button_url = isset($cta_data['button_url']) ? $cta_data['button_url'] : 'https://example.com';
    $cta_key = isset($cta_data['key']) ? $cta_data['key'] : 'global';

    if ($preview) {
        $final_button_url = $button_url;
    } else {
        $final_button_url = add_query_arg(
            array(
                'action' => 'isb_cta_click',
                'cta_key' => rawurlencode($cta_key),
            ),
            admin_url('admin-post.php')
        );
    }

    $bg_color = get_option('isb_cta_bg_color', '#f8f8f8');
    $text_color = get_option('isb_cta_text_color', '#111111');
    $button_color = get_option('isb_cta_button_color', '#111111');
    $button_text_color = get_option('isb_cta_button_text_color', '#ffffff');

    $border_radius = absint(get_option('isb_cta_border_radius', '12'));
    $title_size = absint(get_option('isb_cta_title_size', '28'));
    $description_size = absint(get_option('isb_cta_description_size', '17'));
    $button_size = absint(get_option('isb_cta_button_size', '16'));

    return '
    <style>
        .isb-cta-box {
            margin-top:30px;
            margin-bottom:30px;
            padding:32px;
            border:2px solid #eeeeee;
            transition:all 0.3s ease;
            text-align:center;
            max-width:700px;
            margin-left:auto;
            margin-right:auto;
            box-sizing:border-box;
        }

        .isb-cta-box:hover {
            transform:scale(1.02);
            box-shadow:0 10px 30px rgba(0,0,0,0.08);
        }

        .isb-cta-button {
            display:inline-block;
            padding:12px 22px;
            text-decoration:none;
            border-radius:8px;
            transition:all 0.25s ease;
            font-weight:600;
            cursor:pointer;
        }

        .isb-cta-button:hover {
            transform:translateY(-2px);
            filter:brightness(1.1);
        }
    </style>

    <div class="isb-cta-box" data-cta-preview="' . esc_attr($cta_key) . '" style="
        border-radius:' . esc_attr($border_radius) . 'px;
        background:' . esc_attr($bg_color) . ';
        color:' . esc_attr($text_color) . ';
    ">
        <strong class="isb-cta-preview-title" style="
            font-size:' . esc_attr($title_size) . 'px;
            display:block;
            margin-bottom:15px;
            color:' . esc_attr($text_color) . ';
        ">
            ' . esc_html($title) . '
        </strong>

        <p class="isb-cta-preview-description" style="
            margin:0 0 25px;
            font-size:' . esc_attr($description_size) . 'px;
            line-height:1.7;
            color:' . esc_attr($text_color) . ';
        ">
            ' . esc_html($description) . '
        </p>

        <a href="' . esc_url($final_button_url) . '" class="isb-cta-button" style="
            background:' . esc_attr($button_color) . ';
            color:' . esc_attr($button_text_color) . ';
            font-size:' . esc_attr($button_size) . 'px;
        ">
            ' . esc_html($button_text) . '
        </a>
    </div>';
}

function isb_cta_insert_after_middle_paragraph($content, $cta) {
    if (strpos($content, '</p>') !== false) {
        $paragraphs = explode('</p>', $content);
        $clean_paragraphs = array();

        foreach ($paragraphs as $paragraph) {
            if (trim($paragraph) !== '') {
                $clean_paragraphs[] = $paragraph . '</p>';
            }
        }

        $paragraph_count = count($clean_paragraphs);

        if ($paragraph_count < 3) {
            return $content . $cta;
        }

        $middle = floor($paragraph_count / 2);
        $new_content = '';

        foreach ($clean_paragraphs as $index => $paragraph) {
            $new_content .= $paragraph;

            if ($index === $middle) {
                $new_content .= $cta;
            }
        }

        return $new_content;
    }

    return $content . $cta;
}

add_filter('the_content', 'isb_add_cta_box');

function isb_add_cta_box($content) {
    if (get_option('isb_cta_enabled', '1') !== '1') {
        return $content;
    }

    if (is_single() && in_the_loop() && is_main_query()) {
        $cta_data = isb_cta_get_cta_data_for_post(get_the_ID());
        $cta = isb_cta_build_box($cta_data, false);

        $positions = get_option('isb_cta_positions', array('end'));

        if (!is_array($positions)) {
            $positions = array('end');
        }

        if (empty($positions)) {
            return $content;
        }

        if (in_array('middle', $positions, true)) {
            $content = isb_cta_insert_after_middle_paragraph($content, $cta);
        }

        if (in_array('start', $positions, true)) {
            $content = $cta . $content;
        }

        if (in_array('end', $positions, true)) {
            $content .= $cta;
        }

        return $content;
    }

    return $content;
}

add_action('admin_post_isb_cta_click', 'isb_cta_handle_click');
add_action('admin_post_nopriv_isb_cta_click', 'isb_cta_handle_click');

function isb_cta_handle_click() {
    $cta_key = isset($_GET['cta_key']) ? sanitize_text_field(wp_unslash($_GET['cta_key'])) : 'global';
    $cta_key = rawurldecode($cta_key);

    $stats = get_option('isb_cta_click_stats', array());

    if (!is_array($stats)) {
        $stats = array();
    }

    if (!isset($stats[$cta_key])) {
        $stats[$cta_key] = 0;
    }

    $stats[$cta_key]++;

    update_option('isb_cta_click_stats', $stats);

    $redirect_url = isb_cta_get_redirect_url_by_key($cta_key);

    wp_safe_redirect($redirect_url);
    exit;
}

function isb_cta_get_redirect_url_by_key($cta_key) {
    if ($cta_key === 'global') {
        return esc_url_raw(get_option('isb_cta_button_url', 'https://example.com'));
    }

    if (strpos($cta_key, 'cat_') === 0) {
        $cat_id = absint(str_replace('cat_', '', $cta_key));
        $category_button_url = get_option('isb_cta_category_button_url', array());

        if (is_array($category_button_url) && !empty($category_button_url[$cat_id])) {
            return esc_url_raw($category_button_url[$cat_id]);
        }
    }

    return home_url('/');
}