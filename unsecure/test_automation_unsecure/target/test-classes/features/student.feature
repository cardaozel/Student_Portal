Feature: Student View Page

  Scenario Outline: Login and view student
    Given the user is on the login page
    When  the user logs in with "<email>" and "<password>"
    And   the user navigates to student view page with ID <id>
    Then  the first list item should display ID "<Userid>"

    Examples:
      | email                       | password       | id | Userid        |
      | Kimia.karbasi@ue-germany.de | 1234           | 3  | User ID: 3    |
      | Kimia.karbasi@ue-germany.de | 1234           | 4  | User ID: 4    |
      | ' OR 1=1 --                 | ' OR 1=1 --    | 4  | User ID: 4    |
      | ' OR 1=1 --                 | ' OR 1=1 --    | 3  | User ID: 3    |
