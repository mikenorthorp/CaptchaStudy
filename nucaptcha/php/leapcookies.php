<?php
/**
 * @package   NuCaptcha PHP clientlib
 * @author    <support@nucaptcha.com> Leap Marketing Technologies Inc
 * @license   LGPL License 2.1 (see included license.txt)
 * @link      http://www.nucaptcha.com/api/php
 */

/**
 * Class for managing cookies errors.
 */

class lmcSecurityCookieData
{
	const CLIENTCOOKIE_VERSION = 1;
	
	private $mPrefix;
	private $mName;
	private $mValue;
	private $mExpiry;
		
	public function __construct($prefix)
	{
		$this->mPrefix = $prefix;
		$this->mName = '';
		$this->	mValue = '';
		$this->mExpiry = -1;
	}
		
	public function getPrefix()
	{
		return $this->mPrefix;
	}
	
	public function getName()
	{
		return $this->mName;
	}
	
	public function setName($v)
	{
		$this->mName = $v;
	}
	
	public function getValue()
	{
		return $this->mValue;
	}
	
	public function setValue($v)
	{
		$this->mValue = $v;
	}
	
	public function getExpiry()
	{
		return $this->mExpiry;
	}
	
	public function setExpiry($v)
	{
		$this->mExpiry = $v;
	}
}



class lmcSecurityCookies
{	
	const COOKIENAME_SESSION = 'NCCSCK';
	const COOKIENAME_PERSISTENT = 'NCCPCK';
	
	/**
	 * @var lmcSecurityCookieData
	 */
	private $mSessionCookie;
	
	/**
	 * @var lmcSecurityCookieData
	 */
	private $mPersistentCookie;
	
	/**
	 * @var array
	 */
	private $mCookies;
	
	/**
	 * @var boolean
	 */
	private $mIsInitialized;
	
	public function __construct()
	{
		$this->mSessionCookie = new lmcSecurityCookieData(self::COOKIENAME_SESSION);
		$this->mPersistentCookie = new lmcSecurityCookieData(self::COOKIENAME_PERSISTENT);
		$this->mCookies = array( 
			self::COOKIENAME_SESSION => $this->mSessionCookie, 
			self::COOKIENAME_PERSISTENT => $this->mPersistentCookie, 
		);
		$this->mIsInitialized = false;
	}
	
	public function getCookieObjects()
	{
		$res = array();
		
		$res[] = array(
				'name' => $this->mSessionCookie->getName(),
				'value' => $this->mSessionCookie->getValue(),
				'domain' => null,
				'expiry' => $this->mSessionCookie->getExpiry()
			);
		
		$res[] = array(
				'name' => $this->mPersistentCookie->getName(),
				'value' => $this->mPersistentCookie->getValue(),
				'domain' => null,
				'expiry' => $this->mPersistentCookie->getExpiry()
			);
		
		return $res;
	}
	
	private function getCookieName($prefix)
	{
		if( Leap::GetForceTokenServer() != null && strlen(Leap::GetForceTokenServer()) > 0 )
		{
			$prefix .= 'DEV';
		}
		else
		{
			switch(Leap::GetClusterRecord())
			{
				case 'clusters.nucaptcha.com':
					//nothing
					break;
				case 'lpstg.leapmarketing.com':
					$prefix .= 'LPSTG';
					break;
				default:
					$prefix .= 'DEV';
					break;
			}
		}
		return $prefix;
	}
	
	public function init()
	{
		// update cookie names
		foreach( $this->mCookies as $k => $v )
		{
			$this->initCookie($k,$v);
		}
	}
	
	private function initCookie($prefix, lmcSecurityCookieData $c)
	{
		$c->setName( $this->getCookieName($prefix) );
		$data = self::getCookieData($c->getName());
		if( $data !== null )
		{
			$c->setValue($data);
		}
	}
	
	private function checkInit()
	{
		if( !$this->mIsInitialized )
		{
			$this->init();
			$this->mIsInitialized = true;
		}
	}
	
	public function exportDynamicData()
	{
		$this->checkInit();
		
		$res = array();
		foreach( $this->mCookies as $k => $v )
		{
			$res[$k] = array(
				'prefix' => $v->getPrefix(),
				'name' => $v->getName(),
				'value' => $v->getValue(),
				'expiry' => intval($v->getExpiry()),
				'version' => lmcSecurityCookieData::CLIENTCOOKIE_VERSION
			);
		}
		return $res;
	}
	
	public function importDynamicData($data)
	{
		$this->checkInit();
		
		foreach( $data as $k => $v )
		{
			if( array_key_exists($k, $this->mCookies) )
			{
				$this->mCookies[$k]->setValue($v['value']);
				$this->mCookies[$k]->setExpiry(intval($v['expiry']));
			}
		}
	}
		
	private static function getCookieData($name)
	{
		if( array_key_exists($name, $_COOKIE) )
		{
			return $_COOKIE[$name];
		}
		return null;
	}
	
	private function handleError(Exception $e, $msg)
	{
		// how to handle this?
		//die($msg . ' :' . $e->getMessage());
	}
}


