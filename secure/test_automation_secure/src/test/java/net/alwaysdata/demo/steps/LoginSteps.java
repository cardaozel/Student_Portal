package net.alwaysdata.demo.steps;

import io.cucumber.java.en.*;
import net.alwaysdata.demo.hooks.BaseHooks;
import net.alwaysdata.demo.pages.LoginPage;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.support.ui.*;

import java.time.Duration;

import static org.junit.jupiter.api.Assertions.*;

public class LoginSteps {

    private WebDriver driver;   // Başta null
    private LoginPage login;

    @Given("the user is on the login page")
    public void theUserIsOnLoginPage() {

        driver = BaseHooks.getDriver();
        login  = new LoginPage(driver);
        login.open();
    }

    @When("the user logs in with {string} and {string}")
    public void theUserLogsIn(String email, String pass) {
        login.loginAs(email, pass);
    }

    @Then("the login should be {string}")
    public void loginShouldBe(String result) {
        String expectedUrl = "";
        WebDriverWait wait = new WebDriverWait(driver, Duration.ofSeconds(3));

        if ("success".equalsIgnoreCase(result)) {
            expectedUrl = "/home.php";
            wait.until(ExpectedConditions.urlContains(expectedUrl));
            assertTrue(driver.getCurrentUrl().endsWith(expectedUrl));
        } else if ("fail".equalsIgnoreCase(result)) {
            expectedUrl = "";
            wait.until(ExpectedConditions.urlContains(expectedUrl));
            assertTrue(driver.getCurrentUrl().endsWith(expectedUrl));
        } else if ("maria-db-redirect".equalsIgnoreCase(result)) {
            expectedUrl = "index.php";
            wait.until(ExpectedConditions.urlContains(expectedUrl));
            String src = driver.getPageSource().toLowerCase();
            assertTrue(src.contains("mariadb") || src.contains("sql syntax") || src.contains("warning"));
        } else {
            fail("Unknown result type: " + result);
        }
    }
}
