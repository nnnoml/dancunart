<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class ArticleModel extends Model
{
    protected  $table = 'article';

    public static function getAll($key){
        return self::where(function($q) use($key){
            if($key) $q->where('title','like','%'.$key.'%')
                ->orwhere('keywords','like','%'.$key.'%');
        })->paginate(25);
    }

    public static function insertDo($data){
        $article = new self;
        foreach($data as $key=>$vo){
            $article->$key = $vo;
        }
        return $article->save();
    }

    public static function updateDo($id,$data){
        $article = self::find($id);
        foreach($data as $key=>$vo){
            $article->$key = $vo;
        }
        return $article->save();
    }

    public static function getSingleWithClass($id){
        $article = new Self;
        return self::leftJoin('article_class as ac','ac.id','=',$article->table.'.article_class')
            ->where($article->table.'.id',$id)
            ->where($article->table.'.status',1)
            ->first();
    }

    public static function getAllByClass($list){
        return self::where('article_class',$list)
            ->where('status',1)
            ->paginate(10);
    }
}
