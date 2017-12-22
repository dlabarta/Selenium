<?php

namespace AvaibookTests;

use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverKeys;

class AvaibookTest extends \PHPUnit_Framework_TestCase
{
    protected $webDriver;

    public function setUp()
    {
        $host = 'http://localhost:4444/wd/hub';
        $this->webDriver = RemoteWebDriver::create($host, DesiredCapabilities::chrome());
    }

    public function testAvaibookTitle()
    {
        $url = 'https://www.avaibook.com/';

        $this->webDriver->get($url);
        $this->assertContains(' AvaiBook.com', $this->webDriver->getTitle());
    }


    public function tearDown()
    {
        $this->webDriver->quit();
    }


    public function testWrongLogin()
    {
        $url = 'https://app.avaibook.com/login.php';
        $this->webDriver->get($url);

        $userForm = $this->webDriver->findElement(WebDriverBy::id('usuario'));
        $userForm->click();
        $this->webDriver->getKeyboard()->sendKeys('bad@mail.es');

        $passwordForm = $this->webDriver->findElement(WebDriverBy::id('clave'));
        $passwordForm->click();
        $this->webDriver->getKeyboard()->sendKeys('badPassword');


        $this->webDriver->getKeyboard()->pressKey(WebDriverKeys::ENTER);


        $errorMessage = $this->webDriver->findElements(
            WebDriverBy::cssSelector('div.alert-danger')
        );

        $this->assertContains('incorrectos', $errorMessage[0]->getText());

    }
}
