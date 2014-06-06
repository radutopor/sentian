<?php

// vendor\bin\phpunit --filter ServiceStress

class ServiceStressTest extends TestCase {

    private static $iterations = 0;            

    private function getPseudoRandomWord(){
        $symbols = preg_split('//', 'abcdefghijklmnopqrstuvwxyz0123456789', -1);
        shuffle($symbols);
        return implode($symbols);
    }


    public function testsimpleAnalyze(){ //TODO benchmark
        for ($i=0; $i < 1000; $i++) { 
            Analyzer::analyze($this->getPseudoRandomWord(), true);
            $it = ++static::$iterations;
            echo "iterated $it times...\n";
        }
    }

}