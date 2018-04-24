<?php

//namespace MyC\MyComplex;
namespace MyC;


//use MyComplexException;

require_once 'MyComplexException.php';

define("PRECICION", 3);        // Точность вычислений (кол-во знаков после зап.)

/*
 * Класс реализует элементарные операции с комплексными числами (к.ч.)
 * -------------------------------------------------------------------
 * public свойства:
 *      real    - действительная часть к.ч.
 *      imag    - мнимая часть к.ч.
 *      err     - сообщение об ошибке операции с к.ч.
 *      mod2    - квадрат модуля к.ч.
 * -------------------------------------------------------------------
 * public методы:
 *      AsString()      - Преобразование к.ч. в string
 *      isComplex($a)   - Тест на корректное к.ч.
 *      isZero($a)      - Тест на нулевое к.ч.
 *      mod()           - Модуль к.ч.
 *      inver($a)       - Обращение
 *      conj($a)        - Сопряжение
 *      add($a, $b)     - Сложение
 *      sub($a, $b)     - Вычитание
 *      mult($a, $b)    - Умножение
 *      dev($a, $b)     - Деление
 * -------------------------------------------------------------------
 */

    Class MyComplex                     //  Элементарная арифметика к.ч.
    {
        protected $_real;
        protected $_imag;
        protected $_err;

        //----------------------------------------------------------------
        function __construct ($real=0.0, $imag=0.0, $err='')
        {
            try {
                if (is_numeric($real) && is_numeric($imag)) {
                    $this->_real = (real)$real;
                    $this->_imag = (real)$imag;
                    $this->_err = 0;
                } else {
                    $this->_err = $err . "\n";
                    throw new MyComplexException(__CLASS__ .' : '. __FUNCTION__ . ' : ошибка инициализации.', 10);
                }
            }
            catch (MyComplexException $e) {
                $this->_err .= $e->getTraceAsString();
                $this->_err = mbereg_replace("['|,]", "", $this->_err);
            }
        }
        //---------------------------------------------
        function __get($property)
        {
            try {
                switch ($property) {
                    case 'real':
                        return $this->_real;
                    case 'imag':
                        return $this->_imag;
                    case 'err':
                        return $this->_err;
                    case 'mod2':
                        return pow($this->_real, 2) + pow($this->_imag, 2);
                    default:
                        throw new MyComplexException(__CLASS__ . ': отсутствует свойство - ' . $property);
                }
            }
            catch (MyComplexException $e) {
                echo 'Ошибка! ' . $e->getMessage() . '</br>';
                return null;
            }
        }
        //---------------------------------------------
        function __set($property, $value)
        {
            switch ($property) {
                case 'real':
                    $this->_real = $value;
                    break;
                case 'imag':
                    $this->_imag = $value;
                    break;
                case 'err':
                    $this->_err = $value;
                    break;
            }
        }
        //---------------------------------------------
        function AsString($precision = PRECICION)             //  в строку
        {
            if (is_null($this->_real) || is_null($this->_imag)) return "null";
            $real = ($this->_real == 0) ? '' : round($this->_real, $precision);
            $sing_imag_i = ($this->_imag == 0) ? ('') : (($this->_imag > 0.0) ?
                (" + " . round($this->_imag, $precision) ." i") :
                (" - " . round(abs($this->_imag), $precision) . " i"));
            $res = ($real == '' && $sing_imag_i =='') ? 0 : ($real . $sing_imag_i);
            $res = mbereg_replace('^\s\+\s', '', $res);
            return $res;
        }
        //---------------------------------------------
        static function isComlex(&$a)   //  Тест на корректное к.ч.
        {
            if (is_a($a, 'MyC\MyComplex') && (is_numeric($a->real) && is_numeric($a->imag))) return true;
            if (is_numeric($a)) {
                $a = new MyComplex($a, 0);
                return true;
            }
            return false;
        }
        //---------------------------------------------
        static function isZero($a)      //  Тест на нулевое к.ч.
        {
            return ($a->real == 0 && $a->imag == 0);
        }
        //---------------------------------------------
        function mod()                  //  |a|
        {
            try {
                if (self::isComlex($this)) {
                    return round(sqrt(pow($this->_real, 2) + pow($this->_imag, 2)), PRECICION);
                } throw new MyComplexException(__CLASS__ .' : '. __FUNCTION__ . ' : операнд должен быть комплексным числом.', 30);
            }
            catch (MyComplexException $e) {
                //echo 'Ошибка! ' . $e->getMessage() . '</br>';
                return null;
            }

        }
        //---------------------------------------------
        static function inver($a)       //  1 / a
        {
            try {
                if (self::isComlex($a)) {
                    if (self::isZero($a)) {
                        throw new MyComplexException(__CLASS__ .' : '. __FUNCTION__ . ' : Попытка деления на 0 + 0i', 20);
                    }
                    $real = $a->real / $a->mod2;
                    $imag = ($a->imag == 0) ? 0 : -$a->imag / $a->mod2;
                    return new  MyComplex($real, $imag);
                } throw new MyComplexException(__CLASS__ .' : '. __FUNCTION__ . ' : операнд должен быть комплексным числом.', 30);
            }
            catch (MyComplexException $e) {
                //echo 'Ошибка! ' . $e->getMessage() . '</br>';
                return  new  MyComplex('','', $e->getMessage());
            }
        }
        //---------------------------------------------
        static function conj($a)        //  a'
        {
            try {
                if (self::isComlex($a)) {
                    $real = $a->real;
                    $imag = -$a->imag;
                    return new  MyComplex($real, $imag);
                }
                throw new MyComplexException(__CLASS__ .' : '. __FUNCTION__ . ' : операнд должен быть комплексным числом.', 30);
            }
            catch (MyComplexException $e) {
                //echo 'Ошибка! ' . $e->getMessage() . '</br>';
                return  new  MyComplex('','', $e->getMessage());
            }
        }
        //---------------------------------------------
        static function add($a, $b)     //  a + b
        {
            try {
                if (self::isComlex($a) && self::isComlex($b)) {
                    $real = $a->real + $b->real;
                    $imag = $a->imag + $b->imag;
                    return new MyComplex($real, $imag);
                }
                throw new MyComplexException(__CLASS__ .' : '. __FUNCTION__ . ' : оба операнда должны быть комплексными числами', 40);
            }
            catch (MyComplexException $e) {
                //echo 'Ошибка! ' . $e->getMessage() . '</br>';
                return  new  MyComplex('','', $e->getMessage());
            }
        }
        //---------------------------------------------
        static function sub($a, $b)     //  a - b
        {
            try {
                if (self::isComlex($a) && self::isComlex($b)) {
                    $real = $a->real - $b->real;
                    $imag = $a->imag - $b->imag;
                    return new MyComplex($real, $imag);
                }
                throw new MyComplexException(__CLASS__ .' : '. __FUNCTION__ . ' : оба операнда должны быть комплексными числами', 40);
            }
            catch (MyComplexException $e) {
                //echo 'Ошибка! ' . $e->getMessage() . '</br>';
                return  new  MyComplex('','', $e->getMessage());
            }
        }
        //---------------------------------------------
        static function mult($a, $b)    //  a * b
        {
            try {
                if (self::isComlex($a) && self::isComlex($b)) {
                    $real = $a->real * $b->real - $a->imag * $b->imag;
                    $imag = $a->imag * $b->real + $a->real * $b->imag;
                    return new MyComplex($real, $imag);
                }
                throw new MyComplexException(__CLASS__ .' : '. __FUNCTION__ . ' : оба операнда должны быть комплексными числами', 40);
            }
            catch (MyComplexException $e) {
                //echo 'Ошибка! ' . $e->getMessage() . '</br>';
                return  new  MyComplex('','', $e->getMessage());
            }
        }
        //---------------------------------------------
        static function dev($a, $b)     //  a / b
        {
            try {
                if (self::isComlex($a) && self::isComlex($b)) {
                    if (self::isZero($b)) {
                        throw new MyComplexException(__CLASS__ .' : '. __FUNCTION__ . " : Попытка деления на 0 + 0i", 20);
                    }
                    $real = ($a->real * $b->real + $a->imag * $b->imag) / $b->mod2;
                    $imag = ($a->imag * $b->real - $a->real * $b->imag) / $b->mod2;
                    return new MyComplex($real, $imag);
                } else {
                    throw new MyComplexException(__CLASS__ .' : '. __FUNCTION__ . ' : оба операнда должны быть комплексными числами', 40);
                }
            }
            catch (MyComplexException $e) {
                //echo 'Ошибка! ' . $e->getMessage() . '</br>';
                return  new MyComplex('','', $e->getMessage());
            }
        }
    }


