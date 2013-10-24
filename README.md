## Forman-CSRF
Forman-Recaptcha - plugin for [forman](http://github.com/shadowprince/forman), adding automatic CSRF-protection for all forms.
Plugin works at background, no code needed.

### Mechanism
* Generates and stores token at every form `process`
* Compares token from form data and user cookies, if cookie not exist or not matches - field error will be added and `verify` (so `process` too) fails
* Removes `csrf_token` from `process` result, so you'll not even notice

### You can turn it off for one form
```php
\Forman\CSRFPlugin::disable();
if ($data = $form->process($_POST)) {
    // now there is no CSRF
}
\Forman\CSRFPlugin::enable();
```

### Or global
```php
// somewhere in bootstrap
\Forman\CSRFPlugin::disableGlobal(); // so any enable() will not work now
```
