<?php
/**
 * kek_Customize_Control_Font
 *
 * @package KeK\Core\Customize\Classes\Controls
 *
 */
final class kek_Customize_Control_Font extends kek_Customize_Control_Default
{
    /**
     * Print template
     */
    static function control_template()
    {
        ?>
        <script type="text/html" id="tmpl-customize-control-css-ruler">
        <#
        var required = '';
        if ( ! _.isUndefined( data.required ) ) {
            required = JSON.stringify( data.required  );
        }
        #>
        <div class="customize-control customize-control-{{ data.type }} {{ data.class }} customize-control-name-{{ data.original_name }}" data-required="{{ required }}" data-field-name="{{ data.name }}">
            <# if ( data.label || data.description ) { #>
            <div class="customize-control-header">
                <# if ( data.label ) { #>
                    <div class="customize-control-heading">
                        <label class="customize-control-title">{{{ data.label }}}</label>
                    </div>
                <# } #>
                <# if ( data.description ) { #>
                    <p class="description">{{{ data.description }}}</p>
                <# } #>
            </div>
            <# } #>
            <div class="customize-control-settings-inner">
                <input type="hidden" class="font-type" data-name="{{ data.name }}-type" >
                <div class="font-families-wrapper">
                    <select class="font-families" data-value="{{ JSON.stringify( data.value ) }}" data-name="{{ data.name }}-font"></select>
                </div>
                <div class="font-variants-wrapper">
                    <label><?php esc_html_e( 'Variants', 'sublimeplus' ) ?></label>
                    <select class="font-variants" data-name="{{ data.name }}-variant"></select>
                </div>
                <div class="font-subsets-wrapper">
                    <label><?php esc_html_e( 'Languages', 'sublimeplus' ) ?></label>
                    <div data-name="{{ data.name }}-subsets" class="list-subsets">
                    </div>
                </div>
            </div>
        </div>
        </script>
        <?php
    }
}
