<?php
/**
 * Created by PhpStorm.
 * User: khoa
 * Date: 24/07/2019
 * Time: 16:20
 */

namespace Khoaln\Contact2GoogleSheet\Helper;


use Magento\Framework\App\Helper\AbstractHelper;

class Data extends AbstractHelper
{

    const CONFIG_PATH_CONTACT_GOOGLE_API_CREDENTIALS = 'khoaln_contact2googlesheet/google_sheet_contact/credentials';
    const CONFIG_PATH_CONTACT_GOOGLE_CONTACT_FORM_SHEET_ID = 'khoaln_contact2googlesheet/google_sheet_contact/contact_sheet_id';
    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface|null
     */
    protected $_scopeConfig = null;

    /**
     * Data constructor.
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context
    )
    {
        parent::__construct($context);
        $this->_scopeConfig = $context->getScopeConfig();
    }


    /**
     * @param $path
     * @param string $scope
     * @param null $storeId
     * @return mixed
     */
    public function getConfigValueByPath(
        $path,
        $scope = \Magento\Store\Model\ScopeInterface::SCOPE_WEBSITE,
        $storeId = null
    )
    {
        return $this->_scopeConfig->getValue(
            $path,
            $scope,
            $storeId
        );
    }

    public function getCredential()
    {
        $credential = $this->getConfigValueByPath(self::CONFIG_PATH_CONTACT_GOOGLE_API_CREDENTIALS);
        return json_decode($credential, true);
    }

    public function getContactFormSheetId()
    {
        return $this->getConfigValueByPath(self::CONFIG_PATH_CONTACT_GOOGLE_CONTACT_FORM_SHEET_ID);
    }

}
