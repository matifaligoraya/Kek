<?php
/**
 * kek_Customize_Control_Slider
 *
 * @package KeK\Core\Customize\Classes\Controls
 *
 */
final class kek_Customize_Control_Slider extends kek_Customize_Control_Default
{
    /**
     * Print template
     */
    static function control_template()
    {
        ?>
        <script type="text/html" id="tmpl-customize-control-slider">
        <#
        var required = '';
        if ( ! _.isUndefined( data.required ) ) {
            required = JSON.stringify( data.required  );
        }
        #>
        <div class="customize-control customize-control-{{ data.type }} {{ data.class }} customize-control-name-{{ data.original_name }}" data-required="{{ required }}" data-field-name="{{ data.name }}">
            <#
            if ( ! _.isObject( data.value ) ) {
                data.value = { unit: 'px' };
            }
            var uniqueID = data.name + ( new Date().getTime() );

            if ( ! data.device_settings ) {
                if ( ! _.isObject( data.default  ) ) {
                    data.default = {
                        unit: 'px',
                        value: data.default
                    }
                }
                if ( _.isUndefined( data.value.value ) || ! data.value.value ) {
                    data.value.value = data.default.value;
                }

            } else {
                _.each( data.default, function( value, device ){
                    if ( ! _.isObject( value  ) ) {
                        value = {
                            unit: 'px',
                            value: value
                        }
                    }
                    data.default[device] = value;
                } );

                try {
                    if ( ! _.isUndefined( data.default[data._current_device] ) ) {
                        if ( data._current_device ) {
                           data.default = data.default[data._current_device];
                        }
                    }
                } catch ( e ) {

                }
            }
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
                <div class="input-slider-wrapper">
                    <div class="css-unit">
                        <label class="<# if ( data.value.unit == 'px' || ! data.value.unit ){ #> label-active <# } #>">
                            <# if ( data.unit ) { #>
                                {{ data.unit }}
                            <#  } else {  #>
                            <?php echo esc_html( 'px'); ?>
                            <#  } #>
                            <input type="radio" class="input label-parent change-by-js" <# if ( data.value.unit == 'px' || ! data.value.unit ){ #> checked="checked" <# } #> data-name="{{ data.name }}-unit" name="r{{ uniqueID }}" value="px">
                        </label>
                        <a href="#" class="reset" title="<?php esc_attr_e( 'Reset', 'sublimeplus' ); ?>"></a>
                    </div>
                    <div data-min="{{ data.min }}" data-default="{{ JSON.stringify( data.default ) }}" data-step="{{ data.step }}" data-max="{{ data.max }}" class="input-slider"></div>
                    <input type="number" min="{{ data.min }}" step="{{ data.step }}" max="{{ data.max }}" class="slider-input input" data-name="{{ data.name }}-value" value="{{ data.value.value }}" size="4">
                </div>
            </div>
        </div>
        </script>
        <?php
    }
}
