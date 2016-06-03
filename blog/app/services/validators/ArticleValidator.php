<?php

namespace App\Services\Validators;

class ArticleVlidator extends Validator{
	
	public static $rules = array(
		'title'    => 'required',
		'body'     => 'required',
	);
}