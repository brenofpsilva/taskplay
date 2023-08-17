<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\ListColumn;
use App\Models\Task;
use Asantibanez\LivewireStatusBoard\LivewireStatusBoard;
use Illuminate\Support\Collection;

class TasksStatusBoard extends LivewireStatusBoard
{
    public function statuses(): Collection
    {

        return ListColumn::query()
            ->get()
            ->map(function (ListColumn $listColumn){
                return [
                    'id' => $listColumn->id,
                    'title' => $listColumn->name
                ];
            });
    }

    public function records(): Collection
    {

        return Task::query()
            ->orderBy('order','ASC')
            ->orderBy('created_at','DESC')
            ->get()
            ->map(function (Task $task) {
                return [
                    'id'              => $task->id,
                    'title'           => $task->title,
                    'status'          => $task->list_id,
                    'start_date_time' => $task->start_date_time,
                    'end_date_time'   => $task->end_date_time,
                    'order'           => $task->order
                ];
            });
    }

    public function onStatusSorted($recordId, $statusId, $orderedIds)
    {
        foreach ($orderedIds as $order => $orderedId) {
            Task::where('id', $orderedId)->update(['order' => $order]);
        }
    }

    public function onStatusChanged($recordId, $statusId, $fromOrderedIds, $toOrderedIds)
    {
        try {
            $record = Task::findOrFail($recordId);
            $record->update(['list_id' => $statusId]);

            foreach ($toOrderedIds as $order => $orderedId) {
                Task::where('id', $orderedId)->update(['order' => $order]);
            }

            foreach ($fromOrderedIds as $order => $orderedId) {
                Task::where('id', $orderedId)->update(['order' => $order]);
            }

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return 'Error: '. $e;
        }
    }

    public function onRecordClick($recordId)
    {
        dd($recordId);
    }

    public function styles()
    {
        $baseStyles = parent::styles();

        $baseStyles['wrapper'] = 'w-full flex space-x-4 overflow-x-auto bg-blue-500 px-4 py-8';

        $baseStyles['statusWrapper'] = 'flex-1';

        $baseStyles['status'] = 'bg-gray-200 rounded px-2 mr-2 flex flex-col flex-1';

        $baseStyles['statusHeader'] = 'text-sm font-bold py-2 text-gray-700 ';

        $baseStyles['statusRecords'] = 'space-y-2 px-1 pt-2 pb-2';

        $baseStyles['record'] = 'shadow bg-white p-2 rounded border text-sm text-gray-800 mb-4';

        return $baseStyles;
    }
}
