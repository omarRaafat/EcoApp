<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateBlogPostRequest;
use App\Services\Admin\BlogPostService;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;


class BlogController extends Controller
{
    

    /**
     * @param BlogPostService $service
     */
    public function __construct(
        public BlogPostService $service,
    ) {}
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $request = request();
        $blogPosts = $this->service->getAllBlogPostsWithPagination($request,20);
        return view("admin.blogpost.index",compact('blogPosts'));
    }

    public function show(int $id)
    {
        $blogPost = $this->service->getBlogPostUsingID($id)->load('media');
        $breadcrumbParent = 'admin.blog.index';
        $breadcrumbParentUrl = route('admin.blog.index');
        return view("admin.blogpost.show", compact('blogPost', "breadcrumbParent", "breadcrumbParentUrl"));
    }
    
    public function create(){
        $breadcrumbParent = 'admin.blog.index';
        $breadcrumbParentUrl = route('admin.blog.index');

        return view('admin.blogpost.create', compact("breadcrumbParent", "breadcrumbParentUrl"));
    }

    public function store(CreateBlogPostRequest $request){

        $result = $this->service->createBlogPost($request);

        if($result["success"] == true) {
            Alert::success($result["title"], $result["body"]);
            return redirect()->route("admin.blog.index");
        }

        Alert::error($result["title"], $result["body"]);
        return redirect()->back();
    }


    public function edit(int $id)
    {
        $blogPost =  $this->service->getBlogPostUsingID($id);
        $breadcrumbParent = 'admin.blog.index';
        $breadcrumbParentUrl = route('admin.blog.index');

        return view("admin.blogpost.edit", compact('blogPost', "breadcrumbParent", "breadcrumbParentUrl"));
    }

    /**
     * Update the category..
     *
     * @param  UpdateCategoryRequest  $request
     * @param  int  $id
     * @return Redirect
     */
    public function update(CreateBlogPostRequest $request, int $id)
    {
        $result = $this->service->updateBlogPost($id, $request);

        if($result["success"] == true) {
            Alert::success($result["title"], $result["body"]);
            return redirect()->route("admin.blog.index", $id);
        }

        Alert::error($result["title"], $result["body"]);
        return redirect()->back();
    }

    public function destroy(int $id)
    {
        $result = $this->service->deleteBlogPost($id);

        if($result["success"] == true) {
            Alert::success($result["title"], $result["body"]);
        } else {
            Alert::error($result["title"], $result["body"]);
        }

        return redirect()->route('admin.blog.index');
    }
}
