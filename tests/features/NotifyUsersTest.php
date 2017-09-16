<?php

use App\Notifications\PostCommented;
use App\User;
use Illuminate\Support\Facades\Notification;

class NotifyUsersTest extends FeaturesTestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_the_subscribers_recive_a_notification_when_post_is_commented()
    {

    	Notification::fake();
        $post=$this->createPost();

        $subscriber = factory(User::class)->create();

        $subscriber->subscribeTo($post);

        $writer = factory(User::class)->create();

        $comment = $writer->comment($post,'Un comentario cualquiera');

        Notification::assertSentTo($subscriber, PostCommented::class, function($notification) use($comment){
        	return $notification->comment->id == $comment->id;
        });

        // The author of the comment shouldn't be notified even if he or she is a subscriber.
        Notification::assertNotSentTo($writer,PostCommented::class);
    }
}
