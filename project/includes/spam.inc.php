<?php
    function isspam($text){
    $num_spam=0;
    $spam=[ 
        'affordable','action','natural','organic','apply','bonus','free','million','millionire','cash','casino','click','cheap','certified','deal','discount',
        'collect','deal','congratualtions!','hesitate','money','win','unlimited','win','winner','terms','conditions','loan','investment',
        'hot girls','credit cards','debt','chance','sucess','ad','trial','offer','50% off','dollars','vacation','100%','spam',
        'credit card','avail offer','free cash','call now','apply now','avail now','get it now','do not delete','free gift','sexy',
        'urgent','thanks for  ordering','illegal','!!!!!','e-mail','mail','infected','virus','read for details','additional income',
        'collect','earn','lottery','free acess', 'while supplies last','left','only','cancel at any time','limited time',
        'miracle','once in life time','risk free','shopper','you are a winner','you have been selected','password','address','?!?!?!',
        'discount'
    ];
    $lowtext=strtolower($text);
    for($i=0;$i<count($spam);$i++){
        if( strpos($lowtext,$spam[$i])){
            $num_spam++;
        }
    }
    $num_text=str_word_count($text);
    if($num_spam/$num_text>0.2){
        return 'spam';
    }
    else{
        return 'ham';
    }
}