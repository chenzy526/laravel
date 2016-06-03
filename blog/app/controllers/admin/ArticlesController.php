<?php

namespace App\Controllers\Admin;

use Article;
use App\Services\Validators\ArticleVlidator;
use Input,Redirect,Sentry,Notification;

class ArticlesController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /admin/articles
	 *
	 * @return Response
	 */
	public function index()
	{
		return \View::make('admin.articles.index')->with('articles',\Article::all());
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /admin/articles/create
	 *
	 * @return Response
	 */
	public function create()
	{
		return \View::make('admin.articles.create');
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /admin/articles
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator	= new ArticleVlidator();
		
		if ($validator->passes()) {
			$article	= new Article();
			$article->title	   = Input::get('title');
			$article->body	   = Input::get('body');
			$article->user_id  = Sentry::getUser()->id;
	
			$article->save();
			
			Notification::success('新增成功');
			
			return  Redirect::route('admin.articles.index');
			
		}
		
		return Redirect::back()->withInput()->withErrors($validator->errors);
	}

	/**
	 * Display the specified resource.
	 * GET /admin/articles/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		return \View::make('admin.articles.show')->with('article', \Article::find($id))->withAuthor(Sentry::findUserById(Article::find($id)->user_id)->name);
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /admin/articles/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		return \View::make('admin.articles.edit')->with('article',\Article::find($id));
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /admin/articles/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$validator	= new ArticleVlidator();
			
			if ($validator->passes()) {
				$article	= Article::find($id);
				$article->title	   = Input::get('title');
				$article->body	   = Input::get('body');
				$article->user_id  = Sentry::getUser()->id;
		
				$article->save();
				
				Notification::success('编辑成功');
				
				return  Redirect::route('admin.articles.index');
				
			}
			
			return Redirect::back()->withInput()->withErrors($validator->errors);
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /admin/articles/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$article	= Article::find($id);
		$article->delete();
		
		Notification::success("删除成功");
		
		return Redirect::route("admin.articles.index");
		
	}

}








