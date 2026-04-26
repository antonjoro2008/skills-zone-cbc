@extends('layouts.app')

@section('title', 'Start - Gravity CBC')

@section('content')
    <div class="min-h-[70vh] flex items-center">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16 w-full">
            <div class="bg-white rounded-3xl shadow-xl p-8 md:p-12 border border-gray-100/80 ring-1 ring-gray-900/5">
                <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-4">
                    Welcome to Gravity CBC Assessments
                </h1>

                <p class="text-gray-600 text-lg mb-8">
                    Start here:
                </p>

                <ul class="space-y-3 text-gray-800 text-lg mb-10">
                    <li class="flex items-start gap-3">
                        <span class="mt-1 w-2.5 h-2.5 rounded-full bg-[#8FC340] shrink-0"></span>
                        <span>View learner progress</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="mt-1 w-2.5 h-2.5 rounded-full bg-[#E368A7] shrink-0"></span>
                        <span>Open assessment results</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="mt-1 w-2.5 h-2.5 rounded-full bg-blue-500 shrink-0"></span>
                        <span>Check learning insights</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="mt-1 w-2.5 h-2.5 rounded-full bg-yellow-500 shrink-0"></span>
                        <span>View next step</span>
                    </li>
                </ul>

                <div class="flex flex-col sm:flex-row gap-3">
                    <button
                        id="goToDashboardBtn"
                        class="inline-flex items-center justify-center bg-gradient-to-r from-[#8FC340] to-[#E368A7] text-white px-8 py-4 rounded-2xl text-lg font-semibold shadow-lg hover:shadow-xl transition-all hover:scale-[1.01]"
                    >
                        Go to Dashboard
                        <i class="fas fa-arrow-right ml-3"></i>
                    </button>

                    <a
                        href="{{ route('subjects') }}"
                        class="inline-flex items-center justify-center bg-white border-2 border-gray-200 text-gray-800 px-8 py-4 rounded-2xl text-lg font-semibold hover:bg-gray-50 transition-all"
                    >
                        View Assessments
                    </a>
                </div>

                <p class="text-sm text-gray-500 mt-8">
                    Currently used in pilot school environments
                </p>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const btn = document.getElementById('goToDashboardBtn');
        if (!btn) return;

        btn.addEventListener('click', function () {
            const storedUser = localStorage.getItem('user');
            if (!storedUser) {
                window.location.href = '/login?return=' + encodeURIComponent('/start');
                return;
            }

            try {
                const user = JSON.parse(storedUser);
                if (user.user_type === 'institution') {
                    window.location.href = '/institution-dashboard';
                } else if (user.user_type === 'teacher') {
                    window.location.href = '/teacher-dashboard';
                } else if (user.user_type === 'parent') {
                    window.location.href = '/parent-dashboard';
                } else {
                    window.location.href = '/dashboard';
                }
            } catch (e) {
                window.location.href = '/dashboard';
            }
        });
    });
</script>
@endsection

