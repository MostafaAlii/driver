<?php
namespace App\Models\Concerns\History;
use App\Models\History;
use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Model;
trait Historyable {
    public static function bootHistoryable() {
        static::updated(function (Model $model) {
            collect($model->getWantedChangedColumns($model))->each(function ($change) use ($model) {
                $model->saveChange($change);
            });
        });
    }

    protected function saveChange(ColumnChange $change) {
        $this->history()->create([
            'changed_column' => $change->column,
            'change_value_from' => $change->from,
            'change_value_to' => $change->to,
            'admin_id' => auth()->guard('admin')?->id(),
            'user_id' => auth()->guard('web')?->id(),
            'driver_id' => auth()->guard('driver')?->id(),
        ]);
    }

    protected function getWantedChangedColumns(Model $model) {
        return collect(
            array_diff(Arr::except($model->getChanges(), $this->ignoreHistoryColumns()), $original = $model->getOriginal())
        )->map(function ($change, $column) use ($original) {
            return new ColumnChange($column, Arr::get($original, $column), $change);
        });
    }

    public function history() {
        return $this->morphMany(History::class, 'historyable')->latest();
    }

    public function ignoreHistoryColumns() {
        return 'updated_at';
    }
}