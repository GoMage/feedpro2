<?php

namespace GoMage\Feed\Model\Feed\Row;

use Magento\Framework\Validator\Exception as ValidatorException;

/**
 * Class Data
 *
 * @method string getName()
 * @method string getPrefixType()
 * @method string getPrefixValue()
 * @method string getType()
 * @method string getValue()
 * @method string getSuffixType()
 * @method string getSuffixValue()
 * @method string getLimit()
 * @method array getOutput()
 */
class Data extends \Magento\Framework\DataObject
{

    public function __construct(array $data = [])
    {
        $data = $this->validate($data);
        parent::__construct($data);
    }

    /**
     * @param  array $data
     * @return array
     * @throws ValidatorException
     */
    protected function validate(array $data)
    {
        if (!isset($data['name']) || !$data['name']) {
            throw new ValidatorException(__('Name is required field.'));
        }
        if (!isset($data['output'])) {
            $data['output'] = [];
        }
        if (is_string($data['output'])) {
            $data['output'] = explode(',', $data['output']);
        }
        return $data;
    }

    /**
     * @return array
     */
    public function getFields()
    {
        $data = [];
        if ($this->getPrefixValue()) {
            $data[] = ['type' => $this->getPrefixType(), 'value' => $this->getPrefixValue()];
        }
        $data[] = ['type' => $this->getType(), 'value' => $this->getValue()];
        if ($this->getSuffixValue()) {
            $data[] = ['type' => $this->getSuffixType(), 'value' => $this->getSuffixValue()];
        }

        return $data;
    }

}
