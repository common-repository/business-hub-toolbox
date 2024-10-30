<?php

require_once( BHP_DIR . 'inc/TwitterAPIExchange.php' );

class bht_showTweets{

    public $instance;

    public $settings = array();

    public $username;

    public $noofTweets = 5;

    function __construct(){

        $this->setInstance();

    }


    public function setInstance(){

        $this->instance = $this;

    }

    public function setSettings(Array $settings = null){
        $this->settings = $settings;
    }

    public function setUserName($username){

        $this->username = $username;

    }

    public function setNoOfTweet($noofTweet){

        $noofTweet = (int) $noofTweet;

        if($noofTweet<1){

            $noofTweet = 1;

        }

        $this->noofTweets = $noofTweet;

    }

    public function bht_getTweets(){

        $url = "https://api.twitter.com/1.1/statuses/user_timeline.json";

        $requestMethod = "GET";

        if (isset($_GET['user'])) { $this->username = $_GET['user']; }
        if (isset($_GET['count'])) { $this->noofTweets = $_GET['count'];}

        $getfield = "?screen_name=".$this->username."&count=".$this->noofTweets;

        $bht_twitter = new TwitterAPIExchange($this->settings);

        $string = json_decode($bht_twitter->setGetfield($getfield)->buildOauth($url, $requestMethod)->performRequest(),$assoc = TRUE);

        return $string;

    }

    function __destruct(){

    }
}
