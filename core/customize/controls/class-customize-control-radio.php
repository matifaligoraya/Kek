<?php
/**
 * kek_Customize_Control_Radio
 *
 * @package KeK\Core\Customize\Classes\Controls
 *
 */
final class kek_Customize_Control_Radio extends kek_Customize_Control_Default
{
    /**
     * Print template
     */
    static function control_template()
    {
        ?>
        <script type="text/html" id="tmpl-customize-control-radio">
        <#
        var required = '';
        if ( ! _.isUndefined( data.required ) ) {
            required = JSON.stringify( data.required  );
        }
        #>
        <div class="customize-control customize-control-{{ data.type }} {{ data.class }} customize-control-name-{{ data.original_name }}" data-required="{{ required }}" data-field-name="{{ data.name }}">
            <#
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
                <div class="radio-list">
                    <# _.each( data.choices, function( label, key ){
                        var l = '';
                        if ( ! _.isObject( label ) ) {
                            l = label;
                        } else {
                            if ( label.img ) {
                                l = '<img src="'+label.img+'">';
                            }
                            if ( label.label ) {
                                l += '<span>'+label.label+'</span>';
                            }
                        }
                        #>
                        <p>
                            <label><input type="radio" data-name="{{ data.name }}" value="{{ key }}" <# if ( data.value == key ){ #> checked="checked" <# } #> name="{{ uniqueID }}">
                                <span class="label">{{{ l }}}</span>
                            </label>
                        </p>
                    <# } ); #>
                </div>
            </div>
        </div>
        </script>
        <?php
    }
}
