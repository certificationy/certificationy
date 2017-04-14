Certificationy
==============

[![Join the chat at https://gitter.im/certificationy/certificationy](https://badges.gitter.im/Join%20Chat.svg)](https://gitter.im/certificationy/certificationy?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge) [![Build Status](https://secure.travis-ci.org/certificationy/certificationy.png?branch=master)](http://travis-ci.org/certificationy/certificationy) [![SensioLabsInsight](https://insight.sensiolabs.com/projects/cd3b6bc1-632e-491a-abfc-43edc390e1cc/mini.png)](https://insight.sensiolabs.com/projects/cd3b6bc1-632e-491a-abfc-43edc390e1cc)

Certificationy provides a complete system to build multiple choice question system. This is useful for any company that need to test an applicant,
or to make a certification website/training tool.

# How to use it?

Inside any PHP application
--------------------------

As usual, use composer to install the library:

```bash
composer require "certificationy/certificationy"
```

Then, you need to load questions using a loader: for now only [PhpArray](Loaders/PhpArrayLoader.php) and [Yaml](Loaders/YamlLoader.php) loaders
are provided, but thanks to the [Loader interface](Interfaces/LoaderInterface.php) you can create your owns.

For instance, let's say you have created a Yaml file with some few questions:

```yaml
# question.yaml
category: basics
questions:
    -
        question: '2 + 2 = ?'
        answers:
            - {value: 4,           correct: true}
            - {value: 3,           correct: false}
            - {value: 2,           correct: false}
```

Then you can do:

```php
<?php
use Certificationy\Loaders\YamlLoader;

$loader = new YamlLoader(['path/to/question.yaml']);
$set = $loader->initSet(1, []); // (nbQuestions, fromCategories)
$loader->categories(); // ['basics']

$questions = $set->getQuestions(); // receives a "Questions" collection with the question
```

Then, for each question you can set user answers (as answers can be multiple):

```php
<?php
 $set->setUserAnswers(0, [4]); // (questionIndex, [values])
```

At every moment, you can get the correct and wrong answers (non answered questions are wrong).

```php
$set->getCorrectAnswers();
$set->getWrongAnswers();
```

CLI tool
--------

A CLI tool is available under the following repository: http://www.github.com/certificationy/certificationy-cli.

# Please, help us complete our official packs of questions!

You can submit PR with your own questions into the packs located under the [Certificationy organization](https://github.com/certificationy).

We provide packs for both [PHP5](https://github.com/certificationy/php-pack) and [Symfony](https://github.com/certificationy/symfony-pack) certifications.

> As of today (03/04/2017), Certificationy CLI uses Certificationy library ``1.x`` branch.

More we will have questions, the more powerful will be this tool!
