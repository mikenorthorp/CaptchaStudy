<?php

require_once(dirname(__FILE__) . "/leapmarketingclient.php");

define("LM_FIELD_ANSWER", "nucaptcha-answer");
define("LM_FIELD_DATATYPE", "nucaptcha-datatype");
define("LM_FIELD_INDEX", "nucaptcha-index");

//define("LM_TESTACTION_EXCEPTION_SECURITY", "exception-security");

define("LM_AIM_SECURITY_RESPONSE_STATUS_WAIT", 0);
define("LM_AIM_SECURITY_RESPONSE_STATUS_READY", 1);

define("LM_ENTERPRISE_SETTING_WIDGET", "widget");
define("LM_ENTERPRISE_SETTING_WIDGET_AIM", "aim");


class lmcAIMSecurityResponse
{
    private $mStatus;
    private $mWaitTime;
    private $mPersistentData;
    private $mChallengeURL;
    private $mWidgetData;
    
    /** !EXPORT
	 * Initializes an aim security response. Should never be called directly outside of this file.
	 *
	 * @param int $status - either LM_AIM_SECURITY_RESPONSE_STATUS_READY or LM_AIM_SECURITY_RESPONSE_STATUS_WAIT
     * @param float $waitTime - the amount of time to wait until the next request, if the status was LM_AIM_SECURITY_RESPONSE_STATUS_WAIT
     * @param string $pdata - the security persistent data
     * @param string $challengeURL - the url to the challenge data (MP4, GIF, etc)
     * @param $widgetData - the persistent data from a transaction
	 */
    public function __construct($status, $waitTime, $pdata, $challengeURL, $widgetData)
    {
        $this->mStatus = $status;
        $this->mWaitTime = $waitTime;
        $this->mPersistentData = $pdata;
        $this->mChallengeURL = $challengeURL;
        $this->mWidgetData = $widgetData;
    }
    
    /** !EXPORT
	 * Gets the response status from a security request. Wait indicates that a challenge retry should happen after the value returned from GetWaitTime has elapsed.
	 *
     * @return int - LM_AIM_SECURITY_RESPONSE_STATUS_READY or LM_AIM_SECURITY_RESPONSE_STATUS_WAIT
	 */
    public function GetResponseStatus()
    {
        return $this->mStatus;
    }
    
    /** !EXPORT
	 * Gets the amount of time to wait before retrying the security request.
	 *
     * @return float - time, in seconds, to wait before retrying the security request
	 */
    public function GetWaitTime()
    {
        return ($this->mStatus == LM_AIM_SECURITY_RESPONSE_STATUS_READY) ? 0 : $this->mWaitTime;
    }
    
    /** !EXPORT
	 * Gets the persistent data for this security response. It's url_encoded and safe to pass around in GET or POST parameters or through JSON.
	 *
     * @return string - persistent data
	 */
    public function GetPersistentData()
    {
        return $this->mPersistentData;
    }
    
    /** !EXPORT
	 * Get the challenge url. This is the URL to load the data from. The URL will have the string '__INDEX__', which needs to be replaced with an index for the captcha resource to use, and the string '__FORMAT__', which needs to be replaced with the type of resource you want (GIF, MP4, or MP3, currently).
	 *
     * @return string
	 */
    public function GetChallengeURL()
    {
        return ($this->mStatus == LM_AIM_SECURITY_RESPONSE_STATUS_READY) ? $this->mChallengeURL : "";
    }
    
    /** !EXPORT
	 * Encodes and encrypts the input, which can be passed out to the client page.
	 *
     * @param array $dataList
     * @return string
	 */
    static public function PackData($dataList)
    {
        // encode the data in json format
        $encodedData = json_encode($dataList);
        
        // get our client key, so we can encrypt
        $clientKey = Leap::GetClientKey();
        if (!$clientKey)
        {
            return "";
        }
        
        // pack it all into a text chunk
        $td = new lmcTextChunk("PCDATA");
        
        // add all of our chunk data pieces
        $td->AddChunk("TIME", time());
        $td->AddChunk("PUID", lmcHelper::GenerateWebUserID());
        $td->AddChunk("PSDATA", $encodedData);
        
        // write out the data into a text stream
        $message = $td->Export();
        
        // encipher the message
        return lmcSymmetricMessage::EncipherMessage($clientKey->GetChunk("SKEY"), $message, $clientKey->GetChunk("CID"), $clientKey->GetChunk("KID")/*, PerfProfile*/);
    }
    
    /** !EXPORT
	 * Unpacks an array that was previously encoded and encrypted by PackData.
	 *
     * @return array
	 */
    static public function UnpackData($previousCaptchaData)
    {
        // get the client key to decipher with
        $clientKey = Leap::GetClientKey();
        if (!$clientKey)
        {
            return array();
        }
        
        // decipher the message
        $message = lmcSymmetricMessage::DecipherMessage($clientKey->GetChunk("SKEY"), $previousCaptchaData/*, PerfProfile*/);
        
        // get the our text data in chunk form
        $td = lmcTextChunk::Decode($message, "PCDATA");
        
        // get our data block back out
        $encodedData = $td->GetChunk("PSDATA");
        
        // now decode it from json format
        $dataList = json_decode($encodedData);
        
        return $dataList;
    }
}
    
class lmcTransactionParameters
{
    private $mUserData = null;
    private $mUseSSL = false;
    private $mCampaignProfile = null;
    private $mPurpose = Leap::PURPOSE_UNKNOWN;
    private $mPreferredLanguage = Leap::LANGUAGE_ENGLISH;
    private $mEnterpriseSettings = array();

    public function SetUserData($userData)
    {
        $this->mUserData = $userData;
    }
       
    public function GetUserData()
    {
        return $this->mUserData;
    }
    
    public function SetUseSSL($useSSL)
    {
        $this->mUseSSL = $useSSL;
    }
       
    public function GetUseSSL()
    {
        return $this->mUseSSL;
    }
    
    public function SetCampaignProfile($campaignProfile)
    {
        $this->mCampaignProfile = $campaignProfile;
    }
       
    public function GetCampaignProfile()
    {
        return $this->mCampaignProfile;
    }
    
    public function SetPurpose($purpose)
    {
        $this->mPurpose = $purpose;
    }
       
    public function GetPurpose()
    {
        return $this->mPurpose;
    }
    
    public function SetPreferredLanguage($preferredLanguage)
    {
        $this->mPreferredLanguage = $preferredLanguage;
    }
       
    public function GetPreferredLanguage()
    {
        return $this->mPreferredLanguage;
    }
    
    public function SetEnterpriseSetting($settingName, $settingValue)
    {
        $this->mEnterpriseSettings[$settingName] = $settingValue;
    }
       
    public function GetEnterpriseSettings()
    {
        return $this->mEnterpriseSettings;
    }
}
       

class lmcAIM
{
    public function __construct()
    {
    }
    
    /** !EXPORT
	 * Initializes a new transaction and returns the transaction object.
	 *
     * @param lmcTransactionParameters $transactionParameters
     * @return lmcTransactionInterface
	 */
    public function InitializeTransaction($transactionParameters)
    {
        try
        {
            // tell NuCaptcha that we're in AIM mode
            $transactionParameters->SetEnterpriseSetting(LM_ENTERPRISE_SETTING_WIDGET, LM_ENTERPRISE_SETTING_WIDGET_AIM);
       
            // initialize the transaction
            $transaction =  Leap::InitializeTransaction($transactionParameters->GetUserData(), $transactionParameters->GetUseSSL(), $transactionParameters->GetCampaignProfile(), $transactionParameters->GetPurpose(), $transactionParameters->GetPreferredLanguage(), $transactionParameters->GetEnterpriseSettings());
            
            // Check that everything is OK
            if (Leap::GetErrorCode() != LMSC_OK)
            {
                $message = Leap::GetErrorString();
                $code = Leap::GetErrorCode();
                
                return null;
            }
            
            return $transaction;
        }
        catch(LeapException $e)
        {
            Leap::HandleException($e);
            
            $message = Leap::GetErrorString();
            $code = Leap::GetErrorCode();
            
            return null;
        }
    }
    
    /** !EXPORT
	 * Sends a security request to NuCaptcha.
	 *
     * @param string $widgetData - the persistent data from a transaction object.
     * @return lmcAIMSecurityResponse
	 */
    public function SendSecurityRequest($widgetData)
    {
        try
        {
            // Assemble the SREQ
            $sreq = lmcHelper::CreateRequestChunk("SREQ", false);
            $transaction = lmcTextChunk::Decode($widgetData, "PDATA");
            
            self::CheckMissingChunk($transaction, "TOKEN");
            self::CheckMissingChunk($transaction, "SSERV");
            self::CheckMissingChunk($transaction, "DSERV");
            self::CheckMissingChunk($transaction, "SKEY");
            
            if( $transaction->ChunkExists("TOKEN") &&
               $transaction->ChunkExists("SSERV") &&
               $transaction->ChunkExists("DSERV") &&
               $transaction->ChunkExists("SKEY") )
            {
                $token = $transaction->GetChunk("TOKEN");
                $skey = $transaction->GetChunk("SKEY");
                $sserv = $transaction->GetChunk("SSERV");
                
                $clientKey = lmcHelper::GetClientKey();
                $req = lmcSymmetricMessage::EncipherMessage($skey, $sreq->Export(), $clientKey->GetChunk("CID"), $clientKey->GetChunk("KID")/*, $mClient->PerfProfile*/);
                $message = $req . "&token=" . $token;
                
                /*
                 // nothing currently using TestAction, as far as I can tell, so no point in dealing with it.
                 if (Leap::GetTestAction() == TESTACTION_EXCEPTION_SECURITY)
                 {
                 throw new LeapException(TESTACTION_EXCEPTION_SECURITY);
                 }
                 */
                
                $transactionID = "S:" . lmcSymmetricMessage::GetIV($req);
                
                // try the same server three times
                $sres = lmcHelper::DoNuCaptchaReq($sserv, $message, "SREQ", $skey, $clientKey->GetChunk("KID"), $transactionID);
                
                $waitTime = 0;
                if( $sres->ChunkExists("AK_RETRY") )
                {
                    $waitTime = $sres->GetChunk("AK_RETRY");
                }
                
                $status = $waitTime > 0 ? LM_AIM_SECURITY_RESPONSE_STATUS_WAIT : LM_AIM_SECURITY_RESPONSE_STATUS_READY;
                
                $data = new lmcTextChunk("SPSDATA");
                $data->AddChunk("FIELDS2", $sres->GetChunk("FIELDS2"));
                
                // Combine the DSERV base url from the TRES with the URL params from the SRES
                $dserv = $transaction->GetChunk("DSERV") . "?" . str_replace("__TOKEN__", $token, $sres->GetChunk("DSERV"));
                $data->AddChunk ("DSERV", $dserv);
                //$data->AddChunk("TIME", time());
                //$data->AddChunk("PUID", lmcHelper::GenerateUniqueWebUserId(mClient.ClientEnvironment));
                $sr = new lmcAIMSecurityResponse($status, $waitTime, $data->Export(), $dserv, $widgetData);
                return $sr;
            }
            else
            {
                throw new LeapException("Persistent data not valid for security request", LMSC_INVALIDPERSISTENT);
            }
        }
        catch (LeapException $e)
        {
            Leap::HandleException($e);
            
            $message = Leap::GetErrorString();
            $code = Leap::GetErrorCode();
            
            return null;
        }
    }
    
    /** !EXPORT
	 * Validate a NuCaptcha challenge answer.
	 *
     * @param string $widgetData - the persistent data from a transaction object.
     * @param string $securityData - the persistent data from a lmcSecurityResponse object.
     * @param string $challengeAnswer - the user's answer to the captcha challenge
     * @param int $challengeIndex - the index of the challenge that was shown/played to the user.
     * @param string $dataFormat - the format of the data that was shown/played to the user (GIF, MP4, MP3).
     * @return true or false for success or failure; Leap::GetErrorCode and Leap::GetErrorMessage will both return more information.
	 */
    public function ValidateTransaction($widgetData, $securityData, $challengeAnswer, $challengeIndex, $dataFormat)
    {
        try
        {
            /*if( lmcHelper::CheckForInvalidToken($widgetData) )
             {
             return true;
             }*/
            
            // get the validation fields from the securityData
            $resp = new lmcResponse($widgetData);
            
            // set the validation fields
            $vdata = lmcTextChunk::Decode($securityData, "SPSDATA");
            $resp->LoadData($vdata->GetChunk("FIELDS2"));
            
            $resp->SetVar(LM_FIELD_ANSWER, $challengeAnswer);
            $resp->SetVar(LM_FIELD_DATATYPE, $dataFormat);
            $resp->SetVar(LM_FIELD_INDEX, $challengeIndex);
            
            // send the validate
            return Leap::ValidateTransaction($widgetData, $resp);
        }
        catch(LeapException $e)
        {
            Leap::HandleException($e);
            return false;
        }
    }
    
    static private function CheckMissingChunk($transaction, $dataName)
    {
        if (!$transaction->ChunkExists($dataName))
        {
            throw new LeapException("Missing: $dataName", LMSC_INVALIDPERSISTENT);
        }
    }
}