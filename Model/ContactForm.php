<?php


namespace Khoaln\Contact2GoogleSheet\Model;

class ContactForm extends \Magento\Framework\Model\AbstractModel implements \Magento\Framework\DataObject\IdentityInterface
{
    const CACHE_TAG = 'contact_form';

    protected function _construct()
    {
        $this->_init(\Khoaln\Contact2GoogleSheet\Model\ResourceModel\ContactForm::class);
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getEntityId()];
    }
}

