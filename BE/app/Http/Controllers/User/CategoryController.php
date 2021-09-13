<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
// use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Category\CreateCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Services\CategoryService;
use Exception;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    /**
     * Show list category from user.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // get user information login
        $user = Auth::guard('web')->user();
        // select id, name, parent name of table product_categories with user_id
        $data = Category::select('categories.id', 'categories.name', 'parent.name as parent_name')
            ->leftJoin('categories as parent', 'categories.parent_id', '=', 'parent.id')
            ->where('categories.user_id', $user->id)
            ->where('categories.flag_delete', config('constants.FLAG_DELETE'))
            ->paginate(config('constants.PAGINATION_RECORDS'));
        return view('user.category.index', compact('data'));
    }

    /**
     * Get page category user from user.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $parent = Category::select('id', 'name')
            ->where('parent_id', config('constants.PARENT_ID'))
            ->where('flag_delete', config('constants.FLAG_DELETE'))
            ->get();
        return view('user.category.create', compact('parent'));
    }

    /**
     * Store a new category.
     *
     * @param  \App\Http\Requests\User\CreateCategoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateCategoryRequest $request)
    {
        DB::beginTransaction();
        try {
            $category = new Category;
            // get user information login
            $user = Auth::guard('web')->user();
            $category->user_id = $user->id;
            $category->name = $request->name;
            $category->parent_id = $request->parent_id;
            $category->save();
            DB::commit();
            return redirect('/user/category')->withSuccessMessage('Create category successfully ');
        } catch (Exception $e) {
            DB::rollback();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param   int $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        // get user information login
        $user = Auth::guard('web')->user();
        // get information cateory that has id = $id
        $category = Category::select('id', 'name', 'parent_id')
            ->where('id', $id)
            ->where('user_id', $user->id)
            ->where('flag_delete', config('constants.FLAG_DELETE'))
            ->first();
        if ($category) {
            // select id, name of product_category with parent_id = parent_id
            $parent = Category::select('id', 'name')
                ->where('parent_id', config('constant.PARENT_ID'))
                ->where('flag_delete', config('constants.FLAG_DELETE'))
                ->get();
            return view('user.category.edit', compact('category', 'parent'));
        } else {
            return view('user.category.edit', ['error' => 'Không tìm thấy danh mục']);
        }
    }

    /**
     * Update the given user.
     *
     * @param  \App\Http\Requests\User\UpdateCategoryRequest  $request
     * @param   int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(UpdateCategoryRequest $request, $id)
    {
        // get user information login
        $user = Auth::guard('web')->user();
        DB::beginTransaction();
        // get information cateory that has id = $id
        $category = Category::select('id', 'name', 'parent_id')
            ->where('id', $id)
            ->where('user_id', $user->id)
            ->where('flag_delete', config('constants.FLAG_DELETE'))
            ->first();
        try {
            $category->name = $request->name;
            $category->parent_id = $request->parent_id;
            $category->user_id = $user->id;
            $category->save();
            DB::commit();
            return redirect()->route('user.get.category')->withSuccessMessage('Update category successfully ');
        } catch (Exception $e) {
            DB::rollback();
            return view('user.category.edit', ['error' => 'Category not found']);
        }
    }
    protected $categoryService;

    /**
     * Instantiate a new controller instance.
     * @param \App\Services\CategoryService $categoryService
     * @return void
     */
    public function __construct(CategoryService $categoryService)
    {
        $this->getAlert();
        $this->categoryService = $categoryService;
    }
    /**
     * Delete category.
     *
     * @param   int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $this->categoryService->destroy($id);
            DB::commit();
            return response()->json([
                'success' => true,
                'text' => 'Deleted!',
                'message' => 'Delete Successfully!',
            ]);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Delete failed ! ' . $e->getMessage(),
            ]);
        }
    }
}
