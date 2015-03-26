jQuery(document).ready(function($) {

    var gm_btn_subscribe    = $("#gm-btn-subscribe");
    var gm_mailinglist_id   = $("#gm-mailinglist-id").val();

    gm_btn_subscribe.on('click', function(e) {

        e.preventDefault();

        $.ajax({
            type: "POST",
            url: "/wp-admin/admin-ajax.php",
            dataType: 'json',
            data: {
                gm_mailinglist_id:      gm_mailinglist_id,
                gm_email_subscriber:    $("#gm-email-subscriber").val(),
                action:                 'gm_ajax_subscribe'
            },
            success: function(data) {

                var subscription_status = data.success == true ? 'success' : 'error';
                swal(data.messages[0], data.messages[1], subscription_status);

                $("#gm-email-subscriber").val('');

            }

        });

    });

});