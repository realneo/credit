<?php
    require_once $file_path.'apis/oneapi/client.php';
    
    class SMS extends Main{
        
        public $smsClient;
        
        public function __construct(){
            $this->smsClient = new SmsClient(SMS_USERNAME, SMS_PASSWORD);
            $this->smsClient->login();
        }
        
        public function send($number, $message){
            $smsMessage = new SMSRequest();
            $smsMessage->senderAddress = SMS_SENDER;
            $smsMessage->address = $number;
            $smsMessage->message = $message;
            
            $smsMessageSendResult = $this->smsClient->sendSMS($smsMessage);
        }
            
    }
?>