<?php
namespace Thrace\FormBundle\Tests\Validator\Constraint;

use Thrace\FormBundle\Validator\Constraint\Recaptcha;

use Symfony\Component\DependencyInjection\Definition;

use Symfony\Component\DependencyInjection\ContainerBuilder;

use Thrace\FormBundle\Validator\Constraint\RecaptchaValidator;

use Thrace\ComponentBundle\Test\Tool\BaseTestCase;

class RecaptchaValidatorTest extends BaseTestCase
{
    
    public function testNullIsValid()
    {
        $context = $this->getMock('Symfony\Component\Validator\ExecutionContext', array(), array(), '', false);
        
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
        $context = $this->getMock('Symfony\Component\Validator\ExecutionContext', array(), array(), '', false);
        $validator = new RecaptchaValidator($this->getRequestMock('param'), array(
            'public_key' => 'xxx',
            'private_key' => 'xxx',
            'verify_url' => 'http://www.google.com/recaptcha/api/verify'
        ));
        
        $validator->initialize($context);
        
        $context->expects($this->once())
            ->method('addViolationAt');

        $result = $validator->validate('data', new Recaptcha());
    }
    
    
    protected function getRequestMock($param = null)
    {
        $mock = 
            $this
                ->getMockBuilder('Symfony\Component\HttpFoundation\Request')
                ->disableOriginalConstructor()
                ->getMock()
            ;
        
        $mock->request = $this->getParameterBagMock($param);
        $mock->server = $this->getServerBagMock();
        
        return $mock;
    }
    
    protected function getParameterBagMock($param)
    {
        $mock =
            $this
                ->getMockBuilder('Symfony\Component\HttpFoundation\ParameterBag')
                ->disableOriginalConstructor()
                ->getMock()
            ;
        
        $mock->expects($this->any())->method('get')->will($this->returnValue($param));
        return $mock;
    }
    
    protected function getServerBagMock()
    {
        $mock =
            $this
                ->getMockBuilder('Symfony\Component\HttpFoundation\ServerBag')
                ->disableOriginalConstructor()
                ->getMock()
            ;
        
        $mock->expects($this->any())->method('get')->will($this->returnValue('http://thrace.local/'));
        return $mock;
    }
}