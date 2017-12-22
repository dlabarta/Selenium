<?php

namespace AvaibookTests;

use AvaibookTests\AvaibookPages\LoginPage;

class AvaibookPageObjectTest extends \PHPUnit_Framework_TestCase
{
    protected $loginPage;

    public function setUp()
    {
        $this->loginPage = new LoginPage();
        $this->loginPage->load();
    }

    public function tearDown()
    {
        $this->loginPage->close();
    }

    public function testWrongLogin()
    {
        $this->loginPage->setLoginValues("email@text.es", "badPassword");
        $this->loginPage->login();

        $this->assertContains('incorrectos', $this->loginPage->getErrorMessage());
    }

    public function testValidLogin()
    {
        $this->loginPage->setLoginValues("correctMail", "correctPassword");
        $this->loginPage->login();

        $this->assertContains('Administración', $this->loginPage->getLoginOk());
    }

}
