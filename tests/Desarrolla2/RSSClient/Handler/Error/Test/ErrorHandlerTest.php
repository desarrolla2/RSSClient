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

namespace Desarrolla2\RSSClient\Handler\Error\Test;

use \Desarrolla2\RSSClient\Handler\Error\ErrorHandler;

/**
 *
 * Description of ErrorHandlerTest
 *
 * @author : Daniel González Cerviño <daniel.gonzalez@freelancemadrid.es>
 * @file : ErrorHandlerTest.php , UTF-8
 * @date : Mar 19, 2013 , 5:13:23 PM
 */
class ErrorHandlerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Desarrolla2\RSSClient\Handler\Error\ErrorHandler
     */
    protected $handler = null;

    /**
     * Setup
     */
    public function setUp()
    {
        $this->handler = new ErrorHandler();
    }

    /**
     * @test
     */
    public function testGetErrors()
    {
        $this->assertEquals($this->handler->getErrors(), array());
    }

    /**
     * @test
     */
    public function testHasErrors()
    {
        $this->assertEquals($this->handler->hasErrors(), false);
    }

}
