<?php

define('__ONEAPI_LIBRARY_PATH__', dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR);

function __oneapi_autoloader($class) {
    $paths = array('oneapi/models', 'oneapi/core', 'oneapi/utils');
    foreach($paths as $path) {
        $fileName = __ONEAPI_LIBRARY_PATH__ . $path . '/' . $class . '.class.php';
        if(is_file($fileName))
            require_once $fileName;
    }
}

spl_autoload_register('__oneapi_autoloader');

//require_once 'yapd/dbg.php';

require_once __ONEAPI_LIBRARY_PATH__ . 'oneapi/object.php';

// Check that curl is defined:
if(!function_exists('curl_init')) {
    die('php must be compiled/installed with curl support in order for OneApi client lib to work');
}

if(!defined('ONEAPI_BASE_URL'))
    define('ONEAPI_BASE_URL', 'https://oneapi.infobip.com');

/**
 * Utility handler class to store username/password.
 */
class OneApiConfigurator {

    private static $username;
    private static $password;
    private static $charset;

    public static function setCredentials($username, $password) {
        self::$username = $username;
        self::$password = $password;
    }

    public static function getUsername() {
        return self::$username;
    }

    public static function getPassword() {
        return self::$password;
    }

    /**
     * May be used in case the locale charset of this script is not utf-8.
     */
    public static function setCharset($charset) {
        self::$charset = $charset;
    }

    public static function getCharset() {
        return self::$charset;
    }

}

class AbstractOneApiClient {

    const VERSION = '0.0.2';

    public $oneApiAuthentication = null;

    private $username;
    private $password;

    public $throwException = true;

    public function __construct($username = null, $password = null, $baseUrl = null) {
        if(!$username)
            $username = OneApiConfigurator::getUsername();
        if(!$password)
            $password = OneApiConfigurator::getPassword();

        $this->username = $username;
        $this->password = $password;

        $this->baseUrl = $baseUrl ? $baseUrl : ONEAPI_BASE_URL;

        if ($this->baseUrl[strlen($this->baseUrl) - 1] != '/')
            $this->baseUrl .= '/';

        # If true -- an exception will be thrown on error, otherwise, you have
        # to check the is_success and exception methods on resulting objects.
        $this->throwException = true;
    }

    public function setAPIurl($baseUrl=NULL) {
        $this->baseUrl = $baseUrl ? $baseUrl : ONEAPI_BASE_URL;
        if ($this->baseUrl[strlen($this->baseUrl) - 1] != '/')
            $this->baseUrl .= '/';
    }

    public function login() {
        $restPath = '/1/customerProfile/login';

        list($isSuccess, $content) = $this->executePOST(
                $this->getRestUrl($restPath), Array(
                    'username' => $this->username,
                    'password' => $this->password
                )
        );

        return $this->fillOneApiAuthentication($content, $isSuccess);
    }

    protected function fillOneApiAuthentication($content, $isSuccess) {
        $this->oneApiAuthentication = Conversions::createFromJSON('OneApiAuthentication', $content, !$isSuccess);
        $this->oneApiAuthentication->username = $this->username;
        $this->oneApiAuthentication->password = $this->password;
        $this->oneApiAuthentication->authenticated = @strlen($this->oneApiAuthentication->ibssoToken) > 0;
        return $this->oneApiAuthentication;
    }

    // ----------------------------------------------------------------------------------------------------
    // Util methods:
    // ----------------------------------------------------------------------------------------------------

    /**
     * Check if the authorization (username/password) is valid.
     */
    public function isValid() {
        $restUrl = $this->getRestUrl('/1/customerProfile');

        list($isSuccess, $content) = $this->executeGET($restUrl);

        return (boolean) $isSuccess;
    }

    protected function getOrCreateClientCorrelator($clientCorrelator=null) {
        if($clientCorrelator)
            return $clientCorrelator;

        return Utils::randomAlphanumericString();
    }

    protected function executeGET($restPath, $params = null) {
        list($isSuccess, $result) = $this->executeRequest('GET', $restPath, $params);

        return array($isSuccess, json_decode($result, true));
    }

    protected function executePOST($restPath, $params = null, $contentType = null, $socinvAppSecret = null) {
        if ($contentType != null && $socinvAppSecret != null) {
          list($isSuccess, $result) =
              $this->executeRequest('POST', $restPath, $params, null, $contentType, $socinvAppSecret);
        } else if($contentType != null){
          list($isSuccess, $result) = $this->executeRequest('POST', $restPath, $params, null, $contentType);
        } else {
            list($isSuccess, $result) = $this->executeRequest('POST', $restPath, $params);
        }

        return array($isSuccess, json_decode($result, true));
    }

    protected function executePUT($restPath, $params = null) {
        list($isSuccess, $result) = $this->executeRequest('PUT', $restPath, $params);

        return array($isSuccess, json_decode($result, true));
    }

    protected function executeDELETE($restPath, $params = null) {
        list($isSuccess, $result) = $this->executeRequest('DELETE', $restPath, $params);

        return array($isSuccess, json_decode($result, true));
    }

    /**
     * Like http_build_query but works for {'a': ['b', 'c']} the result is
     * a=b&a=c
     */
    private function buildQuery($array) {
        $result = '';
        foreach($array as $key => $value) {
            if($result)
                $result .= '&';
            if(is_array($value)) {
                foreach($value as $subValue) {
                    if($result)
                        $result .= '&';
                    $result .= urlencode($key) . '=' . urlencode($subValue);
                }
            } else {
                $result .= urlencode($key) . '=' . urlencode($value);
            }
        }
        return $result;
    }

    private function executeRequest(
            $httpMethod, $url, $queryParams = null, $requestHeaders = null,
            $contentType = "application/x-www-form-urlencoded", $specialAuth = null)
    {
        if ($queryParams == null)
            $queryParams = Array();
        if ($requestHeaders == null)
            $requestHeaders = Array();

        // Check if the charset is specified in the content-type:
        if(strpos($contentType, 'charset') === false) {
            $charset = OneApiConfigurator::getCharset();
            if(!$charset)
                $charset = 'utf-8';

            $contentType .= '; charset=' . $charset;
        }

        $sendHeaders = Array(
            'Content-Type: ' . $contentType
        );
        foreach ($requestHeaders as $key => $value) {
            $sendHeaders[] = $key . ': ' . $value;
        }

        if($httpMethod === 'GET') {
            if(sizeof($queryParams) > 0)
                $url .= '?' . $this->buildQuery($queryParams);
        }

        $opts = array(
            CURLOPT_FRESH_CONNECT => 1,
            CURLOPT_CONNECTTIMEOUT => 60,
            CURLOPT_TIMEOUT => 120,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_MAXREDIRS => 3,
            CURLOPT_USERAGENT => 'OneApi-php-' . self::VERSION,
            CURLOPT_CUSTOMREQUEST => $httpMethod,
            CURLOPT_URL => $url,
            CURLOPT_HTTPHEADER => $sendHeaders
        );

        if ($specialAuth) {
            $opts[CURLOPT_HTTPHEADER][] = 'Authorization: App ' . $specialAuth;
        } else {
            if ($this->oneApiAuthentication && $this->oneApiAuthentication->ibssoToken) {
                // Token based authentication (one request per login request):
                $opts[CURLOPT_HTTPHEADER][] = 'Authorization: IBSSO ' . $this->oneApiAuthentication->ibssoToken;
            } else {
                // Basic authorization:
                $opts[CURLOPT_USERPWD] = $this->username . ':' . $this->password;
            }
        }

        Logs::debug('Executing ', $httpMethod, ' to ', $url);

        if (sizeof($queryParams) > 0 && ($httpMethod == 'POST' || $httpMethod == 'PUT')) {
            $httpBody = null;

            if (strpos($contentType, 'x-www-form-urlencoded')) {
              $httpBody = $this->buildQuery($queryParams);
            } else if (strpos($contentType, 'json')) {
              $httpBody = json_encode($queryParams);
            }

            Logs::debug('Http body:', $httpBody);
            $opts[CURLOPT_POSTFIELDS] = $httpBody;
        }

        $ch = curl_init();
        curl_setopt_array($ch, $opts);

        $result = curl_exec($ch);

        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if(curl_errno($ch) != 0)
            throw new Exception(curl_error($ch));

        $isSuccess = 200 <= $code && $code < 300;

        curl_close($ch);

        Logs::debug('Response code ', $code);
        Logs::debug('isSuccess:', $isSuccess);
        Logs::debug('Result:', $result);

        return array($isSuccess, $result);
    }

    protected function getRestUrl($restPath = null, $vars = null) {
        $rurl = $this->baseUrl;
        if ($restPath && $restPath !== '') {
            $rurl .= substr($restPath, 0, 1) === '/' ?
                    substr($restPath, 1) : $restPath
            ;
        }

        return $this->applyTemplate($rurl, $vars);
    }

    // escape string
    protected function strEscape($str) {
        $search = array("\\", "\0", "\n", "\r", "\x1a", "'", '"');
        $replace = array("\\\\", "\\0", "\\n", "\\r", "\Z", "\'", '\"');
        return str_replace($search, $replace, $str);
    }

    // apply bind variables to template
    protected function applyTemplate($str, $params = NULL, $escapeFields = FALSE) {
        if (!$params)
            return($str);

        $rez = $str;

        foreach ($params as $nam => $val) {
            if ($val !== NULL) {
                $valn = $vals = $escapeFields ? $this->strEscape($val) : $val;
            } else {
                $vals = '';
                $valn = 'null';
            }

            $rez = str_replace("'{" . $nam . "}'", "'" . urlencode($vals) . "'", $rez);
            $rez = str_replace("{" . $nam . "}", urlencode($valn), $rez);
        }
        return($rez);
    }

    protected function createFromJSON($className, $json, $isError) {
        $result = Conversions::createFromJSON($className, $json, $isError);

        if($this->throwException && !$result->isSuccess()) {
            $message = $result->exception->messageId . ': ' . $result->exception->text . ' [' . implode(',', $result->exception->variables) . ']';
            throw new Exception($message);
        }

        return $result;
    }

}

class SmsClient extends AbstractOneApiClient {

    public function __construct($username = null, $password = null, $baseUrl = null) {
        parent::__construct($username, $password, $baseUrl);
    }

    // ----------------------------------------------------------------------------------------------------
    // Static methods used for http push events from the server:
    // ----------------------------------------------------------------------------------------------------

    public static function unserializeDeliveryStatus($json=null) {
        if($json === null)
            $json = file_get_contents("php://input");

        return Conversions::createFromJSON('DeliveryInfoNotification', $json);
    }

    public static function unserializeInboundMessages($json=null) {
        if($json === null)
            $json = file_get_contents("php://input");

        $json = json_decode($json, true);
        $json = Utils::getArrayValue($json, 'inboundSMSMessage.0');

        return Conversions::createFromJSON('InboundSmsMessage', $json);
    }

    // ----------------------------------------------------------------------------------------------------
    // Rest methods:
    // ----------------------------------------------------------------------------------------------------

    public function sendSMS($message) {
        $restPath = '/1/smsmessaging/outbound/{senderAddress}/requests'; //TODO check version

        $clientCorrelator = $this->getOrCreateClientCorrelator($message->clientCorrelator);

        if(is_string($message->address)) {
            $message->address = explode(',', $message->address);
        }

        $params = array(
            'senderAddress' => $message->senderAddress,
            'address' => $message->address,
            'message' => $message->message,
            'clientCorrelator' => $clientCorrelator,
            'senderName' => 'tel:' . $message->senderAddress
        );

        if ($message->notifyURL)
            $params['notifyURL'] = $message->notifyURL;
        if ($message->callbackData)
            $params['callbackData'] = $message->callbackData;
        if($message->language){
            $params['language'] = $message->language;
        }

        $contentType = 'application/json';

        list($isSuccess, $content) = $this->executePOST(
                $this->getRestUrl($restPath, Array('senderAddress' => $message->senderAddress)), $params, $contentType
        );

        return $this->createFromJSON('ResourceReference', $content, !$isSuccess);
    }

    /**
     * Check for delivery status of a message. If no
     * $clientCorrelatorOrResourceReference is given -- get the list of all pending
     * delivery statuses.
     */
    public function queryDeliveryStatus($clientCorrelatorOrResourceReference = null) {
        $restPath = '/1/smsmessaging/outbound/requests/{clientCorrelator}/deliveryInfos';

        if (is_object($clientCorrelatorOrResourceReference)) {
            $clientCorrelator = $clientCorrelatorOrResourceReference->clientCorrelator;
        } else {
            $clientCorrelator = (string) $clientCorrelatorOrResourceReference;
        }

        $clientCorrelator = $this->getOrCreateClientCorrelator($clientCorrelator);

        $params = array();
        if($clientCorrelator)
            $params['clientCorrelator'] = $clientCorrelator;

        list($isSuccess, $content) = $this->executeGET(
                $this->getRestUrl($restPath, $params)
        );

        return $this->createFromJSON('DeliveryInfoList', $content, !$isSuccess);
    }

    /**
     * Get the list of sent SMS messages.
     */
    public function retrieveOutboundMessages($fromTime=null, $toTime=null){
        $params = array();
        if(! $fromTime){
            $fromTime = OneApiDateTime::createFromFormat('Y-m-dTH:i:s....O', '1970-01-01T00:00:00.000+0000');
        }

        $params['from'] = $fromTime->format('Y-m-d\TH:i:s.000O');
        if($toTime){
            $params['to'] = $toTime->format('Y-m-d\TH:i:s.000O');
        }

        $restUrl = $this->getRestUrl('/1/messaging/outbound/logs/');
        list($isSuccess, $content) = $this->executeGET($restUrl, $params);

        return $this->createFromJSON('OutboxMessages', $content, !$isSuccess);
        //return new OutboxMessages($content, $isSuccess);
    }

    /**
     * Get the list of mobile originated subscriptions for the current user.
     */
    public function retrieveInboundMessagesSubscriptions() {
        $restUrl = $this->getRestUrl('/1/smsmessaging/inbound/subscriptions');
        list($isSuccess, $content) = $this->executeGET($restUrl);

        return new MoSubscriptions($content, $isSuccess);
    }

    /**
     * Create new inbound messages subscription.
     */
    public function subscribeToInboundMessagesNotifications($moSubscription) {
        $restUrl = $this->getRestUrl('/1/smsmessaging/inbound/subscriptions');

        $params = Conversions::convertToJSON($moSubscription);

        list($isSuccess, $content) = $this->executePOST($restUrl, $params);

        // TODO(TK) clientCorrelator !!!

        return new GenericObject($content, $isSuccess);
    }

    /**
     * Delete inbound messages subscription.
     */
    // TODO(TK)
    public function cancelInboundMessagesSubscription($subscriptionId) {
        $restUrl = $this->getRestUrl('/1/smsmessaging/outbound/subscriptions/' . $subscriptionId);
        list($isSuccess, $content) = $this->executeDELETE($restUrl);

        return new GenericObject($content, $isSuccess);
    }

    public function retrieveInboundMessages($maxNumberOfMessages=null){
        $restUrl = $this->getRestUrl('/1/smsmessaging/inbound/registrations/INBOUND/messages');

        if(! $maxNumberOfMessages)
            $maxNumberOfMessages = 100;

        if($maxNumberOfMessages < 0)
            $maxNumberOfMessages = -1 * $maxNumberOfMessages;

        $params = array('maxBatchSize' => $maxNumberOfMessages);

        list($isSuccess, $content) = $this->executeGET($restUrl, $params);

        return $this->createFromJSON('InboundSmsMessages', $content, !$isSuccess);
    }

	/**
	 * Start subscribing to delivery status notifications over OneAPI for all your sent SMS
	 */
	public function subscribeToDeliveryStatusNotifications($subscribeToDeliveryNotificationsRequest) {
        $restUrl = $this->getRestUrl('/1/smsmessaging/outbound/'.$subscribeToDeliveryNotificationsRequest->senderAddress.'/subscriptions');

        $clientCorrelator = $this->getOrCreateClientCorrelator($subscribeToDeliveryNotificationsRequest->clientCorrelator);

        $params = array(
            'notifyURL' => $subscribeToDeliveryNotificationsRequest->notifyURL,
            'criteria' => $subscribeToDeliveryNotificationsRequest->criteria,
            'callbackData' => $subscribeToDeliveryNotificationsRequest->callbackData,
            'clientCorrelator' => $clientCorrelator
        );

        list($isSuccess, $content) = $this->executePOST($restUrl, $params);

        return $this->createFromJSON('DeliveryReportSubscription', $content, !$isSuccess);
    }

	/**
	 * Stop subscribing to delivery status notifications for all your sent SMS
	 * @param subscriptionId (mandatory) contains the subscriptionId of a previously created SMS delivery report subscription
	 */
	public function cancelDeliveryNotificationsSubscription($subscriptionId) {
        $restUrl = $this->getRestUrl('/1/smsmessaging/outbound/subscriptions/' . $subscriptionId);

        list($isSuccess, $content) = $this->executeDELETE($restUrl);

        return $this->createFromJSON('GenericObject', null, !$isSuccess);
    }

	/**
	 * Retrieve delivery notifications subscriptions by for the current user
	 * @return DeliveryReportSubscription[]
	 */
	public function retrieveDeliveryNotificationsSubscriptions() {
        $restUrl = $this->getRestUrl('/1/smsmessaging/outbound/subscriptions');

        list($isSuccess, $content) = $this->executeGET($restUrl);

        return $this->createFromJSON('DeliveryReportSubscription', $content, !$isSuccess);
    }

}

/**
 * Warning, temporary implementation, the API may change!
 */
class UssdClient extends AbstractOneApiClient {

    public function __construct($username = null, $password = null, $baseUrl = null) {
        parent::__construct($username, $password, $baseUrl);
    }

    public function sendMessage($address, $message) {
        $params = array(
                'address' => $address,
                'message' => $message,
        );

        list($isSuccess, $content) = $this->executePOST(
                $this->getRestUrl('/1/ussd/outbound'),
                $params
        );

        return $this->createFromJSON('InboundSmsMessage', $content, !$isSuccess);
    }

    public function stopSession($address, $message) {
        $params = array(
                'address' => $address,
                'message' => $message,
                'stopSession' => 'true',
        );

        list($isSuccess, $content) = $this->executePOST(
                $this->getRestUrl('/1/ussd/outbound'),
                $params
        );

        return $isSuccess;
    }

}

class DataConnectionProfileClient extends AbstractOneApiClient {

    public function __construct($username = null, $password = null, $baseUrl = null) {
        parent::__construct($username, $password, $baseUrl);
    }

    public static function unserializeRoamingStatus($json=null) {
        if($json === null)
            $json = file_get_contents("php://input");

        return Conversions::createFromJSON('TerminalRoamingStatusNotification', $json);
    }

	/**
	 * Retrieve asynchronously the customer’s roaming status for a single network-connected mobile device  (HLR)
	 */
	public function retrieveRoamingStatus($address, $notifyURL=null) {
        $restUrl = $this->getRestUrl('/1/terminalstatus/queries/roamingStatus');

        $params = array(
			'address' => $address,
        );

        // TODO(TK) Add these parameters when ready:
        if(false)
            $params['includeExtendedData'] = true;
        if(false)
			$params['clientCorrelator'] = true;
        if(false)
			$params['callbackData'] = true;

        if($notifyURL)
			$params['notifyURL'] = $notifyURL;

        list($isSuccess, $content) = $this->executeGET($restUrl, $params);

        if($notifyURL)
            return $this->createFromJSON('GenericObject', null, !$isSuccess);
        else
            return $this->createFromJSON('TerminalRoamingStatus', $content['roaming'], !$isSuccess);
    }

}

class CaptchaClient extends AbstractOneApiClient {

    public function __construct($username = null, $password = null, $baseUrl = null) {
        parent::__construct($username, $password, $baseUrl);
    }

    /**
     * Get captcha
     */
    // TODO(TK)
    public function getCaptcha($width=200,$height=50,$imageFormat="png") {
        $restUrl = $this->getRestUrl('/1/captcha/generate',Array(
            'width' => $width,
            'height' => $height,
            'imageFormat' => $imageFormat
        ));
        list($isSuccess, $content) = $this->executePOST($restUrl);

        return new Captcha($content, $isSuccess);
    }

}

class CountryClient extends AbstractOneApiClient {

    public function __construct($username = null, $password = null, $baseUrl = null) {
        parent::__construct($username, $password, $baseUrl);
    }

    /**
     * Get list of all countries or one with given country id
     */
    // TODO(TK)
    public function getCountries($id = null) {
        $restUrl = $this->getRestUrl(
                $id == null ? '/1/countries' : '/1/countries/{id}', Array('id' => $id)
        );
        list($isSuccess, $content) = $this->executeGET($restUrl);

        return new Countries($content, $isSuccess);
    }

}

class CustomerProfileClient extends AbstractOneApiClient {

    public function __construct($username = null, $password = null, $baseUrl = null) {
        parent::__construct($username, $password, $baseUrl);
    }

    public function getAccountBalance() {
        $restPath = $this->getRestUrl('/1/customerProfile/balance');

        list($isSuccess, $content) = $this->executeGET($restPath);

        return $this->createFromJSON('AccountBalance', $content, !$isSuccess);
    }

    public function logout() {
        $restPath = '/1/customerProfile/logout';

        list($isSuccess, $content) = $this->executePOST($this->getRestUrl($restPath));
        $this->oneApiAuthentication = null;

        return $isSuccess;
    }

    // TODO(TK)
    public function verifyUser($verificationCode='') {
        $restPath = '/1/customerProfile/verify';

        // reset current auth
        list($isSuccess, $content) = $this->executePOST(
                $this->getRestUrl($restPath), Array(
                    'verificationCode' => $verificationCode
                )
        );
        if(!$isSuccess) {
            return new SmsAuthentication($content, $isSuccess);
        } else {
            $this->oneApiAuthentication->verified = true;
        }
        return $this->oneApiAuthentication;
    }


    // TODO(TK)
    public function signup($customerProfile, $password, $captchaId, $captchaAnswer) {
        $restPath = '/1/customerProfile/signup';

        $params = array(
            'username' => $customerProfile->username,
            'forename' => $customerProfile->forename,
            'surname' => $customerProfile->surname,
            'email' => $customerProfile->email,
            'gsm' => $customerProfile->gsm,
            'countryCode' => $customerProfile->countryCode,
            'timezoneId' => $customerProfile->timezoneId,
            //
            'password' => $password,
            'captchaId' => $captchaId,
            'captchaAnswer' => $captchaAnswer
        );

        list($isSuccess, $content) = $this->executePOST(
                $this->getRestUrl($restPath),
                $params
        );

        return $this->fillOneApiAuthentication($content, $isSuccess);
    }

    // TODO(TK)
    public function checkUsername($uname) {
        $restPath = '/1/customerProfile/username/check';

        list($isSuccess, $content) = $this->executeGET(
            $this->getRestUrl($restPath), Array(
                'username' => $uname
            )
        );

        return Utils::getArrayValue($content,'usernameCheck',false) == true;
    }

    /**
     * Get customer profile for the current user or user with given user id.
     */
    public function getCustomerProfile($id = null) {
        $restUrl = $this->getRestUrl(
                $id == null ? '/1/customerProfile' : '/1/customerProfile/{id}', Array('id' => $id)
        );
        list($isSuccess, $content) = $this->executeGET($restUrl);

        return $this->createFromJSON('CustomerProfile', $content, !$isSuccess);
    }

    /**
     * Update customer profile.
     */
    // TODO(TK)
    public function updateCustomerProfile($customerProfile) {
        $restUrl = $this->getRestUrl('/1/customerProfile');
        list($isSuccess, $content) = $this->executeGET($restUrl, Array(
            'id' => $customerProfile->id,
            'username' => $customerProfile->username,
            'forename' => $customerProfile->forename,
            'surname' => $customerProfile->surname,
            'street' => $customerProfile->street,
            'city' => $customerProfile->city,
            'zipCode' => $customerProfile->zipCode,
            'telephone' => $customerProfile->telephone,
            'gsm' => $customerProfile->gsm,
            'fax' => $customerProfile->fax,
            'email' => $customerProfile->email,
            'msn' => $customerProfile->msn,
            'skype' => $customerProfile->skype,
            'countryId' => $customerProfile->countryId,
            'timezoneId' => $customerProfile->timezoneId,
            'primaryLanguageId' => $customerProfile->primaryLanguageId,
            'secondaryLanguageId' => $customerProfile->secondaryLanguageId
        ));

        return $isSuccess;
    }

}

class TimeZoneClient extends AbstractOneApiClient {

    public function __construct($username = null, $password = null, $baseUrl = null) {
        parent::__construct($username, $password, $baseUrl);
    }

    /**
     * Get list of all timezones or one with given timezone id
     */
    // TODO(TK)
    public function getTimezones($id = null) {
        $restUrl = $this->getRestUrl(
                $id == null ? '/1/timezones' : '/1/timezones/{id}', Array('id' => $id)
        );
        list($isSuccess, $content) = $this->executeGET($restUrl);

        return new Timezones($content, $isSuccess);
    }

}

class EncodingClient extends AbstractOneApiClient {

    public function __construct($username = null, $password = null, $baseUrl = null) {
        parent::__construct($username, $password, $baseUrl);
    }

    /**
     * Get list of all encodings
     */
    // TODO(TK)
    public function getEncodings($id = null) {
        $restUrl = $this->getRestUrl('/1/fileEncodings');
        list($isSuccess, $content) = $this->executeGET($restUrl);

        return new Encodings($content, $isSuccess);
    }

}

class SocialInviteClient extends AbstractOneApiClient {

    public function __construct($username = null, $password = null, $baseUrl = null) {
        parent::__construct($username, $password, $baseUrl);
    }

    private function getOrCreateSenderId($sender) {
        if ($sender)
            return $sender;

        return 'InfoSMS';
    }

    /**
     * Send social invitation
     */
    public function sendInvite($socialInviteRequest, $socialInviteAppSecret) {
        $restUrl = $this->getRestUrl('/1/social-invite/invitation');

        $sender = $this->getOrCreateSenderId($socialInviteRequest->senderAddress);

        if(is_string($socialInviteRequest->recipients)) {
            $temp = explode(',', $socialInviteRequest->recipients);
            unset($socialInviteRequest->recipients);
            for ($i = 0; $i < count($temp); $i++) {
                $socialInviteRequest->recipients->destinations[$i] = new stdClass();
                $socialInviteRequest->recipients->destinations[$i]->address = $temp[$i];
            }
        }

        $params = array(
           'messageKey' => $socialInviteRequest->messageKey,
           'sender' => $sender,
           'recipients' => $socialInviteRequest->recipients
        );

        list($isSuccess, $content) = $this->executePOST(
               $restUrl, $params, 'application/json', $socialInviteAppSecret
        );

        return $this->createFromJSON('SocialInviteResponse', $content, !$isSuccess);
    }
}
