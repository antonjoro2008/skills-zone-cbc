@extends('layouts.app')

@section('title', 'Pupil Assessment Book - Gravity CBC')

@section('content')
<div class="gradient-bg text-white py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <a href="{{ route('teacher-dashboard') }}" class="inline-flex items-center text-white/90 hover:text-white text-sm font-semibold mb-4">
            <i class="fas fa-arrow-left mr-2"></i> Back to Teacher hub
        </a>
        <h1 class="text-3xl md:text-4xl font-bold mb-2">Pupil assessment book</h1>
        <p class="text-gray-100 text-lg max-w-3xl">
            A simple teacher record — an extract of each learner’s assessment book. Fill progress daily, weekly, monthly or termly. Guardian reports lead with these entries and include digital assessment attempts below.
        </p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-8">
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
        <div class="flex flex-col lg:flex-row lg:items-end gap-4 mb-6">
            <div class="flex-1">
                <label class="block text-sm font-medium text-gray-700 mb-1">Learner</label>
                <select id="abStudent" class="form-input w-full max-w-md px-4 py-3 rounded-xl border border-gray-300">
                    <option value="">Select learner…</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Record period</label>
                <div class="flex flex-wrap gap-2" id="abPeriodTabs">
                    <button type="button" data-period="daily" class="ab-period-tab px-4 py-2 rounded-xl text-sm font-semibold border border-gray-300 text-gray-700 hover:bg-gray-50">Daily</button>
                    <button type="button" data-period="weekly" class="ab-period-tab px-4 py-2 rounded-xl text-sm font-semibold border border-teal-600 bg-teal-600 text-white">Weekly</button>
                    <button type="button" data-period="monthly" class="ab-period-tab px-4 py-2 rounded-xl text-sm font-semibold border border-gray-300 text-gray-700 hover:bg-gray-50">Monthly</button>
                    <button type="button" data-period="termly" class="ab-period-tab px-4 py-2 rounded-xl text-sm font-semibold border border-gray-300 text-gray-700 hover:bg-gray-50">Termly</button>
                </div>
            </div>
        </div>

        <form id="abEntryForm" class="grid grid-cols-1 md:grid-cols-2 gap-4 border-t border-gray-100 pt-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Period start <span class="text-red-500">*</span></label>
                <input type="date" id="abPeriodStart" class="form-input w-full px-4 py-3 rounded-xl border border-gray-300" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Period end</label>
                <input type="date" id="abPeriodEnd" class="form-input w-full px-4 py-3 rounded-xl border border-gray-300">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Learning area / subject <span class="text-red-500">*</span></label>
                <input type="text" id="abLearningArea" class="form-input w-full px-4 py-3 rounded-xl border border-gray-300" placeholder="e.g. Integrated Science" required maxlength="120">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Strand / topic</label>
                <input type="text" id="abStrand" class="form-input w-full px-4 py-3 rounded-xl border border-gray-300" placeholder="e.g. Chemistry" maxlength="120">
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Activity observed</label>
                <textarea id="abActivity" rows="2" class="form-input w-full px-4 py-3 rounded-xl border border-gray-300" placeholder="What was assessed or observed in class"></textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Score (%)</label>
                <input type="number" id="abScore" min="0" max="100" class="form-input w-full px-4 py-3 rounded-xl border border-gray-300" placeholder="0–100">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">CBE level</label>
                <select id="abCbeLevel" class="form-input w-full px-4 py-3 rounded-xl border border-gray-300">
                    <option value="">Auto from score</option>
                    <option value="BE">Below Expectation (BE)</option>
                    <option value="AE">Approaching Expectation (AE)</option>
                    <option value="ME">Meeting Expectation (ME)</option>
                    <option value="EE">Exceeding Expectation (EE)</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Strengths</label>
                <textarea id="abStrengths" rows="2" class="form-input w-full px-4 py-3 rounded-xl border border-gray-300"></textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Gaps to address</label>
                <textarea id="abGaps" rows="2" class="form-input w-full px-4 py-3 rounded-xl border border-gray-300"></textarea>
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Next steps</label>
                <textarea id="abNextSteps" rows="2" class="form-input w-full px-4 py-3 rounded-xl border border-gray-300"></textarea>
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Teacher notes</label>
                <textarea id="abNotes" rows="2" class="form-input w-full px-4 py-3 rounded-xl border border-gray-300" placeholder="Summary for termly / monthly report"></textarea>
            </div>
            <div class="md:col-span-2 flex flex-wrap gap-3">
                <button type="submit" id="abSaveBtn" class="inline-flex items-center gap-2 rounded-xl bg-teal-600 text-white font-semibold px-6 py-3 hover:bg-teal-700">
                    <i class="fas fa-save"></i> Save entry
                </button>
                <button type="button" id="abClearBtn" class="rounded-xl border border-gray-300 text-gray-700 font-semibold px-6 py-3 hover:bg-gray-50">Clear form</button>
            </div>
        </form>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
            <h2 class="text-lg font-bold text-gray-900 mb-4">Recorded entries</h2>
            <div id="abEntriesList" class="space-y-3 text-sm text-gray-500">
                <p>Select a learner to view entries.</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
            <div class="flex items-center justify-between gap-4 mb-4">
                <h2 class="text-lg font-bold text-gray-900">Performance report preview</h2>
                <button type="button" id="abEmailReportBtn" class="text-sm font-semibold text-teal-700 hover:underline disabled:opacity-50" disabled>Email guardian</button>
            </div>
            <p class="text-xs text-gray-500 mb-4">Assessment book summary first; digital attempts listed as detail below.</p>
            <div id="abReportPreview" class="rounded-xl border border-gray-200 bg-gray-50 p-4 text-sm text-gray-600">
                Select a learner and save entries to preview the report.
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
(function () {
    let students = [];
    let activePeriod = 'weekly';
    let selectedStudentId = '';

    function token() {
        return localStorage.getItem('token') || localStorage.getItem('access_token');
    }

    function abEscape(text) {
        if (text == null) return '';
        const d = document.createElement('div');
        d.textContent = String(text);
        return d.innerHTML;
    }

    function checkAuth() {
        const t = token();
        const userRaw = localStorage.getItem('user');
        if (!t || !userRaw) {
            window.location.href = '/login?return=' + encodeURIComponent('/teacher-assessment-book');
            return false;
        }
        try {
            const u = JSON.parse(userRaw);
            if (u.user_type !== 'teacher') {
                window.location.href = '/teacher-dashboard';
                return false;
            }
        } catch (e) {
            window.location.href = '/login';
            return false;
        }
        return true;
    }

    async function api(path, options) {
        const response = await fetch(API_BASE_URL + path, {
            method: (options && options.method) || 'GET',
            headers: {
                Accept: 'application/json',
                'Content-Type': 'application/json',
                Authorization: 'Bearer ' + token(),
            },
            ...(options && options.body ? { body: JSON.stringify(options.body) } : {}),
        });
        return response.json();
    }

    async function loadStudents() {
        const data = await api('/api/teacher/dashboard');
        if (!data.success) return;
        students = data.data?.students || data.data?.learners || [];
        const select = document.getElementById('abStudent');
        select.innerHTML = '<option value="">Select learner…</option>' + students.map(function (s) {
            return '<option value="' + s.id + '">' + abEscape(s.name) + (s.grade_level ? ' · ' + abEscape(s.grade_level) : '') + '</option>';
        }).join('');
    }

    function setActivePeriod(period) {
        activePeriod = period;
        document.querySelectorAll('.ab-period-tab').forEach(function (btn) {
            const on = btn.dataset.period === period;
            btn.className = 'ab-period-tab px-4 py-2 rounded-xl text-sm font-semibold border ' +
                (on ? 'border-teal-600 bg-teal-600 text-white' : 'border-gray-300 text-gray-700 hover:bg-gray-50');
        });
        loadEntries();
    }

    async function loadEntries() {
        const list = document.getElementById('abEntriesList');
        if (!selectedStudentId) {
            list.innerHTML = '<p>Select a learner to view entries.</p>';
            return;
        }
        list.innerHTML = '<p><i class="fas fa-spinner fa-spin mr-2"></i>Loading…</p>';
        const q = '?student_id=' + encodeURIComponent(selectedStudentId) + '&period_type=' + encodeURIComponent(activePeriod);
        const data = await api('/api/teacher/assessment-book' + q);
        const entries = data.success ? (data.data?.entries || []) : [];
        if (!entries.length) {
            list.innerHTML = '<p>No ' + activePeriod + ' entries yet for this learner.</p>';
            return;
        }
        list.innerHTML = entries.map(function (e) {
            const level = e.cbe_level_label || e.cbe_level || '—';
            const score = e.score_percent != null ? e.score_percent + '%' : '—';
            return '<div class="border border-gray-200 rounded-xl p-4 bg-white">' +
                '<div class="flex justify-between gap-2">' +
                '<div><p class="font-semibold text-gray-900">' + abEscape(e.learning_area) + (e.strand ? ' · ' + abEscape(e.strand) : '') + '</p>' +
                '<p class="text-xs text-gray-500">' + abEscape(e.period_start) + (e.period_end ? ' – ' + abEscape(e.period_end) : '') + '</p></div>' +
                '<div class="text-right shrink-0"><p class="font-bold text-teal-700">' + score + '</p><p class="text-xs text-gray-600">' + abEscape(level) + '</p></div></div>' +
                (e.next_steps ? '<p class="text-xs text-gray-600 mt-2">' + abEscape(e.next_steps) + '</p>' : '') +
                '<button type="button" class="text-xs text-red-600 mt-2 hover:underline ab-delete" data-id="' + e.id + '">Remove</button></div>';
        }).join('');
        list.querySelectorAll('.ab-delete').forEach(function (btn) {
            btn.addEventListener('click', function () { deleteEntry(btn.dataset.id); });
        });
    }

    async function deleteEntry(id) {
        if (!confirm('Remove this assessment book entry?')) return;
        const data = await api('/api/teacher/assessment-book/' + id, { method: 'DELETE' });
        if (data.success) {
            loadEntries();
            loadReportPreview();
        } else {
            alert(data.message || 'Could not remove entry.');
        }
    }

    async function loadReportPreview() {
        const box = document.getElementById('abReportPreview');
        const emailBtn = document.getElementById('abEmailReportBtn');
        if (!selectedStudentId) {
            box.innerHTML = 'Select a learner and save entries to preview the report.';
            emailBtn.disabled = true;
            return;
        }
        box.innerHTML = '<p><i class="fas fa-spinner fa-spin mr-2"></i>Loading report…</p>';
        const data = await api('/api/teacher/students/' + selectedStudentId + '/performance-report');
        if (!data.success) {
            box.innerHTML = '<p class="text-red-600">' + abEscape(data.message || 'Could not load report.') + '</p>';
            emailBtn.disabled = true;
            return;
        }
        const r = data.data.report || {};
        const subjects = r.subjects || [];
        const digital = r.digital_attempts || {};
        const attempts = digital.attempts || [];
        emailBtn.disabled = false;
        box.innerHTML =
            '<div class="space-y-4">' +
            '<div><p class="text-xs font-semibold text-teal-800 uppercase mb-1">Assessment book (summary)</p>' +
            '<p><span class="text-gray-500">Overall CBE level:</span> <strong class="text-gray-900">' + abEscape(r.overall_level || '—') + '</strong></p>' +
            '<p><span class="text-gray-500">Average:</span> <strong>' + abEscape(r.average_percent || '—') + '</strong> · ' + abEscape(r.tt_mks || '') + '</p>' +
            (r.teacher_summary ? '<p class="text-gray-700 italic text-xs mt-1">' + abEscape(r.teacher_summary) + '</p>' : '') +
            '<table class="w-full text-left text-xs mt-2"><thead><tr class="text-gray-500"><th class="py-1">Subject</th><th>Score</th><th>Level</th></tr></thead><tbody>' +
            (subjects.length ? subjects.map(function (s) {
                return '<tr><td class="py-1 font-medium text-gray-900">' + abEscape(s.code) + '</td><td>' + abEscape(s.percent) + '</td><td>' + abEscape(s.level) + '</td></tr>';
            }).join('') : '<tr><td colspan="3" class="py-2 text-gray-500">No assessment book entries yet.</td></tr>') +
            '</tbody></table></div>' +
            '<div class="border-t border-gray-200 pt-3"><p class="text-xs font-semibold text-indigo-800 uppercase mb-1">Digital assessment attempts</p>' +
            (attempts.length ? '<p class="text-xs text-gray-500 mb-2">Average ' + abEscape(digital.average_percent || '—') + ' · ' + abEscape(digital.overall_level || '—') + '</p>' : '') +
            '<table class="w-full text-left text-xs"><thead><tr class="text-gray-500"><th class="py-1">Assessment</th><th>Date</th><th>Score</th></tr></thead><tbody>' +
            (attempts.length ? attempts.map(function (a) {
                return '<tr><td class="py-1 text-gray-900">' + abEscape(a.assessment_title) + '</td><td>' + abEscape(a.completed_at || '—') + '</td><td>' +
                    (a.score_percent != null ? a.score_percent + '%' : '—') + '</td></tr>';
            }).join('') : '<tr><td colspan="3" class="py-2 text-gray-500">No completed digital attempts this year.</td></tr>') +
            '</tbody></table></div></div>';
    }

    async function saveEntry(event) {
        event.preventDefault();
        if (!selectedStudentId) {
            alert('Select a learner first.');
            return;
        }
        const btn = document.getElementById('abSaveBtn');
        btn.disabled = true;
        const body = {
            student_id: parseInt(selectedStudentId, 10),
            period_type: activePeriod,
            period_start: document.getElementById('abPeriodStart').value,
            period_end: document.getElementById('abPeriodEnd').value || null,
            learning_area: document.getElementById('abLearningArea').value.trim(),
            strand: document.getElementById('abStrand').value.trim() || null,
            activity_observed: document.getElementById('abActivity').value.trim() || null,
            score_percent: document.getElementById('abScore').value !== '' ? parseInt(document.getElementById('abScore').value, 10) : null,
            cbe_level: document.getElementById('abCbeLevel').value || null,
            strengths: document.getElementById('abStrengths').value.trim() || null,
            gaps_to_address: document.getElementById('abGaps').value.trim() || null,
            next_steps: document.getElementById('abNextSteps').value.trim() || null,
            teacher_notes: document.getElementById('abNotes').value.trim() || null,
        };
        const data = await api('/api/teacher/assessment-book', { method: 'POST', body: body });
        btn.disabled = false;
        if (data.success) {
            document.getElementById('abEntryForm').reset();
            document.getElementById('abPeriodStart').value = new Date().toISOString().slice(0, 10);
            loadEntries();
            loadReportPreview();
        } else {
            alert(data.message || 'Could not save entry.');
        }
    }

    async function emailReport() {
        if (!selectedStudentId) return;
        const data = await api('/api/teacher/students/' + selectedStudentId + '/share/guardian-email', { method: 'POST', body: {} });
        alert(data.success ? (data.message || 'Report sent.') : (data.message || 'Could not send report.'));
    }

    document.getElementById('abPeriodTabs').addEventListener('click', function (e) {
        const btn = e.target.closest('.ab-period-tab');
        if (btn) setActivePeriod(btn.dataset.period);
    });

    document.getElementById('abStudent').addEventListener('change', function (e) {
        selectedStudentId = e.target.value;
        loadEntries();
        loadReportPreview();
    });

    document.getElementById('abEntryForm').addEventListener('submit', saveEntry);
    document.getElementById('abClearBtn').addEventListener('click', function () {
        document.getElementById('abEntryForm').reset();
        document.getElementById('abPeriodStart').value = new Date().toISOString().slice(0, 10);
    });
    document.getElementById('abEmailReportBtn').addEventListener('click', emailReport);

    document.addEventListener('DOMContentLoaded', function () {
        if (!checkAuth()) return;
        document.getElementById('abPeriodStart').value = new Date().toISOString().slice(0, 10);
        loadStudents();
        setActivePeriod('weekly');
    });
})();
</script>
@endsection
