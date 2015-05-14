Feature: SamsonCMS authorization
  In order to access SamsonCMS application
  As a visitor
  I need to be able to log in into it

  Scenario: Authorization page
    Given I am on "/signin"
    And print last response
    Then I should see 1 ".btn-lg" elements

  @javascript
  Scenario: Failed authorization
    Given I am on "/signin"
    When I fill in "email" with "test@test.com"
    And I fill in "password" with "123456"
    And I press "btn-signin"
    And I wait for ajax response
    Then I should be on "/signin"

  @javascript
  Scenario: Successful authorization
    Given I am on "/signin"
    When I fill in "email" with "test@test.com"
    And I fill in "password" with "123"
    And I press "btn-signin"
    And I wait for ajax response
    Then I should be on homepage
    And I log out

  @javascript
  Scenario: Test
    Given I am logged in as "test@test.com" with "123"
    Then I should be on the homepage