<?php

namespace App\Services;

use App\Models\Category;

class CategoryService{

    /**
     *  @var category
     */
    protected $category;

    /**
     *  Constructs a new CategoryService object.
     *  @param category $category
     *  @return void
     */
    public function __construct(Category $category)
    {
        $this-> category = $category;
    }

    /**
     * Delete category.
     *
     * @param   int $id
     * @return void
     */
    public function destroy($id)
    {
        $category = $this -> category::findOrFail($id);
        if ($category) {
            $category -> update([
                'flag_delete' => config('constants.FLAG_DELETED'),
            ]);
        }
    }
}