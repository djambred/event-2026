<!DOCTYPE html>
<html class="scroll-smooth" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>@yield('title', $settings['site_title'] ?? 'Esa Unggul International Event 2026')</title>
    <link href="https://fonts.googleapis.com" rel="preconnect"/>
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&family=Inter:wght@400;500;600&family=Work+Sans:wght@400;500&family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .hero-gradient {
            background: linear-gradient(135deg, #003B73 0%, #0D5DA6 100%);
        }
        .form-gradient {
            background: linear-gradient(135deg, #003B73 0%, #0D5DA6 100%);
        }
        .editorial-gradient {
            background: linear-gradient(135deg, #003B73 0%, #0D5DA6 100%);
        }
    </style>
    @stack('styles')
</head>
<body class="bg-[#f8f9ff] font-['Inter'] text-[#141c27] antialiased">
    {{-- TopNavBar --}}
    <header class="sticky top-0 z-50 bg-white/80 backdrop-blur-xl transition-all duration-300">
        <nav class="flex justify-between items-center max-w-7xl mx-auto px-6 h-20">
            <div class="flex items-center gap-2">
                <a href="{{ route('home') }}" class="text-lg font-extrabold text-[#003B73] tracking-tight font-['Plus_Jakarta_Sans']">
                    {{ $settings['site_title'] ?? 'Esa Unggul International Event 2026' }}
                </a>
            </div>
            <div class="hidden md:flex items-center gap-8">
                <a class="{{ request()->routeIs('home') ? 'text-[#003B73] border-b-2 border-[#003B73] pb-1' : 'text-slate-600 hover:text-[#0D5DA6]' }} font-['Plus_Jakarta_Sans'] font-semibold text-sm transition-all" href="{{ route('home') }}">Home</a>
                {{-- Registration Dropdown --}}
                <div class="relative group">
                    <button class="{{ request()->routeIs('registration.*') ? 'text-[#003B73] border-b-2 border-[#003B73] pb-1' : 'text-slate-600 hover:text-[#0D5DA6]' }} font-['Plus_Jakarta_Sans'] font-semibold text-sm transition-all flex items-center gap-1">
                        Registration
                        <span class="material-symbols-outlined text-sm">expand_more</span>
                    </button>
                    <div class="absolute top-full left-1/2 -translate-x-1/2 pt-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                        <div class="bg-white rounded-xl shadow-xl border border-[#e1e9f8] p-2 min-w-[200px]">
                            <a href="{{ route('registration.national') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-[#eff4ff] transition-colors">
                                <span class="material-symbols-outlined text-[#003B73] text-lg">flag</span>
                                <span class="font-['Plus_Jakarta_Sans'] font-semibold text-sm text-[#141c27]">National</span>
                            </a>
                            <a href="{{ route('registration.international') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-[#eff4ff] transition-colors">
                                <span class="material-symbols-outlined text-[#003B73] text-lg">public</span>
                                <span class="font-['Plus_Jakarta_Sans'] font-semibold text-sm text-[#141c27]">International</span>
                            </a>
                        </div>
                    </div>
                </div>
                <a class="{{ request()->routeIs('rules') ? 'text-[#003B73] border-b-2 border-[#003B73] pb-1' : 'text-slate-600 hover:text-[#0D5DA6]' }} font-['Plus_Jakarta_Sans'] font-semibold text-sm transition-all" href="{{ route('rules') }}">Rules</a>
                <a class="{{ request()->routeIs('announcements') ? 'text-[#003B73] border-b-2 border-[#003B73] pb-1' : 'text-slate-600 hover:text-[#0D5DA6]' }} font-['Plus_Jakarta_Sans'] font-semibold text-sm transition-all" href="{{ route('announcements') }}">Winners</a>
                <a class="text-slate-600 hover:text-[#0D5DA6] font-['Plus_Jakarta_Sans'] font-semibold text-sm transition-all" href="{{ route('home') }}#faq">FAQ</a>
                <a class="{{ request()->routeIs('participant.*') ? 'text-[#003B73] border-b-2 border-[#003B73] pb-1' : 'text-slate-600 hover:text-[#0D5DA6]' }} font-['Plus_Jakarta_Sans'] font-semibold text-sm transition-all" href="{{ route('participant.login') }}">My Portal</a>
            </div>
            {{-- Register Now Dropdown --}}
            <div class="relative group">
                <button class="bg-[#003B73] hover:bg-[#0D5DA6] text-white px-6 py-2.5 rounded-xl font-['Plus_Jakarta_Sans'] font-semibold text-sm transition-all active:scale-95 duration-200 flex items-center gap-1">
                    Register Now
                    <span class="material-symbols-outlined text-sm">expand_more</span>
                </button>
                <div class="absolute top-full right-0 pt-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                    <div class="bg-white rounded-xl shadow-xl border border-[#e1e9f8] p-2 min-w-[220px]">
                        <a href="{{ route('registration.national') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-[#eff4ff] transition-colors">
                            <div class="w-8 h-8 rounded-lg bg-[#eff4ff] flex items-center justify-center text-[#003B73]">
                                <span class="material-symbols-outlined text-lg">flag</span>
                            </div>
                            <div>
                                <p class="font-['Plus_Jakarta_Sans'] font-semibold text-sm text-[#141c27]">National</p>
                                <p class="font-['Inter'] text-[10px] text-[#404750]">SMA/SMK Sederajat</p>
                            </div>
                        </a>
                        <a href="{{ route('registration.international') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-[#eff4ff] transition-colors">
                            <div class="w-8 h-8 rounded-lg bg-[#eff4ff] flex items-center justify-center text-[#003B73]">
                                <span class="material-symbols-outlined text-lg">public</span>
                            </div>
                            <div>
                                <p class="font-['Plus_Jakarta_Sans'] font-semibold text-sm text-[#141c27]">International</p>
                                <p class="font-['Inter'] text-[10px] text-[#404750]">University Students</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <main>
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer id="footer" class="bg-slate-50 border-t border-[#e1e9f8] py-20">
        <div class="max-w-7xl mx-auto px-8 grid grid-cols-1 md:grid-cols-3 gap-12">
            <div>
                <h3 class="text-xl font-black text-[#002347] mb-6 font-['Plus_Jakarta_Sans']">{{ $settings['site_title'] ?? 'Esa Unggul International Event 2026' }}</h3>
                <p class="text-slate-500 font-['Inter'] leading-relaxed mb-6">{{ $settings['footer_description'] ?? 'Empowering global students to achieve excellence through international collaboration and healthy competition.' }}</p>
                <div class="flex gap-4">
                    <a class="w-10 h-10 rounded-full bg-[#e6eefd] flex items-center justify-center text-[#003B73] hover:bg-[#003B73] hover:text-white transition-all" href="#">
                        <span class="material-symbols-outlined">share</span>
                    </a>
                    <a class="w-10 h-10 rounded-full bg-[#e6eefd] flex items-center justify-center text-[#003B73] hover:bg-[#003B73] hover:text-white transition-all" href="mailto:{{ $settings['contact_email'] ?? 'jefry.sunupurwa@esaunggul.ac.id' }}">
                        <span class="material-symbols-outlined">mail</span>
                    </a>
                </div>
            </div>
            <div class="flex flex-col gap-4">
                <h4 class="font-['Plus_Jakarta_Sans'] font-bold text-[#003B73] mb-2">Quick Links</h4>
                <a class="text-slate-500 hover:text-[#C8962E] font-['Inter'] text-sm transition-colors" href="#">University Address</a>
                <a class="text-slate-500 hover:text-[#C8962E] font-['Inter'] text-sm transition-colors" href="mailto:{{ $settings['contact_email'] ?? 'jefry.sunupurwa@esaunggul.ac.id' }}">Email Us</a>
                <a class="text-slate-500 hover:text-[#C8962E] font-['Inter'] text-sm transition-colors" href="{{ route('participant.login') }}">My Portal</a>
                <a class="text-slate-500 hover:text-[#C8962E] font-['Inter'] text-sm transition-colors" href="#">Terms of Service</a>
                <a class="text-slate-500 hover:text-[#C8962E] font-['Inter'] text-sm transition-colors" href="#">Privacy Policy</a>
            </div>
            <div>
                <h4 class="font-['Plus_Jakarta_Sans'] font-bold text-[#003B73] mb-6">Contact Us</h4>
                <p class="text-slate-500 font-['Inter'] text-sm mb-4">{{ $settings['organizer_name'] ?? 'Lembaga Bahasa dan Kebudayaan' }}<br/>{{ $settings['contact_location'] ?? 'Universitas Esa Unggul, Jakarta, Indonesia' }}</p>
                <p class="text-slate-500 font-['Inter'] text-sm">© {{ date('Y') }} Esa Unggul University. Jakarta, Indonesia.</p>
            </div>
        </div>
    </footer>

    @if(session('form_expired'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" x-transition
         class="fixed top-24 right-6 z-[9999] bg-red-600 text-white px-6 py-4 rounded-xl shadow-2xl flex items-center gap-3 max-w-sm">
        <span class="material-symbols-outlined text-2xl">error</span>
        <div>
            <p class="font-['Plus_Jakarta_Sans'] font-bold text-sm">Form Expired</p>
            <p class="font-['Inter'] text-xs opacity-90">{{ session('form_expired') }}</p>
        </div>
        <button @click="show = false" class="ml-auto text-white/80 hover:text-white">
            <span class="material-symbols-outlined text-lg">close</span>
        </button>
    </div>
    @endif

    @stack('scripts')
</body>
</html>
