@extends('admin.layouts.app')

@section('title', 'Заявка #' . $ticket->id)

@section('content')
<div class="mb-3">
    <a href="{{ route('admin.tickets.index') }}" class="text-decoration-none">← Назад к списку</a>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Заявка #{{ $ticket->id }}</h5>
            </div>
            <div class="card-body">
                <dl class="row mb-0">
                    <dt class="col-sm-3">Тема</dt>
                    <dd class="col-sm-9">{{ $ticket->subject }}</dd>

                    <dt class="col-sm-3">Сообщение</dt>
                    <dd class="col-sm-9">
                        <p class="mb-0" style="white-space: pre-wrap;">{{ $ticket->body }}</p>
                    </dd>

                    <dt class="col-sm-3">Создана</dt>
                    <dd class="col-sm-9">{{ $ticket->created_at->format('d.m.Y H:i:s') }}</dd>

                    @if ($ticket->replied_at)
                    <dt class="col-sm-3">Дата ответа</dt>
                    <dd class="col-sm-9">{{ $ticket->replied_at->format('d.m.Y H:i:s') }}</dd>
                    @endif
                </dl>
            </div>
        </div>

        @if ($files->isNotEmpty())
        <div class="card mb-4">
            <div class="card-header">
                <h6 class="mb-0">Прикреплённые файлы ({{ $files->count() }})</h6>
            </div>
            <ul class="list-group list-group-flush">
                @foreach ($files as $file)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <span class="me-2">📎</span>
                        {{ $file->file_name }}
                        <small class="text-muted ms-2">{{ number_format($file->size / 1024, 1) }} KB</small>
                    </div>
                    <a href="{{ $file->getUrl() }}" class="btn btn-sm btn-outline-secondary" download>
                        Скачать
                    </a>
                </li>
                @endforeach
            </ul>
        </div>
        @endif
    </div>

    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-header">
                <h6 class="mb-0">Клиент</h6>
            </div>
            <div class="card-body">
                <p class="mb-1"><strong>{{ $ticket->customer->name }}</strong></p>
                <p class="mb-1">📞 {{ $ticket->customer->phone }}</p>
                @if ($ticket->customer->email)
                <p class="mb-0">✉️ {{ $ticket->customer->email }}</p>
                @endif
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Статус заявки</h6>
            </div>
            <div class="card-body">
                @php
                    $badges = ['new' => 'primary', 'in_progress' => 'warning', 'resolved' => 'success'];
                    $labels = ['new' => 'Новый', 'in_progress' => 'В работе', 'resolved' => 'Обработан'];
                @endphp
                <p>
                    Текущий:
                    <span class="badge bg-{{ $badges[$ticket->status] ?? 'secondary' }}">
                        {{ $labels[$ticket->status] ?? $ticket->status }}
                    </span>
                </p>

                <form action="{{ route('admin.tickets.update-status', $ticket) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="mb-3">
                        <select name="status" class="form-select form-select-sm">
                            <option value="new" {{ $ticket->status === 'new' ? 'selected' : '' }}>Новый</option>
                            <option value="in_progress" {{ $ticket->status === 'in_progress' ? 'selected' : '' }}>В работе</option>
                            <option value="resolved" {{ $ticket->status === 'resolved' ? 'selected' : '' }}>Обработан</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm w-100">Сохранить</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
