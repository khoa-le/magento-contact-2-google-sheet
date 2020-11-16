<?php


namespace Khoaln\Contact2GoogleSheet\Model\GoogleSheet;

use Magento\Framework\Api\AbstractSimpleObject;
use Khoaln\Contact2GoogleSheet\Api\Data\ContactFormDataInterface;

class ContactFormData  extends AbstractSimpleObject implements ContactFormDataInterface
{
    public function getName()
    {
        return $this->_get(self::NAME);
    }

    public function setName($name)
    {
        return $this->setData(self::NAME, $name);
    }

    public function getPhone()
    {
        return $this->_get(self::PHONE);
    }

    public function setPhone($phone)
    {
        return $this->setData(self::PHONE, $phone);
    }

    public function getEmail()
    {
        return is_null($this->_get(self::EMAIL))?"":$this->_get(self::EMAIL);
    }

    public function setEmail($email)
    {
        return $this->setData(self::EMAIL, $email);
    }
}
