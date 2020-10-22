<?php

namespace Styde\Enlighten\View\Components;

use Illuminate\View\Component;
use Styde\Enlighten\Models\Statable;

class StatsBadgeComponent extends Component
{
    use RepresentsStatusAsColor;

    /**
     * @var Statable
     */
    private $model;

    public function __construct(Statable $model)
    {
        $this->model = $model;
    }

    public function render()
    {
        return view('enlighten::components.stats-badge', [
            'positive' => $this->model->getPassingTestsCount(),
            'total' => $this->model->getTestsCount(),
            'color' => $this->getColor($this->model),
        ]);
    }
}
