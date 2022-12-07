<?php
namespace Aheadworks\MobilePushNotification\Model\Api\Request;

use Magento\Framework\HTTP\Adapter\CurlFactory;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Json\Helper\Data;
use Laminas\Http\Response;

/**
 * Request for curl
 */
class Curl
{
    /**
     * @var CurlFactory
     */
    private $curlFactory;
    
    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @var Data
     */
    private $jsonHelper;

    /**
     * @var Response
     */
    private $response;

    /**
     * @param CurlFactory $curlFactory
     * @param ScopeConfigInterface $scopeConfig
     * @param Data $jsonHelper
     * @param Response $response
     */
    public function __construct(
        CurlFactory $curlFactory,
        ScopeConfigInterface $scopeConfig,
        Data $jsonHelper,
        Response $response
    ) {
        $this->curlFactory = $curlFactory;
        $this->scopeConfig = $scopeConfig;
        $this->jsonHelper = $jsonHelper;
        $this->response = $response;
    }

    /**
     * Perform api request
     *
     * @param string $url
     * @param array $params
     * @param string $method
     * @return Response
     * @throws LocalizedException
     * @throws \Exception
     */
    public function request($url, $params = [], $method = 'POST')
    {
        $curl = $this->curlFactory->create();
        $curl->write(
            $method,
            $url,
            '1.1',
            $this->getHeaders(),
            $params
        );

        try {
            $response = $curl->read();
            $responseStatus = $this->response->getStatusCode($response);
            if ($responseStatus == '200') {
                $responseCode = "success";
            } else {
                $responseCode = "failure";
            }
           
        } catch (\Exception $e) {
            $curl->close();
            throw new LocalizedException(__('Unable to perform request.'));
        }

        $curl->close();
      
        return $responseCode;
    }

    /**
     * Get http headers
     *
     * @return array
     */
    private function getHeaders()
    {
        $headers = [];
        $firebaseApiKey = $this->scopeConfig->getValue('aw_mpn/aw_mpn_setting/firebase_api_key');
        $authorization = "Key=$firebaseApiKey";
        $headersData = [
            'Content-Type' => 'application/json',
            'Authorization' => $authorization
        ];

        foreach ($headersData as $name => $value) {
            $headers[] = $name . ': ' . $value;
        }

        return $headers;
    }
}
