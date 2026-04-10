@extends('layouts.app')
@section('title', 'Gebruikersbeheer')
@section('page-title', 'Gebruikersbeheer')

@section('content')
    {{-- Zoekbalk --}}
    <div class="card mb-6">
        <form method="GET" class="flex gap-3">
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Zoek op naam of e-mail..."
                   class="form-input flex-1 m-0">
            <button type="submit" class="btn btn btn-primary">🔍 Zoeken</button>
            @if(request('search'))
                <a href="{{ route('admin.users.index') }}" class="btn btn btn-secondary">✕ Wissen</a>
            @endif
        </form>
    </div>

    <div class="card">
        <div class="flex items-center justify-between mb-5">
            <h3 class="font-bold text-main">Alle Gebruikers ({{ $users->total() }})</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                <tr class="border-b-2 border-brand-border">
                    <th class="pb-3 text-left text-brand-muted font-medium">ID</th>
                    <th class="pb-3 text-left text-brand-muted font-medium">Naam</th>
                    <th class="pb-3 text-left text-brand-muted font-medium">E-mail</th>
                    <th class="pb-3 text-left text-brand-muted font-medium">Rol</th>
                    <th class="pb-3 text-left text-brand-muted font-medium">Reserveringen</th>
                    <th class="pb-3 text-left text-brand-muted font-medium">Status</th>
                    <th class="pb-3 text-left text-brand-muted font-medium">Acties</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-brand-border">
                @foreach($users as $user)
                    <tr class="hover-row {{ $user->is_banned ? 'opacity-60' : '' }}">
                        <td class="py-3 text-brand-muted">#{{ $user->id }}</td>
                        <td class="py-3 font-medium">{{ $user->name }}</td>
                        <td class="py-3 text-brand-muted">{{ $user->email }}</td>
                        <td class="py-3">
              <span class="badge {{ $user->role === 'admin' ? 'badge-blue' : 'badge-green' }}">
                {{ ucfirst($user->role) }}
              </span>
                        </td>
                        <td class="py-3 text-center">{{ $user->reservations_count }}</td>
                        <td class="py-3">
              <span class="badge {{ $user->is_banned ? 'badge-red' : 'badge-green' }}">
                {{ $user->is_banned ? '🚫 Geblokkeerd' : '✓ Actief' }}
              </span>
                        </td>
                        <td class="py-3">
                            <div class="flex gap-2">
                                <a href="{{ route('admin.users.edit', $user) }}"
                                   class="btn btn btn-primary !py-1 !px-3 font-semibold text-xs">
                                    Bewerken
                                </a>
                                <form method="POST" action="{{ route('admin.users.ban', $user) }}">
                                    @csrf
                                    <button class="btn {{ $user->is_banned ? 'btn-primary' : 'btn btn-danger' }} !py-1 !px-3 font-semibold text-xs">
                                        {{ $user->is_banned ? 'Deblokkeer' : 'Blokkeer' }}
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-5">{{ $users->appends(request()->query())->links() }}</div>
    </div>
@endsection
