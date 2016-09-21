Feature: Image gallery
  In order to browse images in gallery by album
  As an API client
  I want to be able to view albums and images in selected album

  Scenario: View all albums
    When I send a GET request to "/api/v1"
     And the response should be OK
     And the response should be JSON
     And the response should contain json:
    """
    {"albums":[
      {"id":"1","name":"Album 1"},
      {"id":"2","name":"Album 2"},
      {"id":"3","name":"Album 3"},
      {"id":"4","name":"Album 4"},
      {"id":"5","name":"Album 3"}
    ]}
    """

  Scenario: View images in album first page
    When I send a GET request to "/api/v1/album/1"
    Then the response should be OK
     And the response should be JSON
     And the response should contain '"name":"Album 1"'
     And the response should contain '"current":1'
     And the response should contain '"next":1'
     And the response should contain '"name":"Album 1"'

  Scenario: View images in album 2nd page
    When I send a GET request to "/api/v1/album/2/page/2"
    Then the response should be OK
     And the response should be JSON
     And the response should contain '"name":"Album 2"'
     And the response should contain '"current":2'
     And the response should contain '"next":2'

  Scenario: View not existed album
    When I send a GET request to "/api/v1/album/100"
    Then the response code should be 404

