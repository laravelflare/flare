# Contributing

Contributions are **welcome** and will be fully **credited**.

Contributions should be submitted via Pull Requests on [Github](https://github.com/laravelflare/flare).


## Pull Requests

- **Symfony Coding Standards** - All code should follow the [Symfony Coding Standards](http://symfony.com/doc/current/contributing/code/standards.html), which includes [PSR-0](http://www.php-fig.org/psr/psr-0/), [PSR-1](http://www.php-fig.org/psr/psr-1/), [PSR-2](http://www.php-fig.org/psr/psr-2/) and [PSR-4](http://www.php-fig.org/psr/psr-4/). The easiest way to apply the conventions is to install [PHP Coding Standards Fixer](https://github.com/FriendsOfPHP/PHP-CS-Fixer) and then, before committing and submitting a pull request, run:
```
php php-cs-fixer.phar fix /path/to/package --level=symfony
```

- **Add and/or Pass tests!** - Your patch won't be accepted if it doesn't, at a minimum, pass existing tests. Ideally patches should also implement tests, and new features **must** include them.

- **Document any change in behaviour** - All relevant documentation should be updated and submitted as a related pull-request in the [Flare docs repo](https://github.com/laravelflare/docs).

- **Consider the release cycle** - We try to follow [SemVer v2.0.0](http://semver.org/). Randomly breaking public APIs is not an option.

- **Create feature branches** - Don't ask us to pull from your master branch.

- **One pull request per feature** - If you want to do more than one thing, send multiple pull requests.

- **Send coherent history** - Make sure each individual commit in your pull request is meaningful. If you had to make multiple intermediate commits while developing, please [squash them](http://www.git-scm.com/book/en/v2/Git-Tools-Rewriting-History#Changing-Multiple-Commit-Messages) before submitting.


## Running Tests

``` bash
$ composer test
```


**Happy coding**!
