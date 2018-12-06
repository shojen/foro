<?php
//Routes that require authentication.

//Posts

Route::get('posts/create',[
		'uses'=>'CreatePostController@create',
		'as'=>'posts.create',
	]);
Route::post('posts/create', [
		'uses'=>'CreatePostController@store',
		'as'=>'posts.store',
	]);	

//COMMENTS

Route::post('posts/{post}/comment', [
	'uses' => 'CommentController@store',
	'as'	=> 'comments.store',
	]);

Route::post('comments/{comment}/accept', [
		'uses' 	=> 'CommentController@accept',
		'as'	=> 'comments.accept',
	]);
  

//SUBSCRIPTION  

Route::post('posts/{post}/subscribe',[
	'uses' => 'SubscriptionController@subscribe',
	'as'	=> 'posts.subscribe'
	]);

Route::delete('posts/{post}/unsubscribe',[
	'uses' => 'SubscriptionController@unsubscribe',
	'as'	=> 'posts.unsubscribe'
	]);

Route::get('mis-post/{category?}', [
	'uses' => 'ListPostController',
	'as' => 'posts.mine'
]);

//VOTES
Route::post('posts/{post}-{slug}/upvote',[
	'uses' => 'VotePostController@upvote'
])->where('post','[0-9]+');

Route::post('posts/{post}-{slug}/downvote',[
	'uses' => 'VotePostController@downvote'
])->where('post','[0-9]+');

Route::delete('posts/{post}-{slug}/vote',[
	'uses' => 'VotePostController@undovote'
])->where('post','[0-9]+');