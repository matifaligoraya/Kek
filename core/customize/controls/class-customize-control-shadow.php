<?php
/**
 * kek_Customize_Control_Shadow
 *
 * @package KeK\Core\Customize\Classes\Controls
 *
 */
final class kek_Customize_Control_Shadow extends kek_Customize_Control_Default
{
    /**
     * Print template
     */
    static function control_template()
    {
        ?>
        <script type="text/html" id="tmpl-customize-control-shadow">
        <#
        var required = '';
        if ( ! _.isUndefined( data.required ) ) {
            required = JSON.stringify( data.required  );
        }
        #>
        <div class="customize-control customize-control-{{ data.type }} {{ data.class }} customize-control-name-{{ data.original_name }}" data-required="{{ required }}" data-field-name="{{ data.name }}">
            <#
                if ( ! _.isObject( data.value ) ) {
                data.value = { };
                }

                var uniqueID = data.name + ( new Date().getTime() );
            #>
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

                    <div class="input-color" data-default="{{ data.default }}">
                        <input type="hidden" class="input input--color" data-name="{{ data.name }}-color" value="{{ data.value.color }}">
                        <input type="text" class="color-panel" data-alpha="true" value="{{ data.value.color }}">
                    </div>

                    <div class="gr-inputs">
                        <span>
                            <input type="number" class="input input-css change-by-js"  data-name="{{ data.name }}-x" value="{{ data.value.x }}">
                            <span class="small-label"><?php esc_html_e( 'X', 'sublimeplus' ); ?></span>
                        </span>
                        <span>
                            <input type="number" class="input input-css change-by-js"  data-name="{{ data.name }}-y" value="{{ data.value.y }}">
                            <span class="small-label"><?php esc_html_e( 'Y', 'sublimeplus' ); ?></span>
                        </span>
                        <span>
                            <input type="number" class="input input-css change-by-js" data-name="{{ data.name }}-blur" value="{{ data.value.blur }}">
                            <span class="small-label"><?php esc_html_e( 'Blur', 'sublimeplus' ); ?></span>
                        </span>
                        <span>
                            <input type="number" class="input input-css change-by-js" data-name="{{ data.name }}-spread" value="{{ data.value.spread }}">
                            <span class="small-label"><?php esc_html_e( 'Spread', 'sublimeplus' ); ?></span>
                        </span>
                        <span>
                            <span class="input">
                                <input type="checkbox" class="input input-css change-by-js" <# if ( data.value.inset == 1 ){ #> checked="checked" <# } #> data-name="{{ data.name }}-inset" value="{{ data.value.inset }}">
                            </span>
                            <span class="small-label"><?php esc_html_e( 'inset', 'sublimeplus' ); ?></span>
                        </span>
                    </div>
                </div>
            </div>
            </script>
            <?php
    }
}
