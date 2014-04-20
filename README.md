The Thaana Conversions class for PHP provides a number of useful functions for the conversion and transliteration of text between various Thaana representation formats.

## Functions exposed
- convertUtf8ToUnicodeIntegers()
Convert UTF-8 data to Unicode character integer representations

- convertUtf8ToAscii()
Convert UTF-8 data to Ascii

- convertUtf8ToEntities()
Convert UTF-8 data to HTML entities

- convertEntitiesToUnicodeIntegers()
Convert HTML Unicode entitied string to Unicode Integer characters array

- convertEntitiesToUtf8
Convert HTML Unicode entities to UTF-8

- convertEntitiesToAscii()
Convert HTML Unicode entities to Dhivehi Ascii equivalents

- convertUnicodeIntegersToUtf8()
Convert Unicode Integer array to UTF

- convertUnicodeIntegersToEntities()
Convert Unicode char integers to HTML entities

- convertUnicodeIntegersToAscii()
Convert Unicode char integers to Ascii

- convertAsciiToUtf8()
Convert Ascii Thaana to UTf-8

- convertAsciiToEntities()
Convert Ascii Thaana to Unicode HTML entities

- convertAsciiToUnicodeIntegers()
Convert Ascii Thaana to an array of Unicode integers

- convertLatinToAscii()
Converts Dhivehi written in Latin to Thaana in . Use with the convertAsciiTo* functions to convert to Thaana script formats.

- convertAsciiToLatin()
Converts Dhivehi written in Ascii representation to Latinized Dhivehi.

## Usage
```php
<?php

// Load the class
require 'thaana_conversions.obj.php';

// Initialize the Thaana object
$thaana = new Thaana_Conversions();

// Example: Converting latin to ascii
echo $thaana->convertLatinToAscii('miadhakee haadha reethi dhuvahekeve.');

// Example: Converting ascii to latin
echo $thaana->convertAsciiToLatin('miawdwkI hWdw rIti duvwhekeve.');
?>
```

## Requirements
PHP 5

## License
This script is released under the Open Source MIT License, allowing its use in both personal and commercial applications as long as the copyright and license permission notice remains intact.
