<?php
/**
 * kek_Customize_Control_Icon
 *
 * @package KeK\Core\Customize\Classes\Controls
 *
 */
final class kek_Customize_Control_Icon extends kek_Customize_Control_Default
{
    /**
     * Print template
     */
    static function control_template()
    {
        ?>
       <script type="text/html" id="tmpl-customize-control-icon">
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
            <div class="icon-picker">
                <div class="icon-preview">
                    <input type="hidden" class="input input-icon-type" data-name="{{ data.name }}-type" value="{{ data.value.type }}">
                    <div class="icon-preview-icon pick-icon">
                        <# if ( data.value.icon ) {  #>
                            <i class="{{ data.value.icon }}"></i>
                        <# }  #>
                    </div>
                </div>
                <input type="text" readonly class="input pick-icon input-icon-name" placeholder="<?php esc_attr_e( 'Pick an icon', 'sublimeplus' ); ?>" data-name="{{ data.name }}" value="{{ data.value.icon }}">
                <span class="icon-remove" title="<?php esc_attr_e( 'Remove', 'sublimeplus' ); ?>">
                    <span class="dashicons dashicons-no-alt"></span>
                    <span class="screen-reader-text">
                    <?php esc_html_e( 'Remove', 'sublimeplus' ) ?></span>
                </span>
            </div>
        </div>
        </div>
        </script>
        <div id="sidebar-icons">
            <div class="sidebar-header">
                <a class="customize-controls-icon-close" href="#">
                    <span class="screen-reader-text"><?php esc_html_e( 'Cancel', 'sublimeplus' );  ?></span>
                </a>
                <div class="icon-type-inner">
                    <select id="sidebar-icon-type">
                        <option value="all"><?php esc_html_e( 'All Icon Types', 'sublimeplus' ); ?></option>
                    </select>
                </div>
            </div>
            <div class="sidebar-search">
               <input type="text" id="icon-search" placeholder="<?php esc_attr_e( 'Type icon name', 'sublimeplus' ) ?>">
            </div>
            <div id="icon-browser"></div>
        </div>
        <?php
    }
}
