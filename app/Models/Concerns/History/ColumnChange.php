<?php 
namespace App\Models\Concerns\History;
class ColumnChange {
    public function __construct(public $column, public $from, public $to) {
        $this->column = $column;
        $this->from = $from;
        $this->to = $to;
    }
}