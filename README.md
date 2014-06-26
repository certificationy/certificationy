Certificationy
==============

[![Build Status](https://secure.travis-ci.org/eko/certificationy.png?branch=master)](http://travis-ci.org/eko/certificationy)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/cd3b6bc1-632e-491a-abfc-43edc390e1cc/mini.png)](https://insight.sensiolabs.com/projects/cd3b6bc1-632e-491a-abfc-43edc390e1cc)

This is a Symfony Console application to train on Symfony certification.

# How it looks?
![Certificationy application](http://vincent.composieux.fr/assets/img/blog/certificationy-console.png "Certificationy application")

# Installation

## Using Phar

```
$ curl -s http://box-project.org/installer.php | php
$ php box.phar build
$ php certificationy.phar [--number=20]
```

## Using Composer
```
$ composer create-project eko/certificationy
$ php certificationy.php [--number=20]
```

# Please, add your questions!

You can submit PR with your own questions into the `data/` directory to extends questions database.
More we will have questions, the more powerful will be this tool!
