<?php 

namespace App;

use Illuminate\Database\Eloquent\Model;

trait CanBeVoted
{
	
    protected function refreshPostScore()
    {
        $this->score=Vote::where(['post_id' => $this->id])->sum('vote');
        $this->save();
    }

    public function getCurrentVoteAttribute()
    {
        return Vote::where('user_id',auth()->id())->value('vote');//+1, -1, null
    }

    public function upvote()
    {
        
        $this->addVote(1);
        
    }

    public function downvote()
    {
        
        $this->addVote(-1);
        
    }

    protected function addVote($amount)
    {
        Vote::updateOrCreate([
            'user_id' => auth()->id(),
            'post_id' => $this->id],
        [
            'vote' => $amount,
        ]);

        $this->refreshPostScore();
    }

    public function undoVote()
    {
        Vote::where([
            'post_id' => $this->id,
            'user_id' => auth()->id(),
        ])->delete();

        $this->refreshPostScore();
    }

    
}