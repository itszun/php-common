<?php
namespace Itszun\Common;

use DateTimeInterface;

trait Cherrypickable {
    /**
     * Additional q for conditional id/slug product
     *
     * @return Doctrine\DBAL\q\qBuilder
     */

    public function scopePick($q, $offset, $limit) {
        $offset = !is_null($offset) & is_numeric($offset) ? (int) $offset : 0;
        $limit = !is_null($limit) & is_numeric($limit) ? (int) $limit : 10;
        $limit = $limit > 25 ? 25 : $limit;
        return $q->offset($offset)->limit($limit);
    }

    public function scopeSearch($q, $keyword, array $columns) {
        if ($keyword == "" || $keyword == null) {
            return $q;
        }
        $keyword = "%".$keyword."%";
        return $q->where(function ($q) use ($keyword, $columns) {
            return collect($columns)->reduce(function($acc, $i) use ($keyword) {
                $columnOrRelation = explode(".", $i);
                if (count($columnOrRelation) > 1) {
                    return $this->relationSearch($acc, $columnOrRelation, $keyword);
                }
                return $acc->orWhere($i, 'like', $keyword);
            }, $q);
        });
    }

    public function relationSearch($query, $relation, $keyword) {
        return $query->whereHas($relation[0], function($q) use ($relation, $keyword) {
            $q->where($relation[1], 'LIKE', $keyword);
        });
    }


    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
