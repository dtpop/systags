<?php
class systags extends rex_yform_manager_dataset
{
    public static function get_query()
    {
        return self::query();
    }

    /**
     * find_articles_for_tag_ids
     * 
     * Funktion erhält die Tag Ids als Array in der Form [id1,id2,...]
     * Es werden online Artikel nach den Kriterien Sprache, Reihenfolge und Anzahl zurück gegeben.
     * Der aktuelle Artikel wird ausgenommen.
     * 
     * Außerdem werden Daily Datensätze aus der yform Tabelle geholt, die entsprechend getaggt sind.
     * 
     * Das Ergebnis wird zusammengemergt und nach Datum absteigend sortiert und die gewünschte Anzahl herausgeschnitten und zurück gegeben.
     * 
     * Das zurückgegebene Array besteht aus Artikelobjekten und Datensätzen aus daily.
     */
    public static function find_articles_for_tag_ids($tag_ids = [], $count = 0)
    {

        $clang = rex_clang::getCurrentId();
        $where = [];
        $where_daily = [];
        $params = [];
        $limit = '';
        $current_id = rex_article::getCurrentId();

        if ($count) {
            $limit = ' LIMIT '.$count;
        }

        foreach ($tag_ids as $k => $tag_id) {
            $where[] = 'FIND_IN_SET(:p' . $k . ',REPLACE(art_tags,"|",","))';
            $where_daily[] = 'FIND_IN_SET(' . $tag_id . ',`tags`)';
            $params['p' . $k] = $tag_id;
        }
        $params['clang_id'] = $clang;
        $where_string = implode(' OR ', $where);
        $where_string = $where_string ?: '0';
        $where_string .= ' AND id != '.$current_id;

        $sql = rex_sql::factory();
        $sql->setQuery('SELECT id, updatedate `date`, "article" `type` FROM rex_article WHERE (' . $where_string . ') AND status = 1 AND clang_id = :clang_id ORDER BY updatedate DESC ' .$limit, $params);
        $result = $sql->getArray();

        $where_string = implode(' OR ', $where_daily);
        $where_string = $where_string ?: '0';
        $sql2 = rex_sql::factory();
        $sql2->setQuery('SELECT id, publishdate `date`, title_'.$clang.' title, text_'.$clang.' text, image, "daily" `type` FROM rex_opto_daily WHERE (' . $where_string . ') AND status = 1 ORDER BY publishdate DESC'.$limit);
        $result_daily = $sql2->getArray();

        $both = array_merge($result, $result_daily);
        $sort = [];
        foreach ($both as $v) {
            $sort[] = $v['date'];
        }

        array_multisort($sort, SORT_DESC, SORT_NATURAL, $both);

        foreach ($both as $k=>$res) {
            if ('article' == $res['type'])
            $both[$k] = rex_article::get($res['id'], $clang);
        }
        if ($count) {
            $both = array_slice($both,0,$count);
        }
        return $both;
    }

    public static function get_tags_for_tag_categories ($categories = []) {
        if (!$categories) {
            return [];
        }
        $out = [];
        $qry = self::get_query();
        $qry->whereListContains('categories_id',$categories);
        $result = $qry->find();
        foreach ($result as $res) {
            $out[] = $res->id;
        }
        return $out;
    }



}
