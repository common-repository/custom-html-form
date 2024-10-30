<?php

require_once dirname(__FILE__) . '/Element.php';

/**
 * Custom HTML Form -> Form
 */
class Chf_Model_Form
{

	protected   $_elements	= array();

	protected   $_errors	= array();

	protected   $_valid		= null;

	public function __construct() {}

	/**
	 * Setter elements
	 * @param Chf_Model_Element $element
	 * @return Chf_Model_Form
	 */
	public function addElement(Chf_Model_Element $element)
	{
		$this->_elements[$element->getName()] = $element;
		return $this;
	}

	/**
	 * Getter element
	 * @param string $name
	 * @return null|Chf_Model_Element
	 */
	public function getElement($name)
	{
		if (key_exists($name, $this->_elements))
			return $this->_elements[$name];
		return null;
	}

	/**
	 * Validate elements
	 * @param array $post
	 * @return bool
	 */
	public function validate(array $post)
	{
		// Check each post
		foreach ($this->_elements as $name=>$element)
		{
			$element->setValue(!empty($post[$name])?$post[$name]:null);
			if (!$element->isValid()) {
				$this->addErrors($name, $element->getErrors());
			}
		}
		return $this->_valid = (bool) empty($this->_errors);
	}

	/**
	 * Add error messages
	 * @throws InvalidArgumentException
	 * @param string $key
	 * @param array $messages
	 * @return Chf_Model_Form
	 */
	public function addErrors($key, array $messages)
	{
		if (is_string($key) && !key_exists($key, $this->_errors))
			$this->_errors[$key] = $messages;
		else
			throw new InvalidArgumentException('errors should be of type string');
		return $this;
	}

	/**
	 * Getter errors
	 * @return array
	 */
	public function getErrors()
	{
		return $this->_errors;
	}

	/**
	 * Getter valid
	 * @return bool|null
	 */
	public function getValid()
	{
		return $this->_valid;
	}

	/**
	 * Setter valid
	 * @param bool $valid
	 * @return Chf_Model_Form
	 */
	public function setValid($valid)
	{
		$this->_valid = (bool)$valid;
		return $this;
	}

	/**
	 * Clear values in case you dont want the values to return in the successfull posted form
	 * @return bool
	 */
	public function clearValues()
	{
		foreach ($this->_elements as $element)
			$element->setValue('');
		return true;
	}

}