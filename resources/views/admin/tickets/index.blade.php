@extends('admin.layouts.app')

@section('title', 'Заявки')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Заявки</h1>
</div>

<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.tickets.index') }}" class="row g-3">
            <div class="col-md-2">
                <label class="form-label">Статус</label>
                <select name="status" class="form-select form-select-sm">
                    <option value="">Все</option>
                    <option value="new" {{ request('status') === 'new' ? 'selected' : '' }}>Новый</option>
                    <option value="in_progress" {{ request('status') === 'in_progress' ? 'selected' : '' }}>В работе</option>
                    <option value="resolved" {{ request('status') === 'resolved' ? 'selected' : '' }}>Обработан</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Дата от</label>
                <input type="date" name="date_from" class="form-control form-control-sm" value="{{ request('date_from') }}">
            </div>
            <div class="col-md-2">
                <label class="form-label">Дата до</label>
                <input type="date" name="date_to" class="form-control form-control-sm" value="{{ request('date_to') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">Email клиента</label>
                <input type="text" name="email" class="form-control form-control-sm" placeholder="email@example.com" value="{{ request('email') }}">
            </div>
            <div class="col-md-2">
                <label class="form-label">Телефон</label>
                <input type="text" name="phone" class="form-control form-control-sm" placeholder="+380..." value="{{ request('phone') }}">
            </div>
            <div class="col-md-1 d-flex align-items-end gap-1">
                <button type="submit" class="btn btn-primary btn-sm">Найти</button>
                <a href="{{ route('admin.tickets.index') }}" class="btn btn-secondary btn-sm">×</a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Клиент</th>
                    <th>Тема</th>
                    <th>Статус</th>
                    <th>Дата</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($tickets as $ticket)
                <tr>
                    <td>{{ $ticket->id }}</td>
                    <td>
                        <div>{{ $ticket->customer->name }}</div>
                        <small class="text-muted">{{ $ticket->customer->phone }}</small>
                        @if ($ticket->customer->email)
                            <br><small class="text-muted">{{ $ticket->customer->email }}</small>
                        @endif
                    </td>
                    <td>{{ Str::limit($ticket->subject, 60) }}</td>
                    <td>
                        @php
                            $badges = ['new' => 'primary', 'in_progress' => 'warning', 'resolved' => 'success'];
                            $labels = ['new' => 'Новый', 'in_progress' => 'В работе', 'resolved' => 'Обработан'];
                        @endphp
                        <span class="badge bg-{{ $badges[$ticket->status] ?? 'secondary' }}">
                            {{ $labels[$ticket->status] ?? $ticket->status }}
                        </span>
                    </td>
                    <td>{{ $ticket->created_at->format('d.m.Y H:i') }}</td>
                    <td>
                        <a href="{{ route('admin.tickets.show', $ticket) }}" class="btn btn-sm btn-outline-primary">
                            Открыть
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">Заявки не найдены</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if ($tickets->hasPages())
<div class="mt-3">
    {{ $tickets->links() }}
</div>
@endif
@endsection
