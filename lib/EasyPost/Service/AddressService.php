<?php

namespace EasyPost\Service;

use EasyPost\Http\Requestor;
use EasyPost\Util\InternalUtil;

/**
 * Address service containing all the logic to make API calls.
 */
class AddressService extends BaseService
{
    private static $modelClass = 'Address';

    /**
     * Retrieve an address.
     *
     * @param string $id
     * @return mixed
     */
    public function retrieve($id)
    {
        return self::retrieveResource(self::$modelClass, $id);
    }

    /**
     * Retrieve all addresses.
     *
     * @param mixed $params
     * @return mixed
     */
    public function all($params = null)
    {
        return self::allResources(self::$modelClass, $params);
    }

    /**
     * Create an address.
     *
     * @param mixed $params
     * @return mixed
     */
    public function create($params = null)
    {
        $wrappedParams = [];

        if (isset($params['verify'])) {
            $verify = $params['verify'];
            unset($params['verify']);
            $wrappedParams['verify'] = $verify;
        }

        if (isset($params['verify_strict'])) {
            $verifyStrict = $params['verify_strict'];
            unset($params['verify_strict']);
            $wrappedParams['verify_strict'] = $verifyStrict;
        }

        $wrappedParams['address'] = $params;

        return self::createResource(self::$modelClass, $wrappedParams);
    }

    /**
     * Create and verify an address.
     *
     * @param mixed $params
     * @return mixed
     */
    public function createAndVerify($params = null)
    {
        if (!isset($params['address']) || !is_array($params['address'])) {
            $clone = $params;
            unset($params);
            $params['address'] = $clone;
        }

        $url = self::classUrl(self::$modelClass);
        $response = Requestor::request($this->client, 'post', $url . '/create_and_verify', $params);

        return InternalUtil::convertToEasyPostObject($this->client, $response['address']);
    }

    /**
     * Verify an address.
     *
     * @param string $id
     * @return mixed
     */
    public function verify($id)
    {
        $url = $this->instanceUrl(self::$modelClass, $id) . '/verify';
        $response = Requestor::request($this->client, 'get', $url, null);

        return InternalUtil::convertToEasyPostObject($this->client, $response['address'], self::$modelClass);
    }
}
