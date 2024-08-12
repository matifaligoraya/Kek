<?php
/**
 * kek_Customize_Control_Font_Style
 *
 * @package KeK\Core\Customize\Classes\Controls
 *
 */
final class kek_Customize_Control_Font_Style extends kek_Customize_Control_Default
{
    /**
     * Print template
     */
    static function control_template()
    {
        ?>
        <script type="text/html" id="tmpl-customize-control-font-style">
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
        <#
        if ( ! _.isObject( data.value ) ) {
            data.value = { };
        }
        #>
        <div class="customize-control-settings-inner font-style">
            <label title="<?php esc_attr_e( 'Bold', 'sublimeplus' ); ?>" class="button <# if ( data.value.b == 1 ){ #> checked <# } #>"><input type="checkbox" <# if ( data.value.b == 1 ){ #> checked="checked" <# } #> data-name="{{ data.name }}-b" value="1"><span class="dashicons dashicons-editor-bold"></span></label>
            <label title="<?php esc_attr_e( 'Italic', 'sublimeplus' ); ?>" class="button <# if ( data.value.i == 1 ){ #> checked <# } #>"><input type="checkbox" <# if ( data.value.i == 1 ){ #> checked="checked" <# } #> data-name="{{ data.name }}-i" value="1"><span class="dashicons dashicons-editor-italic"></span></label>
            <label title="<?php esc_attr_e( 'Underline', 'sublimeplus' ); ?>" class="button <# if ( data.value.u == 1 ){ #> checked <# } #>"><input type="checkbox" <# if ( data.value.u == 1 ){ #> checked="checked" <# } #> data-name="{{ data.name }}-u" value="1"><span class="dashicons dashicons-editor-underline"></span></label>
            <label title="<?php esc_attr_e( 'Strikethrough', 'sublimeplus' ); ?>" class="button <# if ( data.value.s == 1 ){ #> checked <# } #>"><input type="checkbox" <# if ( data.value.s == 1 ){ #> checked="checked" <# } #> data-name="{{ data.name }}-s" value="1"><span class="dashicons dashicons-editor-strikethrough"></span></label>
            <label title="<?php esc_attr_e( 'Uppercase', 'sublimeplus' ); ?>" class="button <# if ( data.value.t == 1 ){ #> checked <# } #>"><input type="checkbox" <# if ( data.value.t == 1 ){ #> checked="checked" <# } #> data-name="{{ data.name }}-t" value="1"><span class="dashicons dashicons-editor-textcolor"></span></label>
        </div>
        </div>
        </script>
        <?php
    }
}
