package net.alwaysdata.demo.pages;

import org.openqa.selenium.By;
import org.openqa.selenium.WebDriver;

public class LoginPage {

    private final WebDriver driver;

    // CSS locators supplied by you
    private final By email    = By.cssSelector("input[name='email']");
    private final By password = By.cssSelector("input[name='password']");
    private final By loginBtn = By.cssSelector("div.card form button");

    public LoginPage(WebDriver driver) { this.driver = driver; }

    public void open() {
       driver.get("https://logindb.alwaysdata.net/index.php");

    }

    public void loginAs(String user, String pass) {
        driver.findElement(email).clear();
        driver.findElement(email).sendKeys(user);
        driver.findElement(password).clear();
        driver.findElement(password).sendKeys(pass);
        driver.findElement(loginBtn).click();
    }
}
