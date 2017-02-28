<?php
/**
 * @company MTE Telecom, Ltd.
 * @author Aleksandr Lobanov <lobanov@mte-telecom.ru>
 * @year 2013
 */

namespace Application\Form\Fieldset;

use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;

class InputFilterFieldset extends Fieldset implements InputFilterProviderInterface
{

    /* @var array */
    protected $inputFilterSpecification = array();

    /**
     * Should return an array specification compatible with
     * {@link Zend\InputFilter\Factory::createInputFilter()}.
     *
     * @return array
     */
    public function getInputFilterSpecification()
    {
        return $this->inputFilterSpecification;
    }

    /**
     * @param mixed $inputFilterSpecification
     */
    public function setInputFilterSpecification(array $inputFilterSpecification)
    {
        $this->inputFilterSpecification = $inputFilterSpecification;
    }

}
