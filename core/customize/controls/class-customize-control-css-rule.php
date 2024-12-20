<?php
/**
 * kek_Customize_Control_CSS_Rule
 *
 * @package KeK\Core\Customize\Classes\Controls
 *
 */
final class kek_Customize_Control_CSS_Rule extends kek_Customize_Control_Default
{
    /**
     * Print template
     */
    static function control_template()
    {
        ?>
        <script type="text/html" id="tmpl-customize-control-css_rule">
        <#
        var required = '';
        if (!_.isUndefined(data.required)) {
            required = JSON.stringify(data.required);
        }
        #>
        <div class="customize-control customize-control-{{ data.type }} {{ data.class }} customize-control-name-{{ data.original_name }}" data-required="{{ required }}" data-field-name="{{ data.name }}">
            <#
            if (!_.isObject(data.value)) {
                data.value = { link: 0 };
            }
            var fields_disabled;
            if (!_.isObject(data.fields_disabled)) {
                fields_disabled = {};
            } else {
                fields_disabled = _.clone(data.fields_disabled);
            }
            var defaultpl = <?php echo json_encode(__('Auto', 'sublimeplus')); ?>;
            _.each(['top', 'right', 'bottom', 'left'], function(key){
                if (!_.isUndefined(fields_disabled[key])) {
                    if (!fields_disabled[key]) {
                        fields_disabled[key] = defaultpl;
                    }
                } else {
                    fields_disabled[key] = false;
                }
            });
            var uniqueID = data.name + (new Date().getTime());
            #>
            <# if (data.label || data.description) { #>
            <div class="customize-control-header">
                <# if (data.label) { #>
                    <div class="customize-control-heading">
                        <label class="customize-control-title">{{{ data.label }}}</label>
                    </div>
                <# } #>
                <# if (data.description) { #>
                    <p class="description">{{{ data.description }}}</p>
                <# } #>
            </div>
            <# } #>
            <div class="customize-control-settings-inner">
                <div class="css-ruler gr-inputs">
                    <span>
                        <input type="number" class="input input-css change-by-js" <# if (fields_disabled['top']) { #> disabled="disabled" placeholder="{{ fields_disabled['top'] }}" <# } #> data-name="{{ data.name }}-top" value="{{ data.value.top }}">
                        <span class="small-label"><?php esc_html_e('Top', 'sublimeplus'); ?></span>
                    </span>
                    <span>
                        <input type="number" class="input input-css change-by-js" <# if (fields_disabled['right']) { #> disabled="disabled" placeholder="{{ fields_disabled['right'] }}" <# } #> data-name="{{ data.name }}-right" value="{{ data.value.right }}">
                        <span class="small-label"><?php esc_html_e('Right', 'sublimeplus'); ?></span>
                    </span>
                    <span>
                        <input type="number" class="input input-css change-by-js" <# if (fields_disabled['bottom']) { #> disabled="disabled" placeholder="{{ fields_disabled['bottom'] }}" <# } #> data-name="{{ data.name }}-bottom" value="{{ data.value.bottom }}">
                        <span class="small-label"><?php esc_html_e('Bottom', 'sublimeplus'); ?></span>
                    </span>
                    <span>
                        <input type="number" class="input input-css change-by-js" <# if (fields_disabled['left']) { #> disabled="disabled" placeholder="{{ fields_disabled['left'] }}" <# } #> data-name="{{ data.name }}-left" value="{{ data.value.left }}">
                        <span class="small-label"><?php esc_html_e('Left', 'sublimeplus'); ?></span>
                    </span>
                    <label title="<?php esc_attr_e('Toggle values together', 'sublimeplus'); ?>" class="css-ruler-link <# if (data.value.link == 1){ #> label-active <# } #>">
                        <input type="checkbox" class="input label-parent change-by-js" <# if (data.value.link == 1){ #> checked="checked" <# } #> data-name="{{ data.name }}-link" value="1">
                    </label>
                </div>
            </div>
        </div>
        </script>
        <?php
    }
}
