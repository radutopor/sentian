<?php

class HomeController extends BaseController
{
    /*
    |--------------------------------------------------------------------------
    | Default Home Controller
    |--------------------------------------------------------------------------
    |
    | You may wish to use controllers instead of, or in addition to, Closure
    | based routes. That's great! Here is an example controller method to
    | get you started. To route to this controller, just add the route:
    |
    |	Route::get('/', 'HomeController@showWelcome');
    |
    */

            
   

    public function showWelcome()
    {
        $response = Unirest::post("http://httpbin.org/post", array("Accept" => "application/json"),
            array(
                "parameter" => 23,
                "foo" => "bar"
            )
        );
        return View::make('hello', array('test' => $response));
    }

    public function testAnalyzer(){
       $result = Analyzer::analyze("Guns are awesome");
        dd($result);
        return "Testing functions";
    }
    public function classiffier(){
        $c = new NaiveBayensClassifier();
        $c->init();
        // $c->init(30, 70);
    }

    // public function testPhpInsight(){
    //     $sentiment = new Sentiment();

    //     $examples = array(
    //         1 => 'Weather today is rubbish',
    //         2 => 'This cake looks amazing',
    //         3 => 'His skills are mediocre',
    //         4 => 'He is very talented',
    //         5 => 'She is seemingly very agressive',
    //         6 => 'Marie was enthusiastic about the upcoming trip. Her brother was also passionate about her leaving - he would finally have the house for himself.',
    //         7 => 'To be or not to be?',
    //         8 => 'Guns are awesome'
    //     );
        
    //     foreach ($examples as $key => $example) {

    //         echo '<div class="example">';
    //         echo "<h2>Example $key</h2>";
    //         echo "<blockquote>$example</blockquote>";

    //         echo "Scores: <br />";
    //         $scores = $sentiment->score($example);

    //         echo "<ul>";
    //         foreach ($scores as $class => $score) {
    //             $string = "$class -- <i>$score</i>";
    //             if ($class == $sentiment->categorise($example)) {
    //                 $string = "<b class=\"$class\">$string</b>";
    //             }
    //             echo "<ol>$string</ol>";
    //         }
    //         echo "</ul>";
    //         echo '</div>';
    //     }
    // }
}

