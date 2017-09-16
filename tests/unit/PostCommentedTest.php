<?php

use App\Comment;
use App\Notifications\PostCommented;
use App\Post;
use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Notifications\Messages\MailMessage;


class PostCommentedTest extends TestCase
{
	use DatabaseTransactions;
    /**
	* @test
	**/
    public function it_builds_a_mail_message()
    {
    	$author = factory(User::class)->create([
    		'name' => 'Angel Rosso'
    	]);

    	$post = factory(Post::class)->create([
    		'title' =>'Titulo del post'    		
    	]);

        $comment = factory(Comment::class)->create([
        	'post_id' => $post->id,
        	'user_id' => $author->id
        ]);

        $notification = new PostCommented($comment);

        $subscriber = factory(User::class)->create();

        $message = $notification->toMail($subscriber);

        $this->assertInstanceOf(MailMessage::class,$message);

        $this->assertSame(
        	'Nuevo comentario en: Titulo del post',
        	$message->subject
        );

        $this->assertSame(
        	'Angel Rosso escribió un comentario en: Titulo del post',
        	$message->introLines[0]
        );

        $this->assertSame($post->url,$message->actionUrl);

    }
}
