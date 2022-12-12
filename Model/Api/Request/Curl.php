<?php
namespace Aheadworks\MobilePushNotification\Model\Api\Request;

use Magento\Framework\HTTP\Adapter\CurlFactory;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Json\Helper\Data;
use Magento\Framework\Encryption\EncryptorInterface;
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
     * @var EncryptorInterface
     */
    protected $encryptor;

    /**
     * @var Response
     */
    private $response;

    /**
     * @param CurlFactory $curlFactory
     * @param ScopeConfigInterface $scopeConfig
     * @param Data $jsonHelper
     * @param EncryptorInterface $encryptor
     * @param Response $response
     */
    public function __construct(
        CurlFactory $curlFactory,
        ScopeConfigInterface $scopeConfig,
        Data $jsonHelper,
        EncryptorInterface $encryptor,
        Response $response
    ) {
        $this->curlFactory = $curlFactory;
        $this->scopeConfig = $scopeConfig;
        $this->jsonHelper = $jsonHelper;
        $this->encryptor = $encryptor;
        $this->response = $response;
    }

    /**
     * Perform api request
     *
     * @param string $url
     * @param array $params
     * @param string $method
     * @return string
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
        $firebaseApiKey = $this->getFireBaseApiKey();
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

    /**
     * Get fire base api key
     *
     * @param string $scope
     * @return string
     */
    public function getFireBaseApiKey($scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT)
    {
        $secret = $this->scopeConfig->getValue(
            'aw_mpn/aw_mpn_setting/firebase_api_key',
            $scope
        );
        $secret = $this->encryptor->decrypt($secret);

        return $secret;
    }
}
