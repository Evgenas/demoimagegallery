Feature: Image gallery
  In order to browse images by gallery
  As an API client
  I want to be able to view images in selected gallery

  Scenario: View image gallery first page
    When I send a GET request to "/album/1"
    Then the response should be OK
    Then the response should be JSON

  Scenario: View image gallery first page
    When I send a GET request to "/album/1/page/2"
    Then the response should be OK
    Then the response should be JSON
