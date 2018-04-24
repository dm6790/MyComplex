<?php

use PHPUnit\Framework\TestCase;
use MyC\MyComplex;
require_once "MyC\MyComplex.php";

/**
 * Created by PhpStorm.
 * User: WKR
 * Date: 03.12.2017
 * Time: 19:06
 *
 */
class MyComplexTest extends TestCase {

    /**
     * @dataProvider providerPower
     * @param $a
     * @param $b
     * @param $abs
     * @param $conj
     * @param $inver
     * @param $add
     * @param $sub
     * @param $mult
     * @param $dev
     */
    public function testMod($a, $b, $abs, $conj, $inver, $add, $sub, $mult, $dev)
    {
        $a = new MyComplex($a[0], $a[1]);
        $b = new MyComplex($b[0], $b[1]);
        $c = new MyComplex($conj[0], $conj[1]);
        $d = new MyComplex($inver[0], $inver[1]);
        $e = new MyComplex($add[0], $add[1]);
        $f = new MyComplex($sub[0], $sub[1]);
        $g = new MyComplex($mult[0], $mult[1]);
        $h = new MyComplex($dev[0], $dev[1]);

        $this->assertEquals($abs, $a->mod());
        $this->assertEquals($c, MyComplex::conj($a));
        $this->assertEquals($d, MyComplex::inver($a));
        $this->assertEquals($e, MyComplex::add($a, $b));
        $this->assertEquals($f, MyComplex::sub($a, $b));
        $this->assertEquals($g, MyComplex::mult($a, $b));
        $this->assertEquals($h, MyComplex::dev($a, $b));
    }
//-------------------------------------------------------------------

    /**
     * @return array
     */
    public function providerPower ()
    {
     return array (
         //           a                b                |a|              a'                         1/a                   a + b         a - b         a * b                         a / b
         array ([3,       4], [0,            10],               5, [ 3,     -4], [0.12,                        -0.16], [3,     14], [3,      -6], [-40,         30], [0.4,                            -0.3]),
         array ([-2,      4], [10,   '-2.12e-1'], 4.4721359549996, [ -2,    -4], [-0.1,                         -0.2], [8,  3.788], [-12, 4.212], [-19.152, 40.424], [-0.20838634284207,  0.39558220953175]),
         array ([0,       9], [-0.087e2,      6],               9, [ 0,     -9], [0,               -0.11111111111111], [-8.7,  15], [8.7,     3], [-54,      -78.3], [0.48348106365834, - 0.70104754230459]),
         array ([-4,      2], [6,            -3], 4.4721359549996, [-4,     -2], [-0.2,                         -0.1], [2,     -1], [-10,     5], [-18,         24], [-0.66666666666667,                 0]),
         array ([-1,     -4], [1,             3], 4.1231056256177, [-1,      4], [-0.05882352941176,0.23529411764706], [0,     -1], [-2,    - 7], [11,         - 7], [-1.3,                          - 0.1]),
         array ([0,     1.4], [2.6,         0.5],             1.4, [0,    -1.4], [0,               -0.71428571428571], [2.6 , 1.9], [-2.6,  0.9], [-0.7,      3.64], [0.09985734664765,   0.51925820256776]),
         array ([-2,      0], [0,           0.2],               2, [-2,      0], [-0.5,                            0], [-2,   0.2], [-2,   -0.2], [0,         -0.4], [0,                                10]),
         array ([10,     10], [1,        -0.621], 14.142135623731, [10,    -10], [0.05,                        -0.05], [11, 9.379], [9,  10.621], [16.21 ,    3.79], [2.7351962016136 ,    11.698556841202]),
         array ([1.232e2, 0], [-12,          -2],           123.2, [123.2,   0], [0.00811688311688,                0], [111.2,- 2], [135.2 ,  2], [-1478.4,- 246.4], [-9.9891891891892 ,   1.6648648648649]),
         array ([5.2e-1, -2], [5.5,           0], 2.0664946164943, [0.52,    2], [0.12176845260397, 0.46834020232297], [6.02, - 2], [-4.98, - 2], [2.86,       -11], [0.09454545454545, - 0.36363636363636]),
     );
    }
//-------------------------------------------------------------------

}
