<?php
/**
 * Created by PhpStorm.
 * User: fabien.sanchez
 * Date: 09/10/2017
 * Time: 14:28
 */

namespace Test;

use Fzed51\Validator\Validator;
use PHPUnit\Framework\TestCase;

class ValidatorTest extends TestCase
{

    public function testObjectParams()
    {
        $params = new \stdClass();
        $params->name = 'joe';
        $validator = new Validator($params);
        $errors = $validator->required('name')
        ->getErrors();
        $this->assertCount(0, $errors);
        $this->assertTrue($validator->isValid());
    }

    public function testArrayParams()
    {
        $params = ["name" => "joe"];
        $validator = new Validator($params);
        $errors = $validator->required('name')
        ->getErrors();
        $this->assertCount(0, $errors);
        $this->assertTrue($validator->isValid());
    }

    /**
     * Test de la methode required
     */
    public function testRequiredBad()
    {
        $validator = new Validator([
            'name'=>'joe'
        ]);
        $errors = $validator->required('name', 'age')
            ->getErrors();
        $this->assertCount(1, $errors);
        $this->assertEquals('Le champs age est requis.', (string) $errors['age']);
        $this->assertFalse($validator->isValid());
    }

    /**
     * Test de la methode required
     */
    public function testRequired()
    {
        $validator = new Validator([
            'name'=>'joe',
            'age' => 28
        ]);
        $errors = $validator->required('name', 'age')
            ->getErrors();
        $this->assertCount(0, $errors);
        $this->assertTrue($validator->isValid());
    }

    public function testNotEmptyBad()
    {
        $validator = new Validator([
            'name'=>''
        ]);
        $errors = $validator->notEmpty('name')
            ->getErrors();
        $this->assertCount(1, $errors);
        $this->assertEquals('Le champs name est vide.', (string) $errors['name']);
        $this->assertFalse($validator->isValid());
    }

    /**
     * Test de la methode required
     */
    public function testNotEmpty()
    {
        $validator = new Validator([
            'name'=>'joe',
            'age' => 28
        ]);
        $errors = $validator->notEmpty('name')
            ->getErrors();
        $this->assertCount(0, $errors);
        $this->assertTrue($validator->isValid());
    }

    public function testSulgBad()
    {
        $validator = new Validator([
            'name'=>'joe',
            'age' => 28,
            'slug' => 'azertyui--25'
        ]);
        $errors = $validator->slug('slug')->getErrors();
        $this->assertCount(1, $errors);
        $this->assertFalse($validator->isValid());
    }

    public function testSulg()
    {
        $validator = new Validator([
            'name'=>'joe',
            'age' => 28,
            'slug' => 'azertyui-25'
        ]);
        $errors = $validator->slug('slug')->getErrors();
        $this->assertCount(0, $errors);
        $this->assertTrue($validator->isValid());
    }

    public function testMinLength()
    {
        $validator = new Validator([
            'name'=>'joe',
            'age' => 28,
            'slug' => 'azertyui-25'
        ]);
        $errors = $validator->MinLength(3, 'slug')->getErrors();
        $this->assertCount(0, $errors);
        $this->assertTrue($validator->isValid());
    }
    public function testMinLengthBad()
    {
        $validator = new Validator([
            'name'=>'joe',
            'age' => 28,
            'slug' => 'azertyui-25'
        ]);
        $errors = $validator->MinLength(5, 'name')->getErrors();
        $this->assertCount(1, $errors);
        $this->assertFalse($validator->isValid());
    }

    public function testMaxLength()
    {
        $validator = new Validator([
            'name'=>'joe',
            'age' => 28,
            'slug' => 'azertyui-25'
        ]);
        $errors = $validator->MaxLength(6, 'name')->getErrors();
        $this->assertCount(0, $errors);
        $this->assertTrue($validator->isValid());
    }
    public function testMaxLengthBad()
    {
        $validator = new Validator([
            'name'=>'joe',
            'age' => 28,
            'slug' => 'azertyui-25'
        ]);
        $errors = $validator->MaxLength(5, 'slug')->getErrors();
        $this->assertCount(1, $errors);
        $this->assertFalse($validator->isValid());
    }
}
