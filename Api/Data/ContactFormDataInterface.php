<?php

namespace Khoaln\Contact2GoogleSheet\Api\Data;

interface ContactFormDataInterface
{
    const NAME  ='name';
    const PHONE  ='phone';
    const EMAIL  ='email';

    /**
     * @return string
     */
    public function getName();

    /**
     * @param string $name
     * @return ContactFormDataInterface
     */
    public function setName($name);

    /**
     * @return string
     */
    public function getPhone();

    /**
     * @param string $phone
     * @return ContactFormDataInterface
     */
    public function setPhone($phone);

    /**
     * @return string
     */
    public function getEmail();

    /**
     * @param string $email
     * @return ContactFormDataInterface
     */
    public function setEmail($email);
}
