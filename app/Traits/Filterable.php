<?php
namespace App\Traits;

use App\Utils\Constants;
use Illuminate\Database\Eloquent\Builder;

trait Filterable
{
    protected function applyFilters($query, $request, $filters, $distinctField = null)
{
    foreach ($filters as $filter => $operator) {
        $paramName = str_replace('.', '$', $filter);
        $value = $request->query($paramName);

        if (!is_null($value)) {
            // Si la relación es con bet.contestant
            if (strpos($filter, '.') !== false) {
                $relationParts = explode('.', $filter);

                // Si hay 3 partes (relación 'bet', sub-relación 'contestant', campo 'name')
                if (count($relationParts) === 3) {
                    [$relation, $subRelation, $subField] = $relationParts;

                    // Verifica si la relación 'bet' existe y es válida
                    if (method_exists($query->getModel(), $relation)) {
                        $query->whereHas($relation, function ($q) use ($subRelation, $subField, $operator, $value) {
                            // Verifica si la sub-relación 'contestant' también es válida
                            if (method_exists($q->getModel(), $subRelation)) {
                                $q->whereHas($subRelation, function ($subQ) use ($subField, $operator, $value) {
                                    $this->applyFilterCondition($subQ, $subField, $operator, $value);
                                });
                            } else {
                                throw new \Exception("La sub-relación '{$subRelation}' no existe.");
                            }
                        });
                    } else {
                        throw new \Exception("La relación '{$relation}' no existe.");
                    }
                } elseif (count($relationParts) === 2) {
                    // Si hay 2 partes (relación 'bet', campo 'contestant.name')
                    [$relation, $relationFilter] = $relationParts;

                    if (method_exists($query->getModel(), $relation)) {
                        $query->whereHas($relation, function ($q) use ($relationFilter, $operator, $value) {
                            $this->applyFilterCondition($q, $relationFilter, $operator, $value);
                        });
                    } else {
                        throw new \Exception("La relación '{$relation}' no existe.");
                    }
                }
            } else {
                $this->applyFilterCondition($query, $filter, $operator, $value);
            }
        }
    }

    // Búsqueda global con 'orWhereHas'
    if ($search = $request->query('search')) {
        $query->where(function ($q) use ($search, $filters) {
            foreach ($filters as $filter => $operator) {
                $q->orWhere(function ($subQuery) use ($filter, $operator, $search) {
                    if (strpos($filter, '.') !== false) {
                        $relationParts = explode('.', $filter);

                        if (count($relationParts) === 3) {
                            [$relation, $subRelation, $subField] = $relationParts;

                            if (method_exists($subQuery->getModel(), $relation)) {
                                $subQuery->orWhereHas($relation, function ($q1) use ($subRelation, $subField, $search) {
                                    if (method_exists($q1->getModel(), $subRelation)) {
                                        $q1->whereHas($subRelation, function ($q2) use ($subField, $search) {
                                            $q2->where($subField, 'like', '%' . $search . '%');
                                        });
                                    } else {
                                        throw new \Exception("La sub-relación '{$subRelation}' no existe.");
                                    }
                                });
                            } else {
                                throw new \Exception("La relación '{$relation}' no existe.");
                            }
                        } elseif (count($relationParts) === 2) {
                            [$relation, $relationFilter] = $relationParts;
                            $subQuery->orWhereHas($relation, function ($q1) use ($relationFilter, $search) {
                                $q1->where($relationFilter, 'like', '%' . $search . '%');
                            });
                        }
                    } else {
                        $subQuery->orWhere($filter, 'like', '%' . $search . '%');
                    }
                });
            }
        });
    }

    return $query;
}

    

    protected function applyFilterCondition($query, $filter, $operator, $value)
    {
        if ($operator === 'between' && is_array($value)) {
            $from = $value['from'] ?? null;
            $to   = $value['to'] ?? null;

            if ($from && $to) {
                $query->whereBetween($filter, [$from, $to]);
            } elseif ($from) {
                $query->where($filter, '>=', $from);
            } elseif ($to) {
                $query->where($filter, '<=', $to);
            }
            return;
        }

        switch ($operator) {
            case 'like':
                $query->where($filter, 'like', '%' . $value . '%');
                break;
            case '>':
                $query->where($filter, '>', $value);
                break;
            case '<':
                $query->where($filter, '<', $value);
                break;
            case '>=':
                $query->where($filter, '>=', $value);
                break;
            case '<=':
                $query->where($filter, '<=', $value);
                break;
            case '=':
                $query->where($filter, '=', $value);
                break;
            default:
                break;
        }
    }

    protected function applySorting($query, $request, $sorts)
    {
        $sortField = $request->query('sort');
        $sortOrder = $request->query('direction', 'desc');

        if ($sortField !== null && in_array($sortField, $sorts)) {
            $query->orderBy($sortField, $sortOrder);
        } else {
            $query->orderBy('id', $sortOrder);
        }

        return $query;
    }

    protected function getFilteredResults($modelOrQuery, $request, $filters, $sorts, $resource, $distincname = null)
    {

        if ($modelOrQuery instanceof Builder) {
            $query = $modelOrQuery;
        } else {
            $query = $modelOrQuery::query();
        }

        $query = $this->applyFilters($query, $request, $filters,$distincname);
        $query = $this->applySorting($query, $request, $sorts);

        $all     = $request->query('all', false) === 'true';
        $results = $all ? $query->get() : $query->paginate($request->query('per_page', Constants::DEFAULT_PER_PAGE));

        return $all ? response()->json($resource::collection($results)) : $resource::collection($results);
    }
}
