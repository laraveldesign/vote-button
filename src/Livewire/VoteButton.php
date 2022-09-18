<?php

namespace Laraveldesign\VoteButton\Livewire;

use Laraveldesign\VoteButton\Models\Vote;
use Livewire\Component;

class VoteButton extends Component
{

    public $model;
    public $voted = false;
    public $votes = 0;

    public function mount($model)
    {
        $this->model = $model;
        $this->calculate();
    }

    public function vote()
    {

        if (\Auth::check()) {
            $this->calculate();
            if(!$this->voted) {
                $vote = new Vote();
                $vote->user_id = auth()->user()->id;
                $vote->model_id = $this->model->id;
                $vote->model_class = get_class($this->model);
                $vote->save();
            } else {
                $vote = Vote::where([
                    ['user_id','=',auth()->user()->id],
                    ['model_id','=',$this->model->id],
                    ['model_class','=',get_class($this->model)]
                ])->first();
                if($vote) {
                    $vote->delete();
                }
            }
            $this->calculate();
        }
    }

    public function calculate()
    {
        $this->votes = Vote::where([
            ['model_id', '=', $this->model->id],
            ['model_class', '=', get_class($this->model)]
        ])->count();
        if(\Auth::check()) {
            $this->voted = Vote::where([
                    ['model_id', '=', $this->model->id],
                    ['model_class', '=', get_class($this->model)],
                    ['user_id', '=', auth()->user()->id]
                ])->count() > 0;
        } else {
            $this->voted = false;
        }
    }

    public function render()
    {
        return view('vote-button::livewire.vote-button');
    }
}
