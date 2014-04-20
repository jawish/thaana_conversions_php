<?php

// {{{ Thaana format conversions

/**
 * Provides a number of functions for conversion/transliteration of text between various Thaana representation formats.
 *
 * This class currently provides the following functions:
 * 
 * convertUtf8ToUnicodeIntegers()
 * convertUtf8ToAscii()
 * convertUtf8ToEntities()
 * convertEntitiesToUnicodeIntegers()
 * convertEntitiesToUtf8
 * convertEntitiesToAscii()
 * convertUnicodeIntegersToUtf8()
 * convertUnicodeIntegersToEntities()
 * convertUnicodeIntegersToAscii()
 * convertAsciiToUtf8()
 * convertAsciiToEntities()
 * convertAsciiToUnicodeIntegers()
 * convertLatinToAscii()
 * convertAsciiToLatin()
 *
 * Usage:
 * $thaana = new ThaanaConversions();
 * echo $thaana->convertEntitiesToAscii('&#1931;&#1960;&#1928;&#1964;&#1920;&#1960;');
 * echo $thaana->convertAsciiToUtf8('rWacje');
 *
 *
 * @author Jawish Hameed
 * @link http://www.jawish.org/
 * @copyright  2009 Jawish Hameed
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 * @version Release: 0.4
 * @updated 29 Jan 2009
 */
class ThaanaConversions
{
	// {{{ properties
	
	/**
	 * Mapping for Ascii to Unicode
	 *
	 * @var array
	 *
	 * @access private
	 */
	private $mapAsciiToUnicode = array(	'h' => '1920', 'S' => '1921', 'n' => '1922', 'r' => '1923', 'b' => '1924', 'L' => '1925', 'k' => '1926', 'a' => '1927', 'v' => '1928', 'm' => '1929', 'f' => '1930', 'd' => '1931', 't' => '1932', 'l' => '1933', 'g' => '1934', 'N' => '1935', 's' => '1936', 'D' => '1937', 'z' => '1938', 'T' => '1939', 'y' => '1940', 'p' => '1941', 'j' => '1942', 'C' => '1943', 'X' => '1944', 'H' => '1945', 'K' => '1946', 'J' => '1947', 'R' => '1948', 'x' => '1949', 'B' => '1950', 'F' => '1951', 'Y' => '1952', 'Z' => '1953', 'A' => '1954', 'G' => '1955', 'q' => '1956', 'V' => '1957', 'w' => '1958', 'W' => '1959', 'i' => '1960', 'I' => '1961', 'u' => '1962', 'U' => '1963', 'e' => '1964', 'E' => '1965', 'o' => '1966', 'O' => '1967', 'c' => '1968', ',' => '1548', ';' => '1563', '?' => '1567', ')' => '0041', '(' => '0040', 'Q' => '65010');
	
	/**
	 * Mapping for Unicode to Ascii
	 *
	 * @var array
	 *
	 * @access private
	 */
	private $mapUnicodeToAscii;
	
	/**
	 * Mapping for Latin Thaana to Ascii
	 *
	 * @var array
	 *
	 * @access private
	 */
	private $mapLatinToAscii = array('a' => 'aw', 'aa' => 'aW', 'aajj' => 'acj', 'add' => 'aeDc', 'ah' => 'awSc', 'aha' => 'awhw', 'ari' => 'awri', 'au' => 'ao', 'b' => 'bc', 'ba' => 'bw', 'baa' => 'bW', 'bai' => 'bwai', 'baiy' => 'bwtc', 'be' => 'be', 'bee' => 'bI', 'bey' => 'bE', 'bi' => 'bi', 'bo' => 'bo', 'boo' => 'bU', 'bu' => 'bu', 'by' => 'bI', 'cha' => 'Cw', 'chaa' => 'CW', 'che' => 'Ce', 'cher' => 'Cwr', 'chey' => 'CE', 'chi' => 'Ci', 'cho' => 'Co', 'choo' => 'kU', 'ci' => 'si', 'co' => 'ko', 'd' => 'dc', 'da' => 'dW', 'da ' => 'dW', 'daa' => 'DW', 'dai' => 'Dwai', 'dee' => 'dI', 'dey' => 'Deac', 'dha' => 'dw', 'dhaa' => 'dW', 'dhe' => 'de', 'dhee' => 'dI', 'dhey' => 'dE', 'dhi' => 'di', 'dho' => 'do', 'dhoo' => 'dU', 'dhu' => 'du', 'di' => 'Di', 'do' => 'do', 'doo' => 'DU', 'du' => 'Du', 'dy' => 'dI', 'e' => 'ae', 'ee' => 'aI', 'eh' => 'aeac', 'evvi' => 'acvi', 'ey' => 'E', 'f' => 'fc', 'fa' => 'fw', 'faa' => 'fW', 'fah' => 'fwhc', 'fahe' => 'fwhI', 'fai' => 'fwai', 'faiy' => 'fwtc', 'fe' => 'fe', 'fee' => 'fI', 'fey' => 'fE', 'ff' => 'fc', 'ffi' => 'fi', 'fi' => 'fi', 'foor' => 'fUrc', 'foos' => 'fUsc', 'fu' => 'fu', 'fy' => 'fI', 'ga' => 'gw', 'gaa' => 'gW', 'gai' => 'gwai', 'ge' => 'ge', 'gee' => 'gI', 'gey' => 'gE', 'gha' => 'Gw', 'gi' => 'gi', 'giou' => 'jw', 'go' => 'go', 'goo' => 'gU', 'gu' => 'gu', 'h' => 'hc', 'ha' => 'hw', 'haa' => 'hW', 'hah' => 'hwSc', 'hai' => 'hwai', 'he' => 'he', 'hee' => 'hI', 'heed' => 'hIdc', 'heem' => 'hImc', 'heh' => 'heac', 'hey' => 'hE', 'hi' => 'hi', 'hoo' => 'hU', 'hu' => 'hu', 'hy' => 'hI', 'i' => 'ai', 'idh' => 'aidc', 'in' => 'ainc', 'j' => 'jc', 'ja' => 'jw', 'jaa' => 'jW', 'je' => 'je', 'jeed' => 'jIdc', 'jey' => 'jE', 'ji' => 'ji', 'jjey' => 'jE', 'jo' => 'jo', 'ju' => 'ju', 'k' => 'ku', 'ka' => 'kw', 'kaa' => 'kW', 'kah' => 'kwhc', 'kaiy' => 'kwtc', 'ke' => 'ke', 'kee' => 'kI', 'key' => 'kE', 'kh' => 'Kc', 'kha' => 'KW', 'khaa' => 'KW', 'khi' => 'Ki', 'ki' => 'ki', 'kka' => 'ackw', 'ko' => 'ko', 'koo' => 'kU', 'koor' => 'kUrc', 'ku' => 'ku', 'ky' => 'kI', 'l' => 'lc', 'la' => 'lw', 'laa' => 'lW', 'le' => 'le', 'lee' => 'lI', 'lev' => 'leac', 'ley' => 'lE', 'lha' => 'Lw', 'lhe' => 'Le', 'lhi' => 'Li', 'lhu' => 'Lu', 'li' => 'li', 'lla' => 'Q', 'loa' => 'lO', 'loo' => 'lU', 'lu' => 'lu', 'ly' => 'lI', 'm' => 'mc', 'ma' => 'mw', 'maa' => 'mW', 'me' => 'me', 'mee' => 'mI', 'mey' => 'mE', 'mi' => 'mi', 'mmai' => 'mWai', 'mo' => 'mo', 'moo' => 'mU', 'mu' => 'mu', 'mudh' => 'muac', 'my' => 'mI', 'n' => 'nc', 'na' => 'nw', 'na-' => 'nW', 'naa' => 'nW', 'nah' => 'nwSc', 'ne' => 'ne', 'nee' => 'nI', 'ney' => 'neac', 'ni' => 'ni', 'noo' => 'nU', 'nu' => 'nu', 'ny' => 'nI', 'o' => 'ao', 'of' => 'fo', 'oiy' => 'aotc', 'oo' => 'aU', 'p' => 'pc', 'pa' => 'pw', 'paa' => 'pW', 'pe' => 'pe', 'po' => 'po', 'py' => 'pI', 'q' => 'gc', 'qa' => 'qw', 'qaa' => 'qW', 'qee' => 'qI', 'qy' => 'qI', 'r' => 'rc', 'ra' => 'rw', 'raa' => 'rW', 'rah' => 'rwSc', 're' => 're', 'ree' => 'rI', 'rey' => 'rE', 'ri' => 'ri', 'ro' => 'ro', 'roo' => 'rU', 'roof' => 'rUfc', 'roon' => 'rUnc', 'rra' => 'rw', 'ru' => 'ru', 'ry' => 'rI', 's' => 'sc', 'sa' => 'sw', 'saa' => 'sW', 'se' => 'se', 'see' => 'sI', 'sey' => 'sE', 'sh' => 'xc', 'sha' => 'xw', 'shaa' => 'xW', 'she' => 'Se', 'shee' => 'xI', 'shey' => 'SE', 'shi' => 'xi', 'shu' => 'xu', 'si' => 'si', 'sion' => 'xwnc', 'so' => 'so', 'soo' => 'sU', 'ss' => 'sc', 'ssa' => 'swac', 'ssan' => 'swnc', 'ssy' => 'sI', 'su' => 'su', 'suf' => 'sufc', 'sy' => 'sI', 't' => 'Tc', 'ta' => 'Tw', 'te' => 'Te', 'tea' => 'TI', 'tee' => 'TI', 'th' => 't', 'tha' => 'tw', 'thaa' => 'tW', 'thah' => 'twac', 'thee' => 'tI', 'thi' => 'ti', 'tho' => 'to', 'thu' => 'tu', 'thy' => 'tI', 'too' => 'TU', 'ttaa' => 'acTW', 'tte' => 'acTe', 'u' => 'au', 'uddi' => 'acdi', 'va' => 'vw', 'vaa' => 'vW', 've' => 've', 'vee' => 'vI', 'vi' => 'vi', 'vo' => 'vo', 'vu' => 'vu', 'vva' => 'acvw', 'vvaa' => 'acvW', 'w' => 'au', 'wa' => 'vw', 'waa' => 'vW', 'wi' => 'vi', 'ya' => 'yw', 'yaa' => 'yW', 'ye' => 'ye', 'yeve' => 'yeve', 'yo' => 'yo', 'yoo' => 'yU', 'yu' => 'yu', 'yya' => 'acyw', 'yyaa' => 'acyW', 'yye' => 'acye', 'yyoo' => 'acyU', '0' => '0', 'z' => 'zc', 'za' => 'zw', 'zee' => 'zI', 'zi' => 'zi', 'zoo' => 'zU', 'zu' => 'zu', 'zy' => 'zI');
	
	/**
	 * Mapping for Ascii to Latin Thaana
	 *
	 * @var array
	 *
	 * @access private
	 */
	private $mapAsciiToLatin;
	
	// }}}
	// {{{ Class constructor
	
	/**
	 * Initializes the class by preparing internal variables
	 *
	 */
	public function __construct()
	{
		// Prepare the Unicode to Ascii translation map
		$this->mapUnicodeToAscii = array_flip($this->mapAsciiToUnicode);
		
		// Prepare the Ascii to Latin translation map
		$this->mapAsciiToLatin = array_flip($this->mapLatinToAscii);
	}
	
	// }}}
	// {{{ convertAsciiToUnicodeIntegers()
	
	/**
	 * Convert Ascii Thaana to an array of Unicode integers
	 *
	 * @param	string	$text		String Ascii text to convert
	 * @return	array		Array Unicode integer representations
	 */
	public function convertAsciiToUnicodeIntegers($input)
	{
		$output = array();
		
		// Loop through the chars in the text string
		for ($i = 0; $i < strlen($input); $i++) {
			
			// Check if the Ascii to Unicode lookup table defines the char code
			if (isset($this->mapAsciiToUnicode[$input[$i]])) {
				// Definition for char exists:
				
				// Add the looked-up code value to the output array
				array_push($output, $this->mapAsciiToUnicode[$input[$i]]);
				
			} else {
				// No definition for char:
				
				// Add char directly to output array
				array_push($output, ord($input[$i]));
			}
		}
		
		// Return converted text
		return $output;
	}
	
	// }}}
	// {{{ convertAsciiToEntities()
	
	/**
	 * Convert Ascii Thaana to Unicode HTML entities
	 *
	 * @param	string	$text		String Ascii text to convert
	 * @return	string		String converted HTML entities
	 */
	public function convertAsciiToEntities($text)
	{
		// Convert Ascii thaana into Unicode Integers
		$text = $this->convertAsciiToUnicodeIntegers($text);
		
		// Convert the Unicode Integers to Unicode HTML entities
		return $this->convertUnicodeIntegersToEntities($text);
	}
	
	// }}}
	// {{{ convertAsciiToUtf8()
	
	/**
	 * Convert Ascii Thaana to UTf-8
	 *
	 * @param	string	$text		String Ascii text to convert
	 * @return	string		String converted UTF-8 data
	 */
	public function convertAsciiToUtf8($text)
	{
		// Convert Ascii thaana into Unicode Integers
		$text = $this->convertAsciiToUnicodeIntegers($text);
		
		// Convert the Unicode Integers to Unicode HTML entities
		return $this->convertUnicodeIntegersToUtf8($text);
	}
	
	// }}}
	// {{{ convertUnicodeIntegersToAscii()
	
	/**
	 * Convert Unicode char integers to Ascii
	 *
	 * @param	mixed	$input		Integer or integer array to convert
	 * @return	string				String converted Ascii output
	 */
	public function convertUnicodeIntegersToAscii($input)
	{
		$output = '';
		
		// Force input to array if not already array
		if (!is_array($input)) $input = array($input);
		
		// Loop through input Unicode Integers array
		foreach ($input as $key => $char) {
			
			// Check if Unicode to Ascii mapping exists for char
			if (isset($this->mapUnicodeToAscii[$char])) {
				// Char mapping exists:
				
				// Get the mapped ASCII for the char and append to output
				$output .= $this->mapUnicodeToAscii[$char];
				
			} else {
				// Char is not mapped:
				
				// Convert char to ASCII and append to output
				$output .= chr($char);
			}
		}
		
		return $output;
	}
	
	// }}}
	// {{{ convertUnicodeIntegersToEntities()
	
	/**
	 * Convert Unicode char integers to HTML entities
	 *
	 * @param	mixed	$input		Integer or integer array to convert
	 * @return	string				String converted HTML entitied output
	 */
	public function convertUnicodeIntegersToEntities($input)
	{
		$output = '';
		
		// Force input to array if not already array
		if (!is_array($input)) $input = array($input);
		
		// Ensure argument is an array
		if (is_array($input)) {
			
			// Loop through each character
			foreach ($input as $key => $char) {
				
				// Convert char to HTML entity if is in Unicode range, convert to ASCII otherwise
				$output .= ($char < 256) ? chr($char) : '&#' . $char . ';';
			}
		}
		
		// Return output
		return $output;
	}
	
	// }}}
	// {{{ convertUnicodeIntegersToUtf8()
	
	/**
	 * Convert Unicode Integer array to UTF
	 *
	 * Adapted from original code by Scott Reynen on http://www.randomchaos.com/
	 *
	 * @param array	$text	Array of integer Unicode char representations
	 * @return string		String converted text in UTF
	 */
	public function convertUnicodeIntegersToUtf8($input)
	{
		$output = '';
		
		// Force input to array if not already array
		if (!is_array($input)) $input = array($input);
		
		// Loop through the input unicode char integers array
		foreach ($input as $char) {
			
			// Check char byte length
			if ($char < 128) {
				// Char is 1 byte, i.e. standard ASCII:
				
				// Convert to char and add to output
				$output.= chr($char);
				
			} elseif ($char < 2048) {
				// Char is 2 bytes:
				
				// Convert to char and add to output
				$output.= chr(192 + (($char - ($char % 64)) / 64));
				$output.= chr(128 + ($char % 64));
				
			} else {
				// Char is 3 bytes:
				
				// Convert to char and add to output
				$output.= chr(224 + (($char - ($char % 4096)) / 4096));
				$output.= chr(128 + ((($char % 4096) - ($char % 64)) / 64));
				$output.= chr(128 + ($char % 64));
			}
		}
		
		// Return output
		return $output;
	}
	
	// }}}
	// {{{ convertEntitiesToAscii()
	
	/**
	 * Convert HTML Unicode entities to Dhivehi Ascii equivalents
	 *
	 * @param	string $text	String with HTML encoded Unicode in Thaana range
	 * @return	string			String with the converted Ascii output
	 */
	public function convertEntitiesToAscii($input)
	{
		// Replace Unicode entities with Ascii equivalents
		$input = preg_replace_callback('/&#([0-9]+);/U', array(&$this, 'getAsciiChar'), $input);
		
		// Fix the numerics and return final output
		return $this->reverseNumerics($input);
	}
	
	// }}}
	// {{{ convertEntitiesToUtf8()
	
	/**
	 * Convert HTML Unicode entities to UTF-8
	 *
	 * @param	string $text	String with HTML encoded Unicode in Thaana range
	 * @return	string			String with the converted Utf8 output
	 */
	public function convertEntitiesToUtf8($input)
	{
		// Replace numeric entities
		$input = preg_replace_callback('/(?:&#([0-9]+);)/U', array(&$this, 'getUtf8Char'), $input);
		
		// Return output
		return $input;
	}
	
	// }}}
	// {{{ convertEntitiesToUnicodeIntegers()
	
	/**
	 * Convert HTML Unicode entitied string to Unicode Integer characters array
	 *
	 * @param	string $text	String with HTML encoded Unicode in Thaana range
	 * @return	array			Array with the converted Unicode integer character representation
	 */
	public function convertEntitiesToUnicodeIntegers($input)
	{
		// Convert entities to utf8
		$input = $this->convertEntitiesToUtf8($input);
		
		// Convert utf8 to unicode integers
		$input = $this->convertUtf8ToUnicodeIntegers($input);
		
		// Return output
		return $input;
	}
	
	// }}}
	// {{{ convertUtf8ToAscii()
	
	/**
	 * Convert UTF-8 data to Ascii
	 *
	 * @param	string	$text		String UTF-8 text to convert
	 * @return	string				String output in Ascii
	 */
	public function convertUtf8ToAscii($text)
	{
		$text = $this->convertUtf8ToUnicodeIntegers($text);
		$text = $this->convertUnicodeIntegersToAscii($text);
		return strrev($text);
	}
	
	// }}}
	// {{{ convertUtf8ToEntities()
	
	/**
	 * Convert UTF-8 data to Unicode Entities
	 *
	 * @param	string	$text		String UTF-8 text to convert
	 * @return	string				String output as Unicode Entities
	 */
	public function convertUtf8ToEntities($text)
	{
		// Temporarily convert text to unicode integers
		$text = $this->convertUtf8ToUnicodeIntegers($text);
		
		// Convert unicode integers into entities and return
		return $this->convertUnicodeIntegersToEntities($text);
	}
	
	// }}}
	// {{{ convertUtf8ToUnicodeIntegers()
	
	/**
	 * Convert UTF-8 data to Unicode character integer representations
	 *
	 * Adapted from original code by Scott Reynen on http://www.randomchaos.com/
	 *
	 * @param	string	$text		String UTF-8 text to convert
	 * @return	array				Array Unicode integer representations
	 */
	public function convertUtf8ToUnicodeIntegers($input)
	{
		$output = array();
		$temp = array();
		$lookingFor = 1;
		
		for ($i = 0; $i < strlen($input); $i++) {
			
			// Get the char code for the current char
			$charcode = ord($input[$i]);
			
			// Check char value
			if ($charcode < 128) {
				// Char is 1 byte, i.e. standard ASCII:
				
				// Add char to output
				$output[] = $charcode;
				
			} else {
				// Char takes 2 or 3 bytes, i.e extended ASCII and Unicode:
				
				// Get expected length of char
				if (count($temp) == 0) $lookingFor = ($charcode < 224) ? 2 : 3;
				
				// Add char code to temp storage
				$temp[] = $charcode;
				
				// Check if current char code has reached it's required length
				if (count($temp) == $lookingFor) {
					// Required length reached:
					
					// Build multibyte char code
					if ($lookingFor == 3) {
						$number = (($temp[0] % 16) * 4096) + (($temp[1] % 64) * 64) + ($temp[2] % 64);
					} else {
						$number = (($temp[0] % 32) * 64) + ($temp[1] % 64);
					}
					
					// Add char to output
					$output[] = $number;
					
					// Reset char code store anc status
					$temp = array();
					$lookingFor = 1;
				}
			}
		}
		
		// Return output
		return $output;
	}

	// }}}
	// {{{ convertLatinToAscii()
	
	/**
	 * Convert Latin Thaana (i.e Thaana transliterated into English) to Ascii Thaana
	 *
	 * Note: The algorithm used here is not context-aware and uses special lookup tables 
	 * constructed from the analysis of a small corpus. Errors are to be expected.
	 *
	 * @param	string	$input		String Latin Thaana text to convert
	 * @return	string				String output Ascii Thaana representation
	 */
	public function convertLatinToAscii($input)
	{		
		$output = '';
		$i = 0;
		
		// Standardize input to lowercase
		$input = strtolower($input);
		
		while ($i < strlen($input)) {
			
			$found = false;
			
			// Loop through combination lengths
			for ($c = 4; $c > 0; $c--) {
				
				// Get combination
				$comb = substr($input, $i, $c);
				
				// Make sure combination is defined
				if (isset($this->mapLatinToAscii[$comb])) {
					
					// Transliterate using the definition
					$output .= $this->mapLatinToAscii[$comb];
					
					// Move onto next combination
					$found = true;
					$i += $c;
					break;
				}
			}
			
			// Check if there was transliteration failure
			if ($found == false) {
				
				// Add combination to output directly
				$output .= substr($input, $i, 1);
				$i++;
			}
		}
		
		// Return output
		return $output;
	}
	
	// }}}
	// {{{ convertAsciiToLatin()
	
	/**
	 * Convert Ascii Thaana to Latin Thaana (i.e Thaana transliterated into English)
	 *
	 * Note: The algorithm used here is not context-aware and uses special lookup tables 
	 * constructed from the analysis of a small corpus. Errors are to be expected.
	 *
	 * @param	string	$input		String Ascii Thaana text to convert
	 * @return	string				String output Latin Thaana representation
	 */
	public function convertAsciiToLatin($input)
	{		
		$output = '';
		$i = 0;
				
		while ($i < strlen($input)) {
			
			$found = false;
			
			// Loop through combination lengths
			for ($c = 4; $c > 0; $c--) {
				
				// Get combination
				$comb = substr($input, $i, $c);
				
				// Make sure combination is defined
				if (isset($this->mapAsciiToLatin[$comb])) {
					
					// Transliterate using the definition
					$output .= $this->mapAsciiToLatin[$comb];
					
					// Move onto next combination
					$found = true;
					$i += $c;
					break;
				}
			}
			
			// Check if there was transliteration failure
			if ($found == false) {
				
				// Add combination to output directly
				$output .= substr($input, $i, 1);
				$i++;
			}
		}
		
		// Return output
		return $output;
	}
	
	// }}}
	// {{{ getAsciiChar()
	
	/**
	 *  Helper function to get the Unicode equivalent for a character in ASCII
	 *
	 * This is a helper function used by the convertUnicodeIntegersToAscii() function
	 *
	 * @param	string $key		Char in unicode
	 * @return	string			String with Unicode character code
	 *
	 * @access private
	 */
	private function getAsciiChar($key)
	{
		return ($this->mapUnicodeToAscii[$key[1]]) ? $this->mapUnicodeToAscii[$key[1]] : $key[1];
	}
	
	// }}}
	// {{{
	
	/**
	 * Return the UTF-8 char for a given Unicode char integer specification
	 *
	 * This is a helper function used by the convertEntitiesToUtf8() function
	 *
	 * @param	integer	$code	Integer char code
	 * @return	string			String UTF-8 char
	 *
	 * @access private
	 */
	private function getUtf8Char($code)
	{
		return $this->convertUnicodeIntegersToUtf8($code[1]);
	}
	// }}}
	// {{{ reverseNumerics()
	
	/**
	 * Fix the numeric display order in the text from right-to-left to left-to-right
	 *
	 * @param	string	$text	String with the text to fix numerics
	 * @return	string			String with the numerics fixed text
	 *
	 * @access private
	 */
	private function reverseNumerics($text)
	{
		return preg_replace_callback(
					'/\b[0-9\.,:]+/',
					create_function('$matches', 'return strrev($matches[0]);'),
					$text
				);
	}
	
	// }}}
	
}

// }}}

?>
