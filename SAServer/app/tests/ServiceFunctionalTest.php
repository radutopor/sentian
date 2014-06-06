<?php

// vendor\bin\phpunit --filter ServiceFunctional

class ServiceFunctionalTest extends TestCase {

    private $testCases = array(
        array(
            'txt' => 'Weather today is rubbish',
            'expected' => 'NEG'
        ),
        array(
            'txt' => 'This cake looks amazing',
            'expected' => 'POS'
        ),
        array(
            'txt' => 'His skills are mediocre',
            'expected' => 'NEU'
        ),
        array(
            'txt' => 'He is very talented',
            'expected' => 'POS'
        ),
        array(
            'txt' => 'She is seemingly very agressive',
            'expected' => 'NEG'
        ),
        array(
            'txt' => 'Marie was enthusiastic about the upcoming trip. Her brother was also passionate about her leaving - he would finally have the house for himself.',
            'expected' => 'POS'
        ),
        array(
            'txt' => 'To be or not to be?',
            'expected' => 'NEU'
        ),
        array(
            'txt' => 'Guns are awesome',
            'expected' => 'POS'
        ),
    );
    private static $nextCase = 0;

    private function doNextCase(){
        $case = $this->testCases[static::$nextCase++];
        $num = static::$nextCase;
        $label = Analyzer::analyze($case['txt'], true)->label;
        $expected = $case['expected'];
        echo "\n$num. got $label; expected $expected\n";
        $this->assertTrue($label == $case['expected']);
    }

    public function testCase1(){ $this->doNextCase(); }
    public function testCase2(){ $this->doNextCase(); }
    public function testCase3(){ $this->doNextCase(); }
    public function testCase4(){ $this->doNextCase(); }
    public function testCase5(){ $this->doNextCase(); }
    public function testCase6(){ $this->doNextCase(); }
    public function testCase7(){ $this->doNextCase(); }
    public function testCase8(){ $this->doNextCase(); }

}