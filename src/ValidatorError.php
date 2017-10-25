<?php
/**
 * Created by PhpStorm.
 * User: fabien.sanchez
 * Date: 09/10/2017
 * Time: 14:51
 */

namespace Fzed51\Validator;

class ValidatorError
{
    /** @var  string */
    private $key;
    /** @var  string */
    private $rule;
    /** @var $messages */
    protected $messages = [
        'required' => 'Le champs %s est requis.',
        'empty' => 'Le champs %s est vide.',
        'slug' => 'Le champs %s n\'est pas un slug valide.',
        'minLength' => 'Le champs %s est trop court.',
        'maxLength' => 'Le champs %s est trop court.'
    ];

    /**
     * ValidatorError constructor.
     * @param $key
     * @param $rule
     */
    public function __construct(string $key, string $rule)
    {
        $this->key = $key;
        $this->rule = $rule;
    }

    public function __toString()
    {
        return sprintf($this->messages[$this->rule], $this->key);
    }
}
