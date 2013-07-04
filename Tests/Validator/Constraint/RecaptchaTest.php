<?php
namespace Thrace\FormBundle\Tests\Validator\Constraint;

use Thrace\FormBundle\Validator\Constraint\Recaptcha;

use Thrace\ComponentBundle\Test\Tool\BaseTestCase;

class RecaptchaTest extends BaseTestCase
{
    
    public function testDefault()
    {
        $constraint = new Recaptcha(array('emptyMessage' => 'empty', 'invalidMessage' => 'invalid'));
        
        $this->assertSame('empty', $constraint->emptyMessage);
        $this->assertSame('invalid', $constraint->invalidMessage);
        $this->assertSame('thrace_form_recaptcha_validator', $constraint->validatedBy());        
    }

}