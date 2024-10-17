<div class="mt-4">
    <div class="flex flex-col md:flex-row gap-4">
        <div class="flex-1 bg-white border p-3 text-white">
            {!! $tasksGraphData->render() !!}
        </div>
        <div class="flex-1 bg-white border p-2 text-white">
            {!! $itemsCountGraphData->render() !!}
        </div>
    </div>
</div>
