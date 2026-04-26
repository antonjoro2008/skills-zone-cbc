@extends('layouts.app')

@section('title', 'Teacher hub - Gravity CBC')

@section('content')
<div class="gradient-bg text-white py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl md:text-4xl font-bold mb-2">Teacher hub</h1>
        <p class="text-gray-100 text-lg max-w-2xl">Your class, your learners, and competency-focused learning insights.</p>
        <div class="mt-6 flex flex-wrap gap-4 text-sm">
            <div class="bg-white/10 backdrop-blur rounded-xl px-4 py-2">
                <span class="text-gray-200">Signed in as</span>
                <span id="teacherDisplayName" class="font-semibold ml-2">—</span>
            </div>
            <div class="bg-white/10 backdrop-blur rounded-xl px-4 py-2">
                <span class="text-gray-200">Class</span>
                <span id="teacherClassLabel" class="font-semibold ml-2">—</span>
            </div>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-8">
    <div id="teacherNoClassBanner" class="hidden rounded-2xl border border-amber-200 bg-amber-50 text-amber-900 px-5 py-4 text-sm">
        <strong class="font-semibold">No classroom assigned.</strong>
        Ask your institution admin to assign you to a class in CBC Admin. You can still browse assessments, but adding learners and analytics stay disabled until then.
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
            <p class="text-sm text-gray-500 mb-1">Average CBE level (class)</p>
            <p id="tdInsightLevel" class="text-2xl font-extrabold text-gray-900">—</p>
            <p class="text-xs text-gray-500 mt-2"><span id="tdInsightPercent">0</span>% average across recent attempts</p>
        </div>
        <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
            <p class="text-sm text-gray-500 mb-1">Learners on track</p>
            <p id="tdInsightImproving" class="text-2xl font-extrabold text-gray-900">—</p>
            <p class="text-xs text-gray-500 mt-2">Share of learners trending up on recent assessments</p>
        </div>
        <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 flex flex-col justify-center">
            <a href="{{ route('subjects') }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-[#8FC340] to-[#E368A7] text-white font-semibold px-5 py-3 shadow hover:opacity-95 transition-opacity">
                <i class="fas fa-clipboard-list"></i> Open assessments
            </a>
        </div>
    </div>

    <div id="tdInclusionPanel" class="hidden bg-white rounded-3xl shadow-lg p-6 md:p-8 border border-gray-100 border-l-4 border-l-indigo-500">
        <h2 class="text-xl font-bold text-gray-900 mb-1">Inclusion &amp; gender-segmented analytics</h2>
        <p class="text-sm text-gray-600 mb-6">Cohort counts from your class roster; averages use completed assessment attempts only. Small groups can fluctuate—interpret alongside classroom context.</p>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6" id="tdInclusionStats"></div>
        <div id="tdInclusionPerformance" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4"></div>
        <ul id="tdInclusionNotes" class="mt-6 text-xs text-gray-500 space-y-1 list-disc list-inside"></ul>
    </div>

    <div class="bg-white rounded-3xl shadow-lg p-6 md:p-8 border border-gray-100">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div>
                <h2 class="text-xl font-bold text-gray-900">Your learners</h2>
                <p class="text-sm text-gray-600">Add learners to this class, open progress, email guardians a branded report.</p>
            </div>
            <button type="button" id="btnOpenAddLearnerTeacher" onclick="openTeacherAddLearnerModal()" class="inline-flex items-center justify-center gap-2 rounded-xl bg-teal-600 text-white font-semibold px-5 py-3 hover:bg-teal-700 transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                <i class="fas fa-user-plus"></i> Add learner
            </button>
        </div>
        <div class="overflow-x-auto rounded-xl border border-gray-100">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 text-gray-600">
                    <tr>
                        <th class="py-3 px-3 font-semibold">Learner</th>
                        <th class="py-3 px-3 font-semibold">Grade</th>
                        <th class="py-3 px-3 font-semibold">Gender</th>
                        <th class="py-3 px-3 font-semibold">Guardian</th>
                        <th class="py-3 px-3 font-semibold text-right">Actions</th>
                    </tr>
                </thead>
                <tbody id="teacherStudentsBody">
                    <tr><td colspan="5" class="py-10 px-3 text-center text-gray-500"><i class="fas fa-spinner fa-spin mr-2"></i>Loading…</td></tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Teacher add learner -->
<div id="teacherAddLearnerModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-3xl shadow-2xl max-w-lg w-full max-h-[90vh] overflow-y-auto relative">
        <button type="button" class="absolute top-4 right-4 text-gray-400 hover:text-gray-700 p-2 rounded-full hover:bg-gray-100" onclick="closeTeacherAddLearnerModal()" aria-label="Close">
            <i class="fas fa-times text-lg"></i>
        </button>
        <div class="p-8 pt-10">
            <h3 class="text-xl font-bold text-gray-900 mb-1">Add learner to your class</h3>
            <p class="text-sm text-gray-600 mb-6">This learner is created in your assigned classroom automatically.</p>
            <form id="teacherAddLearnerForm" class="space-y-4" onsubmit="submitTeacherAddLearner(event)">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Full name <span class="text-red-500">*</span></label>
                    <input type="text" id="tlName" class="form-input w-full px-4 py-3 rounded-xl" required maxlength="255">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Admission number <span class="text-red-500">*</span></label>
                    <input type="text" id="tlAdmission" class="form-input w-full px-4 py-3 rounded-xl" required maxlength="50">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email <span class="text-gray-400">(optional)</span></label>
                    <input type="email" id="tlEmail" class="form-input w-full px-4 py-3 rounded-xl">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Grade <span class="text-red-500">*</span></label>
                    <select id="tlGrade" class="form-input w-full px-4 py-3 rounded-xl" required>
                        <option value="">Select</option>
                        @foreach (['Grade 1','Grade 2','Grade 3','Grade 4','Grade 5','Grade 6','Grade 7','Grade 8','Grade 9'] as $g)
                            <option value="{{ $g }}">{{ $g }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Gender <span class="text-gray-400">(optional)</span></label>
                    <select id="tlGender" class="form-input w-full px-4 py-3 rounded-xl">
                        <option value="">Prefer not to specify</option>
                        <option value="female">Female</option>
                        <option value="male">Male</option>
                        <option value="non_binary">Non-binary</option>
                        <option value="prefer_not_to_say">Learner prefers not to say</option>
                        <option value="other">Other / school category</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Guardian email <span class="text-gray-400">(optional)</span></label>
                    <input type="email" id="tlGuardianEmail" class="form-input w-full px-4 py-3 rounded-xl" placeholder="For performance report email">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Guardian phone <span class="text-gray-400">(optional)</span></label>
                    <input type="text" id="tlGuardianPhone" class="form-input w-full px-4 py-3 rounded-xl">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Password <span class="text-red-500">*</span></label>
                    <input type="password" id="tlPassword" class="form-input w-full px-4 py-3 rounded-xl" required minlength="8" autocomplete="new-password">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Confirm password <span class="text-red-500">*</span></label>
                    <input type="password" id="tlPasswordConfirm" class="form-input w-full px-4 py-3 rounded-xl" required minlength="8" autocomplete="new-password">
                </div>
                <button type="submit" id="tlSubmit" class="w-full bg-teal-600 text-white py-3 rounded-xl font-semibold hover:bg-teal-700 transition-colors">
                    Create learner
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
(function () {
    let teacherDashboardPayload = null;

    function tdEscape(s) {
        return String(s ?? '').replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/"/g, '&quot;');
    }

    function formatGenderLabel(code) {
        const m = {
            female: 'Female',
            male: 'Male',
            non_binary: 'Non-binary',
            prefer_not_to_say: 'Prefer not to say',
            other: 'Other',
        };
        return m[code] || '—';
    }

    function renderTdInclusion(im) {
        const panel = document.getElementById('tdInclusionPanel');
        const statsEl = document.getElementById('tdInclusionStats');
        const perfEl = document.getElementById('tdInclusionPerformance');
        const notesEl = document.getElementById('tdInclusionNotes');
        if (!panel || !statsEl || !perfEl || !notesEl) return;
        if (!im) {
            panel.classList.add('hidden');
            return;
        }
        panel.classList.remove('hidden');
        const gr = im.gender_reporting || {};
        statsEl.innerHTML = `
            <div class="rounded-2xl border border-gray-100 bg-gray-50 p-5">
                <p class="text-sm text-gray-500 mb-1">Gender reporting (roster)</p>
                <p class="text-3xl font-extrabold text-gray-900">${tdEscape(String(gr.reporting_rate_percent ?? 0))}%</p>
                <p class="text-xs text-gray-600 mt-2">${gr.learners_with_gender ?? 0} with field · ${gr.learners_without_gender ?? 0} unspecified</p>
            </div>
            <div class="rounded-2xl border border-gray-100 bg-gray-50 p-5 md:col-span-2">
                <p class="text-sm text-gray-500 mb-2">Cohort by category (learners)</p>
                <div class="flex flex-wrap gap-2 text-xs">
                    ${Object.entries(im.cohort_by_gender || {}).map(([k, v]) => {
                        if (!v && k !== 'unspecified') return '';
                        const lab = k === 'unspecified' ? 'Unspecified' : formatGenderLabel(k);
                        return `<span class="inline-flex items-center gap-1 rounded-full bg-white border border-gray-200 px-3 py-1"><span class="font-semibold text-gray-800">${tdEscape(lab)}</span><span class="text-gray-500">${v}</span></span>`;
                    }).filter(Boolean).join('') || '<span class="text-gray-500">No roster data</span>'}
                </div>
            </div>
        `;
        const perf = im.performance_by_gender || {};
        const perfKeys = Object.keys(perf);
        if (perfKeys.length === 0) {
            perfEl.innerHTML = '<div class="text-sm text-gray-500 col-span-full">No completed attempts yet to split by gender.</div>';
        } else {
            perfEl.innerHTML = perfKeys.map(k => {
                const p = perf[k];
                const lab = k === 'unspecified' ? 'Unspecified' : formatGenderLabel(k);
                return `<div class="rounded-xl border border-indigo-100 bg-indigo-50/50 p-4">
                    <p class="text-xs font-semibold text-indigo-900 mb-1">${tdEscape(lab)}</p>
                    <p class="text-2xl font-bold text-gray-900">${tdEscape(String(p.average_percent ?? 0))}%</p>
                    <p class="text-xs text-gray-600 mt-1">${p.assessment_attempts ?? 0} attempts · ${p.distinct_learners ?? 0} learners</p>
                </div>`;
            }).join('');
        }
        const notes = Array.isArray(im.notes) ? im.notes : [];
        notesEl.innerHTML = notes.map(n => `<li>${tdEscape(n)}</li>`).join('');
    }

    function checkTeacherAuth() {
        const token = localStorage.getItem('token') || localStorage.getItem('access_token');
        const userRaw = localStorage.getItem('user');
        if (!token || !userRaw) {
            window.location.href = '/login?return=' + encodeURIComponent('/teacher-dashboard');
            return false;
        }
        try {
            const u = JSON.parse(userRaw);
            if (u.user_type !== 'teacher') {
                if (u.user_type === 'institution') window.location.href = '/institution-dashboard';
                else if (u.user_type === 'parent') window.location.href = '/parent-dashboard';
                else window.location.href = '/dashboard';
                return false;
            }
            window.currentUser = u;
        } catch (e) {
            window.location.href = '/login?return=' + encodeURIComponent('/teacher-dashboard');
            return false;
        }
        return true;
    }

    function showTdAlert(title, message, type) {
        if (typeof showAlert === 'function') {
            showAlert(title, message, type);
        } else {
            alert(title + ': ' + message);
        }
    }

    async function loadTeacherDashboard() {
        const tbody = document.getElementById('teacherStudentsBody');
        const token = localStorage.getItem('token');
        try {
            const res = await fetch(`${API_BASE_URL}/api/teacher/dashboard`, {
                headers: { 'Authorization': `Bearer ${token}`, 'Accept': 'application/json' }
            });
            const data = await res.json();
            if (!data.success) {
                if (tbody) tbody.innerHTML = '<tr><td colspan="5" class="py-8 text-center text-red-600">' + tdEscape(data.message || 'Could not load') + '</td></tr>';
                return;
            }
            teacherDashboardPayload = data.data || {};
            const ins = teacherDashboardPayload.insights || {};
            const pct = ins.average_percent != null ? ins.average_percent : 0;
            document.getElementById('tdInsightLevel').textContent = ins.average_level || '—';
            document.getElementById('tdInsightPercent').textContent = String(pct);
            const imp = ins.learners_improving_percent != null ? ins.learners_improving_percent : 0;
            document.getElementById('tdInsightImproving').textContent = imp + '%';

            const students = teacherDashboardPayload.students || [];
            const hasClass = !!teacherDashboardPayload.classroom_id;
            document.getElementById('teacherNoClassBanner').classList.toggle('hidden', hasClass);
            const addBtn = document.getElementById('btnOpenAddLearnerTeacher');
            if (addBtn) addBtn.disabled = !hasClass;

            if (hasClass && teacherDashboardPayload.inclusion_metrics) {
                renderTdInclusion(teacherDashboardPayload.inclusion_metrics);
            } else {
                const pnl = document.getElementById('tdInclusionPanel');
                if (pnl) pnl.classList.add('hidden');
            }

            if (!tbody) return;
            if (students.length === 0) {
                tbody.innerHTML = '<tr><td colspan="5" class="py-10 px-3 text-center text-gray-500">No learners in this class yet.</td></tr>';
                return;
            }
            tbody.innerHTML = students.map(s => {
                const g = (s.guardian_email || s.guardian_phone) ? [s.guardian_email, s.guardian_phone].filter(Boolean).join(' · ') : '—';
                return `<tr class="border-t border-gray-100">
                    <td class="py-3 px-3 font-medium text-gray-900">
                        <a href="/learner/${s.id}" class="hover:text-teal-700">${tdEscape(s.name)}</a>
                    </td>
                    <td class="py-3 px-3 text-gray-600">${tdEscape(s.grade_level || '—')}</td>
                    <td class="py-3 px-3 text-gray-600 text-sm">${tdEscape(formatGenderLabel(s.gender))}</td>
                    <td class="py-3 px-3 text-gray-600 text-xs max-w-xs">${tdEscape(g)}</td>
                    <td class="py-3 px-3 text-right whitespace-nowrap space-x-2">
                        <a href="/learner/${s.id}" class="text-teal-700 font-semibold text-sm hover:underline">Progress</a>
                        <button type="button" class="text-sm font-semibold text-indigo-700 hover:underline" onclick="emailGuardianReport(${s.id})">Email report</button>
                    </td>
                </tr>`;
            }).join('');
        } catch (e) {
            console.error(e);
            if (tbody) tbody.innerHTML = '<tr><td colspan="5" class="py-8 text-center text-red-600">Network error</td></tr>';
        }
    }

    window.openTeacherAddLearnerModal = function () {
        const m = document.getElementById('teacherAddLearnerModal');
        if (!m) return;
        if (!teacherDashboardPayload || !teacherDashboardPayload.classroom_id) {
            showTdAlert('Not ready', 'You need a classroom assignment before adding learners.', 'warning');
            return;
        }
        document.getElementById('tlName').value = '';
        document.getElementById('tlAdmission').value = '';
        document.getElementById('tlEmail').value = '';
        document.getElementById('tlGrade').value = '';
        const tg = document.getElementById('tlGender');
        if (tg) tg.value = '';
        document.getElementById('tlGuardianEmail').value = '';
        document.getElementById('tlGuardianPhone').value = '';
        document.getElementById('tlPassword').value = '';
        document.getElementById('tlPasswordConfirm').value = '';
        m.classList.remove('hidden');
        m.classList.add('flex');
    };

    window.closeTeacherAddLearnerModal = function () {
        const m = document.getElementById('teacherAddLearnerModal');
        if (!m) return;
        m.classList.add('hidden');
        m.classList.remove('flex');
    };

    window.submitTeacherAddLearner = async function (event) {
        event.preventDefault();
        const pw = document.getElementById('tlPassword').value;
        const pwc = document.getElementById('tlPasswordConfirm').value;
        if (pw.length < 8 || pw !== pwc) {
            showTdAlert('Validation', 'Password must be at least 8 characters and match confirmation.', 'error');
            return;
        }
        const gVal = document.getElementById('tlGender')?.value;
        const body = {
            name: document.getElementById('tlName').value.trim(),
            admission_number: document.getElementById('tlAdmission').value.trim(),
            email: document.getElementById('tlEmail').value.trim() || null,
            grade_level: document.getElementById('tlGrade').value,
            password: pw,
            password_confirmation: pwc,
            guardian_email: document.getElementById('tlGuardianEmail').value.trim() || null,
            guardian_phone: document.getElementById('tlGuardianPhone').value.trim() || null,
            gender: gVal && gVal.length ? gVal : null,
        };
        const btn = document.getElementById('tlSubmit');
        const orig = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Saving…';
        btn.disabled = true;
        try {
            const token = localStorage.getItem('token');
            const res = await fetch(`${API_BASE_URL}/api/teacher/students`, {
                method: 'POST',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                body: JSON.stringify(body)
            });
            const data = await res.json();
            if (data.success) {
                showTdAlert('Success', data.message || 'Learner created.', 'success');
                closeTeacherAddLearnerModal();
                await loadTeacherDashboard();
            } else {
                const msg = typeof extractErrorMessage === 'function'
                    ? extractErrorMessage(data, 'Could not create learner.')
                    : (data.message || 'Error');
                showTdAlert('Error', msg, 'error');
            }
        } catch (e) {
            showTdAlert('Network', 'Request failed.', 'error');
        } finally {
            btn.innerHTML = orig;
            btn.disabled = false;
        }
    };

    window.emailGuardianReport = async function (studentId) {
        const token = localStorage.getItem('token');
        try {
            const res = await fetch(`${API_BASE_URL}/api/teacher/students/${studentId}/share/guardian-email`, {
                method: 'POST',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({})
            });
            const data = await res.json();
            if (data.success) {
                showTdAlert('Sent', data.message || 'Email sent to guardian.', 'success');
            } else {
                const msg = typeof extractErrorMessage === 'function'
                    ? extractErrorMessage(data, 'Could not send email.')
                    : (data.message || 'Error');
                showTdAlert('Could not send', msg, 'error');
            }
        } catch (e) {
            showTdAlert('Network', 'Request failed.', 'error');
        }
    };

    document.addEventListener('DOMContentLoaded', function () {
        if (!checkTeacherAuth()) return;
        const u = window.currentUser;
        document.getElementById('teacherDisplayName').textContent = u.name || 'Teacher';
        const cr = u.classroom;
        const label = cr && (cr.name || cr.grade_level)
            ? [cr.name, cr.grade_level].filter(Boolean).join(' · ')
            : (u.classroom_id ? 'Classroom #' + u.classroom_id : 'Not assigned');
        document.getElementById('teacherClassLabel').textContent = label;
        loadTeacherDashboard();
        if (typeof updateAuthState === 'function') updateAuthState();
    });
})();
</script>
@endsection
