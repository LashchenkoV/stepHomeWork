<?php
/**
 * Ищет в HTML все совпадения
 * @param string $text - html в котором искать
 * @param string $tagName - имя тега
 * @param string $attributeName - имя атрибута
 * @param string $valueAttribute - зачение атрибута
 * @param array $arr - конечный массив
 * @return array|mixed - массив всех совпадений
 */
function searchTag(string $text, string $tagName, string $attributeName, string $valueAttribute, array $arr=[]){
    if(strlen($text) == 0) return $arr;
    preg_match('/<'.$tagName.'[^<>]*?'.$attributeName.'="'.$valueAttribute.'".*?>.*<\/'.$tagName.'>/s',$text,$result);
    $div_rexp = '/<\/?'.$tagName.'[^<>]*>/';
    $div_o_rexp = '/<'.$tagName.'[^<>]*>/';
    preg_match_all($div_rexp,$result[0],$tags);

    $pos=0;
    $str = '';
    for($i=0;$i<count($tags[0]);$i++){
        if(preg_match($div_o_rexp,$tags[0][$i]))
            $pos++;
        else
            $pos--;
        $str .= $tags[0][$i];
        if($pos==0){
            $arr[]=$str;
            array_splice($tags[0],0,$i+1);
            $str_next = implode('',$tags[0]);
            return searchTag($str_next, $tagName, $attributeName, $valueAttribute, $arr);

        }
    }
}
var_dump(searchTag(file_get_contents("a.html"),'div', 'class', 'f'));


