<?php

namespace AppBundle\Form;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CaptchaValidator {

    private $recaptcha;
    private $session;

    public function __construct(SessionInterface $session, $secret)
    {
        $this->recaptcha = new \ReCaptcha\ReCaptcha($secret);
        $this->session = $session;
    }

    public function validate($gRecaptchaResponse)
    {
        $previousErrorReporting = error_reporting();
        error_reporting(E_ERROR);
        $response = $this->recaptcha->verify($gRecaptchaResponse);
        error_reporting($previousErrorReporting);
        $messages = array(
            'missing-input-secret' => 'The secret parameter is missing',
            'invalid-input-secret' => 'The secret parameter is invalid or malformed',
            'missing-input-response' =>	'Merci de valider le captcha',
            'invalid-input-response' => 'Merci de remplir correctement le captcha'
        );
        if ($response->isSuccess()) {
            return true;
        } else {
            $errors = $response->getErrorCodes();
            $toDisplayErrors = array_map(function ($element) use ($messages) {
                return $messages[$element];
            }, $errors);
            foreach ($toDisplayErrors as $error) {
                if ($error) {
                    $this->session->getFlashBag()->add('error', $error);
                }
            }
            return false;
        }
    }
}
