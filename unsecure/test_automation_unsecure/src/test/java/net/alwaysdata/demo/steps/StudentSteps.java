package net.alwaysdata.demo.steps;

import net.alwaysdata.demo.hooks.BaseHooks;
import io.cucumber.java.en.*;
import org.openqa.selenium.*;
import org.openqa.selenium.support.ui.*;

import java.time.Duration;

import static org.junit.jupiter.api.Assertions.*;

public class StudentSteps {

    @When("the user navigates to student view page with ID {int}")
    public void theUserNavigatesToStudentViewPage(int id) {
        WebDriver driver = BaseHooks.getDriver();
        new WebDriverWait(driver, Duration.ofSeconds(10))
                .until(ExpectedConditions.urlContains("home.php"));

        driver.get("https://logindb.alwaysdata.net/view_student.php?id=" + id);
    }

    @Then("the first list item should display ID {string}")
    public void theFirstListItemShouldDisplayId(String expectedText) {
        WebDriver driver = BaseHooks.getDriver();
        WebDriverWait wait = new WebDriverWait(driver, Duration.ofSeconds(10));

        // <li> öğesini bul ve metnini al
        String actual = wait.until(ExpectedConditions
                        .presenceOfElementLocated(By.xpath("/html/body/div[1]/div/ul/li[1]")))
                .getText()
                .trim();

        assertEquals(String.valueOf(expectedText), actual,
                "Student ID in first <li> is incorrect");
    }
}
