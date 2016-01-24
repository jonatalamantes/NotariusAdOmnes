<?php 

    require_once(__DIR__."/LanguageSupport.php");

    /**
    * A Class to display bible quotes
    *
    * @author Jonathan Sandoval <[jonathan_s_pisis@yahoo.com.mx]>
    */
    class BibleQuote
    {
        /**
         * Generate a random quote from the holy bible
         * @author Jonathan Sandoval <[jonathan_s_pisis@yahoo.com.mx]>
         * 
         * @return string  The random quote
         */
        static function randomQuote()
        {
            $book       = rand(1,73);
            $chapter    = rand(1, self::maximumChapters($book));
            $verse      = rand(1, 40);
            $amount     = 1;

            return self::findInBible($book, $chapter, $verse, $amount);
        }

        /**
         * Recover all text from one book from the holy bible
         * @author Jonathan Sandoval <[jonathan_s_pisis@yahoo.com.mx]>
         * 
         * @param  integer $book   The number of the book
         * @param  string  $myLang The language to recover the book
         * @return string          The full text from the book        
         */
        static function getBookText($book = 1, $myLang = '')
        {
            if ($myLang == 'es')
            {
                $path = __DIR__."/Biblia/BIBLIA.txt";

                if (!file_exists($path))
                {
                    exit("Biblia no encontrada");
                }

                $file     = fopen($path, "r");
                $inBook   = false;
                $bookName = self::numberBookToName($book);
                $nextBook = self::numberBookToName($book + 1);
                $text     = "";

                if ($file) 
                {
                    while (($line = fgets($file)) !== false) 
                    {
                        if (mb_strpos($line, $bookName) !== false && $inBook == false) //being book
                        {
                            $inBook = true;
                            continue;
                        }

                        if ($inBook) //Inside the book
                        {                        
                            $finalBook = LanguageSupport::getLang("Nothing");
                            $previusBook = LanguageSupport::getLang("Ecclesiasticus");

                            if (($nextBook == $finalBook && $bookName != $previusBook) || 
                                 mb_strpos($line, $nextBook) !== false) //booḱ's end
                            {
                                break;
                            }
                            else 
                            {
                                $text = $text . "$line<br>";
                            }                
                        }
                    }

                    fclose($file);
                }

                return $text;
            }
            else if ($myLang == 'en')
            {
                $bookName = self::numberBookToName($book);
                $path = __DIR__."/Biblia/BIBLE/" . $bookName . ".txt";

                if (!file_exists($path))
                {
                    exit("Bible not found");
                }

                $file = fopen($path, "r");
                $text = "";

                if ($file) 
                {
                    while (($line = fgets($file)) !== false) 
                    {
                        $text = $text . "$line<br>";
                    }

                    fclose($file);
                }

                return $text; 
            }
        }    

        /**
         * Check if the current search is correct and return a correct verse number
         * @author Jonathan Sandoval <[jonathan_s_pisis@yahoo.com.mx]>
         * 
         * @param  integer $book    The number of Book
         * @param  integer $chapter The number of Charapter
         * @param  integer $verse   The number of Verse
         * @return integer          A valid numberic verse
         */
        static function nextVerse($book = 1, $chapter = 1, $verse = 1)
        {
            $prevLang = LanguageSupport::getActualLanguage();
            
            //getting the text of the book
            LanguageSupport::changeLanguage('en');
            $text = self::getBookText($book, 'en');
            LanguageSupport::changeLanguage($prevLang);

            //find the verse
            $verseNotation = "{" . $chapter . ":" . $verse . "}";

            $vers = $verse;
            $posVerse = false;

            while ($posVerse === false && $vers > 0)
            {
                //Eval verse
                $posVerse = stripos($text, $verseNotation);

                if ($posVerse === false)
                {
                    //update vers
                    $vers = round($vers/2);
                    $verseNotation = "{" . $chapter . ":" . $vers . "}";
                }
            }

            return $vers;
        }

        /**
         * Return a piece from the holy bible
         * @author Jonathan Sandoval <[jonathan_s_pisis@yahoo.com.mx]>
         * 
         * @param  integer $book    The number of Book
         * @param  integer $chapter The number of Charapter
         * @param  integer $verse   The number of Verse
         * @param  integer $amount  The amount of Verses to display
         * @return string           The piece from the holy bible           
         */
        static function findInBible($book = 1, $chapter = 1, $verse = 1, $amount = 1)
        {
            $text = "";

            $lastVerse = intval(self::nextVerse($book, $chapter, intval($amount + $verse)));
            $firstVerse = intval($lastVerse) - intval($amount);

            for ($i = $firstVerse; $i < $lastVerse; $i++)
            {
                $news = self::findVerse($book, $chapter, $i);

                if (strpos($text, $news) === false)
                {
                    $text = $text . " " . self::findVerse($book, $chapter, $i);
                }
            }

            if ($amount != 1)
            {
                return $text . " (". self::numberBookToName($book). " $chapter: " . 
                                strval($firstVerse) ."-" .  strval($lastVerse). ")<br>"; 
            }
            else
            {
                return $text. " (". self::numberBookToName($book). " $chapter: $firstVerse)<br>"; 
            }
        }

        /**
         * Recover a specific verse from the holy bible
         * @author Jonathan Sandoval <[jonathan_s_pisis@yahoo.com.mx]>
         * 
         * @param  integer $book    The number of Book
         * @param  integer $chapter The number of Chapter
         * @param  integer $verse   The number of Verse
         * @return string           The Current verse
         */
        static function findVerse($book = 1, $chapter = 1, $verse = 1)
        {   
            $myLang = LanguageSupport::getActualLanguage();

            if ($myLang == 'es')
            {
                //getting the book's text
                $text = self::getBookText($book, $myLang);

                //find the chapter
                $chapterNombre = self::numberBookToName($book) . " $chapter";
                $posInicio = stripos($text, $chapterNombre);

                //cut since the beggin
                $inicioCapitulo  = substr($text, $posInicio + strlen($chapterNombre)); 

                //Eval verse
                $vers = $verse;

                $posVerse = stripos($inicioCapitulo, strval($vers));
                $text = substr($inicioCapitulo, $posVerse);

                $vers = $vers + 1;
                $posVerse = stripos($text, strval($vers));
                $text = substr($text, 0, $posVerse);

                //remove until the point
                $posPoint = strpos($text, ".");

                if ($posPoint === false)
                {
                    $text = substr($text, strlen(strval($verse)));
                }
                else
                {
                    $text = substr($text, strlen(strval($verse)), $posPoint);
                }

                $text = str_replace("<br>", " ", $text);

                return $text;          
            }
            else if ($myLang == 'en')
            {
                //getting the book's text
                $text = self::getBookText($book, 'en');

                //find verse
                $verseNotation = "{" . $chapter . ":" . $verse . "}";

                $posVerse = stripos($text, $verseNotation);
                $text = substr($text, $posVerse + strlen($verseNotation));

                //remove until the key
                $posKey = strpos($text, "{");

                if ($posPoint !== false)
                {
                    $text = substr($text, 0, $posKey);
                }

                //remove until the point
                $posPoint = strpos($text, ".");

                if ($posPoint !== false)
                {
                    $text = substr($text, 0, $posKey);
                }

                $text = str_replace("<br>", " ", $text);

                return $text;
            }  

        }

        /**
         * Recover the total of chapter from one book
         * @author Jonathan Sandoval <[jonathan_s_pisis@yahoo.com.mx]>
         * 
         * @param  integer $number   The book number
         * @return integer           The Chapter total
         */
        static function maximumChapters($number = 1)
        {
            if ($number == 1) 
            {
                return 50;
            }
            else if ($number == 2)
            {
                return 40;
            }
            else if ($number == 3)
            {
                return 27;
            }
            else if ($number == 4)
            {
                return 36;
            }
            else if ($number == 5)
            {
                return 34;
            }
            else if ($number == 6)
            {
                return 24;
            }
            else if ($number == 7)
            {
                return 21;
            }
            else if ($number == 8)
            {
                return 4;
            }
            else if ($number == 9)
            {
                return 31;
            }
            else if ($number == 10)
            {
                return 24;
            }
            else if ($number == 11)
            {
                return 22;
            }
            else if ($number == 12)
            {
                return 25;
            }
            else if ($number == 13)
            {
                return 29;
            }
            else if ($number == 14)
            {
                return 36;
            }
            else if ($number == 15)
            {
                return 10;
            }
            else if ($number == 16)
            {
                return 13;
            }
            else if ($number == 17)
            {
                return 10;
            }
            else if ($number == 18)
            {
                return 42;
            }
            else if ($number == 19)
            {
                return 150;
            }
            else if ($number == 20)
            {
                return 31;
            }
            else if ($number == 21)
            {
                return 12;
            }
            else if ($number == 22)
            {
                return 8;
            }
            else if ($number == 23)
            {
                return 66;
            }
            else if ($number == 24)
            {
                return 52;
            }
            else if ($number == 25)
            {
                return 5;
            }
            else if ($number == 26)
            {
                return 48;
            }
            else if ($number == 27)
            {
                return 14;
            }
            else if ($number == 28)
            {
                return 14;
            }
            else if ($number == 29)
            {
                return 3;
            }
            else if ($number == 30)
            {
                return 9;
            }
            else if ($number == 31)
            {
                return 1;
            }
            else if ($number == 32)
            {
                return 4;
            }
            else if ($number == 33)
            {
                return 7;
            }
            else if ($number == 34)
            {
                return 3;
            }
            else if ($number == 35)
            {
                return 3;
            }
            else if ($number == 36)
            {
                return 3;
            }
            else if ($number == 37)
            {
                return 2;
            }
            else if ($number == 38)
            {
                return 14;
            }
            else if ($number == 39)
            {
                return 4;
            }
            else if ($number == 40)
            {
                return 28;
            }
            else if ($number == 41)
            {
                return 16;
            }
            else if ($number == 42)
            {
                return 24;
            }
            else if ($number == 43)
            {
                return 21;
            }
            else if ($number == 44)
            {
                return 28;
            }
            else if ($number == 45)
            {
                return 16;
            }
            else if ($number == 46)
            {
                return 16;
            }
            else if ($number == 47)
            {
                return 13;
            }
            else if ($number == 48)
            {
                return 6;
            }
            else if ($number == 49)
            {
                return 6;
            }
            else if ($number == 50)
            {
                return 4;
            }
            else if ($number == 51)
            {
                return 4;
            }
            else if ($number == 52)
            {
                return 5;
            }
            else if ($number == 53)
            {
                return 3;
            }
            else if ($number == 54)
            {
                return 6;
            }
            else if ($number == 55)
            {
                return 4;
            }
            else if ($number == 56)
            {
                return 3;
            }
            else if ($number == 57)
            {
                return 1;
            }
            else if ($number == 58)
            {
                return 13;
            }
            else if ($number == 59)
            {
                return 5;
            }
            else if ($number == 60)
            {
                return 5;
            }
            else if ($number == 61)
            {
                return 3;
            }
            else if ($number == 62)
            {
                return 5;
            }
            else if ($number == 63)
            {
                return 1;
            }
            else if ($number == 64)
            {
                return 1;
            }
            else if ($number == 65)
            {
                return 1;
            }
            else if ($number == 66)
            {
                return 22;
            }
            else if ($number == 67)
            {
                return 14;
            }
            else if ($number == 68)
            {
                return 16;
            }
            else if ($number == 69)
            {
                return 15;
            }
            else if ($number == 70)
            {
                return 19;
            }
            else if ($number == 71)
            {
                return 16;
            }
            else if ($number == 72)
            {
                return 5;
            }
            else if ($number == 73)
            {
                return 51;
            }
            else 
            {                
                return 1;
            }   
        }

        /**
         * Convetion between the the number of Book and the name of that book
         * @author Jonathan Sandoval <[jonathan_s_pisis@yahoo.com.mx]>
         * 
         * @param  integer $number   The number of book
         * @return string            The name of that book
         */
        static function numberBookToName($number = 1)
        {
            if ($number > 0 && $number < 74)
            {
                if ($number == 1)
                {
                    return LanguageSupport::getLang('Genesis');
                }
                else if ($number == 2)
                {
                    return LanguageSupport::getLang('Exodus');
                }
                else if ($number == 3)
                {
                    return LanguageSupport::getLang('Leviticus');
                }
                else if ($number == 4)
                {
                    return LanguageSupport::getLang('Numbers');
                }
                else if ($number == 5)
                {
                    return LanguageSupport::getLang('Deuteronomy');
                }
                else if ($number == 6)
                {
                    return LanguageSupport::getLang('Joshua');
                }
                else if ($number == 7)
                {
                    return LanguageSupport::getLang('Judges');
                }
                else if ($number == 8)
                {
                    return LanguageSupport::getLang('Ruth');
                }
                else if ($number == 9)
                {
                    return LanguageSupport::getLang('1 Samuel');
                }
                else if ($number == 10)
                {
                    return LanguageSupport::getLang('2 Samuel');
                }
                else if ($number == 11)
                {
                    return LanguageSupport::getLang('1 Kings');
                }
                else if ($number == 12)
                {
                    return LanguageSupport::getLang('2 Kings');
                }
                else if ($number == 13)
                {
                    return LanguageSupport::getLang('1 Chronicles');
                }
                else if ($number == 14)
                {
                    return LanguageSupport::getLang('2 Chronicles');
                }
                else if ($number == 15)
                {
                    return LanguageSupport::getLang('Ezra');
                }
                else if ($number == 16)
                {
                    return LanguageSupport::getLang('Nehemiah');
                }
                else if ($number == 17)
                {
                    return LanguageSupport::getLang('Esther');
                }
                else if ($number == 18)
                {
                    return LanguageSupport::getLang('Job');
                }
                else if ($number == 19)
                {
                    return LanguageSupport::getLang('Psalms');
                }
                else if ($number == 20)
                {
                    return LanguageSupport::getLang('Proverbs');
                }
                else if ($number == 21)
                {
                    return LanguageSupport::getLang('Ecclesiastes');
                }
                else if ($number == 22)
                {
                    return LanguageSupport::getLang('Song of Salomon');
                }
                else if ($number == 23)
                {
                    return LanguageSupport::getLang('Isaiah');
                }
                else if ($number == 24)
                {
                    return LanguageSupport::getLang('Jeremiah');
                }
                else if ($number == 25)
                {
                    return LanguageSupport::getLang('Lamentations');
                }
                else if ($number == 26)
                {
                    return LanguageSupport::getLang('Ezekiel');
                }
                else if ($number == 27)
                {
                    return LanguageSupport::getLang('Daniel');
                }
                else if ($number == 28)
                {
                    return LanguageSupport::getLang('Hosea');
                }
                else if ($number == 29)
                {
                    return LanguageSupport::getLang('Joel');
                }
                else if ($number == 30)
                {
                    return LanguageSupport::getLang('Amos');
                }
                else if ($number == 31)
                {
                    return LanguageSupport::getLang('Obadiah');
                }
                else if ($number == 32)
                {
                    return LanguageSupport::getLang('Jonah');
                }
                else if ($number == 33)
                {
                    return LanguageSupport::getLang('Micah');
                }
                else if ($number == 34)
                {
                    return LanguageSupport::getLang('Nahum');
                }
                else if ($number == 35)
                {
                    return LanguageSupport::getLang('Habakkuk');
                }
                else if ($number == 36)
                {
                    return LanguageSupport::getLang('Zephaniah');
                }
                else if ($number == 37)
                {
                    return LanguageSupport::getLang('Haggai');
                }
                else if ($number == 38)
                {
                    return LanguageSupport::getLang('Zechariah');
                }
                else if ($number == 39)
                {
                    return LanguageSupport::getLang('Malachi');
                }
                else if ($number == 40)
                {
                    return LanguageSupport::getLang('Matthew');
                }
                else if ($number == 41)
                {
                    return LanguageSupport::getLang('Mark');
                }
                else if ($number == 42)
                {
                    return LanguageSupport::getLang('Luke');
                }
                else if ($number == 43)
                {
                    return LanguageSupport::getLang('John');
                }
                else if ($number == 44)
                {
                    return LanguageSupport::getLang('Acts');
                }
                else if ($number == 45)
                {
                    return LanguageSupport::getLang('Romans');
                }
                else if ($number == 46)
                {
                    return LanguageSupport::getLang('1 Corinthians');
                }
                else if ($number == 47)
                {
                    return LanguageSupport::getLang('2 Corinthians');
                }
                else if ($number == 48)
                {
                    return LanguageSupport::getLang('Galatians');
                }
                else if ($number == 49)
                {
                    return LanguageSupport::getLang('Ephesians');
                }
                else if ($number == 50)
                {
                    return LanguageSupport::getLang('Philippians');
                }
                else if ($number == 51)
                {
                    return LanguageSupport::getLang('Colossians');
                }
                else if ($number == 52)
                {
                    return LanguageSupport::getLang('1 Thessalonians');
                }
                else if ($number == 53)
                {
                    return LanguageSupport::getLang('2 Thessalonians');
                }
                else if ($number == 54)
                {
                    return LanguageSupport::getLang('1 Timothy');
                }
                else if ($number == 55)
                {
                    return LanguageSupport::getLang('2 Timothy');
                }
                else if ($number == 56)
                {
                    return LanguageSupport::getLang('Titus');
                }
                else if ($number == 57)
                {
                    return LanguageSupport::getLang('Philemon');
                }
                else if ($number == 58)
                {
                    return LanguageSupport::getLang('Hebrews');
                }
                else if ($number == 59)
                {
                    return LanguageSupport::getLang('James');
                }
                else if ($number == 60)
                {
                    return LanguageSupport::getLang('1 Peter');
                }
                else if ($number == 61)
                {
                    return LanguageSupport::getLang('2 Peter');
                }
                else if ($number == 62)
                {
                    return LanguageSupport::getLang('1 John');
                }
                else if ($number == 63)
                {
                    return LanguageSupport::getLang('2 John');
                }
                else if ($number == 64)
                {
                    return LanguageSupport::getLang('3 John');
                }
                else if ($number == 65)
                {
                    return LanguageSupport::getLang('Jude');
                }
                else if ($number == 66)
                {
                    return LanguageSupport::getLang('Revelation');
                }
                else if ($number == 67)
                {
                    return LanguageSupport::getLang('Tobit');
                }
                else if ($number == 68)
                {
                    return LanguageSupport::getLang('1 Maccabees');
                }
                else if ($number == 69)
                {
                    return LanguageSupport::getLang('2 Maccabees');
                }
                else if ($number == 70)
                {
                    return LanguageSupport::getLang('Wisdom');
                }
                else if ($number == 71)
                {
                    return LanguageSupport::getLang('Judith');
                }
                else if ($number == 72)
                {
                    return LanguageSupport::getLang('Baruch');
                }
                else if ($number == 73)
                {
                    return LanguageSupport::getLang('Ecclesiasticus');
                }
            }
            else
            {
                return LanguageSupport::getLang('Nothing');;
            }        
        }
    }

    LanguageSupport::changeLanguage('en');

 ?>
