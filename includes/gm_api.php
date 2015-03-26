<?php

class GraphicMail {

    private $url;
    private $user;
    private $pass;

    public function __construct( $url, $user, $pass ) {

        $this->url  = $url;
        $this->user = $user;
        $this->pass = $pass;

    }

    public function gm_check_url($url) {

        $response = @file_get_contents($url);

        if ( empty($response) ) { return false; }

        if ( $response[0] != '0' ) {

            libxml_use_internal_errors(true);
            $xml = simplexml_load_string($response);

            return $xml ? true : false;

        }

        return false;

    }

    public function gm_correct_url() {

        $url = $this->url.'/api.aspx?Username='.$this->user.'&Password='.$this->pass.'&Function=get_mailinglists';

        if ( strpos($url, 'http') === false and strpos($url, 'https') === false ) {

            $s = GM_HTTPS ? 's' : '';
            $url = 'http'.$s.'://'.$this->url;

            $this->url = $url;

        }

        if ( $this->gm_check_url($url) ) {

            return $this->url;

        }

        return $this->url;

    }

    public function gm_check_credentials() {

        if ( $this->gm_get_mailinglists() === false ) {

            return false;

        }

        return true;

    }

    public function gm_subscribe($email, $mailinglist_id) {

        $this->url = $this->gm_correct_url();
        $url = $this->url.'/api.aspx?Username='.$this->user.'&Password='.$this->pass.'&Function=post_subscribe&Email='.$email.'&MailinglistID='.$mailinglist_id;

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $response = curl_exec($curl);

        curl_close($curl);

        if ( $response !== false ) {

            return $response[0] == '0' ? false : true;

        }

        return false;

    }

    public function gm_get_mailinglists() {

        $this->url = $this->gm_correct_url();
        $url = $this->url.'/api.aspx?Username='.$this->user.'&Password='.$this->pass.'&Function=get_mailinglists';

        $response = @file_get_contents($url);

        if ( empty($response) ) {

            // failed to connect
            return false;

        }

        if ( $response[0] != '0' ) {

            // API success
            libxml_use_internal_errors(true);
            $xml = simplexml_load_string($response);

            if ( $xml ) {

                $mailinglists = array();

                foreach ( $xml->mailinglist as $mailinglist ) {

                    $mailinglists[ (string) $mailinglist->mailinglistid ] = $mailinglist->description;

                }

                return $mailinglists;

            }

        }

        // API error
        return false;

    }

}