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
$ php certificationy.phar [--number=5]
```

## Using Composer
```
$ composer create-project eko/certificationy
$ php certificationy.php [--number=5]
```

## More run options

### List categories
```
$ php certificationy.php --list [-l]
```

Will list all the categories available

### Only questions from certain categories
```
$ php certificationy.php "Automated tests" "Bundles"
```

Will only get the questions from the categories "Automated tests" and "Bundles"

Use the category list from [List categories](#list-categories)

### Show if a question has multiple choices
```
$ php certificationy.php --show-multiple-choice
```

![Multiple choices](https://cloud.githubusercontent.com/assets/795661/3308225/721b5324-f679-11e3-8d9d-62ba32cd8e32.png "Multiple choices")

### And all combined
```
$ php certificationy.php --numbers=5 --show-multiple-choice "Automated tests" "Bundles"
```

* 5 questions
* We will show if a questions has multiple choices
* Only get questions from category "Automated tests" and "Bundles"

> Note: if you pass --list [-l] then you will ONLY get the category list, regarding your other settings

# Please, add your questions!

You can submit PR with your own questions into the `data/` directory to extends questions database.
More we will have questions, the more powerful will be this tool!
