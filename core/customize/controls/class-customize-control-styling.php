<?php
/**
 * kek_Customize_Control_Styling
 *
 * @package KeK\Core\Customize\Classes\Controls
 *
 */
final class kek_Customize_Control_Styling extends kek_Customize_Control_Modal
{
    /**
     * Print template
     */
    static function control_template()
    {
        ?>
        <script type="text/html" id="tmpl-customize-control-styling">
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
        <div class="actions">
            <a href="#" title="<?php esc_attr_e( 'Reset to default', 'sublimeplus' ); ?>" class="action--reset" data-control="{{ data.name }}"><span class="dashicons dashicons-image-rotate"></span></a>
            <a href="#" title="<?php esc_attr_e( 'Toggle edit panel', 'sublimeplus' ); ?>" class="action--edit" data-control="{{ data.name }}"><span class="dashicons dashicons-edit"></span></a>
        </div>
        <div class="customize-control-settings-inner">
            <input type="hidden" class="hidden-modal-input only" data-name="{{ data.name }}" value="{{ JSON.stringify( data.value ) }}" data-default="{{ JSON.stringify( data.default ) }}">
        </div>
        </div>
        </script>
        <script type="text/html" id="tmpl-modal-settings">
            <div class="modal-settings">
                <div class="modal-settings--inner">
                    <div class="modal-settings--fields"></div>
                </div>
            </div>
        </script>
        <?php
    }
}
