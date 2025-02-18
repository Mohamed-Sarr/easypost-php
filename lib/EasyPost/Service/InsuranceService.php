<?php

namespace EasyPost\Service;

/**
 * Insurance service containing all the logic to make API calls.
 */
class InsuranceService extends BaseService
{
    private static $modelClass = 'Insurance';

    /**
     * Retrieve an insurance object.
     *
     * @param string $id
     * @return mixed
     */
    public function retrieve($id)
    {
        return self::retrieveResource(self::$modelClass, $id);
    }

    /**
     * Retrieve all insurance objects.
     *
     * @param mixed $params
     * @return mixed
     */
    public function all($params = null)
    {
        return self::allResources(self::$modelClass, $params);
    }

    /**
     * Create an insurance object.
     *
     * @param mixed $params
     * @return mixed
     */
    public function create($params = null)
    {
        if (!isset($params['insurance']) || !is_array($params['insurance'])) {
            $clone = $params;
            unset($params);
            $params['insurance'] = $clone;
        }

        return self::createResource(self::$modelClass, $params);
    }
}
