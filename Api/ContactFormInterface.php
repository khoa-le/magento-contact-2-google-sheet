<?php


namespace Khoaln\Contact2GoogleSheet\Api;


use Khoaln\Contact2GoogleSheet\Api\Data\ContactFormDataInterface;

interface ContactFormInterface
{
    /**
     * @param ContactFormDataInterface $contact
     * @return mixed
     */
    public function save(ContactFormDataInterface $contact);
}

