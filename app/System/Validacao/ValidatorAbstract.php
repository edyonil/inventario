<?php namespace JobsCondDev\System\Validacao;

use Illuminate\Validation\Factory;

abstract class ValidatorAbstract implements ValidatorInterface {

    /**
     * Validator
     *
     * @var \Illuminate\Validation\Factory
     */
    protected $validator;

    /**
     * Validator
     *
     * @var \Illuminate\Validation\Factory
     */
    protected $connection;

    /**
     * Validation data key => value array
     *
     * @var Array
     */
    protected $data = array();

    /**
     * Validation errors
     *
     * @var Array
     */
    protected $errors = array();

    /**
     * Validation rules
     *
     * @var Array
     */
    protected $rules = array();

    /**
     * Validation messages
     *
     * @var Array
     */
    protected $message = array();

    public function __construct(Factory $validator)
    {
        $this->validator = $validator;
    }

    /**
     * Set data to validate
     *
     * @return $this
     */
    public function with(array $data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Validation passes or fails
     *
     * @return Boolean
     */
    public function passes()
    {

        $validator = $this->validator->make($this->data, $this->rules, $this->message);

        $validator->getPresenceVerifier()->setConnection($this->connection);

        if( $validator->fails() )
        {
            $this->errors = $validator->messages();
            return false;
        }

        return true;
    }

    /**
     * Return errors, if any
     *
     * @return array
     */
    public function errors()
    {
        return $this->errors;
    }

}