<div class="mb-4">
    @if ($comment->is_deleted)
        <p class="italic text-gray-500">Комментарий был удалён.</p>
    @else
        <p class="font-bold">{{ $comment->user->name }}</p>
        <p class="text-sm text-gray-500">{{ $comment->created_at->format('d.m.Y H:i') }}</p>
        <p class="mt-2">{{ $comment->content }}</p>

        {{-- Кнопка для удаления --}}
        @can('delete', $comment)
            <form action="{{ route('comments.destroy', $comment) }}" method="POST" class="mt-2">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-500 hover:underline">Удалить</button>
            </form>
        @endcan
    @endif

    {{-- Ответить на комментарий --}}
    <form action="{{ route('comments.store', $comment->article) }}" method="POST" class="mt-2">
        @csrf
        <input type="hidden" name="parent_id" value="{{ $comment->id }}">
        <textarea name="content" rows="2" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500" placeholder="Ответить на комментарий..." required></textarea>
        <button type="submit" class="mt-2 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">Ответить</button>
    </form>

    {{-- Рекурсивный вызов для дочерних комментариев --}}
    @if ($comment->replies->count() > 0)
        <div class="ml-6 border-l-2 border-gray-300 pl-4 mt-4">
            @foreach ($comment->replies as $reply)
                @include('comments.partials.comment', ['comment' => $reply])
            @endforeach
        </div>
    @endif
</div>
