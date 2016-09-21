Demo Image Gallery project with CI flow
================


##API endpoints

Notes: prefix "api" is added, version control is added to url 

+ /api/v1  - albums list
+ /api/v1/album/:id - images list for album with id specified, page 1
+ /api/v1/album/:id/page/:page  - images list for album with id specified, page :page

[API specification documentation](http://localhost:8000/apidoc) 

###Unit testing

Instead of standart PhpUnit, it is tested with [PhpSpec BDD](http://www.phpspec.net/en/stable/) 

```bash
$bin/phpspec run --format=pretty
```



