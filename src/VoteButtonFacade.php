<?php

namespace Laraveldesign\VoteButton;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Laraveldesign\VoteButton\Skeleton\SkeletonClass
 */
class VoteButtonFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'vote-button';
    }
}
