<?php

namespace GoMage\Feed\Model\Writer;

use GoMage\Feed\Model\Config\Source\FeedType;

class Factory
{
    protected $_writers = [
        FeedType::CSV_TYPE => 'GoMage\Feed\Model\Writer\Csv',
        FeedType::XML_TYPE => 'GoMage\Feed\Model\Writer\Xml'
    ];

    /**
     * @var \Magento\Framework\ObjectManagerInterface
     */
    protected $_objectManager;

    public function __construct(\Magento\Framework\ObjectManagerInterface $objectManager)
    {
        $this->_objectManager = $objectManager;
    }

    /**
     * @param string $type
     * @param array $arguments
     * @return \GoMage\Feed\Model\Writer\WriterInterface
     * @throws \Exception
     */
    public function create($type, array $arguments = [])
    {
        if (!isset($this->_writers[$type])) {
            throw new \Exception(__('Undefined writer.'));
        }
        return $this->_objectManager->create($this->_writers[$type], $arguments);
    }

}
