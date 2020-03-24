<?php


namespace App\Services;


use App\Like;
use App\News;
use App\Photo;
use App\User;
use Illuminate\Database\Eloquent\Relations\Relation;

class LikeService
{
    const AVAILABLE_CLASSES = [
        News::class,
        Photo::class,
    ];

    /**
     * @param string $modelName
     * @param $id
     * @param User $user
     * @return bool
     * @throws \Exception
     */
    public function like(string $modelName, $id, User $user): bool
    {
        $model = $this->getMorphedModelByNameAndId($modelName, $id);
        if($this->findLike($model, $user))
            return false;
        $this->createNewLike($model, $user);
        return  true;
    }

    /**
     * @param string $modelName
     * @param $id
     * @param User $user
     * @return bool
     * @throws \Exception
     */
    public function unlike(string $modelName, $id, User $user): bool
    {
        $model = $this->getMorphedModelByNameAndId($modelName, $id);
        $like = $this->findLike($model, $user);
        if($like)
            return $like->delete();
        return false;
    }

    private function findLike($model, User $user): ?Like
    {
        return Like::whereHasMorph('can_be_liked', get_class($model), function ($query) use ($model) {
            $query->where('id', '=', $model->id);
        })
            ->where('user_id', '=', $user->id)
            ->first();
    }

    private function createNewLike($model, User $user)
    {
        $like = new Like();
        $like->can_be_liked()->associate($model);
        $like->user()->associate($user);
        try {
            $like->save();
        } catch (\Exception $exception) {
            throw new \Exception($exception);
        }
        return $like;
    }

    private function getMorphedModelByNameAndId(string $modelName, $id)
    {
        $modelClass = Relation::getMorphedModel(
            $modelName
        );
        if (!in_array($modelClass, self::AVAILABLE_CLASSES))
            throw new \Exception('Trying to like item, that can\'t be liked');

        return call_user_func($modelClass . '::findOrFail', $id);
    }
}
