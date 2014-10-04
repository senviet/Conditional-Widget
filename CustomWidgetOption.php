<?php

class CustomWidgetOption
{
    private $field = array();

    function __construct()
    {
        $this->field["name"] = 'conditionalExp';
        $this->field["label"] = 'conditionalExp';
    }

    public static function getInstance()
    {
        static $instance = null;
        if (null === $instance) {
            $instance = new static();
        }

        return $instance;
    }

    function register()
    {
        if (is_admin()) {
            add_filter('widget_update_callback', array($this, 'widget_update_callback'), 10, 3);                // widget changes submitted by ajax method
            add_action('in_widget_form', array($this, 'in_widget_form'), 10, 3);
        } else {
            add_filter('widget_display_callback', array($this, 'widget_display_callback'), 10, 3);
        }
    }

    function widget_display_callback($instance, $widget, $args)
    {
        if (!isset($instance[$this->field["name"]]) || ($instance[$this->field["name"]] == '') || (eval("return (" . $instance[$this->field["name"]] . ");"))) {
            return $instance;
        }
        return false;
    }


    /*
     * @param WP_Widget $this     The widget instance, passed by reference.
     * @param null      $return   Return null if new fields are added.
     * @param array     $instance An array of the widget's settings.
     */
    function in_widget_form($widget, $return, $instance)
    {
        $htmlformat = '<p><label for="widget-%4$s-%5$s-%1$s">%2$s</label><textarea class="widefat" id="widget-%4$s-%5$s-%1$s" name="widget-%4$s[%5$s][%1$s]">%3$s</textarea></p>';

        $value = "";
        if (isset($instance[$this->field["name"]])) {
            $value = $instance[$this->field["name"]];
        }
        echo sprintf($htmlformat,
            $this->field["name"],
            $this->field['label'],
            $value,
            $widget->id_base,
            $widget->number
        );
    }


    /*
     * @param array     $instance     The current widget instance's settings.
     * @param array     $new_instance Array of new widget settings.
     * @param array     $old_instance Array of old widget settings.
     * @param WP_Widget $widget         The current widget instance.
     */
    function widget_update_callback($instance, $new_instance, $old_instance)
    {
        return array_merge($instance, $new_instance);
    }
}
