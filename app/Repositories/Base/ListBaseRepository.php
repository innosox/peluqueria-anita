<?php

namespace App\Repositories\Base;

use Closure;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class ListBaseRepository
{

    private $model;
    private $parents;
    private $selfFieldsAndParents;
    private $addionalExceptData;

    public function __construct(Model $model, $parents, $selfFieldsAndParents, $addionalExceptData)
    {
        $this->model = $model;
        $this->parents = $parents;
        $this->selfFieldsAndParents = $selfFieldsAndParents;
        $this->addionalExceptData = $addionalExceptData;
    }

    /**
     * Selecciona campos especificos
     *
     * @param  array $selected
     * @return ListBaseRepository
     */
    public function withOutPaginate(array $selected) : ListBaseRepository
    {
        $this->model = $this->model->select($selected);
        return $this;
    }

    /**
     * Devuelve las relaciones de forma perezosa
     *
     * @param  array $relations
     * @return ListBaseRepository
     */
    public function withModelRelations(array $relations) : ListBaseRepository
    {
        if(count($relations) > 0)
            $this->model = $this->model->with($relations);

        return $this;
    }

    /**
     * Aplica busqueda con los campos de la tabla por request
     *
     * @param  mixed $request
     * @return ListBaseRepository
     */
    public function searchWithColumNames($request) : ListBaseRepository
    {
        $collectQueryString = $this->cleanQueryParams($request, $this->addionalExceptData);

        if(!empty($collectQueryString))
            $this->model = $this->model->where($collectQueryString);

        return $this;
    }

    /**
     * Aplica busquedas especificas con condiciones
     *
     * @param  mixed $request
     * @example 1 El request debe contener la key conditions
     * ```
     * $request['conditions'] = [
     *  ['nombre_campo', 'valor']
     * ]
     * ```
     * @return ListBaseRepository
     */
    public function searchWithConditions($request) : ListBaseRepository
    {
        if(isset($request->conditions))
            $this->model = $this->model->where($request->conditions);

        return $this;
    }

    /**
     * Aplica condiciones con el metodo whereRelation
     *
     * @param  string $relations
     * @param  Closure $callback
     * @return ListBaseRepository
     */
    public function whereModelRelation(string $relations, Closure $callback) : ListBaseRepository
    {
        $this->model = $this->model->whereRelation($relations, $callback);
        return $this;
    }

    /**
     * Retorna la data paginada
     *
     * @param  mixed $request
     * @param  string $table
     * @return void
     */
    public function paginated($request, string $table)
    {
        $sort = $request['sort'] ? $table . '.' . $request['sort'] : $table . '.id';
        $type_sort = $request['type_sort'] ? $request['type_sort'] : 'desc';
        $size = $request['size'] ? $request['size'] : 100;

        return $this->model->orderBy($sort, $type_sort)->paginate($size);
    }

    /**
     * Retorna el primer registro encontrado
     *
     * @return Model
     */
    public function first() : Model
    {
        return $this->model->first();
    }

    /**
     * Retorna toda la data encontrada
     *
     * @return Collection
     */
    public function getCollection() : Collection
    {
        return $this->model->get();
    }

    /**
     * Aplica el filtro de busqueda
     *
     * @param  mixed $request
     * @param  array $fields
     * @param  array $relations
     * @param  string $keyName
     * @param  string $table
     * @return ListBaseRepository
     */
    public function filter($request, array $fields, array $relations, string $keyName, string $table) : ListBaseRepository
    {
        $search = $request['search'];
        $model = $this->model;

        $model = $model->when($search, function ($query, $search) use ($fields, $relations, $keyName, $table) {

            $selfFieldsAndParents = $this->selfFieldsAndParents;

            $query = $query->when($this->getParents() == 0, function ($query) use ($fields, $search) {

                $query = $query->where(function ($query) use ($fields, $search) {

                    for ($i = 0; $i < count($fields); $i++) {

                        $query->orwhere($fields[$i], 'like',  '%' . $search . '%');

                    }

                });

                return $query;

            })->when(count($relations) > 0, function ($query) use ($selfFieldsAndParents, $keyName, $table, $relations, $search) {

                for ($i = 0; $i < count($this->getParents()); $i++) {

                    $query->select($table . '.*')->join($this->getParent($i), function ($join) use ($i, $keyName, $table, $relations) {

                        $join->on(
                            $this->getParent($i) . "." . $keyName,
                            $table . "." . $relations[$i]
                        );
                    });
                }

                $query = $query->where(function ($query) use ($search, $selfFieldsAndParents) {

                    for ($i = 0; $i < count($selfFieldsAndParents); $i++) {

                        $query->orwhere($selfFieldsAndParents[$i], 'like',  '%' . $search . '%');

                    }

                });

                return $query;

            });

        });

        $this->model = $model;
        return $this;
    }


    /**
     * Limpia la data enviada desde el request
     *
     * @param  mixed $request
     * @param  array $addionalExceptData
     * @return void
     */
    private function cleanQueryParams($request, array $addionalExceptData)
    {
        return collect($request->all())
                    ->except(
                        array_merge([
                            'page',
                            'size',
                            'sort',
                            'type_sort',
                            'search',
                            'data',
                            'conditions',
                            'user_id'
                        ], $addionalExceptData))->all();
    }

    /**
     * Get all the loaded parents for the instance.
     *
     * @return array|int
     */
    private function getParents()
    {
        if (count($this->parents) > 0)
            return $this->parents;

        return 0;
    }

    /**
     * Get a specified parent.
     *
     * @param  int  $position
     * @return mixed
     */
    private function getParent(int $position)
    {
        return $this->parents[$position];
    }


}
