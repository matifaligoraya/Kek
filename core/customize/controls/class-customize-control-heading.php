<?php
/**
 * kek_Customize_Control_Heading
 *
 * @package KeK\Core\Customize\Classes\Controls
 *
 */
final class kek_Customize_Control_Heading extends kek_Customize_Control_Default
{
    /**
     * Print template
     */
    static function control_template()
    {
        ?>
        <script type="text/html" id="tmpl-customize-control-heading">
        <#
        var required = '';
        if ( ! _.isUndefined( data.required ) ) {
            required = JSON.stringify( data.required  );
        }
        #>
        <div class="customize-control customize-control-{{ data.type }} {{ data.class }} customize-control-name-{{ data.original_name }}" data-required="{{ required }}" data-field-name="{{ data.name }}">
            <h3 class="customize-control--heading">{{ data.label }}</h3>
        </div>
        </script>
        <?php
    }
}
