<?php
/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 19/04/2016
 * Time: 9:21 AM
 */

namespace App\Repositories\Platform\Space;


use App\Entities\Platform\Space\Space;
use App\Entities\Platform\User;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;


class SpaceRepository extends BaseRepository
{
	protected $boolFillable = ['alcohol_restriction', 'snuff_restriction', 'policy_restriction', 'sex_restriction'];

    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'App\Entities\Platform\Space\Space';
    }

    /**
     * @param array $data
     * @param Space $space
     */
    public function sync(array $data, Space $space)
    {
        if(array_key_exists('audiences', $data)) {
            $space->audiences()->sync(explode(',', $data['audiences']));
        }

        if(array_key_exists('cities', $data)) {
            $space->cities()->sync(explode(',', $data['cities']));
        }

        if(array_key_exists('impact_scenes', $data)) {
            $space->impactScenes()->sync(explode(',', $data['impact_scenes']));
        }
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        $space = parent::create($data);
        $this->sync($data, $space);

        return $space;
    }

    /**
     * @param array $data
     * @param Model $entity
     * @return mixed
     */
    public function update(array $data, $entity)
    {
        parent::update($data, $entity);

        if($entity->format && $entity->format->subCategory) {
            $entity->sub_category_id 	= $entity->format->subCategory->id;
            $entity->category_id 		= $entity->format->getCategory()->id;
            $entity->save();
        }

        $this->sync($data, $entity);
        return $entity;
    }

    /**
     * @param Space $space
     * @param $name
     * @return Model
     */
    public function createImage(Space $space, $name) 
    {
        return $space->images()->create([
            'url'  => $name,
            'thumb' => $name
        ]);
    }

    /**
     * @param Space $space
     * @param $name
     * @return bool
     */
    public function updateDetailThumb(Space $space, $name)
    {
        $space->urlThumb = $name;
        return $space->save();
    }

    /**
     * @param User $user
     * @return mixed
     */
    public function countSpaces(User $user) 
    {
        return $user->spaces()->count();
    }

    /**
     * @return mixed
     */
    public function allSpaces()
    {
        return $this->model->load(['images', 'audiences', 'format.subCategory.category', 'impactScenes'])->get();
    }

    /**
     * @param Space $space
     * @param bool $active
     * @return bool
     */
    public function active(Space $space, $active = true)
    {
        $space->active = $active;
        return $space->save();
    }
    
}