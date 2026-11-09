@extends('layouts.app')

@section('content')
<div style="max-width: 820px; margin: 40px auto; padding: 0 20px; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
    <!-- Header Fitur -->
    <div style="margin-bottom: 25px;">
        <a href="{{ url('/') }}" style="color: #4f46e5; text-decoration: none; font-size: 14px; font-weight: 600; display: inline-flex; align-items: center; gap: 5px; transition: color 0.2s;">
            <button style="margin-bottom: 10px; background: #e0e7ff; color: #4338ca; border: none; padding: 6px 12px; border-radius: 9999px; cursor: pointer; font-weight: 600; font-size: 13px; transition: background 0.2s, transform 0.1s;"
                onmouseover="this.style.background='#c7d2fe'" onmouseout="this.style.background='#e0e7ff'" onmousedown="this.style.transform='scale(0.97)'" onmouseup="this.style.transform='scale(1)'">
                &larr; Kembali ke Dashboard
            </button>
        </a>
        
        <h1 style="font-size: 28px; font-weight: 700; color: #111827; margin: 8px 0 4px 0;">Checklist Tugas Pribadi</h1>
        <p style="color: #6b7280; font-size: 15px; margin: 0;">Kelola daftar tugas harian dan target belajarmu dengan lebih terstruktur.</p>
    </div>

    <!-- Kotak Form Tambah / Edit Tugas -->
    <div style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); padding: 24px; border-radius: 16px; box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.05); border: 1px solid #e2e8f0; margin-bottom: 25px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
            <span id="formTitle" style="font-weight: 600; color: #334155; font-size: 15px;">Tambah Tugas Baru</span>
            <span id="progressText" style="font-size: 13px; font-weight: 600; background: #e0e7ff; color: #4338ca; padding: 6px 14px; border-radius: 9999px; box-shadow: inset 0 1px 2px rgba(0,0,0,0.05);">0/0 Selesai (0%)</span>
        </div>

        <form id="taskForm" style="display: flex; gap: 12px; flex-wrap: wrap;">
            <input type="hidden" id="editIndex" value="">
            <input type="text" id="taskInput" placeholder="Contoh: Selesaikan laporan project Laravel..." 
                style="flex: 1; min-width: 240px; padding: 12px 16px; border: 1px solid #cbd5e1; border-radius: 10px; outline: none; font-size: 14px; background: #ffffff; transition: all 0.2s;"
                onfocus="this.style.borderColor='#4f46e5'; this.style.boxShadow='0 0 0 3px rgba(79, 70, 229, 0.15)'"
                onblur="this.style.borderColor='#cbd5e1'; this.style.boxShadow='none'" required>
            
            <select id="taskPriority" style="padding: 12px 16px; border: 1px solid #cbd5e1; border-radius: 10px; outline: none; background: #ffffff; font-size: 14px; cursor: pointer; color: #334155;">
                <option value="Normal">Normal</option>
                <option value="Penting">Penting</option>
                <option value="Mendesak">Mendesak</option>
            </select>
            
            <button type="submit" id="submitBtn" style="background: #203b51; color: white; border: none; padding: 12px 22px; border-radius: 10px; cursor: pointer; font-weight: 600; font-size: 14px; transition: background 0.2s, transform 0.1s;"
                onmouseover="this.style.background='#1b3244'" onmouseout="this.style.background='#203b51'" onmousedown="this.style.transform='scale(0.97)'" onmouseup="this.style.transform='scale(1)'">
                + Tambah
            </button>
            <button type="button" id="cancelEditBtn" style="display: none; background: #94a3b8; color: white; border: none; padding: 12px 16px; border-radius: 10px; cursor: pointer; font-weight: 600; font-size: 14px;">
                Batal
            </button>
        </form>
    </div>

    <!-- Daftar Checklist Tugas -->
    <div style="background: #ffffff; border-radius: 16px; box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05); border: 1px solid #e2e8f0; overflow: hidden;">
        <div style="padding: 18px 24px; background: #f8fafc; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center;">
            <h2 style="font-size: 16px; font-weight: 600; color: #1e293b; margin: 0;">Daftar Tugas Anda</h2>
            <button id="clearCompleted" style="background: #fee2e2; border: none; color: #dc2626; cursor: pointer; font-size: 12px; font-weight: 600; padding: 6px 12px; border-radius: 8px; transition: background 0.2s;"
                onmouseover="this.style.background='#fecaca'" onmouseout="this.style.background='#fee2e2'">
                Hapus yang Selesai
            </button>
        </div>
        
        <ul id="taskList" style="list-style: none; padding: 0; margin: 0;">
            <!-- Item tugas dimuat via JS -->
        </ul>

        <div id="emptyState" style="text-align: center; padding: 50px 20px; color: #94a3b8; display: none;">
            <p style="font-size: 15px; font-weight: 500; margin: 0;">Belum ada tugas. Nikmati waktu luangmu atau buat tugas baru!</p>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const taskForm = document.getElementById('taskForm');
        const taskInput = document.getElementById('taskInput');
        const taskPriority = document.getElementById('taskPriority');
        const editIndexInput = document.getElementById('editIndex');
        const formTitle = document.getElementById('formTitle');
        const submitBtn = document.getElementById('submitBtn');
        const cancelEditBtn = document.getElementById('cancelEditBtn');
        const taskList = document.getElementById('taskList');
        const emptyState = document.getElementById('emptyState');
        const progressText = document.getElementById('progressText');
        const clearCompletedBtn = document.getElementById('clearCompleted');

        let tasks = JSON.parse(localStorage.getItem('portal_tasks_13')) || [
            { id: 1, text: 'Pelajari konsep migration & seeder Laravel', priority: 'Penting', completed: true },
            { id: 2, text: 'Push tugas fitur ke repository GitHub kelas', priority: 'Mendesak', completed: false },
            { id: 3, text: 'Commit kode proyek harian dengan pesan yang jelas', priority: 'Normal', completed: false }
        ];

        function saveAndRender() {
            localStorage.setItem('portal_tasks_13', JSON.stringify(tasks));
            renderTasks();
        }

        function renderTasks() {
            taskList.innerHTML = '';
            
            if (tasks.length === 0) {
                emptyState.style.display = 'block';
                progressText.textContent = `0/0 Selesai (0%)`;
                return;
            } else {
                emptyState.style.display = 'none';
            }

            let completedCount = 0;

            tasks.forEach((task, index) => {
                if (task.completed) completedCount++;

                const li = document.createElement('li');
                li.style.cssText = `
                    padding: 16px 24px; 
                    display: flex; 
                    align-items: center; 
                    justify-content: space-between; 
                    border-bottom: 1px solid #f1f5f9; 
                    background: ${task.completed ? '#f8fafc' : '#ffffff'}; 
                    transition: background 0.2s;
                `;
                
                let badgeBg = '#f1f5f9';
                let badgeColor = '#475569';
                if (task.priority === 'Penting') { badgeBg = '#fef3c7'; badgeColor = '#b45309'; }
                if (task.priority === 'Mendesak') { badgeBg = '#fee2e2'; badgeColor = '#b91c1c'; }

                li.innerHTML = `
                    <div style="display: flex; align-items: center; gap: 14px; flex: 1;">
                        <input type="checkbox" data-id="${task.id}" ${task.completed ? 'checked' : ''} 
                            style="width: 20px; height: 20px; accent-color: #4f46e5; cursor: pointer; border-radius: 4px;">
                        <span style="
                            ${task.completed ? 'text-decoration: line-through; color: #94a3b8;' : 'color: #1e293b;'} 
                            font-weight: 500; font-size: 14.5px; flex: 1; transition: color 0.2s;
                        ">
                            ${escapeHtml(task.text)}
                        </span>
                        <span style="font-size: 11.5px; padding: 4px 10px; border-radius: 9999px; font-weight: 600; background: ${badgeBg}; color: ${badgeColor}; box-shadow: 0 1px 2px rgba(0,0,0,0.02);">
                            ${task.priority}
                        </span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 8px; margin-left: 12px;">
                        <button data-index="${index}" class="edit-btn" style="background: #e0e7ff; border: none; color: #4338ca; cursor: pointer; font-size: 12px; font-weight: 600; padding: 4px 10px; border-radius: 6px; transition: background 0.2s;">
                            Edit
                        </button>
                        <button data-id="${task.id}" class="delete-btn" style="background: transparent; border: none; color: #cbd5e1; cursor: pointer; font-size: 20px; font-weight: bold; padding: 0 4px; border-radius: 6px; transition: all 0.2s;"
                            onmouseover="this.style.color='#ef4444'; this.style.background='#fee2e2'" onmouseout="this.style.color='#cbd5e1'; this.style.background='transparent'">
                            &times;
                        </button>
                    </div>
                `;
                taskList.appendChild(li);
            });

            const total = tasks.length;
            const percentage = total > 0 ? Math.round((completedCount / total) * 100) : 0;
            progressText.textContent = `${completedCount}/${total} Selesai (${percentage}%)`;
        }

        function escapeHtml(text) {
            const map = { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' };
            return text.replace(/[&<>"']/g, function(m) { return map[m]; });
        }

        // Handle Submit (Tambah atau Perbarui Tugas)
        taskForm.addEventListener('submit', function (e) {
            e.preventDefault();
            const text = taskInput.value.trim();
            if (!text) return;

            const editIdx = editIndexInput.value;

            if (editIdx !== "") {
                // Mode Update
                tasks[editIdx].text = text;
                tasks[editIdx].priority = taskPriority.value;
                resetForm();
            } else {
                // Mode Tambah Baru
                const newTask = {
                    id: Date.now(),
                    text: text,
                    priority: taskPriority.value,
                    completed: false
                };
                tasks.unshift(newTask);
            }

            taskInput.value = '';
            saveAndRender();
        });

        // Event listener untuk checkbox, tombol edit, dan tombol hapus
        taskList.addEventListener('click', function (e) {
            const id = Number(e.target.getAttribute('data-id'));
            
            if (e.target.type === 'checkbox') {
                tasks = tasks.map(t => t.id === id ? { ...t, completed: e.target.checked } : t);
                saveAndRender();
            }

            if (e.target.classList.contains('edit-btn')) {
                const index = e.target.getAttribute('data-index');
                const taskToEdit = tasks[index];
                
                taskInput.value = taskToEdit.text;
                taskPriority.value = taskToEdit.priority;
                editIndexInput.value = index;
                
                formTitle.textContent = "Edit Tugas";
                submitBtn.textContent = "Simpan Perubahan";
                cancelEditBtn.style.display = "inline-block";
                taskInput.focus();
            }

            if (e.target.classList.contains('delete-btn')) {
                tasks = tasks.filter(t => t.id !== id);
                // Jika sedang mengedit item yang dihapus, reset form
                if (editIndexInput.value !== "" && tasks.length === 0) {
                    resetForm();
                }
                saveAndRender();
            }
        });

        // Batal Edit
        cancelEditBtn.addEventListener('click', function () {
            resetForm();
            taskInput.value = '';
        });

        function resetForm() {
            editIndexInput.value = "";
            formTitle.textContent = "Tambah Tugas Baru";
            submitBtn.textContent = "+ Tambah";
            cancelEditBtn.style.display = "none";
        }

        clearCompletedBtn.addEventListener('click', function () {
            tasks = tasks.filter(t => !t.completed);
            resetForm();
            saveAndRender();
        });

        renderTasks();
    });
</script>
@endpush
@endsection