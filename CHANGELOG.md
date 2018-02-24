# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic Versioning](http://semver.org/spec/v2.0.0.html).

## [Unreleased]

## 0.1.2 - 2018-02-24
### Added
- Fixed missing extensions in composer require section.
- Continue filling in and expanding on comments.
- Add php dev tool configs.

###Fixed
- Removed unnecessary check for is_null.

## 0.1.1 - 2018-02-24
###Changed
- Small refactor for better testing and usage.

###Fixed
- Fix read me header.
- Fix composer dependency issue preventing dual support for php 7.x and 5.6.

## 0.1.0 - 2018-02-24
### Added
- This CHANGELOG file to hopefully serve as an evolving project history.
- Basic working Whois client for PHP.
- PHPdocblocks for all library code.
- Basic PHPUnit test coverage for the library.
- Continuous Integration setup for StyleCI, TravisCI, and ScrutinizerCI.
- Add Punycode for Unicode domain handling.
- Use League URI package for domain parsing.
