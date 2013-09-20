<?php

/**
 * This file is part of the RSSClient project.
 *
 * Copyright (c)
 * Daniel González Cerviño <daniel.gonzalez@freelancemadrid.es>
 *
 * This source file is subject to the MIT license that is bundled
 * with this package in the file LICENSE.
 */

namespace Desarrolla2\RSSClient\Handler\Error;

/**
 *
 * Description of ErrorHandler
 *
 * @author : Daniel González Cerviño <daniel.gonzalez@freelancemadrid.es>
 */
class ErrorHandler
{
    /**
     * @var array
     */
    protected $errors = array();

    /**
     * Retrieve last Error
     * @return false|string $lastError
     */
    public function getLastError()
    {
        if ($this->hasErrors()) {
            if (isset($errors[count($errors) - 1])) {
                return $errors[count($errors) - 1];
            }
        }

        return false;
    }

    /**
     * Clear error Stack
     */
    public function clearErrors()
    {
        $this->errors = array();
    }

    /**
     * Retrieve errors stack
     *
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * Retrieve if any errors occurred
     *
     * @return boolean
     */
    public function hasErrors()
    {
        return count($this->errors) ? true : false;
    }

    /**
     * Add Error to stack
     *
     * @param string $errorString
     */
    protected function addError($errorString)
    {
        $this->errors[] = (string)$errorString;
    }
}
