    <!-- Footer -->
    <footer class="bg-gray-900 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-1 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-xl font-bold mb-4 text-yellow-400">Gravity CBC</h3>
                    <p class="text-gray-300 mb-4">Empowering Kenyan learners with accessible, quality assessment tools.</p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">
                            <i class="fab fa-facebook text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">
                            <i class="fab fa-twitter text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">
                            <i class="fab fa-linkedin text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">
                            <i class="fab fa-instagram text-xl"></i>
                        </a>
                    </div>
                </div>
                
                <div>
                    <h3 class="text-lg font-semibold mb-4 text-yellow-400">Quick Links</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('subjects') }}" class="text-gray-300 hover:text-yellow-400 transition-colors">Browse Assessments</a></li>
                        <li><a href="{{ route('dashboard') }}" class="text-gray-300 hover:text-yellow-400 transition-colors">Dashboard</a></li>
                        <li><a href="{{ route('pricing') }}" class="text-gray-300 hover:text-yellow-400 transition-colors">Token Packages</a></li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="text-lg font-semibold mb-4 text-yellow-400">Support</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('help') }}" class="text-gray-300 hover:text-yellow-400 transition-colors">Help Center</a></li>
                        <li><a href="{{ route('contact') }}" class="text-gray-300 hover:text-yellow-400 transition-colors">Contact Us</a></li>
                        <li><a href="{{ route('faq') }}" class="text-gray-300 hover:text-yellow-400 transition-colors">FAQ</a></li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="text-lg font-semibold mb-4 text-yellow-400">Legal</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('privacy') }}" class="text-gray-300 hover:text-yellow-400 transition-colors">Privacy Policy</a></li>
                        <li><a href="{{ route('terms') }}" class="text-gray-300 hover:text-yellow-400 transition-colors">Terms &amp; Conditions</a></li>
                        <li><a href="{{ route('cookie-policy') }}" class="text-gray-300 hover:text-yellow-400 transition-colors">Cookie Policy</a></li>
                    </ul>
                </div>
            </div>

            <!-- Data stewardship & policy framework (detailed) -->
            <div class="mt-10 pt-10 border-t border-gray-700">
                <h3 class="text-lg font-bold text-yellow-400 mb-4">Data stewardship &amp; privacy framework</h3>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 text-sm text-gray-300 leading-relaxed">
                    <div class="space-y-4">
                        <div class="rounded-2xl border border-gray-700 bg-gray-800/40 p-5 mb-2">
                            <h4 class="text-white font-semibold mb-2">Kenyan legal framework</h4>
                            <p class="mb-2">Gravity CBC is operated with reference to the <strong>Data Protection Act, 2019</strong> of Kenya (<strong>Act No. 24 of 2019</strong>), which gives effect to Article 31(c) and (d) of the Constitution, establishes the regulatory framework administered by the <strong>Office of the Data Protection Commissioner (ODPC)</strong>, and sets out the rights of data subjects together with the duties of data controllers and processors.</p>
                            <p class="text-xs text-gray-400">Official text: <a href="https://kenyalaw.org/kl/fileadmin/pdfdownloads/Acts/2019/TheDataProtectionAct__No24of2019.pdf" class="text-yellow-400 hover:text-yellow-300 underline" target="_blank" rel="noopener noreferrer">Kenya Law — Data Protection Act, 2019 (PDF)</a> · <a href="https://www.odpc.go.ke/data-protection-laws-kenya/" class="text-yellow-400 hover:text-yellow-300 underline" target="_blank" rel="noopener noreferrer">ODPC — Data protection laws</a></p>
                        </div>
                        <div>
                            <h4 class="text-white font-semibold mb-2">What we process</h4>
                            <p>Gravity CBC processes account identifiers (name, phone or email, admission number where applicable), institution and class membership, assessment responses and scores, competency summaries, token and billing metadata where you use paid features, optional guardian contact details when your school provides them, and <strong>optional learner demographic fields</strong> (such as gender) solely for reporting and inclusion analytics when your institution chooses to record them.</p>
                        </div>
                        <div>
                            <h4 class="text-white font-semibold mb-2">Purposes &amp; lawful basis</h4>
                            <p>Data is used to deliver assessments, authenticate users, compute learning insights, support institutions in CBC-aligned monitoring, and—where enabled—produce <strong>segmented analytics</strong> (for example by gender) to help schools meet stakeholder and policy expectations. Pilot deployments prioritise minimisation: collect only what your school governance approves, and avoid sensitive fields where they are not needed.</p>
                        </div>
                        <div>
                            <h4 class="text-white font-semibold mb-2">Segmentation, gender &amp; inclusion</h4>
                            <p>Gender is <strong>optional</strong> and must be collected in line with your school&apos;s policies and parental consent practices. Where present, it powers aggregate dashboards (never for automated individual profiling unrelated to learning). Small class sizes can make group averages unstable; interpret inclusion metrics alongside qualitative context. Learners without a recorded gender appear as &quot;unspecified&quot; so cohort totals still reconcile.</p>
                        </div>
                    </div>
                    <div class="space-y-4">
                        <div>
                            <h4 class="text-white font-semibold mb-2">Security, sharing &amp; retention</h4>
                            <p>Credentials are protected using industry-standard hashing. API access is scoped by role (learner, parent, teacher, institution). Data is shared with subprocessors only as needed to operate the service (for example hosting and transactional email). Retention follows your institution&apos;s agreement and applicable law; contact us for data export or deletion requests coordinated with your school.</p>
                        </div>
                        <div>
                            <h4 class="text-white font-semibold mb-2">Your responsibilities (schools)</h4>
                            <p>Institution administrators should maintain accurate rosters, limit access to staff who need it, inform guardians where required, and configure optional fields responsibly. Teachers should only use guardian email features where policy allows.</p>
                        </div>
                        <div>
                            <h4 class="text-white font-semibold mb-2">Further reading &amp; contact</h4>
                            <p>The <a href="{{ route('privacy') }}" class="text-yellow-400 hover:text-yellow-300 underline">Privacy Policy</a> and <a href="{{ route('terms') }}" class="text-yellow-400 hover:text-yellow-300 underline">Terms</a> form part of this framework. For privacy questions or DPIA materials, contact your institution lead or reach us via <a href="{{ route('contact') }}" class="text-yellow-400 hover:text-yellow-300 underline">Contact</a>.</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="border-t border-gray-700 mt-8 pt-8 text-center">
                <p class="text-gray-300 text-sm mb-2">
                    Optimized for mobile and low data usage • Designed for low-resource environments
                </p>
                <p class="text-gray-400 text-sm mb-2">
                    Currently used in pilot school environments
                </p>
                <p class="text-gray-400">&copy; {{ date('Y') }} Gravity CBC. All rights reserved. Built with ❤️ for Kenyan Learners | assessments.gravitycbc.co.ke</p>
            </div>
        </div>
    </footer>
