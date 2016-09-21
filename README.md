Demo Image Gallery project with CI flow
================


##API endpoints

Notes: prefix "api" is added, version control is added to url 

+ /api/v1  - albums list
+ /api/v1/album/:id - images list for album with id specified, page 1
+ /api/v1/album/:id/page/:page  - images list for album with id specified, page :page

[API specification documentation](http://localhost:8000/apidoc) 

###Unit testing

Instead of standart PhpUnit, it is tested with [PhpSpec BDD](http://www.phpspec.net/en/stable/) with Prophecy as a mocker. 

```bash
$bin/phpspec run --format=pretty
```

![Screenshot](http://i.imgur.com/4O1ZOT8.png)

###Functional testing

Functional tests with [Behat BDD](http://behat.org)

```bash
$bin/behat
```

![Preview](http://i.imgur.com/2qyIf2z.png)

##Continuous Integration Flow

The flow is configured for minimal CI process, requires [Phing](https://www.phing.info/) installed

```bash
$phing build-ci
```

##Continuous Integration Server

Integrated with [Travis-CI](https://travis-ci.org/Evgenas/demoimagegallery)

develop: ![Preview](https://travis-ci.org/Evgenas/demoimagegallery.svg?branch=develop)
master: ![Preview](https://travis-ci.org/Evgenas/demoimagegallery.svg?branch=master)
