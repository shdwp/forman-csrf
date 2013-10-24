<?php
namespace Forman\Ex;

class DuplicateTokenFieldNameException extends FormException {
    public function __construct($name, $pos) {
        parent::__construct(sprintf(
            "Field at position %d named \"%s\" invalid: name reserved by CSRFPlugin",
            $name, 
            $pos));
    }
}
