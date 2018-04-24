<?php
/**
 * Created by PhpStorm.
 * User: WKR
 * Date: 01.12.2017
 * Time: 16:01
 */
require_once 'MyC/MyComplex.php';
//require_once "vendor/autoload.php";
use MyC\MyComplex;



$input = $data = array (
    array ('a'=>[ 2,          4], 'b'=>[-90,          10]),
    array ('a'=>[-2,          4], 'b'=>[10, '-2.12e-1']),
    array ('a'=>[ 0,          0], 'b'=>['-0.087e2',  6]),
    array ('a'=>[-4,          2], 'b'=>[ 6,         -3]),
    array ('a'=>[-1,         -4], 'b'=>[ 1,          3]),
    array ('a'=>[ 0,        1.4], 'b'=>[ 2.6,      0.5]),
    array ('a'=>[-2,          0], 'b'=>[ 0,        0.2]),
    array ('a'=>['10',       10], 'b'=>[ 1,   -6.21e-1]),
    array ('a'=>['1.232e2',   0], 'b'=>[ -12,       -2]),
    array ('a'=>['5.2e-1',   -2], 'b'=>[ 5.5,        0]),
);


foreach ($data as $i => $row)
{

    foreach ($row as $key => $col) $row[$key] = $$key = new MyComplex($col[0], $col[1]);

    $data[$i] = array_merge($data[$i], array('a'    => $a));
    $data[$i] = array_merge($data[$i], array('b'    => $b));
    $data[$i] = array_merge($data[$i], array('mod'  => $a->mod()));
    $data[$i] = array_merge($data[$i], array('conj' => MyComplex::conj($a)));
    $data[$i] = array_merge($data[$i], array('inver'=> MyComplex::inver($a)));
    $data[$i] = array_merge($data[$i], array('add'  => MyComplex::add($a, $b)));
    $data[$i] = array_merge($data[$i], array('sub'  => MyComplex::sub($a, $b)));
    $data[$i] = array_merge($data[$i], array('mult' => MyComplex::mult($a,$b)));
    $data[$i] = array_merge($data[$i], array('dev'  => MyComplex::dev($a, $b)));
}
//---------------------

$data_table = $example_table = "";

foreach ($data as $i => $row)
{
    $example_table .= "<tr align='right' style='height: 20px;'><td align='center'>" . ($i + 1) ."</td>";
    $data_table    .= "<tr align='right' style='height: 20px;'><td align='center'>" . ($i + 1) ."</td>";
    foreach ($row as $k => $val)
    {
        $td_attributes = '';
        //if (is_a($val, 'MyComplex')) {
        if (is_a($val, 'MyC\MyComplex')) {
            $ToStr = 'AsString';
            $str_val = $val->$ToStr();
            $td_attributes = ($str_val === "null") ?
                (" title = '" . $val->err . "' bgcolor='#b22222' align='center' style='color: white'") :
                (" title = '" . $val->$ToStr() . "'");
        } elseif (is_null($val)) {
            $str_val = "null";
            $td_attributes = " title = 'null' bgcolor='#b22222' align='center' style='color: white'";

        } else $str_val = $val;
        $example_table .= "<td{$td_attributes}>" . $str_val ."</td>";
        if (in_array($k, array('a', 'b')))
            $data_table    .= "<td align='right'>( " . $input[$i][$k][0] . ", ". $input[$i][$k][1] . "i )</td>";
    }
    $example_table .= "</tr>";
    $data_table    .= "</tr>";
}
echo "ДАННЫЕ</br>";
echo "
<div style='border: #3c763d solid 1px; width: 240px'>
    <table width=240 cellspacing='0' border='1' style='font-size: smaller;'>
        <tr align='center'  style='height: 20px;'>
            <td width='40px'>№</td>
            <td width='100px'>a</td>
            <td width='100px'>b</td>
        </tr>". $data_table
    ."</table>
</div>";
echo "</br></br>РЕЗУЛЬТАТЫ</br>";
echo "
<div style='border: #3c763d solid 1px; width: 1400px'>
    <table width=100% cellspacing='0' border='1' style='font-size: smaller;'>
        <tr align='center'  style='height: 20px;'>
            <td width='40px'>№</td>
            <td width='100px'>a</td>
            <td width='100px'>b</td>
            <td width='10%'>|a|</td>
            <td width='10%'>a'</td>
            <td>1/a</td>
            <td width='10%'>a + b</td>
            <td width='10%'>a - b</td>
            <td>a * b</td>
            <td>a / b</td>
        </tr>". $example_table
    ."</table>
</div>";


