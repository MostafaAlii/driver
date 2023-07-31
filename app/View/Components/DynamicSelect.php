<?php
namespace App\View\Components;
use Illuminate\View\Component;
class DynamicSelect extends Component {
    public function __construct(public $options, public $name, public $selected = null) {
        $this->options = $options;
        $this->name = $name;
        $this->selected = $selected;
    }

    public function render() {
        return view('components.dashboard.dynamic-select');
    }
}