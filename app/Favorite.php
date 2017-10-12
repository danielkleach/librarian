<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Exceptions\UserAlreadyFavoritedException;

class Favorite extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    /***********************************************/
    /**************** Relationships ****************/
    /***********************************************/

    /**
     * A Favorite belongs to a User.
     *
     * @return mixed
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get all of the owning favoritable models.
     */
    public function favoritable()
    {
        return $this->morphTo();
    }

    /***********************************************/
    /******************* Methods *******************/
    /***********************************************/

    /**
     * Create a favorite.
     *
     * @param $userId
     * @param $item
     * @return $this|Model
     * @throws UserAlreadyFavoritedException
     * @internal param $bookId
     */
    public function createFavorite($userId, $item)
    {
        $favorite = $this->where('user_id', $userId)
            ->where('favoritable_id', $item->id)
            ->where('favoritable_type', get_class($item))
            ->exists();

        if ($favorite) {
            throw new UserAlreadyFavoritedException;
        }

        $favorite = $this->create([
            'user_id' => $userId,
            'favoritable_id' => $item->id,
            'favoritable_type' => get_class($item)
        ]);

        return $favorite;
    }
}
