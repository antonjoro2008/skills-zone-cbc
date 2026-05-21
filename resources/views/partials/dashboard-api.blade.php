{{-- Shared client for role dashboards (cbc-admin API) --}}
<script>
(function () {
    function authHeaders() {
        const token = localStorage.getItem('token') || localStorage.getItem('access_token');
        return {
            Accept: 'application/json',
            'Content-Type': 'application/json',
            ...(token ? { Authorization: 'Bearer ' + token } : {}),
        };
    }

    function apiBase() {
        return typeof API_BASE_URL !== 'undefined' ? API_BASE_URL : 'https://admin.skillszone.africa';
    }

    async function request(path, options) {
        const response = await fetch(apiBase() + path, {
            method: (options && options.method) || 'GET',
            headers: authHeaders(),
            ...(options && options.body ? { body: JSON.stringify(options.body) } : {}),
        });
        const payload = await response.json().catch(function () {
            return { success: false, message: 'Invalid server response' };
        });
        if (!response.ok && payload.success !== false) {
            payload.success = false;
            payload.message = payload.message || ('Request failed (' + response.status + ')');
        }
        return payload;
    }

    function persistMain(data) {
        if (!data || typeof data !== 'object') return;
        const snapshot = {
            user_type: data.user_type,
            token_balance: data.token_balance,
            minutes_balance: data.minutes_balance,
            available_minutes: data.minutes_balance,
            assessment_stats: data.assessment_stats,
            recent_assessments: data.recent_assessments,
            recent_attempts: data.recent_attempts,
            analytics: data.analytics,
        };
        try {
            localStorage.setItem('dashboard', JSON.stringify(snapshot));
        } catch (e) { /* ignore quota */ }
        if (data.user) {
            try {
                localStorage.setItem('user', JSON.stringify(data.user));
                window.currentUser = data.user;
            } catch (e) { /* ignore */ }
        }
    }

    function attemptSummaryUrl(attemptId) {
        return attemptId ? '/attempt-summary/' + encodeURIComponent(attemptId) : '#';
    }

    function mapStudentHistory(entries) {
        return (entries || []).map(function (item) {
            return {
                attempt_id: item.attempt_id ?? null,
                assessment_id: item.assessment_id ?? null,
                assessment_title: item.assessment_name || item.assessment_title || item.title || 'Assessment',
                title: item.assessment_name || item.title,
                score_percent: item.score_percent ?? item.percentage ?? item.score ?? item.percent ?? 0,
                score: item.score_percent ?? item.score ?? 0,
                assessed_at: item.date_taken || item.completed_at || item.assessed_at,
                subject: item.subject || item.subject_name || null,
                competency_level: item.competency_level || null,
                status: item.status || 'completed',
            };
        });
    }

    function renderAttemptHistoryList(container, attempts, options) {
        if (!container) return;
        const opts = options || {};
        const items = (attempts || []).filter(function (a) {
            return opts.includeInProgress || a.status !== 'in_progress';
        });

        if (!items.length) {
            container.innerHTML = opts.emptyHtml || (
                '<div class="text-center text-gray-500 py-8">' +
                '<i class="fas fa-clipboard-list text-3xl mb-3"></i>' +
                '<p>No completed attempts yet.</p></div>'
            );
            return;
        }

        container.innerHTML = items.map(function (item) {
            const p = item.score_percent ?? item.score ?? 0;
            const title = escapeHtml(item.assessment_title || item.title || 'Assessment');
            const when = item.assessed_at || item.completed_at || item.date_taken;
            const whenStr = when ? new Date(when).toLocaleString() : '—';
            const level = item.competency_level
                ? escapeHtml(item.competency_level)
                : (p + '%');
            const href = item.attempt_id && item.status === 'completed'
                ? attemptSummaryUrl(item.attempt_id)
                : null;
            const sub = item.subject ? escapeHtml(item.subject) : '';
            const student = item.student_name ? '<span class="text-xs text-gray-500 block">' + escapeHtml(item.student_name) + '</span>' : '';

            return (
                '<div class="flex items-center justify-between p-4 bg-white border border-gray-100 rounded-2xl hover:bg-gray-50 transition-all gap-4">' +
                '<div class="min-w-0 flex-1">' +
                '<p class="font-semibold text-gray-900 truncate">' + title + '</p>' +
                student +
                '<p class="text-sm text-gray-600">' + whenStr + (sub ? ' · ' + sub : '') + '</p>' +
                '</div>' +
                '<div class="text-right shrink-0">' +
                '<p class="text-xl font-extrabold text-gray-900">' + (item.status === 'completed' ? p + '%' : 'In progress') + '</p>' +
                '<p class="text-xs font-semibold text-indigo-800 max-w-[10rem] ml-auto leading-tight">' + level + '</p>' +
                (href
                    ? '<a href="' + href + '" class="inline-block mt-2 text-sm font-semibold text-blue-600 hover:underline">View summary</a>'
                    : '') +
                '</div></div>'
            );
        }).join('');
    }

    function dashboardBackUrl(userType) {
        const routes = {
            institution: '/institution-dashboard',
            teacher: '/teacher-dashboard',
            parent: '/parent-dashboard',
            student: '/dashboard',
        };
        return routes[userType] || '/dashboard';
    }

    function applyParentAnalytics(analytics) {
        if (!analytics || typeof analytics !== 'object') return;

        const overview = analytics.overview || {};
        const insights = analytics.insights || {};

        const map = {
            parentLearnerCount: overview.registered_learners,
            parentLinkedCount: overview.linked_learners,
            parentCompletedAttempts: overview.total_completed_attempts,
            parentHouseholdAverage: overview.household_average_percent != null
                ? overview.household_average_percent + '%'
                : '—',
            parentHouseholdLevel: overview.household_competency_level || insights.average_level || '—',
            parentImprovingPercent: overview.learners_improving_percent != null
                ? overview.learners_improving_percent + '%'
                : '—',
            parentDashboardNote: overview.note || '',
        };

        Object.keys(map).forEach(function (id) {
            const el = document.getElementById(id);
            if (el && map[id] != null) el.textContent = String(map[id]);
        });

        const cards = document.getElementById('parentChildrenCards');
        if (cards) {
            const learners = analytics.learners || [];
            if (!learners.length) {
                cards.innerHTML = '<p class="text-gray-500 text-sm col-span-full">Add learners to see household progress.</p>';
            } else {
                cards.innerHTML = learners.map(function (child) {
                    const summary = child.summary || {};
                    const linked = child.linked;
                    const progressHref = child.student_user_id
                        ? '/learner/' + child.student_user_id
                        : null;
                    const avg = summary.average_percent;
                    const level = summary.competency_level || 'No attempts yet';
                    const attempts = summary.completed_attempts ?? 0;
                    const last = summary.last_activity_at
                        ? new Date(summary.last_activity_at).toLocaleDateString()
                        : '—';
                    return (
                        '<div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 flex flex-col">' +
                        '<div class="flex items-start justify-between gap-3 mb-4">' +
                        '<div><h3 class="font-bold text-gray-900">' + escapeHtml(child.name || 'Learner') + '</h3>' +
                        '<p class="text-sm text-gray-500">' + escapeHtml(child.grade_level || '—') + '</p></div>' +
                        (linked
                            ? '<span class="text-xs font-semibold text-green-700 bg-green-50 px-2 py-1 rounded-full">Linked</span>'
                            : '<span class="text-xs font-semibold text-amber-700 bg-amber-50 px-2 py-1 rounded-full">Not linked</span>') +
                        '</div>' +
                        '<div class="space-y-2 text-sm flex-1">' +
                        '<p><span class="text-gray-500">CBE level:</span> <strong>' + escapeHtml(level) + '</strong></p>' +
                        '<p><span class="text-gray-500">Average:</span> <strong>' + (avg != null ? avg + '%' : '—') + '</strong></p>' +
                        '<p><span class="text-gray-500">Attempts:</span> <strong>' + attempts + '</strong></p>' +
                        '<p><span class="text-gray-500">Last activity:</span> ' + escapeHtml(last) + '</p>' +
                        (!linked && child.link_hint
                            ? '<p class="text-xs text-amber-700 mt-2">' + escapeHtml(child.link_hint) + '</p>'
                            : '') +
                        '</div>' +
                        (function () {
                            const recent = (child.recent_assessments || []).filter(function (r) {
                                return r.attempt_id;
                            });
                            if (!recent.length) return '';
                            return '<div class="mt-4 pt-4 border-t border-gray-100"><p class="text-xs font-semibold text-gray-500 uppercase mb-2">Recent attempts</p>' +
                                recent.map(function (r) {
                                    const href = attemptSummaryUrl(r.attempt_id);
                                    const when = r.date_taken ? new Date(r.date_taken).toLocaleDateString() : '';
                                    return '<a href="' + href + '" class="block text-sm text-blue-600 hover:underline py-1">' +
                                        escapeHtml(r.assessment_name || 'Assessment') + ' · ' + (r.score_percent ?? 0) + '%' +
                                        (when ? ' · ' + when : '') + '</a>';
                                }).join('') + '</div>';
                        })() +
                        (progressHref
                            ? '<a href="' + progressHref + '" class="mt-4 inline-flex items-center justify-center rounded-xl bg-blue-600 text-white text-sm font-semibold px-4 py-2 hover:bg-blue-700">View progress</a>'
                            : '') +
                        '</div>'
                    );
                }).join('');
            }
        }

        const actions = document.getElementById('parentActionItems');
        if (actions && Array.isArray(analytics.action_items)) {
            actions.innerHTML = analytics.action_items.map(function (item) {
                return '<li class="text-sm text-gray-700"><strong>' + escapeHtml(item.title || '') + ':</strong> ' +
                    escapeHtml(item.description || '') + '</li>';
            }).join('') || '';
        }

        window.parentAnalyticsByLearnerId = {};
        (analytics.learners || []).forEach(function (child) {
            window.parentAnalyticsByLearnerId[child.id] = child;
        });
    }

    function escapeHtml(text) {
        if (text == null) return '';
        const div = document.createElement('div');
        div.textContent = String(text);
        return div.innerHTML;
    }

    function applyInstitutionAnalytics(analytics) {
        if (!analytics || typeof analytics !== 'object') return;

        const insights = analytics.insights || {};
        const summary = analytics.summary || {};
        const strengths = analytics.class_strengths || [];
        const weaknesses = analytics.class_weaknesses || [];

        const avgEl = document.getElementById('classAvgLevel');
        if (avgEl) {
            const pct = insights.average_percent;
            const hasData = pct != null && Number(pct) > 0;
            avgEl.textContent = hasData
                ? (insights.average_level || '—')
                : 'No attempts yet';
        }

        const strongEl = document.getElementById('classStrongArea');
        if (strongEl) {
            strongEl.textContent = strengths[0]?.label || strengths[0]?.category || 'Literacy';
        }

        const weakEl = document.getElementById('classWeakArea');
        if (weakEl) {
            weakEl.textContent = weaknesses[0]?.label || weaknesses[0]?.category || 'Numeracy';
        }

        const improvingEl = document.getElementById('classImproving');
        if (improvingEl) {
            const imp = insights.learners_improving_percent;
            improvingEl.textContent = imp != null ? imp + '%' : '—';
        }

        const grEl = document.getElementById('institutionGenderReporting');
        if (grEl) {
            const gr = analytics.inclusion_metrics?.gender_reporting || {};
            const rate = gr.reporting_rate_percent;
            if (rate != null) {
                grEl.textContent =
                    'Inclusion data: gender on record for ' +
                    (gr.learners_with_gender ?? 0) +
                    ' of ' +
                    (summary.learners ?? gr.total_learners ?? '—') +
                    ' learners (' +
                    rate +
                    '%). Complete records improve segmented analytics for stakeholders.';
            }
        }

        if (summary.learners != null) {
            const totalEl = document.getElementById('totalLearners');
            if (totalEl) totalEl.textContent = String(summary.learners);
        }
    }

    function applyTeacherInsights(payload) {
        if (!payload) return;
        const ins = payload.insights || {};
        const pct = ins.average_percent != null ? ins.average_percent : 0;
        const imp = ins.learners_improving_percent != null ? ins.learners_improving_percent : 0;

        const impEl = document.getElementById('tdInsightImproving');
        if (impEl) impEl.textContent = imp + '%';

        const completed = (payload.overview?.total_completed_attempts ?? 0) > 0;
        const levelEl = document.getElementById('tdInsightLevel');
        const pctEl = document.getElementById('tdInsightPercent');
        if (levelEl) {
            levelEl.textContent = completed ? (ins.average_level || '—') : 'No attempts yet';
        }
        if (pctEl) {
            pctEl.textContent = completed ? String(pct) : '—';
        }
    }

    window.DashboardApi = {
        request: request,
        persistMain: persistMain,
        mapStudentHistory: mapStudentHistory,
        dashboardBackUrl: dashboardBackUrl,
        applyInstitutionAnalytics: applyInstitutionAnalytics,
        applyParentAnalytics: applyParentAnalytics,
        applyTeacherInsights: applyTeacherInsights,
        fetchMain: function () {
            return request('/api/dashboard');
        },
        fetchAnalytics: function () {
            return request('/api/dashboard/analytics');
        },
        fetchStudentAnalytics: function (studentId) {
            return request('/api/dashboard/students/' + encodeURIComponent(studentId));
        },
        fetchAssessmentAnalytics: function (assessmentId) {
            return request('/api/dashboard/assessments/' + encodeURIComponent(assessmentId));
        },
        fetchTeacherDashboard: function () {
            return request('/api/teacher/dashboard');
        },
        fetchAttemptHistory: function (studentId) {
            const q = studentId ? '?student_id=' + encodeURIComponent(studentId) + '&per_page=50' : '?per_page=50';
            return request('/api/assessment-attempts' + q);
        },
        fetchAttemptSummary: function (attemptId) {
            return request('/api/assessment-attempts/' + encodeURIComponent(attemptId));
        },
        attemptSummaryUrl: attemptSummaryUrl,
        renderAttemptHistoryList: renderAttemptHistoryList,
    };
})();
</script>
