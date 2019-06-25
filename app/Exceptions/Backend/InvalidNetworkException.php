<?php

namespace App\Exceptions\Backend;

use Exception;

/**
 * Class UserNeedsRolesException
 * @package App\Exceptions\Access
 */
class InvalidNetworkException extends Exception
{
    /**
     * @var
     */
    protected $networkName;
    protected $networkDelegation;
    protected $networkGouvernorate;
    protected $networkType;

    /**
     * @var
     */
    protected $errors;

    /**
     * @param $networkName
     */
    public function setNetworkName($networkName)
    {
        $this->networkName = $networkName;
    }

    /**
     * @return mixed
     */
    public function networkName()
    {
        return $this->networkName;
    }

    public function setNetworkDel($networkDel)
    {
        $this->networkDelegation = $networkDel;
    }

    /**
     * @return mixed
     */
    public function networkDel()
    {
        return $this->networkDelegation;
    }

    public function setNetworkGouv($networkGouv)
    {
        $this->networkGouvernorate = $networkGouv;
    }

    /**
     * @return mixed
     */
    public function networkGouv()
    {
        return $this->networkGouvernorate;
    }

    public function setNetworkType($networkType)
    {
        $this->networkType = $networkType;
    }

    /**
     * @return mixed
     */
    public function networkType()
    {
        return $this->networkType;
    }
    /**
     * @param $errors
     */
    public function setValidationErrors($errors)
    {
        $this->errors = $errors;
    }

    /**
     * @return mixed
     */
    public function validationErrors()
    {
        return $this->errors;
    }
}