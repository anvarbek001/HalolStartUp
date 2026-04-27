@extends('layouts.index')
@section('content')
    <div class="flex h-screen bg-gray-100">
        <div class="w-1/3 bg-white border-r border-gray-200 overflow-y-auto">
            <div class="p-4 border-b bg-gray-50">
                <h2 class="text-xl font-semibold">Suhbatlar</h2>
            </div>
            @foreach ($users as $user)
                <a href="{{ route('admin.chat', $user->id) }}"
                    class="flex items-center p-4 hover:bg-blue-50 border-b {{ $selectedUser && $selectedUser->id == $user->id ? 'bg-blue-100' : '' }}">
                    <div class="w-10 h-10 rounded-full bg-blue-500 flex items-center justify-center text-white font-bold">
                        {{ substr($user->name, 0, 1) }}
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-900">{{ $user->name }}</p>
                        <p class="text-xs text-gray-500">So'nggi xabar...</p>
                    </div>
                </a>
            @endforeach
        </div>

        <div class="w-2/3 flex flex-col">
            @if ($selectedUser)
                <div class="p-4 border-b bg-white flex items-center">
                    <h3 class="font-bold text-lg">{{ $selectedUser->name }} bilan suhbat</h3>
                </div>

                <div id="chat-box" class="flex-1 p-6 overflow-y-auto space-y-4 bg-gray-50">
                    @foreach ($messages as $msg)
                        <div class="flex {{ $msg->sender_id == auth()->id() ? 'justify-end' : 'justify-start' }}">
                            <div
                                class="max-w-xs px-4 py-2 rounded-lg shadow {{ $msg->sender_id == auth()->id() ? 'bg-blue-600 text-white' : 'bg-white text-gray-800' }}">
                                <p class="text-sm">{{ $msg->content }}</p>
                                <span class="text-[10px] opacity-75 mt-1 block">
                                    {{ $msg->created_at->format('H:i') }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="p-4 bg-white border-t">
                    <form id="chat-form" class="flex gap-2">
                        <input type="text" id="message-input" placeholder="Xabar yozing..."
                            class="flex-1 border rounded-full px-4 py-2 focus:outline-none focus:border-blue-500">
                        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-full hover:bg-blue-700">
                            Yuborish
                        </button>
                    </form>
                </div>
            @else
                <div class="flex-1 flex items-center justify-center text-gray-400">
                    Suhbatni boshlash uchun foydalanuvchini tanlang
                </div>
            @endif
        </div>
    </div>
@endsection
