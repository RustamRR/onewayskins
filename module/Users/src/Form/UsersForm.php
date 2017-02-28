<?php
/**
 * Created by PhpStorm.
 * User: Рустам
 * Date: 27.02.2017
 * Time: 21:21
 */

namespace Users\Form;


use Users\Form\Fieldset\UsersFieldset;
use Zend\Form\Form;

class UsersForm extends Form
{
    public function __construct($name = 'auth', array $options = array())
    {
        parent::__construct($name, $options);
    }

    public function init()
    {
        $this->setAttribute('method', 'post');

        $this->add([
            'name' => 'auth',
            'type' => UsersFieldset::class,
            'options' => [
                'use_as_base_fieldset' => true,

            ]
        ]);
    }
}