<?php


namespace Khoaln\Contact2GoogleSheet\Model\GoogleSheet;


use Khoaln\Contact2GoogleSheet\Api\ContactFormInterface;
use Khoaln\Contact2GoogleSheet\Api\Data\ContactFormDataInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\InputException;
use Magento\Framework\ObjectManagerInterface;
use Magento\Framework\Stdlib\DateTime;

class ContactForm implements ContactFormInterface
{
    /**
     * @var \Khoaln\Contact2GoogleSheet\Model\ResourceModel\ContactForm
     */
    private $contactForm;
    /**
     * @var Api
     */
    private $googleApi;
    /**
     * @var DateTime
     */
    private $dateTime;
    /**
     * @var \Khoaln\Contact2GoogleSheet\Model\ContactFormFactory
     */
    private $contactFormFactory;

    /**
     * ContactForm constructor.
     * @param \Khoaln\Contact2GoogleSheet\Model\ContactFormFactory $contactFormFactory
     * @param \Khoaln\Contact2GoogleSheet\Model\ResourceModel\ContactForm $contactForm
     * @param Api $googleApi
     * @param DateTime $dateTime
     */
    public function __construct(
        \Khoaln\Contact2GoogleSheet\Model\ContactFormFactory $contactFormFactory,
        \Khoaln\Contact2GoogleSheet\Model\ResourceModel\ContactForm $contactForm,
        \Khoaln\Contact2GoogleSheet\Model\GoogleSheet\Api $googleApi,
        DateTime $dateTime
    )
    {
        $this->contactFormFactory = $contactFormFactory;
        $this->contactForm = $contactForm;
        $this->googleApi = $googleApi;
        $this->dateTime = $dateTime;
    }

    /**
     * @param ContactFormDataInterface $contact
     * @return false|mixed|string
     */
    public function save(ContactFormDataInterface $contact)
    {
        if (!empty($contact->getName()) && (!empty($contact->getPhone()) || !empty($contact->getEmail()))) {
            $gmt7time = date("Y-m-d H:i", strtotime('+7 hours'));
            $createdAt = $this->dateTime->formatDate($gmt7time);
            try {
                $contactFormData = $this->contactFormFactory->create();
                $contactFormData->setData("name", $contact->getName());
                $contactFormData->setData("phone", $contact->getPhone());
                $contactFormData->setData("email", $contact->getEmail());
                $result = $this->contactForm->save($contactFormData);
                if ($result) {
                    $this->appendGoogleSheet($contact, $createdAt);
                }
            } catch (\Exception $exception) {
                throw  new CouldNotSaveException(__($exception->getMessage()));
            }
        } else {
            throw new InputException(__("Please fill the information"));
        }
        return [];
    }

    private function appendGoogleSheet($contact, $createdAt)
    {
        $row = [
            $contact->getName(),
            $contact->getPhone(),
            $contact->getEmail(),
            $createdAt,
        ];
        return $this->googleApi->append($row);
    }
}
