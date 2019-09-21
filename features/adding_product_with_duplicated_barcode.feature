@managing_product_barcodes
Feature: Adding a new product with duplicated barcode
  In order to prevent barcode duplicates
  As an Administrator
  I want to see validation error when trying to add product with non-unique barcode

  Background:
    Given the store operates on a single channel in "United States"
    And the store has "Standard" shipping category
    And the store has a product "Stabilo Point 88-57 Azure"
    And this product has barcode "4006381333931"
    And I am logged in as an administrator

  @ui
  Scenario: Adding a new simple product with barcode
    Given I want to create a new simple product
    When I specify its code as "BOARD_DICE_BREWING"
    And I name it "Dice Brewing" in "English (United States)"
    And I set its slug to "dice-brewing" in "English (United States)"
    And I set its price to "$10.00" for "United States" channel
    And I set its barcode to "4006381333931"
    And I try to add it
    Then I should be notified that product with this barcode already exists
