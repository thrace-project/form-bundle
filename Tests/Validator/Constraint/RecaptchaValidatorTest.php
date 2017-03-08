<?php
namespace Thrace\FormBundle\Tests\Validator\Constraint;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\MockArraySessionStorage;
use Thrace\ComponentBundle\Test\Tool\BaseTestCase;
use Thrace\FormBundle\Validator\Constraint\Recaptcha;
use Thrace\FormBundle\Validator\Constraint\RecaptchaValidator;

class RecaptchaValidatorTest extends BaseTestCase
{
    
    public function testNullIsValid()
    {
        $context = $this->createMock('Symfony\Component\Validator\ExecutionContext');
        
        $validator = new RecaptchaValidator($this->getRequestMock(), array(
            'public_key' => 'xxx',
            'private_key' => 'xxx'
        ));
        
        $validator->initialize($context);
        
        $context->expects($this->once())
            ->method('addViolationAt');

        $validator->validate(null, new Recaptcha());
    }
    
    public function testDataIsValid()
    {
        $context = $this->createMock('Symfony\Component\Validator\ExecutionContext');
        $validator = new RecaptchaValidator($this->getRequestMock(), array(
            'public_key' => 'xxx',
            'private_key' => 'xxx',
            'verify_url' => 'http://www.google.com/recaptcha/api/verify'
        ));
        
        $validator->initialize($context);
        
        $context->expects($this->once())
            ->method('addViolationAt');

         $validator->validate('data', new Recaptcha());
    }
    
    
    protected function getRequestMock($param = null)
    {
        $fakeRequest = Request::create('/', 'GET');

        $fakeRequest->setSession(new Session(new MockArraySessionStorage()));
        $requestStack = new RequestStack();
        $requestStack->push($fakeRequest);

        return $requestStack;
    }
    
    protected function getParameterBagMock($param)
    {
        $mock =
            $this
                ->createMock('Symfony\Component\HttpFoundation\ParameterBag')
             ;
        
        $mock->expects($this->any())->method('get')->will($this->returnValue($param));
        return $mock;
    }
    
    protected function getServerBagMock()
    {
        $mock =
            $this
                ->createMock('Symfony\Component\HttpFoundation\ServerBag')

            ;
        
        $mock->expects($this->any())->method('get')->will($this->returnValue('http://thrace.local/'));
        return $mock;
    }
}