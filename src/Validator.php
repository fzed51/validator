<?php
/**
 * Created by PhpStorm.
 * User: fabien.sanchez
 * Date: 09/10/2017
 * Time: 14:31
 */

namespace Fzed51\Validator;

class Validator
{
    /**
     * @var array
     */
    private $params;

    /** @var ValidatorError[] */
    private $errors = [];

    /**
     * Validator constructor.
     * @param array|object $params
     */
    public function __construct($params)
    {
        $this->params = (array) $params;
    }

    /**
     * @return ValidatorError[]
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @return bool
     */
    public function isValid(): bool
    {
        return (count($this->errors) == 0);
    }

    /**
     * @param string[] ...$keys
     * @return Validator
     */
    public function required(string ...$keys): self
    {
        foreach ($keys as $key) {
            $value = $this->getValue($key);
            if (is_null($value)) {
                $this->addError($key, 'required');
            }
        }
        return $this;
    }

    /**
     * @param string $key
     * @return mixed|null
     */
    private function getValue(string $key)
    {
        if (array_key_exists($key, $this->params)) {
            return $this->params[$key];
        }

        return null;
    }

    private function addError($key, $rule)
    {
        $this->errors[$key] = new ValidatorError($key, $rule);
    }

    /**
     * @param string[] ...$keys
     * @return Validator
     */
    public function notEmpty(string ...$keys): self
    {
        foreach ($keys as $key) {
            $value = $this->getValue($key);
            if (is_null($value) || empty($value)) {
                $this->addError($key, 'empty');
            }
        }
        return $this;
    }

    /**
     * Vérifie que le champ est un slug
     * @param string[] ...$key
     * @return Validator
     */
    public function slug(string ...$keys): self
    {
        $regex = '/^[a-zA-Z0-9]+(\-[a-zA-Z0-9]+)*$/';
        foreach ($keys as $key) {
            $value = $this->getValue($key);
            if (is_null($value)) {
                continue;
            }
            if (preg_match($regex, $value) == 0) {
                $this->addError($key, 'slug');
            }
        }
        return $this;
    }

    public function betweenLength($min, $max, string ...$keys)
    {
        foreach ($keys as $key) {
            $this->minLength(min($min, $max), $key);
            $this->maxLength(max($min, $max), $key);
        }
        return $this;
    }

    public function minLength($min, string ...$keys)
    {
        foreach ($keys as $key) {
            $value = $this->getValue($key);
            if (is_null($value)) {
                continue;
            }
            if (mb_strlen($value) < $min) {
                $this->addError($key, 'minLength');
            }
        }
        return $this;
    }

    public function maxLength($max, string ...$keys)
    {
        foreach ($keys as $key) {
            $value = $this->getValue($key);
            if (is_null($value)) {
                continue;
            }
            if (mb_strlen($value) > $max) {
                $this->addError($key, 'maxLength');
            }
        }
        return $this;
    }

    public function dateTime(string ...$keys)
    {
        foreach ($keys as $key) {
            $value = $this->getValue($key);
            if (is_null($value)) {
                continue;
            }
            \DateTime::createFromFormat('Ymd His', $value);
            $err = \DateTime::getLastErrors();
            if ($err['error_count'] > 0 || $err['warning_count'] > 0) {
                $this->addError('$key', 'datetime');
            }
        }
        return $this;
    }

    public function date(string ...$keys)
    {
        foreach ($keys as $key) {
            $value = $this->getValue($key);
            if (is_null($value)) {
                continue;
            }
            \DateTime::createFromFormat('Ymd', $value);
            $err = \DateTime::getLastErrors();
            if ($err['error_count'] > 0 || $err['warning_count'] > 0) {
                $this->addError('$key', 'datetime');
            }
        }
        return $this;
    }

    private function toArray($params): array
    {
        $refObj = new \ReflectionObject($params);
        $array = [];
        foreach ($refObj->getProperties(ReflectionProperty::IS_PUBLIC) as $property) {
            $array[$property] = $params->{$property};
        }
        return $array;
    }
}
