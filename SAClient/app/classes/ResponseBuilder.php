<?php
class ResponseBuilder {

    private static function analyzePayload( $payload ){
        $analyzedPosts = array();
        $decodedPayload = json_decode($payload);
        $posts = $decodedPayload->posts;
        foreach ($posts as $post) {
            $feeling = Analyzer::analyze($post->text);
            $analyzed = (object) array(
                'id' => $post->id,
                'feeling' => $feeling,
                'tags' => $post->tags
            );

            $analyzedPosts[] = $analyzed;
        }
        return $analyzedPosts;
    }

    public static function getAnalyzedResponse( $payload){
        $posts = static::analyzePayload($payload);
        $postNum = count($posts);
        $tags = array();
        $response = array(
            'general' => array(
                'likelihood' => array(
                    'NEG' => 0,
                    'NEU' => 0,
                    'POS' => 0
                ),
                'label' => NULL
             ),
            'posts' => array(),
            'tags' => array()
        );

        foreach ($posts as $post) {

            $pNEG = $post->feeling->NEG;
            $pNEU = $post->feeling->NEU;
            $pPOS = $post->feeling->POS;

            $response['posts'][] = array(
                'id' => $post->id,
                'result' => array(
                    'likelihood' => array(
                        'NEG' => $pNEG,
                        'NEU' => $pNEU,
                        'POS' => $pPOS
                    ),
                    'label' => $post->feeling->label
                )
            );
            $response['general']['likelihood']['NEG'] += $pNEG;
            $response['general']['likelihood']['NEU'] += $pNEU;
            $response['general']['likelihood']['POS'] += $pPOS;

            $thesetags = $post->tags;
            foreach ($thesetags as $tag) {
                isset($tags[$tag]) ? $tags[$tag]++ : $tags[$tag] = 1;

                $init = isset($response['tags'][$tag]);

                if($init) {
                    $prevL = $response['tags'][$tag]['likelihood'];
                    $newNEG = $prevL['NEG'] + $pNEG;
                    $newNEU = $prevL['NEU'] + $pNEU;
                    $newPOS = $prevL['POS'] + $pPOS;

                    $response['tags'][$tag] = array(
                        'likelihood' => array(
                            'NEG' => $newNEG,
                            'NEU' => $newNEU,
                            'POS' => $newPOS
                        )
                    );
                }
                else {
                    $response['tags'][$tag] = array(
                        'likelihood' => array(
                            'NEG' => $pNEG,
                            'NEU' => $pNEU,
                            'POS' => $pPOS
                        )
                    );
                }
            }
        }

        foreach ($tags as $tag => $count) {
            $response['tags'][$tag]['likelihood']['NEG'] = $response['tags'][$tag]['likelihood']['NEG'] / $count;
            $response['tags'][$tag]['likelihood']['NEU'] = $response['tags'][$tag]['likelihood']['NEU'] / $count;
            $response['tags'][$tag]['likelihood']['POS'] = $response['tags'][$tag]['likelihood']['POS'] / $count;
            $response['tags'][$tag]['label'] = array_keys(
                                                    $response['tags'][$tag]['likelihood'],
                                                    max($response['tags'][$tag]['likelihood'])
                                                )[0];
        }
        $response['general']['label'] = array_keys(
                                        $response['general']['likelihood'],
                                        max($response['general']['likelihood'])
                                    )[0]/count($posts);
        // TODO fix general avg
        return $response;
    }
}