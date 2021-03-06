<?php



namespace XRA\Blog\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use XRA\Blog\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('view', Category::class);

        $categories = Category::all();

        return view('blog::categories.index', ['categories' => $categories]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Category::class);

        return view('blog::categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Category::class);

        $this->validate($request, [
            'name' => 'required|unique:XRA_blog_categories,name|max:255',
        ]);

        Category::create($request->all());

        return redirect()->route('XRA::blog.categories.index')
            ->with('success', __('XRA_blog::general.category_added'));
    }

    /**
     * Display the specified resource.
     *
     * @param \XRA\Blog\Models\Category $category
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        $this->authorize('view', Category::class);

        return view('blog::categories.show', ['category' => $category]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \XRA\Blog\Models\Category $category
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        $this->authorize('update', $category);

        return view('blog::categories.edit', ['category' => $category]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request  $request
     * @param \XRA\Blog\Models\Category $category
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $this->authorize('update', $category);

        $this->validate($request, [
            'name' => 'required|max:255',
        ]);
        $category->update($request->all());

        return redirect()->route('XRA::blog.categories.index')
            ->with('success', __('XRA_blog::general.category_updated', ['id' => $category->id]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \XRA\Blog\Models\Category $category
     *
     * @return \Illuminate\Http\Response
     */
    public function confirmDestroy(Category $category)
    {
        $this->authorize('delete', $category);

        return view('XRA::pages.confirmation', [
            'method' => 'DELETE',
            'message' => __('XRA_blog::general.sure_del_category', ['category' => $category->name]),
            'action' => route('XRA::blog.categories.destroy', ['category' => $category->id]),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \XRA\Blog\Models\Category $category
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $this->authorize('delete', $category);

        $category->posts->each(function ($post) {
            $post->update(['category_id' => Category::first()->id]);
        });

        $category->delete();

        return redirect()->route('XRA::blog.categories.index')
            ->with('success', __('XRA_blog::general.category_deleted', ['id' => $category->id]));
    }
}
