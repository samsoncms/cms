Feature: SamsonCMS authorization
  In order to log in to a SamsonCMS application
  I need to authorize in it

  Scenario: Authorization page
    Given I am on "/signin"
    Then I should see 1 "button.btn-lg.btn-signin" elements

  Scenario: Failed authorization
    Given I am on "/signin"
    When I fill in "email" with "test@test.com"
    And I fill in "password" with "123456"
    And I press "btn-signin"
    Then I should see 1 "form.errAuth" elements

  Scenario: Successfull authorization
    Given I am on "/signin"
    When I fill in "email" with "test@test.com"
    And I fill in "password" with "123"
    And I press "btn-signin"
    Then I should be on homepage

