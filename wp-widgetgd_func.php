<?php

function thumbor($imagem, $size)
{
       $cmd = "fit-in/$size/center/middle/smart"; //transformation command

       $path = str_replace('http://','',$imagem); //original image path

       $key = get_option('thumbor_skey'); //Crypto key

       $server = get_option('thumbor_url'); // Thumbor host

       // Code
       $msg = $cmd .'/'. $path;
       //padding
       $encrypted_data = hash_hmac("sha1", $msg, $key, true);
       $xxx = "$server/" . strtr(base64_encode($encrypted_data ),'/+','_-') . "/" . $msg . "\n";

       return $xxx;
}

?>
