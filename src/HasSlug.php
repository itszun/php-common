<?php
namespace Itszun\Common;

trait HasSlug {
    /**
     * Additional query for conditional id/slug product
     *
     * @return Doctrine\DBAL\Query\QueryBuilder
     */

    public function scopeIdSlug($query, $idslug) {
        if (is_numeric($idslug))
        {
            $query->where('id', $idslug);
        } else {
            $query->where('slug', $idslug);
        }
        return $query;
    }
}
