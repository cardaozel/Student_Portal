Feature: Student View Page

  Scenario Outline: Login and view student
    Given the user is on the login page
    When  the user logs in with "<email>" and "<password>"
    And   the user navigates to student view page with ID <id>
    Then  the first list item should display ID "<Userid>"

    Examples:
      | email                       | password          | id | Userid        |
      | senem.turkaydin@ue-germany.de | STur_2025pass!  | 3  | User ID: 11    |
      | senem.turkaydin@ue-germany.de | STur_2025pass!  | 4  | User ID: 11    |

