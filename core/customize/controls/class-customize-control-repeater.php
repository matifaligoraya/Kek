<?php
/**
 * kek_Customize_Control_Repeater
 *
 * @package KeK\Core\Customize\Classes\Controls
 *
 */
final class kek_Customize_Control_Repeater extends kek_Customize_Control_Default
{
    /**
     * Print template
     */
    static function control_template()
    {
        ?>
        <script type="text/html" id="tmpl-customize-control-repeater">
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
            </div>
            </div>
        </script>
        <script type="text/html" id="tmpl-customize-control-repeater-item">
            <div class="repeater-item">
                <div class="repeater-item-heading">
                    <label class="repeater-visible" title="<?php esc_attr_e( 'Toggle item visible', 'sublimeplus' ); ?>"><input type="checkbox" class="r-visible-input"><span class="r-visible-icon"></span><span class="screen-reader-text"><?php _e( 'Show', 'sublimeplus' ) ?></label>
                    <span class="repeater-live-title"></span>
                    <div class="nav-reorder">
                        <span class="down" tabindex="-1"><span class="screen-reader-text"><?php esc_html_e( 'Move Down', 'sublimeplus' ) ?></span></span>
                        <span class="up" tabindex="0"><span class="screen-reader-text"><?php esc_html_e( 'Move Up', 'sublimeplus' ) ?></span></span>
                    </div>
                    <a href="#" class="repeater-item-toggle"><span class="screen-reader-text"><?php esc_html_e( 'Close', 'sublimeplus' ) ?></span></a>
                </div>
                <div class="repeater-item-settings">
                    <div class="repeater-item-inside">
                        <div class="repeater-item-inner"></div>
                        <# if ( data.addable ){  #>
                            <a href="#" class="remove"><?php esc_html_e( 'Remove', 'sublimeplus' ); ?></a>
                            <# } #>
                    </div>
                </div>
            </div>
        </script>
        <script type="text/html" id="tmpl-customize-control-repeater-inner">
            <div class="repeater-inner">
                <div class="settings-fields repeater-items"></div>
                <div class="repeater-actions">
                    <a href="#" class="repeater-reorder" data-text="<?php esc_attr_e( 'Reorder', 'sublimeplus' ); ?>" data-done="<?php _e( 'Done', 'sublimeplus' ); ?>"><?php _e( 'Reorder', 'sublimeplus' ); ?></a>
                    <# if ( data.addable ){  #>
                        <button type="button" class="button repeater-add-new"><?php esc_html_e( 'Add an item', 'sublimeplus' ); ?></button>
                        <# } #>
                </div>
            </div>
        </script>
        <?php
    }
}
