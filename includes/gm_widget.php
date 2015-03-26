<?php
class GM_Widget extends WP_Widget {

    function __construct() {

        parent::__construct(
            'adv-graphicmail',  // Widget ID
            'GraphicMail',      // Widget name
            array('description' => 'Subscribe form for your mailing list in GraphicMail') // Widget description
        );

    }

    public function widget( $args, $instance ) {

        $title = apply_filters( 'widget_title', $instance['title'] );

        echo $args['before_widget'];

        echo !empty($title) ? $args['before_title'].$title.$args['after_title'] : '&nbsp;';

        ?>

        <form>

            <input type="hidden" id="gm-mailinglist-id" name="gm-mailinglist-id" value="<?= $instance['mailinglist'] ?>" />

            <p>
                <input type="email" name="gm-email-subscriber" id="gm-email-subscriber" placeholder="<?= __('Your email address', 'adv-graphicmail') ?>" />
            </p>

            <p>
                <input id="gm-btn-subscribe" type="submit" value="<?php _e('Subscribe'); ?>" />
            </p>

        </form>

        <?php

        echo $args['after_widget'];

    }

    public function form( $instance ) {

        $gm_url         = get_option('gm_url');
        $gm_user        = get_option('gm_user');
        $gm_pass        = get_option('gm_pass');

        $gm = new GraphicMail($gm_url, $gm_user, $gm_pass);

        $mailinglists = $gm->gm_get_mailinglists();

        if ( !is_array($mailinglists) ) {

            echo '<p><strong>'.__('Error retrieving mailing lists from GraphicMail', 'adv-graphicmail').'</strong></p>';
            echo '<p>'.__('Please check if the API parameters are set properly in Settings > GraphicMail', 'adv-graphicmail').'</p>';

        } else {

            $title = isset( $instance['title'] ) ? $instance['title'] : __('Subscribe to our newsletter', 'adv-graphicmail');

            ?>

            <p>
                <label for="<?= $this->get_field_id( 'title' ) ?>"><?php _e('Title:') ?></label>
                <input class="widefat" id="<?= $this->get_field_id( 'title' ) ?>" name="<?= $this->get_field_name( 'title' ) ?>" type="text" value="<?= esc_attr( $title ) ?>" />
            </p>

            <p>
                <label for="<?= $this->get_field_id( 'mailinglist' ) ?>"><?= __('Select mailing list:', 'adv-graphicmail') ?></label>
                <select class="widefat" id="<?= $this->get_field_id( 'mailinglist' ) ?>" name="<?= $this->get_field_name( 'mailinglist' ) ?>">

                <?php
                foreach ( $mailinglists as $mailinglist_id => $mailinglist_description ) {

                    $selected = $mailinglist_id == $instance['mailinglist'] ? 'selected="selected"' : '';

                    echo '<option '.$selected.' value="'.$mailinglist_id.'">'.$mailinglist_description.'</option>';

                }
                ?>

                </select>
            </p>

            <?php

        }

    }

    public function update( $new_instance, $old_instance ) {

        $instance = array(
            'title'         => ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '',
            'mailinglist'   => $new_instance['mailinglist']
        );

        return $instance;

    }

}