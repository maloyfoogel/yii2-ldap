<?php
namespace maloyfoogel;

use yii\base\Component; //include YII component class
use adLDAP\adLDAP; //include the adLDAP class

class Ldap extends Component {
    /**
     * The internal adLDAP object.
     *
     * @var object adLDAP
     */
    private $adLdapClass=null;
	
    /**
     * Options variable for the adLDAP module.
     * See adLDAP __construct function for possible values.
     *
     * @var array Array with option values
     */	
    public $options=null;

    /**
     * init() called by yii.
     */	
    public function init() {
        try {
            $this->adLdapClass = new adLDAP($this->options);
        } catch (adLDAPException $e) {
            throw new CException($e);   
        }		
    }

    /**
     * Use magic PHP function __call to route function calls to the adLDAP class.
     * Look into the adLDAP class for possible functions.
     *
     * @param string $methodName Method name from adLDAP class
     * @param array $methodParams Parameters pass to method
     * @return mixed
     */	
    public function __call($methodName, $methodParams) {
            if ( method_exists( $this->adLdapClass, $methodName ) ) {
                return call_user_func_array(array($this->adLdapClass, $methodName), $methodParams);
            }       
    }
}
