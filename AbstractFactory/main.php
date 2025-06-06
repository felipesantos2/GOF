<?php

/**
 * BookFactory classes.
 */
abstract class AbstractBookFactory
{
    abstract public function makePHPBook();

    abstract public function makeMySQLBook();
}

class OReillyBookFactory extends AbstractBookFactory
{
    private $context = 'OReilly';

    public function makePHPBook()
    {
        return new OReillyPHPBook();
    }

    public function makeMySQLBook()
    {
        return new OReillyMySQLBook();
    }
}

class SamsBookFactory extends AbstractBookFactory
{
    private $context = 'Sams';

    public function makePHPBook()
    {
        return new SamsPHPBook();
    }

    public function makeMySQLBook()
    {
        return new SamsMySQLBook();
    }
}

/**
 * Book classes.
 */
abstract class AbstractBook
{
    abstract public function getAuthor();

    abstract public function getTitle();
}

abstract class AbstractMySQLBook extends AbstractBook
{
    protected $subject = 'MySQL';
}

class OReillyMySQLBook extends AbstractMySQLBook
{
    private $author;
    private $title;

    public function __construct()
    {
        $this->author = 'George Reese, Randy Jay Yarger, and Tim King';
        $this->title = 'Managing and Using MySQL';
    }

    public function getAuthor()
    {
        return $this->author;
    }

    public function getTitle()
    {
        return $this->title;
    }
}

class SamsMySQLBook extends AbstractMySQLBook
{
    private $author;
    private $title;

    public function __construct()
    {
        $this->author = 'Paul Dubois';
        $this->title = 'MySQL, 3rd Edition';
    }

    public function getAuthor()
    {
        return $this->author;
    }

    public function getTitle()
    {
        return $this->title;
    }
}

abstract class AbstractPHPBook extends AbstractBook
{
    protected $subject = 'PHP';
}

class OReillyPHPBook extends AbstractPHPBook
{
    private $author;
    private $title;
    private static $oddOrEven = 'odd';

    public function __construct()
    {
        // alternate between 2 books
        if ('odd' == self::$oddOrEven) {
            $this->author = 'Rasmus Lerdorf and Kevin Tatroe';
            $this->title = 'Programming PHP';
            self::$oddOrEven = 'even';
        } else {
            $this->author = 'David Sklar and Adam Trachtenberg';
            $this->title = 'PHP Cookbook';
            self::$oddOrEven = 'odd';
        }
    }

    public function getAuthor()
    {
        return $this->author;
    }

    public function getTitle()
    {
        return $this->title;
    }
}

class SamsPHPBook extends AbstractPHPBook
{
    private $author;
    private $title;

    public function __construct()
    {
        // alternate randomly between 2 books
        mt_srand((float) microtime() * 10000000);
        $rand_num = mt_rand(0, 1);

        if (1 > $rand_num) {
            $this->author = 'George Schlossnagle';
            $this->title = 'Advanced PHP Programming';
        } else {
            $this->author = 'Christian Wenz';
            $this->title = 'PHP Phrasebook';
        }
    }

    public function getAuthor()
    {
        return $this->author;
    }

    public function getTitle()
    {
        return $this->title;
    }
}

/*
 * Initialization
 */

writeln('BEGIN TESTING ABSTRACT FACTORY PATTERN');
writeln('');

writeln('testing OReillyBookFactory');
$bookFactoryInstance = new OReillyBookFactory();
testConcreteFactory($bookFactoryInstance);
writeln('');

writeln('testing SamsBookFactory');
$bookFactoryInstance = new SamsBookFactory();
testConcreteFactory($bookFactoryInstance);

writeln('END TESTING ABSTRACT FACTORY PATTERN');
writeln('');

function testConcreteFactory($bookFactoryInstance)
{
    $phpBookOne = $bookFactoryInstance->makePHPBook();
    writeln('first php Author: '.$phpBookOne->getAuthor());
    writeln('first php Title: '.$phpBookOne->getTitle());

    $phpBookTwo = $bookFactoryInstance->makePHPBook();
    writeln('second php Author: '.$phpBookTwo->getAuthor());
    writeln('second php Title: '.$phpBookTwo->getTitle());

    $mySqlBook = $bookFactoryInstance->makeMySQLBook();
    writeln('MySQL Author: '.$mySqlBook->getAuthor());
    writeln('MySQL Title: '.$mySqlBook->getTitle());
}

function writeln($line_in)
{
    echo $line_in.'<br/>';
}
