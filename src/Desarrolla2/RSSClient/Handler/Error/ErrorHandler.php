<?php

/**
 * This file is part of the RSSClient proyect.
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
 * @file : ErrorHandler.php , UTF-8
 * @date : Mar 19, 2013 , 4:13:03 PM
 */
class ErrorHandler
{
    /**
     * @var array
     */
    protected $errors = array();

    /**
     * Retrieve last Error
     *
     * @return string $lastError | false
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
     * Retrieve if any errors ocurred
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
        $this->errors[] = (string) $errorString;
    }

}
