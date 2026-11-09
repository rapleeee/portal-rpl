<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController
{
    public function index(Request $request)
    {
        $status = $request->query('status'); // ?status=pending

        $tasks = Task::query()
            ->when($status, fn ($q) => $q->where('status', $status))
            ->latest()
            ->paginate(10)
            ->withQueryString(); // biar pagination keep ?status=...

        $statusOptions = ['pending', 'in_progress', 'completed', 'late'];

        return view('tasks.index', compact('tasks', 'statusOptions', 'status'));
    }
}

