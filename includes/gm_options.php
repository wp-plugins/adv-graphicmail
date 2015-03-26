<?php
function gm_options() {

    ?>

    <div class="gm-options-panel">

    <?php

    $gm_url         = get_option('gm_url');
    $gm_user        = get_option('gm_user');
    $gm_pass        = get_option('gm_pass');

    if ( !empty($gm_url) and !empty($gm_user) and !empty($gm_pass) ) {

        $gm = new GraphicMail($gm_url, $gm_user, $gm_pass);

        if ( !$gm->gm_check_credentials() ) {

            update_option('gm_off', 1);

            echo '<p class="gm-options-message gm-error">'.__('Unable to authenticate. Please provide valid API credentials.', 'adv-graphicmail').'</p>';

        } else {

            update_option('gm_off', 0);

            echo '<p class="gm-options-message gm-success">'.__('GraphicMail API authenticated', 'adv-graphicmail').'</p>';

        }

    }

    ?>

        <h2><?= __('GraphicMail API options', 'adv-graphicmail') ?></h2>

        <form action="options.php" method="post">

            <?php settings_fields('adv-graphicmail'); ?>

            <p><?= __('Please provide the GraphicMail domain you have an account on, and the API credentials.', 'adv-graphicmail') ?></p>

            <table class="form-table">
                <tr>
                    <th scope="row"><?= __('GraphicMail URL', 'adv-graphicmail') ?></th>
                    <td>
                        <input type="text" placeholder="<?= __('E.g. www.graphicmail.com', 'adv-graphicmail') ?>" name="gm_url" id="gm_url" value="<?= get_option('gm_url') ?>" />
                    </td>
                </tr>
                <tr>
                    <th scope="row"><?= __('API Username', 'adv-graphicmail') ?></th>
                    <td>
                        <input type="text" placeholder="<?= __('Insert your API username', 'adv-graphicmail') ?>" name="gm_user" id="gm_user" value="<?= get_option('gm_user') ?>" />
                    </td>
                </tr>
                <tr>
                    <th scope="row"><?= __('API Password', 'adv-graphicmail') ?></th>
                    <td>
                        <input type="password" placeholder="<?= __('Insert your API password', 'adv-graphicmail') ?>" name="gm_pass" id="gm_pass" value="<?= get_option('gm_pass') ?>" />
                    </td>
                </tr>
            </table>

            <p>
                <input type="submit" class="button-primary" value="<?= __('Save Changes', 'adv-graphicmail') ?>" />
            </p>

        </form>

    </div>

    <?php

}