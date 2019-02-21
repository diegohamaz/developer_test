<?php
	class Elleven
	{

		var $alphabet = array
		(
			'traditional' => 	 array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t'/*,'u','v','w','x','y','z'*/),
            'booglan' =>         array('t','w','h','z','k','d','f','v','c','j','x','l','r','n','q','m','g','p','s','b')

		);
        var $foo = array('r','t','c','d','b');
		var $bar = array('v','f','k','p','h','q','l','w','n','s','g','x','j','m','z');

		/**
		* @param string $string
		* @return integer
		* @access public
		*/

		function countPrepositions($string)
		{
			$foo = implode('', $this->foo);
			$bar = implode('', $this->bar);
			$bar = str_replace('l', null, $bar);

			preg_match_all("/\b([$foo$bar]{2}[^l$foo])\b/", $string, $prepositions);

			return count($prepositions[0]);
		}

    	 /**
		 * @param string $string
		 * @param boolean $firstPerson
		 * @return integer
		 * @access public
		 */

		function countVerbs($string, $firstPerson = false)
		{
			$foo = implode('', $this->foo);
			$bar = implode('', $this->bar);

			if ($firstPerson)
			{
				preg_match_all("/\b([$foo][$foo$bar]{6}[$foo$bar]*[$bar])\b/", $string, $verbs);
			}
			else
			{
				preg_match_all("/\b([$foo$bar]{7}[$foo$bar]*[$bar])\b/", $string, $verbs);
			}

			return count($verbs[0]);
		}

		/**
		 * @param string $string
		 * @return string
		 * @access public
		 */

		function listVocabulary($string)
		{
			$vocabulary = $this->convertString('booglan', 'traditional', $string);

			$vocabulary = explode(' ', $vocabulary);

			$vocabulary = array_unique($vocabulary);

			sort($vocabulary);

			$vocabulary = implode(' ', $vocabulary);

			$vocabulary = $this->convertString('traditional', 'booglan', $vocabulary);

			return $vocabulary;
		}

       	/**
		 * @param string $from
		 * @param string $to
		 * @param string $string
		 * @return string
		 * @access private
		 */

		private function convertString($from, $to, $string)
		{
			$letter = array_combine($this->alphabet[$from], $this->alphabet[$to]);

			$letters = str_split($string);

			foreach ($letters as $key => $value)
			{
				if (isset($letter[$value]))
				{
					$letters[$key] = $letter[$value];
				}
			}

			return implode('', $letters);
		}

		/**
		 * @param string $string
		 * @return integer
		 * @access public
		 */

		function prettyNumbers($string)
		{
			$words = explode(' ', $string);

			$numbers = array();

			foreach ($words as $word)
			{
				$letters = str_split($word);

				for ($i = 0, $number = 0; $i < count($letters); $i++)
				{
					$number += array_search($letters[$i], $this->alphabet['booglan']) * pow(20, $i);
				}

				if ($number >= 422224 and ($number % 3) == 0)
				{
					$numbers[$word] = $number;
				}
			}

			$numbers = array_unique($numbers);

			return count($numbers);
		}
	}
