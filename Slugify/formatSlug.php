public function formatSlug($string) {
    $char_accents = array('à', 'é', 'è', 'ê', 'ô', 'É', 'À', 'ù');
    $char_normal  = array('a', 'e', 'e', 'e', 'o', 'E', 'A', 'u');
    
    // remove letters with accents
    $string = str_replace($char_accents, $char_normal, $string);
    
    // replace non letter or digits by -
    $string = preg_replace('~[^\pL\d]+~u', '-', $string);
    
    // transliterate
    $string = iconv('utf-8', 'us-ascii//TRANSLIT', $string);
    
    // remove unwanted characters
    $string = preg_replace('~[^-\w]+~', '', $string);
    
    // trim
    $string = trim($string, '-');
    
    // remove duplicate -
    $string = preg_replace('~-+~', '-', $string);
    
    // lowercase
    $string = strtolower($string);
    
    if (empty($string)) {
        return 'n-a';
    }
    
    return $string;
}

public function addToTwig( \Twig_Environment $twig ) {
    $twig->addFilter( new \Twig_SimpleFilter( 'slugify', [ $this, 'formatSlug' ] ) );
    
    return $twig;
}