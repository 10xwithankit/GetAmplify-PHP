<?php

/**
 * Amplify is a  customer relationship management  for web app owners
 * 
 * This library provides connectivity with the Amplify API 
 * 
 * Basic usage:
 * 
 * 1. Configure Amplify with your access credentials
 * <code>
 * <?php
 * 
 * $amplify = new Amplify('dummy_api_key','dummy_api_secret','dummy_project_id');
 * ?>
 * </code>
 * 
 * 2. Make requests to the API
 * <code>
 * <?php
 * $amplify = new Amplify('dummy_app_key','dummy_app_secret','dummy_project_id');
 * amplify->identify(`sandeep@socialaxishq.com`,‘Sandeep’);
 *
 * ?>
 * </code>
 * 
 * @author    Sandeep Kaushal Verma <sandeep@socialaxishq.com>
 * @copyright Copyright 2013 Betaout Pvt Ltd All rights reserved.
 * @link      http://www.betaout.com/
 * @license   http://opensource.org/licenses/MIT
 * */
// Check for the required json and curl extensions, the Google API PHP Client won't function without them.
if (!function_exists('curl_init')) {
    throw new Exception('Amplify PHP SDK  requires the CURL PHP extension');
}

if (!function_exists('json_decode')) {
    throw new Exception('Amplify PHP SDK requires the JSON PHP extension');
}

if (!function_exists('http_build_query')) {
    throw new Exception('Amplify PHP SDK requires http_build_query()');
}

/**
 * amplify.to API 
 */
class Amplify {
    /*
     * the amplify ApiKey 
     */

    protected $apiKey;

    /*
     * the amplify ApiSecret 
     */
    protected $apiSecret;
    public $hitcount = 0;

    /*
     * the amplify  ProjectId
     */
    protected $projectId;

    /*
     * the amplify requesturl
     *  
     */
    protected $requestUrl;
    /*
     * the amplify custom URL
     *  
     */
    protected $publicationUrl;

    /**
     * amplify host
     */
    private $host = 'getamplify.com';

    /**
     * amplify version
     */
    private $version = 'v1';

    /*
     * param to be send on amplify 
     */
    protected $params;

    /*
     *  Computes a Hash-based Message Authentication Code (HMAC) using the SHA1 hash function.
     */
    protected $signatureMethod = 'HMAC-SHA1';

    /*
     * signature based string  
     */
    protected $hash;
    /*
     * current time stamp used to create hash 
     */
    protected $timeStamp;
    /*
     * ott refer one time token that use to handshake  
     */
    protected $ott;

    /**
     * Whether we are in debug mode. This is set by the constructor
     */
    private $debug = false;

    /**
     *  If the spider text is found in the current user agent, then return true
     */

    /**
     * gettting device info
     */
    private $botDetect = false;

    /**
     * gettting device info
     */
    private $deviceDetect = 1;

    /**
     * function end point mapping
     */
    protected $functionUrlMap = array(
        'identify' => 'user/identify/',
        'event' => 'user/event/',
        'update' => 'user/update/',
        'add' => 'user/add/',
        'verify' => 'client/verify/',
        'userProfile' => 'user/profile/',
        'fetchwidget' => 'client/fetchwidget/'
    );

    /**
     * spider array used to call is not human
     */
    protected $spiders = array("seek", "accoona", "acoon", "adressendeutschland", "ah-ha.com", "ahoy", "altavista", "ananzi", "anthill", "appie", "arachnophilia", "arale", "araneo", "aranha", "architext", "aretha", "arks", "asterias", "atlocal", "atn", "atomz", "augurfind", "backrub", "bannana_bot", "baypup", "bdfetch", "big brother", "biglotron", "bjaaland", "blackwidow", "blaiz", "blog", "blo.", "bloodhound", "boitho", "booch", "bradley", "butterfly", "calif", "cassandra", "ccubee", "cfetch", "charlotte", "churl", "cienciaficcion", "cmc", "collective", "comagent", "combine", "computingsite", "csci", "curl", "cusco", "daumoa", "deepindex", "delorie", "depspid", "deweb", "die blinde kuh", "digger", "ditto", "dmoz", "docomo", "download express", "dtaagent", "dwcp", "ebiness", "ebingbong", "e-collector", "ejupiter", "emacs-w3 search engine", "esther", "evliya celebi", "ezresult", "falcon", "felix ide", "ferret", "fetchrover", "fido", "findlinks", "fireball", "fish search", "fouineur", "funnelweb", "gazz", "gcreep", "genieknows", "getterroboplus", "geturl", "glx", "goforit", "golem", "grabber", "grapnel", "gralon", "griffon", "gromit", "grub", "gulliver", "hamahakki", "harvest", "havindex", "helix", "heritrix", "hku www octopus", "homerweb", "htdig", "html index", "html_analyzer",
        "htmlgobble",
        "hubater",
        "hyper-decontextualizer",
        "ia_archiver",
        "ibm_planetwide",
        "ichiro",
        "iconsurf",
        "iltrovatore",
        "image.kapsi.net",
        "imagelock",
        "incywincy",
        "indexer",
        "infobee",
        "informant",
        "ingrid",
        "inktomisearch.com",
        "inspector web",
        "intelliagent",
        "internet shinchakubin",
        "ip3000",
        "iron33",
        "israeli-search",
        "ivia",
        "jack",
        "jakarta",
        "javabee",
        "jetbot",
        "jumpstation",
        "katipo",
        "kdd-explorer",
        "kilroy",
        "knowledge",
        "kototoi",
        "kretrieve",
        "labelgrabber",
        "lachesis",
        "larbin",
        "legs",
        "libwww",
        "linkalarm",
        "link validator",
        "linkscan",
        "lockon",
        "lwp",
        "lycos",
        "magpie",
        "mantraagent",
        "mapoftheinternet",
        "marvin/",
        "mattie",
        "mediafox",
        "mediapartners",
        "mercator",
        "merzscope",
        "microsoft url control",
        "minirank",
        "miva",
        "mj12",
        "mnogosearch",
        "moget",
        "monster",
        "moose",
        "motor",
        "multitext",
        "muncher",
        "muscatferret",
        "mwd.search",
        "myweb",
        "najdi",
        "nameprotect",
        "nationaldirectory",
        "nazilla",
        "ncsa beta",
        "nec-meshexplorer",
        "nederland.zoek",
        "netcarta webmap engine",
        "netmechanic",
        "netresearchserver",
        "netscoop",
        "newscan-online",
        "nhse",
        "nokia6682/",
        "nomad",
        "noyona",
        "nutch",
        "nzexplorer",
        "objectssearch",
        "occam",
        "omni",
        "open text",
        "openfind",
        "openintelligencedata",
        "orb search",
        "osis-project",
        "pack rat",
        "pageboy",
        "pagebull",
        "page_verifier",
        "panscient",
        "parasite",
        "partnersite",
        "patric",
        "pear.",
        "pegasus",
        "peregrinator",
        "pgp key agent",
        "phantom",
        "phpdig",
        "picosearch",
        "piltdownman",
        "pimptrain",
        "pinpoint",
        "pioneer",
        "piranha",
        "plumtreewebaccessor",
        "pogodak",
        "poirot",
        "pompos",
        "poppelsdorf",
        "poppi",
        "popular iconoclast",
        "psycheclone",
        "publisher",
        "python",
        "rambler",
        "raven search",
        "roach",
        "road runner",
        "roadhouse",
        "robbie",
        "robofox",
        "robozilla",
        "rules",
        "salty",
        "sbider",
        "scooter",
        "scoutjet",
        "scrubby",
        "search.",
        "searchprocess",
        "semanticdiscovery",
        "senrigan",
        "sg-scout",
        "shai'hulud",
        "shark",
        "shopwiki",
        "sidewinder",
        "sift",
        "silk",
        "simmany",
        "site searcher",
        "site valet",
        "sitetech-rover",
        "skymob.com",
        "sleek",
        "smartwit",
        "sna-",
        "snappy",
        "snooper",
        "sohu",
        "speedfind",
        "sphere",
        "sphider",
        "spinner",
        "spyder",
        "steeler/",
        "suke",
        "suntek",
        "supersnooper",
        "surfnomore",
        "sven",
        "sygol",
        "szukacz",
        "tach black widow",
        "tarantula",
        "templeton",
        "/teoma",
        "t-h-u-n-d-e-r-s-t-o-n-e",
        "theophrastus",
        "titan",
        "titin",
        "tkwww",
        "toutatis",
        "t-rex",
        "tutorgig",
        "twiceler",
        "twisted",
        "ucsd",
        "udmsearch",
        "url check",
        "updated",
        "vagabondo",
        "valkyrie",
        "verticrawl",
        "victoria",
        "vision-search",
        "volcano",
        "voyager/",
        "voyager-hc",
        "w3c_validator",
        "w3m2",
        "w3mir",
        "walker",
        "wallpaper",
        "wanderer",
        "wauuu",
        "wavefire",
        "web core",
        "web hopper",
        "web wombat",
        "webbandit",
        "webcatcher",
        "webcopy",
        "webfoot",
        "weblayers",
        "weblinker",
        "weblog monitor",
        "webmirror",
        "webmonkey",
        "webquest",
        "webreaper",
        "websitepulse",
        "websnarf",
        "webstolperer",
        "webvac",
        "webwalk",
        "webwatch",
        "webwombat",
        "webzinger",
        "wget",
        "whizbang",
        "whowhere",
        "wild ferret",
        "worldlight",
        "wwwc",
        "wwwster",
        "xenu",
        "xget",
        "xift",
        "xirq",
        "yandex",
        "yanga",
        "yeti",
        "yodao",
        "zao/",
        "zippp",
        "zyborg",
        "...."
    );

    /**
     * The constructor
     *
     * @param  string $apiKey  The Amplify application Key
     * @param  string $apiSecret The Amplify application Secret
     * @param  string $projectId The Amplify ProjectId
     * @param  string $debug  Optional debug flag
     * @return void
     * */
    public function __construct($apiKey, $apiSecret, $projectId, $debug = false) {
        $this->setApiKey($apiKey);
        $this->setApiSecret($apiSecret);
        $this->setProjectId($projectId);
        $this->setPublicationUrl();
        $this->setTimeStamp(time());
        // $this->setOtt();
        $this->debug = $debug;
    }

    public static $CURL_OPTS = array(
        CURLOPT_CONNECTTIMEOUT => 10,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 60,
        CURLOPT_USERAGENT => 'amplify-php-1.0',
    );

    public function setApiKey($apiKey) {
        $this->apiKey = $apiKey;
//        return $this;
    }

    public function getApiKey() {
        return $this->apiKey;
    }

    public function setProjectId($projectId) {
        $this->projectId = $projectId;
//        return $this;
    }

    public function getProjectId() {
        return $this->projectId;
    }

    public function setPublicationUrl() {
        $this->publicationUrl = "http://" . $this->getProjectId() . "." . $this->host . "/" . $this->version . "/";
    }

    public function getPublicationUrl() {
        return $this->publicationUrl;
    }

    public function setHash($hash) {
        $this->hash = $hash;
        return $this;
    }

    public function getHash() {
        return $this->hash;
    }

    public function setParams($params) {
        $this->params = $params;
//        return $this;
    }

    public function getParams() {
        return $this->params;
    }

    public function setApiSecret($apiSecret) {
        $this->apiSecret = $apiSecret;
//        return $this;
    }

    public function getApiSecret() {
        return $this->apiSecret;
    }

    public function getRequestUrl() {
        return $this->requestUrl;
    }

    public function setRequestUrl($requestUrl) {
        $this->requestUrl = $requestUrl;
//        return $this;
    }

    public function setTimeStamp($timeStamp) {
        $this->timeStamp = $timeStamp;
    }

    public function getTimeStamp() {
        $timeStamp = $this->timeStamp;
        if (empty($timeStamp))
            $this->setTimeStamp(time());
        return $this->timeStamp;
    }

    public function setOtt() {
        if (isset($_COOKIE['amplifysid']) && !empty($_COOKIE['amplifysid'])) {
            $this->ott = $_COOKIE['amplifysid'];
        }
    }

    public function getOtt() {

        return $this->ott;
    }

    public function makeParams($params = false) {

        if (!is_array($params) && !empty($params))
            throw new Exception("paramter should be associative array!");
        $this->setOtt();
        if (isset($this->ott)) {
            $params['ott'] = $this->getOtt();
        }
        try {
            if (!isset($params['apiKey']))
                $params['apiKey'] = $this->getApiKey();
            if (!isset($params['timestamp']))
                $params['timestamp'] = $this->getTimeStamp();
            ksort($params);
            $paramUrl = http_build_query($params, null, "&");
            $this->setParams($paramUrl);
        } catch (Exception $ex) {
            throw new Exception($ex->getCode() . ":" . $ex->getMessage());
        }
    }

    function http_call($functionName, $argumentsArray) {

        $this->_bot_detected();
        if (!$this->botDetect) {
            $apiKey = $this->getApiKey();
            $apiSecret = $this->getApiSecret();
            if (empty($apiKey))
                throw new Exception("Invalid Api call, Api key must be provided!");
            if (empty($apiSecret))
                throw new Exception("Invalid Api call, Api Secret must be provided!");
            if (!isset($this->functionUrlMap[$functionName]))
                throw new Exception("Invalid Function call!");
            try {
                $this->deviceDetector();
                $requestUrl = $this->getPublicationUrl() . $this->functionUrlMap[$functionName]; //there should be error handling to make sure function name exist
                if (isset($argumentsArray) && is_array($argumentsArray) && count($argumentsArray) > 0) {
                    $argumentsArray['systemInfo'] = array('device'=>$this->deviceDetect,'os'=>'','browser'=>'');
                    $this->makeParams($argumentsArray);
                }
                else
                    $this->makeParams();
                $requestUrl.="?" . $this->getParams();
                $this->setRequestUrl($requestUrl);
                $this->signString();
                $requestUrl = $this->getRequestUrl() . "&hash=" . $this->getHash();
                return $this->makeRequest($requestUrl);
            } catch (Exception $ex) {
                throw new Exception($ex->getCode() . ":" . $ex->getMessage());
            }
        } else {
            return false;
        }
    }

    protected function signString() {
        switch ($this->signatureMethod) {
            case 'HMAC-SHA1':
                $key = $this->encode_rfc3986($this->apiSecret);
                $params = $this->getParams();
                $hash = urlencode(base64_encode(hash_hmac('sha1', $params, $key, true)));
                $this->setHash($hash);
                break;
            default :
                throw new Exception("Signature method is not valid");
                break;
        }
    }

    protected function encode_rfc3986($string) {
        return str_replace('+', ' ', str_replace('%7E', '~', rawurlencode(($string))));
    }

    protected function makeRequest($requestUrl, $ch = null) {
    // echo $requestUrl;
        if (!$ch) {
            $ch = curl_init();
        }
        $options = self::$CURL_OPTS;
        $options[CURLOPT_URL] = $requestUrl;
        if ($this->debug) {
            $options[CURLOPT_VERBOSE] = true;
        }
// disable the 'Expect: 100-continue' behaviour. This causes CURL to wait
// for 2 seconds if the server does not support this header.
        if (isset($options[CURLOPT_HTTPHEADER])) {
            $existing_headers = $options[CURLOPT_HTTPHEADER];
            $existing_headers[] = 'Expect:';
            $options[CURLOPT_HTTPHEADER] = $existing_headers;
        } else {
            $options[CURLOPT_HTTPHEADER] = array('Expect:');
        }

        curl_setopt_array($ch, $options);
        $result = curl_exec($ch);
       // print_r($result);
        if ($result === false) {
            throw new Exception('Curl error: ' . curl_error($ch));
        }
        curl_close($ch);
        return json_decode($result);
    }

    /*
     * check api key and api secret are valid  
     * amplify->verify();
     */

    public function verify() {
        $argumentsArray = array('apiSecret' => $this->apiSecret);
        return $this->http_call('verify', $argumentsArray);
    }

    /*
     * Identify system user if it unknowm leave parameter blank
     * amplify->identify(`sandeep@socialaxishq.com`,‘Sandeep’);
     * Replace with name and email of current user
     */

    public function identify($email = '', $name = '') {

        $argumentsArray = array('email' => $email, 'name' => $name);
        $response = $this->http_call('identify', $argumentsArray);
       // print_r($response);
        if ($response->responseCode == '200') {
            setcookie('amplifysid', $response->amplifySession, time() + 604800, "/", $_SERVER['SERVER_NAME']);
        }
        return $response;
    }

    /*
     * add new event with properties    
     * $amplify->event(`sandeep@socialaxishq.com`,array('addtocart'=>array('product'=>’Samsung Note2’,'category'=>’Mobile’,'price'=>’456.78’)));
     */

    public function event($email, $eventArray) {
        $argumentsArray = array('email' => $email, 'event' => $eventArray);
        return $this->http_call('event', $argumentsArray);
    }

    /*
     * add user  properties    
     * $amplify->update(`sandeep@socialaxishq.com`,array('country'=>’India’,'city'=>’Noida’));
     */

    public function update($email, $propetyArray) {
        $argumentsArray = array('email' => $email, 'properties' => $propetyArray);
        return $this->http_call('update', $argumentsArray);
    }

    /*
     * add new user  properties    
     * $amplify->add(`sandeep@socialaxishq.com`,array('total_comments'=>’5’,'total_shares'=>’4’));
     */

    public function add($email, $propetyArray) {
        $argumentsArray = array('email' => $email, 'properties' => $propetyArray);
        return $this->http_call('add', $argumentsArray);
    }

    /*
     * get userprofile    
     * $amplify->userProfile();
     */

    public function userProfile() {
        $argumentsArray = array('ott' => $this->getOtt());
        return $this->http_call('userProfile', $argumentsArray);
    }

    
    /*
     * get widget 
     * amplify->add('));
     */

    public function fetchwidget($widgetId) {
        $argumentsArray = array('widgetId' => $widgetId);
        return $this->http_call('fetchwidget', $argumentsArray);
    }
    
    
    private function _bot_detected() {

        if (isset($_SERVER['HTTP_USER_AGENT']) && preg_match('/bot|crawl|slurp|spider/i', $_SERVER['HTTP_USER_AGENT'])) {
            $this->botDetect = true;
        } else {

            foreach ($this->spiders as $spider) {
//If the spider text is found in the current user agent, then return true
                if (stripos($_SERVER['HTTP_USER_AGENT'], $spider) !== false)
                    $this->botDetect = true;
            }
//If it gets this far then no bot was found!
        }
    }

    protected function deviceDetector() {
        if (stripos($_SERVER['HTTP_USER_AGENT'], "Android") && stripos($_SERVER['HTTP_USER_AGENT'], "mobile")) {
            $this->deviceDetect = 'android mobile';
        } else if (stripos($_SERVER['HTTP_USER_AGENT'], "Android")) {
            $this->deviceDetect = 'android tablet';
        } else if (stripos($_SERVER['HTTP_USER_AGENT'], "iPhone")) {
            $this->deviceDetect = 'iphone';
        } else if (stripos($_SERVER['HTTP_USER_AGENT'], "iPad")) {
            $this->deviceDetect = 'ipad';
        } else if (stripos($_SERVER['HTTP_USER_AGENT'], "mobile")) {
            $this->deviceDetect = 'generic mobile';
        } else if (stripos($_SERVER['HTTP_USER_AGENT'], "tablet")) {
            $this->deviceDetect = 'generic tablet';
        } else {
            $this->deviceDetect = 'desktop';
        }
    }

}

?>
