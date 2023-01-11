<?php

namespace Plugin\Test\Repository;

use Eccube\Doctrine\Query\QueryCustomizer;
use Eccube\Doctrine\Query\WhereClause;
use Eccube\Repository\QueryKey;
use Doctrine\ORM\QueryBuilder;
use Eccube\Repository\TagRepository;


/**
 * Description of TagSearchCustomizer
 *
 * @author Akira Kurozumi <info@a-zumi.net>
 */
class TagSearchCustomizer implements QueryCustomizer {

    protected $tagRepository;

    public function __construct(TagRepository $tagRepository)
    {
        $this->tagRepository = $tagRepository;

    }
    /**
     * 検索のパラメータにtag_idを追加
     */
    public function customize(QueryBuilder $builder, $params, $queryKey)
    {
        //タグ検索

        if (!empty($params['tag_id']) && $params['tag_id']) {
            $builder->innerJoin('p.ProductTag', 'pt');
            $builder->andWhere('pt.Tag = :tag_id');
            $builder->setParameter('tag_id', $params['tag_id']);
        }
        if(!empty($params['maker']) && $params['maker']){
            $builder->andWhere('p.Maker = :maker');
            $builder->setParameter('maker', $params['maker']);
            
        }
        //クロスカテゴリー用検索
        $search_categories = [0 => 'color'];
        foreach($search_categories as $key => $value){
            if( !empty($params[$value]) ){
                $builder->innerJoin('p.ProductCategories', 'pct'.$key)
                    ->andWhere($builder->expr()->in('pct'.$key.'.Category', ':Categories'.$key)  )
                    ->setParameter('Categories'.$key, $params[$value]);
            }
        }
    }
 
    public function getQueryKey(): string
    {
        return QueryKey::PRODUCT_SEARCH;
    }

}