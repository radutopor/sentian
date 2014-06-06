<?php 
class ServiceSeeder extends Seeder {
 
    public function run()
    {
        DB::table('services')->delete();
        DB::table('endpoints')->delete();
        DB::table('parameters')->delete();

        $serv = Service::create(array(
            'name' => 'nlptools',
            'root' => 'http://nlptools.atrilla.net'
        )); //return service obj

        $limit = new Limit(array(
            'type' => 'month',
            'max_hits' => 500 //test ammount
        ));

        $serv->limits()->save($limit);

        $ep = new EndPoint(array(
            'name' => 'api',
        ));

        $serv->endpoints()->save($ep);

        $ep->parameters()->save(new Parameter(array(
            'name' => 'service',
            'type' => 'string',
            'defaultValue' => 'sentiment_news'
        )));

        $ep->parameters()->save(new Parameter(array(
            'name' => 'text',
            'type' => 'string'
        ))); 
    }
}

?>