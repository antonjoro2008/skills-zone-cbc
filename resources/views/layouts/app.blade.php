<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SkillsZone - Skills Assessment for African Students')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.31/jspdf.plugin.autotable.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#eff6ff',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            900: '#1e3a8a'
                        },
                        accent: {
                            500: '#f59e0b',
                            600: '#d97706'
                        }
                    },
                    animation: {
                        'fade-in-up': 'fade-in-up 0.5s ease-out',
                        'fade-in-left': 'fade-in-left 0.6s ease-out',
                        'fade-in-right': 'fade-in-right 0.6s ease-out',
                        'bounce-slow': 'bounce 2s infinite',
                        'pulse-glow': 'pulse-glow 2s ease-in-out infinite',
                        'float': 'float 3s ease-in-out infinite'
                    }
                }
            }
        }
    </script>
    <link rel="stylesheet" href="/css/style.css">
    @yield('additional_head')
</head>
<body class="bg-gray-50">
    @include('partials.navigation')

    <!-- Main Content -->
    <main class="pt-16">
        @yield('content')
    </main>

    @include('partials.footer')
    @include('partials.modals')
    @include('partials.scripts')
    @yield('scripts')
</body>
</html> 