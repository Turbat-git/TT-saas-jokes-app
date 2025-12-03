<?php

namespace App\Livewire;

use App\Models\Joke;
use App\Models\Vote;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

/**
 * Like/Dislike Component
 */
class LikeDislike extends Component
{
    /**
     * The joke being voted on
     *
     * @var Joke
     */
    public Joke $joke;
    /**
     * The vote for the current joke
     * @var Vote|null
     */
    public ?Vote $userVote = null;
    /**
     * The previous value of the vote
     *
     * @var int
     */
    public int $lastUserVote = 0;
    /**
     * Total Likes
     *
     * @var int
     */
    public int $likes = 0;
    /**
     * Total Dislikes
     * @var int
     */
    public int $dislikes = 0;


    /**
     * Mount (Activate) the component
     *
     * When the component is "inserted" into the page, initialise
     * any required component properties.
     *
     * @param Joke $joke
     * @return void
     */
    public function mount(Joke $joke): void
    {
        $this->joke = $joke;
        $this->userVote = $joke->userVotes;
        $this->lastUserVote = $this->userVote->vote ?? 0;

        $this->likes = $joke->likesCount ?? 0;
        $this->dislikes = $joke->dislikesCount ?? 0;
    }

    /**
     * Update the Likes
     *
     * @return void
     */
    public function like()
    {
        $this->validateAccess();

        if ($this->hasVoted(1)) {
            // Update the vote (change value)
            $this->updateVote(0);
        } else {
            // update the vote (to 1)
            $this->updateVote(1);
        }
    }

    /**
     * Update Dislikes
     *
     * @return void
     */
    public function dislike()
    {
        $this->validateAccess();

        if ($this->hasVoted(-1)) {
            // Update the vote (change value)
            $this->updateVote(0);
        } else {
            // update the vote (to -1)
            $this->updateVote(-1);
        }
    }

    /**
     * Verify that the user is NOT a guest
     * - Guest users are not allowed to vote
     *
     * @return bool
     * @throws \Throwable
     */
    private function validateAccess(): bool
    {
        throw_if(
            auth()->guest(),
            ValidationException::withMessages([
                'unauthenticated' =>
                    'You need to <a href="'
                    . route('login')
                    . '" class="underline">log in</a> to click like/dislike'
            ])
        );
        return true;
    }

    /**
     * Check if the authenticated user has voted for the current joke
     *
     * @param int $value
     * @return bool
     */
    private function hasVoted(int $value): bool
    {
        return $this->userVote &&
            $this->userVote->vote === $value;
    }

    /**
     * Update the vote value
     * - If user has voted change their vote
     * - If user has not voted then create their vote
     * - Update the likes and dislikes totals
     * - Update the last user vote value for this joke
     *
     * @param int $value
     * @return void
     */
    private function updateVote(int $value): void
    {
        if ($this->userVote) {
            $this->joke->votes()
                ->update(['user_id' => auth()->id(), 'vote' => $value]);
        } else {
            $this->userVote = $this->joke->votes()
                ->create(['user_id' => auth()->id(), 'vote' => $value]);
        }

        $this->setLikesAndDislikesCount($value);

        $this->lastUserVote = $value;
    }

    /**
     * Set the Likes and Dislikes counts
     *
     * Depending on the last vote value and the new value, we update
     * the likes and dislikes counts.
     *
     * @param int $value
     * @return void
     */
    private function setLikesAndDislikesCount(int $value): void
    {
        match (true) {
            $this->lastUserVote === 0 && $value === 1 => $this->likes++,
            $this->lastUserVote === 0 && $value === -1 => $this->dislikes++,
            $this->lastUserVote === 1 && $value === 0 => $this->likes--,
            $this->lastUserVote === -1 && $value === 0 => $this->dislikes--,

            $this->lastUserVote === 1 && $value === -1 => call_user_func(
                function () {
                    $this->dislikes++;
                    $this->likes--;
                }
            ),
            $this->lastUserVote === -1 && $value === 1 => call_user_func(
                function () {
                    $this->dislikes--;
                    $this->likes++;
                }
            ),

            $this->lastUserVote === 0 && $value === 0 => call_user_func(
                function () {
                    // This is a precautionary "Do Nothing" for the
                    // intermittent, and rare cases where the click
                    // appears to neither like, nor dislike
                }
            ),
        };

    }


    /**
     * Render the component on screen
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\View\View|object
     */
    public function render()
    {
        return view('livewire.like-dislike');
    }

}
