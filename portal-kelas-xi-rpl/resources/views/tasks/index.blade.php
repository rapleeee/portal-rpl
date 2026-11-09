<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Tugas</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen">
    <div class="max-w-4xl mx-auto px-4 py-8">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
                <h1 class="text-2xl font-semibold text-gray-900">Daftar Tugas</h1>

                <form method="GET" class="w-full sm:w-auto">
                    <label for="status" class="sr-only">Filter Status</label>
                    <select name="status" id="status"
                        class="w-full sm:w-48 px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        onchange="this.form.submit()">
                        <option value="">Semua Status</option>
                        @foreach($statusOptions as $opt)
                            <option value="{{ $opt }}" {{ $status === $opt ? 'selected' : '' }}>
                                {{ ucfirst(str_replace('_', ' ', $opt)) }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-4 py-3 font-medium text-gray-500 uppercase tracking-wider">Judul</th>
                            <th class="px-4 py-3 font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-4 py-3 font-medium text-gray-500 uppercase tracking-wider">Deadline</th>
                            <th class="px-4 py-3 font-medium text-gray-500 uppercase tracking-wider">Dibuat</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($tasks as $task)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3">
                                    <div class="font-medium text-gray-900">{{ $task->title }}</div>
                                    @if($task->description)
                                        <div class="text-gray-500 line-clamp-1 mt-1">{{ $task->description }}</div>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    @php
                                        $statusClass = match ($task->status) {
                                            'pending' => 'bg-yellow-100 text-yellow-800',
                                            'in_progress' => 'bg-blue-100 text-blue-800',
                                            'completed' => 'bg-green-100 text-green-800',
                                            'late' => 'bg-red-100 text-red-800',
                                            default => 'bg-gray-100 text-gray-800',
                                        };
                                    @endphp
                                    <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full {{ $statusClass }}">
                                        {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-gray-600">
                                    {{ $task->due_date ? $task->due_date->format('d M Y') : '-' }}
                                </td>
                                <td class="px-4 py-3 text-gray-500">
                                    {{ $task->created_at->format('d M Y') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-8 text-center text-gray-500">
                                    Belum ada tugas
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($tasks->hasPages())
                <div class="mt-6 flex justify-center">
                    {{ $tasks->links('pagination::tailwind') }}
                </div>
            @endif
        </div>
    </div>
</body>
</html>