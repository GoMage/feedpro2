<?php

namespace GoMage\Feed\Block\Adminhtml\Form\Element;

class Website extends \Magento\Config\Block\System\Config\Form\Field
{
    /**
     * @var \Magento\Framework\View\Helper\Js
     */
    protected $_jsHelper;

    /**
     * @var \GoMage\Feed\Helper\Data
     */
    protected $_helper;


    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\View\Helper\Js $jsHelper,
        \GoMage\Feed\Helper\Data $helper,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->_jsHelper = $jsHelper;
        $this->_helper   = $helper;
    }

    protected function _getElementHtml(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        $html = '';

        $name = $element->getName();
        $id   = $element->getId();

        $info = $this->_helper->ga();

        if (isset($info['d']) && isset($info['c']) && intval($info['c'])) {

            $websites = $this->_helper->getAvailableWebsites();

            /** @var \Magento\Store\Model\Website $website */
            foreach ($this->_storeManager->getWebsites() as $website) {
                $element->setName($name . '[]');
                $element->setId($id . '_' . $website->getId());
                $element->setChecked(in_array($website->getId(), $websites));
                $element->setValue($website->getId());

                $html .= '<div class="field choice admin__field admin__field-option">' . $element->getElementHtml() .
                    ' <label for="' .
                    $id . '_' . $website->getId() .
                    '" class="admin__field-label"><span>' .
                    $website->getName() .
                    '</span></label></div>' .
                    "\n";
            }

            $jsString = '
            $$("input[name=\'' . $element->getName() . '\']").each(function(element) {
               element.observe("click", function () {
                    if($$("input[name=\'' . $element->getName() . '\']:checked").length >= ' . intval($info['c']) . '){
                        $$("input[name=\'' . $element->getName() . '\']").each(function(e){
                            if(!e.checked){
                                e.disabled = "disabled";
                            }
                        });
    			    }else {
                        $$("input[name=\'' . $element->getName() . '\']").each(function(e){
                            if(!e.checked){
                                e.disabled = "";
                            }
                        });
    			    }
               });
            });';


            return $html . $this->_jsHelper->getScript(
                'require([\'prototype\'], function(){document.observe("dom:loaded", function() {' . $jsString . '});});'
            );
        }

        return sprintf('<strong class="required">%s</strong>', __('Please enter a valid key'));
    }

}
