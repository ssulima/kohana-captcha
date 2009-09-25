<?php defined('SYSPATH') OR die('No direct access.');
/**
 * Word captcha class.
 *
 * @package    Captcha
 * @author     Kohana Team
 * @copyright  (c) 2008-2009 Kohana Team
 * @license    http://kohanaphp.com/license.html
 */
class Kohana_Captcha_Word extends Kohana_Captcha_Basic {

	/**
	 * Generates a new Captcha challenge.
	 *
	 * @return  string  the challenge answer
	 */
	public function generate_challenge()
	{
		// Load words from the current language and randomize them
		$words = Kohana::config('captcha.words');
		shuffle($words);

		// Loop over each word...
		foreach ($words as $word)
		{
			// ...until we find one of the desired length
			if (abs(Captcha::$config['complexity'] - strlen($word)) < 2)
				return strtoupper($word);
		}
		
		$word = strtoupper($words[array_rand($words)]);

		// Store the correct Captcha response in a session
		Session::instance()->set('captcha_response', sha1($word));

		// Return any random word as final fallback
		return $word;
	}

} // End Captcha Word Driver Class