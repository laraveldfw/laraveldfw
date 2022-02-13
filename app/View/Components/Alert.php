<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Alert extends Component
{
    public const TYPE_WARNING = 'warning';
    public const TYPE_ERROR = 'error';
    public const TYPE_SUCCESS = 'success';
    public const TYPE_INFO = 'info';
    public const TYPE_QUESTION = 'question';

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        public string $message,
        public ?string $type = null,
        public ?string $title = null
    ) {}

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.alert');
    }
}
