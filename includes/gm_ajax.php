<?php
function gm_ajax_subscribe() {

    $gm_result = array(
        'success'   => false,
        'messages'  => array()
    );

    if ( !empty( $_POST['gm_email_subscriber'] ) and !empty( $_POST['gm_mailinglist_id'] ) ) {

        $gm_mailinglist_id      = $_POST['gm_mailinglist_id'];
        $gm_email_subscriber    = $_POST['gm_email_subscriber'];

        if ( filter_var($gm_email_subscriber, FILTER_VALIDATE_EMAIL) ) {

            $gm_url         = get_option('gm_url');
            $gm_user        = get_option('gm_user');
            $gm_pass        = get_option('gm_pass');

            $gm = new GraphicMail($gm_url, $gm_user, $gm_pass);

            if ( $gm->gm_subscribe($gm_email_subscriber, $gm_mailinglist_id) ) {

                $gm_result['success']   = true;
                $gm_result['messages']  = array( __('Subscription completed', 'adv-graphicmail'), __('You have been subscribed', 'adv-graphicmail') );

            } else {

                $gm_result['success']   = false;
                $gm_result['messages']  = array( __('Cannot subscribe', 'adv-graphicmail'), __('Error subscribing to the mailing list', 'adv-graphicmail') );

            }

        } else {

            $gm_result['success']   = false;
            $gm_result['messages']  = array( __('Cannot subscribe', 'adv-graphicmail'), __('Please insert a valid email address', 'adv-graphicmail') );

        }

    }

    elseif ( isset( $_POST['gm_email_subscriber'] ) ) {

        $gm_result['success']   = false;
        $gm_result['messages']  = array( __('Cannot subscribe', 'adv-graphicmail'), __('Please insert an email address', 'adv-graphicmail') );

    }

    echo json_encode($gm_result);

    die();

}