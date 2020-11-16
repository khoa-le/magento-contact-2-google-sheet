<?php


namespace Khoaln\Contact2GoogleSheet\Model\ResourceModel;


class ContactForm  extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected function _construct()
    {
        $this->_init('contact_form', 'entity_id');
    }
}
