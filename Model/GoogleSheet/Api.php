<?php


namespace Khoaln\Contact2GoogleSheet\Model\GoogleSheet;


use Magento\Framework\App\Filesystem\DirectoryList;

class Api
{
    /**
     * @var \Google_Client $_client
     */
    private $_client;

    /**
     * @var \Khoaln\Contact2GoogleSheet\Helper\Data
     */
    private $_dataHelper;

    /**
     * ContactForm constructor.
     * @param \Khoaln\Contact2GoogleSheet\Helper\Data $dataHelper
     */
    public function __construct(
        \Khoaln\Contact2GoogleSheet\Helper\Data $dataHelper
    )
    {
        $this->_dataHelper = $dataHelper;
    }

    public function append( $contact)
    {
        $client = $this->getClient();
        $service = new \Google_Service_Sheets($client);
        $range = date('Y-m', time());
        $spreadsheetId= $this->_dataHelper->getContactFormSheetId();
        try {
            return $this->appendRow($service, $spreadsheetId, $range, $contact);
        } catch (\Exception $ex) {
            $body = new \Google_Service_Sheets_BatchUpdateSpreadsheetRequest(array(
                'requests' => array(
                    'addSheet' => array(
                        'properties' => array(
                            'title' => $range
                        )
                    )
                )
            ));
            $service->spreadsheets->batchUpdate($spreadsheetId, $body);
            return $this->appendRow($service, $spreadsheetId, $range, $contact);
        }
    }
    private function appendRow($service, $spreadsheetId, $range, $contact)
    {
        // Create the value range Object
        $valueRange = new \Google_Service_Sheets_ValueRange();
        $valueRange->setValues(["values" => $contact]); // Add two values
        $conf = ["valueInputOption" => "RAW"];
        return $service->spreadsheets_values->append($spreadsheetId, $range, $valueRange, $conf);
    }
    private function getClient()
    {
        if (!$this->_client) {
            $credential = $this->_dataHelper->getCredential();
            $client = new \Google_Client();
            $client->setScopes([
                \Google_Service_Sheets::SPREADSHEETS,
            ]);
            //Set Service account key that config in project
            //https://console.cloud.google.com/iam-admin/serviceaccounts/details/101147339843886042602;edit=true?previousPage=%2Fapis%2Fcredentials%3Fproject%3Dsuntory-wellness-1594265938326&project=suntory-wellness-1594265938326
            $client->setAuthConfig($credential);
            $this->_client = $client;
        }

        return $this->_client;
    }
}
