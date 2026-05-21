@extends('layouts.app')

@section('title', 'Learner Progress - Gravity CBC')

@section('content')
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Learning Progress Over Time</h1>
            <p class="text-gray-600">Track assessment performance and recent activity.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-1">
                <div class="bg-white rounded-3xl shadow-lg p-6">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 bg-blue-100 rounded-2xl flex items-center justify-center">
                            <i class="fas fa-user text-blue-600 text-2xl"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Learner</p>
                            <p class="text-xl font-bold text-gray-900" id="learnerName">Loading...</p>
                            <p class="text-sm text-gray-600" id="learnerMeta">—</p>
                        </div>
                    </div>

                    <div class="mt-6 border-t pt-6 space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600 text-sm">Last activity</span>
                            <span class="text-gray-900 font-semibold text-sm" id="lastActivity">—</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600 text-sm">Assessments</span>
                            <span class="text-gray-900 font-semibold text-sm" id="assessmentCount">0</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600 text-sm">Latest CBE level</span>
                            <span class="text-gray-900 font-semibold text-sm" id="latestCompetency">—</span>
                        </div>
                    </div>
                </div>

                <div class="mt-6">
                    <a id="learnerBackLink" href="{{ route('dashboard') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 font-semibold">
                        <i class="fas fa-arrow-left mr-2"></i><span id="learnerBackLabel">Back to Dashboard</span>
                    </a>
                </div>
            </div>

            <div class="lg:col-span-2 space-y-8">
                <div class="bg-white rounded-3xl shadow-lg p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">Progress over time</h2>
                    <div id="progressTimeline" class="space-y-4">
                        <div class="text-center text-gray-500 py-8">
                            <i class="fas fa-spinner fa-spin text-3xl mb-3"></i>
                            <p>Loading progress...</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-3xl shadow-lg p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">List of assessments</h2>
                    <div id="assessmentsList" class="space-y-3">
                        <div class="text-center text-gray-500 py-8">
                            <i class="fas fa-spinner fa-spin text-3xl mb-3"></i>
                            <p>Loading assessments...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    const learnerId = @json($learnerId);

    function safeParse(json, fallback) {
        try { return JSON.parse(json); } catch (e) { return fallback; }
    }

    function getLearnerAssessmentsFromLocal(learnerId) {
        const raw = localStorage.getItem('learner_assessment_history');
        const data = raw ? safeParse(raw, {}) : {};
        return Array.isArray(data[String(learnerId)]) ? data[String(learnerId)] : [];
    }

    function formatDateTime(dateIso) {
        if (!dateIso) return '—';
        const d = new Date(dateIso);
        if (isNaN(d.getTime())) return '—';
        return d.toLocaleString();
    }

    function render(learner, items) {
        document.getElementById('learnerName').textContent = learner?.name || `Learner #${learnerId}`;
        document.getElementById('learnerMeta').textContent = learner?.grade_level ? learner.grade_level : '';

        const sorted = [...items].sort((a, b) => new Date(a.assessed_at) - new Date(b.assessed_at));
        const latest = sorted.length ? sorted[sorted.length - 1] : null;

        document.getElementById('assessmentCount').textContent = String(sorted.length);
        document.getElementById('lastActivity').textContent = latest ? formatDateTime(latest.assessed_at) : '—';

        if (latest && typeof window.formatCompetencyLevel === 'function') {
            document.getElementById('latestCompetency').textContent = window.formatCompetencyLevel(latest.score_percent || latest.score || 0);
        } else {
            document.getElementById('latestCompetency').textContent = latest ? `${latest.score_percent || latest.score || 0}%` : '—';
        }

        // Timeline: show 40 → 60 → 75 style
        const timeline = document.getElementById('progressTimeline');
        if (!sorted.length) {
            timeline.innerHTML = `
                <div class="text-center text-gray-500 py-8">
                    <i class="fas fa-chart-line text-3xl mb-3"></i>
                    <p>No assessments yet.</p>
                </div>
            `;
        } else {
            timeline.innerHTML = sorted.map((it, idx) => {
                const p = it.score_percent ?? it.score ?? 0;
                const c = (typeof window.getCompetencyFromPercent === 'function') ? window.getCompetencyFromPercent(p) : null;
                return `
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-2xl bg-gray-100 flex items-center justify-center font-bold text-gray-700">${idx + 1}</div>
                        <div class="flex-1 bg-gray-50 border border-gray-100 rounded-2xl p-4">
                            <div class="flex flex-wrap items-center justify-between gap-2">
                                <p class="font-semibold text-gray-900">${it.assessment_title || it.title || 'Assessment'}</p>
                                <span class="text-sm font-bold text-blue-700">${p}%</span>
                            </div>
                            <p class="text-sm text-gray-600 mt-1">${formatDateTime(it.assessed_at)}</p>
                            ${c ? `<p class="text-sm text-gray-800 mt-2"><span class="font-semibold">CBE level:</span> ${c.displayFull} · ${p}%</p>` : ''}
                        </div>
                    </div>
                `;
            }).join('');
        }

        // List
        const list = document.getElementById('assessmentsList');
        if (!sorted.length) {
            list.innerHTML = `
                <div class="text-center text-gray-500 py-8">
                    <i class="fas fa-clipboard-list text-3xl mb-3"></i>
                    <p>No assessments recorded yet.</p>
                </div>
            `;
        } else {
            list.innerHTML = sorted.slice().reverse().map(it => {
                const p = it.score_percent ?? it.score ?? 0;
                const c = (typeof window.getCompetencyFromPercent === 'function') ? window.getCompetencyFromPercent(p) : null;
                return `
                    <div class="flex items-center justify-between p-4 bg-white border border-gray-100 rounded-2xl hover:bg-gray-50 transition-all">
                        <div>
                            <p class="font-semibold text-gray-900">${it.assessment_title || it.title || 'Assessment'}</p>
                            <p class="text-sm text-gray-600">${formatDateTime(it.assessed_at)}</p>
                            ${c ? `<p class="text-sm text-gray-700 mt-1">${c.displayFull} · ${c.feedback}</p>` : ''}
                        </div>
                        <div class="text-right">
                            <p class="text-xl font-extrabold text-gray-900">${p}%</p>
                            ${c ? `<p class="text-xs font-semibold text-indigo-800 max-w-[10rem] ml-auto leading-tight">${c.displayFull}</p>` : ''}
                        </div>
                    </div>
                `;
            }).join('');
        }
    }

    function setupBackNavigation() {
        const link = document.getElementById('learnerBackLink');
        const label = document.getElementById('learnerBackLabel');
        if (!link) return;
        let userType = null;
        try {
            const user = safeParse(localStorage.getItem('user'), null);
            userType = user?.user_type;
        } catch (e) { /* ignore */ }
        if (typeof DashboardApi !== 'undefined') {
            link.href = DashboardApi.dashboardBackUrl(userType);
        }
        const labels = {
            institution: 'Back to Institution Dashboard',
            teacher: 'Back to Teacher Hub',
            parent: 'Back to Parent Dashboard',
            student: 'Back to My Dashboard',
        };
        if (label) {
            label.textContent = labels[userType] || 'Back to Dashboard';
        }
    }

    async function loadLearnerFromApi() {
        if (typeof DashboardApi === 'undefined') return false;
        const token = localStorage.getItem('token');
        if (!token) return false;
        try {
            const result = await DashboardApi.fetchStudentAnalytics(learnerId);
            if (!result.success || !result.data) return false;
            const profile = result.data.profile || {};
            const learner = {
                id: profile.student_id || learnerId,
                name: profile.name,
                grade_level: profile.grade_level,
            };
            const history = DashboardApi.mapStudentHistory(
                result.data.assessment_history || result.data.recent_performance || [],
            );
            render(learner, history);
            return true;
        } catch (error) {
            console.error('Error loading learner analytics:', error);
            return false;
        }
    }

    async function loadLearner() {
        setupBackNavigation();

        const token = localStorage.getItem('token');
        if (!token) {
            window.location.href = '/login?return=' + encodeURIComponent(window.location.pathname);
            return;
        }

        if (await loadLearnerFromApi()) {
            return;
        }

        // Fallback: cached roster + local assessment history
        const cached = localStorage.getItem('cached_institution_learners');
        const learners = cached ? safeParse(cached, []) : [];
        const learner = learners.find(l => String(l.id) === String(learnerId));
        const history = getLearnerAssessmentsFromLocal(learnerId);
        render(learner, history);
    }

    document.addEventListener('DOMContentLoaded', loadLearner);
</script>
@endsection

