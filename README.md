# llms.txt PHP CLI

![Test Status](https://github.com/raphaelstolt/llms-txt-php-cli/workflows/test/badge.svg)
[![Version](http://img.shields.io/packagist/v/stolt/llms-txt-php-cli.svg?style=flat)](https://packagist.org/packages/stolt/llms-txt-php-cli)
![Downloads](https://img.shields.io/packagist/dt/stolt/llms-txt-php-cli)
![PHP Version](https://img.shields.io/badge/php-8.1+-ff69b4.svg)
[![PDS Skeleton](https://img.shields.io/badge/pds-skeleton-blue.svg?style=flat)](https://github.com/php-pds/skeleton)
![llms.txt](https://img.shields.io/badge/llms.txt-available-blue.svg?style=flat)

<p align="center">
    <img src="llms-txt-logo.png" 
         alt="Llms txt logo">
</p>

This CLI supports you in creating and validating [llms.txt](https://llmstxt.org/) Markdown files via the console.

## Installation and usage

```bash
composer require --dev stolt/llms-txt-php-cli
```

### Available commands

The following list command call shows the currently available commands.

```bash
bin/llms-txt-cli list

llms-txt-cli 1.0.0

Available commands:
  check-links  Check links of a llms.txt file
  info         Get metadata info of a llms.txt file
  init         Create an initial llms txt.file
  validate     Validate the given llms txt.file
```

### Validating a llms.txt file

```bash
bin/llms-txt-cli validate tests/fixtures/uv.llms.md

The provided llms.txt file tests/fixtures/uv.llms.md is valid.
```

or

```bash
bin/llms-txt-cli validate https://docs.astral.sh/uv/

The delivered llms.txt file from https://docs.astral.sh/uv/ is valid.
```

A `llms.txt` file is considered valid, when a __title__, __description__, __details__, and at least __one section__
with at least __one link__ are available.


### Getting metadata of a llms.txt file

```bash
bin/llms-txt-cli info tests/fixtures/uv.llms.md

{
    "sections": 7,
    "links": 45,
    "last_modification": "26.06.2025 06:38:45",
    "file": {
        "name": "tests\/fixtures\/uv.llms.md",
        "path": "\/home\/stolt\/oss\/llms-txt-php-cli\/tests\/fixtures\/uv.llms.md",
        "size": "4.07K"
    }
}
```

### Initialising a llms.txt file

```bash
bin/llms-txt-cli init [<llms-txt-file>]

Created llms.txt file llms.txt.

cat llms.txt

# Init title

> Init description

Init details

## Init section

- [Init URL](http://init.org)
```

If no `llms-txt-file` name is provided, it defaults to `llms.txt`. 

### Checking the links of a llms.txt file

```bash
bin/llms-txt-cli check-links tests/fixtures/uv.llms.md

All links are reachable.
```

### Running tests

``` bash
composer test
```

### License

This CLI is licensed under the MIT license. Please see [LICENSE.md](LICENSE.md) for more details.

### Changelog

Please see [CHANGELOG.md](CHANGELOG.md) for more details.

### Contributing

Please see [CONTRIBUTING.md](.github/CONTRIBUTING.md) for more details.
