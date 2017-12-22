<?php

namespace AvaibookTests\AvaibookPages;

use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;
use Facebook\WebDriver\WebDriverKeys;

class LoginPage
{
    protected $url = 'https://app.avaibook.com/login.php?lang=es';
    protected $webDriver;

    public function load()
    {
        $host = 'http://localhost:4444/wd/hub';
        $this->webDriver = RemoteWebDriver::create($host, DesiredCapabilities::chrome());
        $this->webDriver->get($this->url);
    }

    public function close()
    {
        $this->webDriver->quit();
    }

    public function getTitle()
    {
        return  $this->webDriver->getTitle();
    }

    public function setLoginValues($username, $password)
    {
        $userForm = $this->webDriver->findElement(WebDriverBy::id('usuario'));
        $userForm->click();
        $this->webDriver->getKeyboard()->sendKeys($username);

        $passwordForm = $this->webDriver->findElement(WebDriverBy::id('clave'));
        $passwordForm->click();
        $this->webDriver->getKeyboard()->sendKeys($password);
    }

    public function login()
    {
        $this->webDriver->getKeyboard()->pressKey(WebDriverKeys::ENTER);
    }

    public function getErrorMessage()
    {
        $errorMessage = $this->webDriver->findElements(
            WebDriverBy::className('alert-danger')
        );
        return $errorMessage[0]->getText();

    }

    public function getLoginOk()
    {
        try {
            $this->webDriver->wait()->until(
                WebDriverExpectedCondition::titleIs('Administración')
            );
            $title = $this->getTitle();
        } catch (\Exception $e) {
            $title = '';
        }
        return $title;

    }


}
