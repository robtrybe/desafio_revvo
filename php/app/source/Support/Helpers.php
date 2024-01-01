<?php

/**
 * ##################
 * #### VALIDATE ####
 * ##################
 */

 function is_email(string $email): bool {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
 }

 function is_passwd(string $password): bool {
    return mb_strlen($password) >= CONF_PASSWORD_MIN_LEN && mb_strlen($password) <= CONF_PASSWORD_MAX_LEN;
 }

/**
 * ##################
 * ##### STRING #####
 * ##################
 */

/**
 * @param string
 * @return string
 */
function str_slug(string $string): string
{
    $string = htmlspecialchars($string);
    $formats = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜüÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿRr"!@#$%&*()_-+={[}]/?;:.,\\\'<>°ºª';
    $replace = 'aaaaaaaceeeeiiiidnoooooouuuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr                                 ';

    $slug = preg_replace('/\-+/', "-",
        preg_replace('/\s+/', "-",
            trim(strtr(mb_convert_encoding($string, 'ISO-8859-1','UTF8'),
                 mb_convert_encoding($formats, 'UTF8', 'ISO-8859-1'), $replace))
        )
    );
    return strtolower($slug);
}

function str_studly_case(string $string): string {
    $string = str_slug($string);
    $studlyCase = str_replace(" ", "", 
        mb_convert_case( str_replace("-", " ", $string), MB_CASE_TITLE)
    );
    return $studlyCase;
}
    
function str_camel_case(string $string): string {
    return $camelCase = lcfirst(str_studly_case($string));
} 

function str_title(string $string): string {
    return mb_convert_case(htmlspecialchars($string), MB_CASE_TITLE);
}

function str_limit_words(string $string, int $limit, $pointer = '...'): string {
    $word = trim(htmlspecialchars($string));
    $arrayWords = explode(" ", $word);
    $numWords = count($arrayWords);

    if($numWords <= $limit) return $word;

    return implode(" ", array_slice($arrayWords,0 , $limit )).$pointer;
}


function str_limit_chars(string $string, int $limit, $pointer = '...'): string {
    $string = trim(htmlspecialchars($string));
    $len = mb_strlen($string);

    if($len <= $limit) return $string;

    $lastWhiteSpace = mb_strrpos(mb_substr($string,0, $limit), " ");

    if(!$lastWhiteSpace) {
        return mb_substr($string, 0, $limit).$pointer; 
    }

    return mb_substr($string, 0, $lastWhiteSpace).$pointer;
}



/**
 * ############
 * ### URLS ####
 * ############
 */
function url(?string $path = null) {
    if(strpos('localhost', $_SERVER['HTTP_HOST'])) {
        if($path) {
            return CONF_TEST_URL.'/'.($path[0] === '/' ? substr($path, 1)  : $path);
        }
        return CONF_TEST_URL;
    }

    if($path) {
        return CONF_BASE_URL.'/'.($path[0] === '/' ? substr($path, 1) : $path);
    }
    return CONF_BASE_URL;
}

function redirect(string $url): void {
    header("HTTP/1.1 302 Redirect");
    if(filter_var($url, FILTER_VALIDATE_URL)){
        header("Location: {$url}");
        exit;
    }

    $location = url($url);
    header("Location: {$location}");
    exit;
}

function message(): \Source\Support\Message {
    return new \Source\Support\Message();
}

function session(): \Source\Core\Session {
    return new \Source\Core\Session();
}

function csrf_input(): string {
    session()->csrf();
    return '<input type="hidden" name="csrf" value="'.(session()->csrf_token ?? "").'" />';
}

function csrf_verify($request): bool {
    if(empty(session()->csrf_token) || empty($rquest['csrf']) || $request['csrf'] !== session()->csrf_token){
        return false;
    }
    return true;
}


################
#### assets ####
################

function assets(string $path): string {
    return CONF_URL_ASSETS.($path[0] === '/' ? substr($path, 1): $path);
}

function image(string $imageName) {
    return url('/uploads/images/').$imageName;
}


function user(): \Source\Models\User |null {
    return session()->user ?? null;
}