Feature: User authentication

  # All rows share the same steps; only <result> changes
  Scenario Outline: Login with different credential sets
    Given the user is on the login page
    When the user logs in with "<email>" and "<password>"
    Then the login should be "<result>"

    Examples: Login test matrix
      | case                    | email                       | password   | result  |
      | valid credentials       | Kimia.karbasi@ue-germany.de | 1234       | success |
      | wrong password          | Kimia.karbasi@ue-germany.de | wrongpass  | fail    |
      | wrong email             | wrong@gmail.com             | 1234       | fail    |
      | empty password          | Kimia.karbasi@ue-germany.de |            | fail    |
      | empty email             |                             | 1234       | fail    |
      | sql inj 1 (always true) | ' OR 1=1 --                 | ' OR 1=1 --   | success |
      | sql inj 2 (always true) | ' or ''='                   | ' or ''='   | success |
      | sql inj 3               | admin@domain.com' --          | anything   | maria-db-redirect  |
      | sql inj 4               | UNION SELECT creditCardNumber,1,'admin' FROM CreditCardTable -- | irrelevant   | maria-db-redirect |
      | sql inj 6               | ' OR 1=1 --          | anything   | maria-db-redirect |
      | sql inj 7               | ' OR 1=1 --          | ' OR 1=0 --   | success |


