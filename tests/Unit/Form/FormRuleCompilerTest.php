<?php
namespace Tests\Boekkooi\Bundle\JqueryValidationBundle\Unit\Form;

use Boekkooi\Bundle\JqueryValidationBundle\Form\FormRuleCompiler;

/**
 * @author Warnar Boekkooi <warnar@boekkooi.net>
 */
class FormRuleCompilerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @dataProvider provide_invalid_construct_arguments
     */
    public function construct_should_only_accept_a_array_of_compilers($invalid)
    {
        try {
            new FormRuleCompiler($invalid);
        } catch (\PHPUnit_Framework_Error $e) {
            return;
        } catch (\InvalidArgumentException $e) {
            return;
        }

        $this->fail('Expected a PHP exception or InvalidArgumentException');
    }

    public function provide_invalid_construct_arguments()
    {
        return array(
            array(new \stdClass()),
            array(array(new \stdClass())),
            array(array(false)),
            array(array(null)),
            array(array('string')),
        );
    }

    /**
     * @test
     */
    public function compile_should_forward_to_all_compilers()
    {
        $formRuleContext = $this->getMockBuilder('Boekkooi\Bundle\JqueryValidationBundle\Form\FormRuleContextBuilder')
            ->disableOriginalConstructor()->getMock();

        $compiler1 = $this->getMock('Boekkooi\Bundle\JqueryValidationBundle\Form\FormRuleCompilerInterface');
        $compiler1->expects($this->once())->method('compile')->with($formRuleContext);
        $compiler2 = $this->getMock('Boekkooi\Bundle\JqueryValidationBundle\Form\FormRuleCompilerInterface');
        $compiler2->expects($this->once())->method('compile')->with($formRuleContext);

        $SUT = new FormRuleCompiler(array(
            $compiler1,
            $compiler2,
        ));

        $SUT->compile($formRuleContext);
    }
}
