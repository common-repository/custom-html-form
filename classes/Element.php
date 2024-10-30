<?php

class Chf_Model_Element
{
	
	private	$_name,
			$_value			= null,
			$_required		= true,
			$_validators	= array(),
			$_errors		= array();

	public function __construct($name, array $options=array())
	{
		$this->setName($name);
		if (isset($options['validators']))
			$this->setValidators($options['validators']);
		if (isset($options['value']))
			$this->setValue($options['value']);
		if (isset($options['required']))
			$this->setRequired((bool) $options['required']);
	}
	
	/**
	 * Check if set value is valid
	 */
	public function isValid()
	{
		// Empty value
		if (null===$this->_value)
			if (false===$this->_required)
				return true;
			else {
				$this->_errors[] = 'Empty value';
				return false;
			}
		
		$valid = true;
		if (!empty($this->_validators))
			foreach ($this->_validators as $validator) {
				if (!$validator->isValid($this->getValue())) {
					$this->_errors = array_merge($this->_errors, $validator->getMessages());
					$valid = false;
				}
			}
		
		return $valid;
	}
	
	/**
	 * Setter name
	 * @param string $name
	 * @throws InvalidArgumentException
	 * @return Chf_Model_Element
	 */
	public function setName($name)
	{
		if (is_string($name))
			$this->_name = $name;
		else
			throw new InvalidArgumentException('name should be of type string');
		return $this;
	}
	
	/**
	 * Getter name
	 * @return string
	 */
	public function getName() 
	{
		return $this->_name;
	}
	
	/**
	 * Setter value
	 * @param string $value
	 * @throws InvalidArgumentException
	 * @return Chf_Model_Element
	 */
	public function setValue($value=null)
	{
		//if (is_string($value))
			$this->_value = $value;
		return $this;
	}
	
	/**
	 * Getter value
	 * @return string
	 */
	public function getValue() 
	{
		return $this->_value;
	}
	
	/**
	 * Setter required
	 * @param bool $required
	 * @return Chf_Model_Element
	 */
	public function setRequired($required)
	{
		$this->_required = (bool) $required;
		return $this;
	}
	
	/**
	 * Getter required
	 * @return bool
	 */
	public function getRequired() 
	{
		return $this->_required;
	}
	
	/**
	 * Setter validators
	 * @param array|object validators
	 * @throws InvalidArgumentException
	 * @return Chf_Model_Element
	 */
	public function setValidators($validators)
	{
		if (is_object($validators))
			$this->_validators[] = $validators;
		elseif (is_array($validators))
			$this->_validators = $validators;
		else 
			throw new InvalidArgumentException('validators should be type of array or object');
		return $this;
	}
	
	/**
	 * Getter validators
	 * @return array
	 */
	public function getValidators() 
	{
		return $this->_validators;
	}
	
	/**
	 * Getter errors
	 * @return array
	 */
	public function getErrors() 
	{
		return $this->_errors;
	}

}