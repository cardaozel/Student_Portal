Feature: User authentication

  # All rows share the same steps; only <result> changes
  Scenario Outline: Login with different credential sets
    Given the user is on the login page
    When the user logs in with "<email>" and "<password>"
    Then the login should be "<result>"

    Examples: Login test matrix
      | case                    | email                       | password   | result  |
      | valid credentials       | senem.turkaydin@ue-germany.de | STur_2025pass!       | success |
      | wrong password          | senem.turkaydin@ue-germany.de | wrongpass  | fail    |
      | wrong email             | wrong@gmail.com             | STur_2025pass!       | fail    |
      | empty password          | senem.turkaydin@ue-germany.de |            | fail    |
      | empty email             |                             | STur_2025pass!       | fail    |
      | sql inj 1 (always true) | ' OR 1=1 --                 | ' OR 1=1 --   | fail |
      | sql inj 2 (always true) | ' or ''='                   | ' or ''='   | fail |
      | sql inj 3               | admin@domain.com' --          | anything   | fail  |
      | sql inj 4     | UNION SELECT creditCardNumber,1,'admin' FROM CreditCardTable -- | irrelevant | fail |
      | sql inj 5               | admin@domain.com' AND SLEEP(5)-- | any   | fail |
      | sql inj 6               | ' OR 1=1 --          | anything   | fail |
      | sql inj 7               | ' OR 1=1 --          | ' OR 1=0 --   | fail |


