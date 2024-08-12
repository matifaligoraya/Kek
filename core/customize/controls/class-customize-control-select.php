<?php
/**
 * kek_Customize_Control_Select
 *
 * @package KeK\Core\Customize\Classes\Controls
 *
 */
final class kek_Customize_Control_Select extends kek_Customize_Control_Default
{
    /**
     * Print template
     */
    static function control_template()
    {
        ?>
        <script type="text/html" id="tmpl-customize-control-select">
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
                <select class="input" data-name="{{ data.name }}">
                    <# _.each( data.choices, function( label, key ){  #>
                        <option <# if ( data.value == key ){ #> selected="selected" <# } #> value="{{ key }}">{{ label }}</option>
                    <# } ); #>
                </select>
            </div>
        </div>
        </script>
        <?php
    }
}