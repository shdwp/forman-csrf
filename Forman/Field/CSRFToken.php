<?php
/**
 * Forman Recaptcha plugin
 *
 * @author Vasiliy Horbachenko <shadow.prince@ya.ru>
 * @copyright 2013 Vasiliy Horbachenko
 * @version 0.1
 * @package shadowprince/forman-recaptcha
 *
 */
namespace Forman\Field;

class CSRFToken extends Hidden {
    protected $token;

    public function __construct() {
        call_user_func_array("parent::__construct", func_get_args());

        $this->token = \Forman\CSRFPlugin::generateToken();
        $this->setupToken();

        setcookie("csrf_token", $this->token, time() + 60*60);

        $this->name = "csrf_token";
    }

    /**
     * Setup token into value (and reset current value)
     */
    public function setupToken() {
        $this->value = $this->token;
    }
}
