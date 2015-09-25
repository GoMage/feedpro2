<?php

namespace GoMage\Feed\Block\Adminhtml\Feed\Edit\Tab;

use GoMage\Feed\Model\Feed;
use Magento\Config\Model\Config\Source\Yesno;
use Magento\Config\Model\Config\Source\Enabledisable;
use GoMage\Feed\Model\Config\Source\Ftp\Protocol;

class Ftp extends \Magento\Backend\Block\Widget\Form\Generic implements \Magento\Backend\Block\Widget\Tab\TabInterface
{

    /**
     * @var Yesno
     */
    protected $_yesNo;

    /**
     * @var Enabledisable
     */
    protected $_enableDisable;

    /**
     * @var Protocol
     */
    protected $_protocol;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param Yesno $yesNo
     * @param Enabledisable $enableDisable
     * @param Protocol $protocol
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        Yesno $yesNo,
        Enabledisable $enableDisable,
        Protocol $protocol,
        array $data = []
    ) {

        $this->_yesNo         = $yesNo;
        $this->_enableDisable = $enableDisable;
        $this->_protocol      = $protocol;

        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * Prepare form
     *
     * @return $this
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    protected function _prepareForm()
    {
        /* @var $model Feed */
        $model = $this->_coreRegistry->registry('current_feed');


        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();

        $form->setHtmlIdPrefix('feed_');

        $fieldset = $form->addFieldset(
            'ftp_fieldset',
            ['legend' => __('FTP Settings')]
        );


        $fieldset->addField(
            'is_ftp',
            'select',
            [
                'name'   => 'is_ftp',
                'label'  => __('Enabled'),
                'title'  => __('Enabled'),
                'values' => $this->_yesNo->toOptionArray(),
            ]
        );

        $fieldset->addField(
            'ftp_protocol',
            'select',
            [
                'name'   => 'ftp_protocol',
                'label'  => __('Enabled'),
                'title'  => __('Enabled'),
                'values' => $this->_protocol->toOptionArray(),
            ]
        );

        $fieldset->addField(
            'ftp_host',
            'text',
            [
                'name'  => 'ftp_host',
                'label' => __('Host Name'),
                'title' => __('Host Name'),
                'note'  => __('e.g. "ftp.domain.com"'),
            ]
        );

        $fieldset->addField(
            'ftp_port',
            'text',
            [
                'name'  => 'ftp_port',
                'label' => __('Port'),
                'title' => __('Port'),
            ]
        );

        $fieldset->addField(
            'ftp_user_name',
            'text',
            [
                'name'  => 'ftp_user_name',
                'label' => __('User Name'),
                'title' => __('User Name'),
            ]
        );

        $fieldset->addField(
            'ftp_password',
            'password',
            [
                'name'  => 'ftp_password',
                'label' => __('Password'),
                'title' => __('Password'),
            ]
        );

        $fieldset->addField(
            'ftp_dir',
            'text',
            [
                'name'  => 'ftp_dir',
                'label' => __('Path'),
                'title' => __('Path'),
                'note'  => __('e.g. "/yourfolder"'),
            ]
        );

        $fieldset->addField(
            'is_ftp_passive',
            'select',
            [
                'name'   => 'is_ftp_passive',
                'label'  => __('Passive mode'),
                'title'  => __('Passive mode'),
                'values' => $this->_enableDisable->toOptionArray(),
            ]
        );


        $form->setValues($model->getData());
        $this->setForm($form);

        $this->_eventManager->dispatch('gomage_feed_tab_ftp_prepare_form', ['form' => $form]);

        return parent::_prepareForm();
    }

    /**
     * Prepare label for tab
     *
     * @return \Magento\Framework\Phrase
     */
    public function getTabLabel()
    {
        return __('FTP Settings');
    }

    /**
     * Prepare title for tab
     *
     * @return \Magento\Framework\Phrase
     */
    public function getTabTitle()
    {
        return __('FTP Settings');
    }

    /**
     * {@inheritdoc}
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function isHidden()
    {
        return false;
    }

    /**
     * Check permission for passed action
     *
     * @param string $resourceId
     * @return bool
     */
    protected function _isAllowedAction($resourceId)
    {
        return $this->_authorization->isAllowed($resourceId);
    }
}
