<?php
namespace Forman;

class CSRFPlugin extends \Forman\Plugin {
    protected static $enabled = true;
    protected static $enabled_global = true;

    protected $element;

    public function __construct() {
        $this->element = new \Forman\Field\CSRFToken("csrf_token", function ($value) {
            if (self::$enabled && $value !== $_COOKIE["csrf_token"])
                return _("Please re-submit form");
        });
    }

    public function processFields($form, $fields) {
        if (self::$enabled) {
            for ($i = 0; $i < count($fields); $i++) {
                if ($fields[$i]->getNormalizedName() == "csrf_token")
                    throw new \Forman\Ex\DuplicateTokenFieldNameException($fields[$i]->getName(), $i);
            }
            
            return array_merge($fields, array(
                $this->element
            ));
        } else {
            return $fields;
        }
    }

    public function processData($form, $data) {
        unset($data["csrf_token"]);

        return $data;
    }

    public function validate($form, $result) {
        $this->element->setupToken();

        return $result;
    }

    /**
     * Disable global, so method enable() will not work anymore.
     */
    public static function disableGlobal() {
        self::$enabled_global = false;
    }

    /**
     * Disable.
     */
    public static function disable() {
        self::$enabled = false;
    }

    /**
     * Enable.
     */
    public static function enable() {
        self::$enabled = self::$enabled_global;
    }

    /**
     * Generate random token
     * @return string
     */
    public static function generateToken() {
        return md5(
            implode("", array_map(function () {
                return chr(rand(48, 122));
            }, array_fill(0, rand(16, 32), null)))
        );
    }
}
