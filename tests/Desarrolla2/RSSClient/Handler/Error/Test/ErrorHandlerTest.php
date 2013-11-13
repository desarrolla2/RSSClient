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

namespace Desarrolla2\RSSClient\Handler\Error\Test;

use \Desarrolla2\RSSClient\Handler\Error\ErrorHandler;

/**
 *
 * Description of ErrorHandlerTest
 *
 * @author : Daniel González Cerviño <daniel.gonzalez@freelancemadrid.es>
 */
class ErrorHandlerTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var \Desarrolla2\RSSClient\Handler\Error\ErrorHandler
     */
    protected $handler = null;

    public function setUp()
    {
        $this->handler = new ErrorHandler();
    }

    public function testGetErrors()
    {
        $this->assertEquals(array(), $this->handler->getErrors());
    }

    public function testHasErrors()
    {
        $this->assertEquals(false, $this->handler->hasErrors());
    }

    public function testClearErrors()
    {
        $this->handler->clearErrors();
        $this->assertEquals(array(), $this->handler->getErrors());
    }

    public function testGetLastError()
    {
        $this->assertEquals(false, $this->handler->getLastError());
    }
}
