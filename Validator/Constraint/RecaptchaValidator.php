<?php
/*
 * This file is part of ThraceFormBundle
 *
 * (c) Nikolay Georgiev <symfonist@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Thrace\FormBundle\Validator\Constraint;

use Symfony\Component\HttpFoundation\RequestStack;

use Symfony\Component\Validator\Constraint;

use Symfony\Component\Validator\ConstraintValidator;

/**
 * Recaptcha validator
 *
 * @author Nikolay Georgiev <symfonist@gmail.com>
 * @since 1.0
 */
class RecaptchaValidator extends ConstraintValidator
{
    /**
     * @var RequestStack
     */
    protected $request;

    /**
     * @var array
     */
    protected $options;

    /**
     * Construct
     *
     * @param Request $request
     * @param array $options
     */
    public function __construct(RequestStack $request, array $options)
    {
        $this->request = $request->getCurrentRequest();
        $this->options = $options;
    }

    /**
     * (non-PHPdoc)
     * @see \Symfony\Component\Validator\ConstraintValidator::validate()
     */
    public function validate($data, Constraint $constraint)
    {
        $propertyPath = $this->context->getPropertyPath();
        $challengeField = $this->request->request->get('recaptcha_challenge_field');
        $responseField = $this->request->request->get('recaptcha_response_field');

        if (empty($challengeField) || empty($responseField)) {
            $this->context->addViolationAt($propertyPath, $constraint->emptyMessage);
        } elseif (false === $this->check($challengeField, $responseField)){ 
            $this->context->addViolationAt($propertyPath, $constraint->invalidMessage);
        }
    }

    /**
     * Makes a request to recaptcha service and checks if recaptcha field is valid.
     * 
     * @param string $challengeField
     * @param string $responseField
     * @return boolean
     */
    protected function check($challengeField, $responseField) {
        
        $server = $this->request->server;
        
        $data = array(
            'privatekey' => $this->options['private_key'],
            'remoteip'   =>  $server->get('REMOTE_ADDR') ,
            'challenge'  => $challengeField,
            'response'   => $responseField     
        );
        
        $curl = curl_init($this->options['verify_url']);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
        curl_setopt($curl, CURLOPT_USERAGENT, 'reCAPTCHA/PHP');
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_HEADER, true);
        $response = curl_exec($curl);

        $response = explode("\r\n\r\n", $response, 2);

        return (isset($response[1]) && preg_match('/true/', $response[1]));       
    }

}