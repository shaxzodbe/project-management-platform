@component('mail::message')
    # Новая задача назначена!

    Вам была назначена новая задача: {{ $task->title }} в проекте {{ $task->project->name }}.

    **Описание:**
    {{          $task->description }}

    Вы можете просмотреть детали задачи в [здесь]({{ url('/api/tasks/' . $task->id) }}).

    Спасибо,
    {{ config('app.name') }}
@endcomponent
