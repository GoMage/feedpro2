<?php

namespace GoMage\Feed\Model\Attribute;


class Field extends \GoMage\Feed\Model\Feed\Field
{

    /**
     * @var string
     */
    protected $_prefix;

    public function __construct($type, $value, $prefix, \GoMage\Feed\Model\Mapper\Factory $mapperFactory)
    {
        $this->_prefix = $prefix;
        parent::__construct($type, $value, $mapperFactory);
    }

    /**
     * @param  \Magento\Framework\DataObject $object
     * @return mixed
     */
    public function map(\Magento\Framework\DataObject $object)
    {
        $value = parent::map($object);
        return $value ? $this->_prefix . $value : '';
    }

}