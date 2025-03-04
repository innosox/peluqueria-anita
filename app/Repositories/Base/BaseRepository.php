<?php

namespace App\Repositories\Base;

use App\Models\Admission\Proceso;
use App\Models\Admission\Solicitud;
use App\Repositories\Contracts\IBaseRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

class BaseRepository implements IBaseRepository
{

    /**
     * model
     *
     * @var mixed
     */
    protected $model;

    /**
     * Relaciones con el modelo para data paginada
     *
     * @var array
     */
    protected $relations = [];

    /**
     * Relaciones con el modelo para data all
     *
     * @var array
     */
    protected $relationsDataAll = [];

    /**
     * Campos del modelo que se encuentra en $fillable
     *
     * @var array
     */
    protected $fields = [];

    /**
     * Campos del modelo hijo y campos del modelo padre
     *
     * @var array
     */
    protected $selfFieldsAndParents = [];

    /**
     * Claves enviadas desde el request para evitar conflictos
     *
     * @var array
     */
    protected $adaddionalExceptData = [];

    /**
     * Especifica campos seleccionados
     *
     * @var array
     */
    protected $selected = ['*'];

    /**
     * Nombre de las tablas con los padres que se relaciona el modelo base
     *
     * @var array
     */
    protected $parents = [];

    protected $data;

    public function __construct(Model $model)
    {
        $this->model = $model;
        $this->data = new ListBaseRepository(
            $model,
            $this->parents,
            $this->selfFieldsAndParents,
            $this->adaddionalExceptData
        );
    }


    /**
     * @param $request
     * @return mixed
     */
    public function all($request)
    {
        if(isset($request['data'])) {
            return ($request['data'] === 'all') ? $this->data->withOutPaginate($this->selected)->searchWithConditions($request)->withModelRelations($this->relationsDataAll)->getCollection() : [];
        }

        return $this->data->withModelRelations($this->relations)
                        ->searchWithColumNames($request)
                        ->searchWithConditions($request)
                        ->filter(
                            $request,
                            $this->fields,
                            $this->model->getRelations(),
                            $this->model->getKeyName(),
                            $this->model->getTable()
                        )->paginated($request, $this->model->getTable());
    }

    /**
     * find information by conditionals
     *
     * @param $id
     * @return model
     */
    public function find($id): Model
    {
        $query = $this->model;

        if (!empty($this->relations)) {
            $query = $query->with($this->relations);
        }

        return $query->findOrFail($id);
    }

    /**
     * find the specified resource.
     *
     * @param array $conditionals
     * @return Model
     *
     */
    public function findByConditionals(array $conditionals)
    {
        $query = $this->model;

        if (!empty($this->relations)) {
            $query = $query->with($this->relations);
        }

        return $query->where($conditionals)->firstOrFail();
    }

    /**
     * get specified resources.
     *
     * @param array $conditionals
     * @param bool $withRelations
     * @return Collection
     */
    public function getByConditionals(array $conditionals, bool $withRelations = true): Collection
    {
        $query = $this->model;

        if (!empty($this->relations) && $withRelations === true) {
            $query = $query->with($this->relations);
        }

        return $query->where($conditionals)->get();
    }

    /**
     * save data
     * @param Model $model
     * @return Model
     */
    public function save(Model $model) : Model
    {
        $model->save();
        return $model;
    }

    /**
     * delete a information
     * @param Model $model
     * @return model
     */
    public function destroy(Model $model) : Model
    {
        $model->delete();
        return $model;
    }

}
