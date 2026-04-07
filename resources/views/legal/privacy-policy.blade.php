<x-app-layout>
    <div class="relative overflow-hidden py-14 md:py-20 min-h-[280px] md:min-h-[320px] flex items-center">
        <div class="absolute inset-0">
            <img src="{{ asset('hero-ai-platform.jpg') }}" alt="" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-br from-indigo-900/80 via-purple-900/70 to-pink-900/80"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent"></div>
        </div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 z-10 w-full text-center">
            <span class="inline-block px-4 py-2 bg-white/20 backdrop-blur-md text-white text-sm font-semibold rounded-full border border-white/30 mb-4">
                {{ __('Legal') }}
            </span>
            <h1 class="text-3xl md:text-5xl font-extrabold text-white drop-shadow-2xl">
                {{ __('Privacy Policy') }}
            </h1>
            <p class="mt-3 text-white/90 text-sm md:text-base max-w-2xl mx-auto">
                {{ __('Last updated') }}: {{ now()->format('F j, Y') }}
            </p>
        </div>
    </div>

    <div class="py-12 md:py-16 bg-gradient-to-b from-gray-50 to-white dark:from-gray-800 dark:to-gray-900">
        <article class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-2xl rounded-3xl border-2 border-gray-200/50 dark:border-gray-700/50 p-8 md:p-10 space-y-8 text-gray-700 dark:text-gray-300 text-sm md:text-base leading-relaxed">
                <p class="text-gray-600 dark:text-gray-400">
                    {{ __('This Privacy Policy describes how Neogencia ("we", "us") collects, uses, and shares information when you use our website and services. Please read it carefully. You may want to replace this text with a version reviewed by your legal counsel.') }}
                </p>

                <section>
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-3">{{ __('1. Information we collect') }}</h2>
                    <ul class="list-disc pl-5 space-y-2">
                        <li>{{ __('Account information you provide when registering (such as name and email address).') }}</li>
                        <li>{{ __('Content you submit (for example, agent listings, reviews, or messages sent through contact forms).') }}</li>
                        <li>{{ __('Technical data such as IP address, browser type, and usage logs, collected automatically when you use the platform.') }}</li>
                    </ul>
                </section>

                <section>
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-3">{{ __('2. How we use your information') }}</h2>
                    <p>{{ __('We use the information we collect to operate and improve the marketplace, authenticate users, communicate with you, moderate content, comply with legal obligations, and protect the security of our services.') }}</p>
                </section>

                <section>
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-3">{{ __('3. Cookies and similar technologies') }}</h2>
                    <p>{{ __('We may use cookies and similar technologies to keep you signed in, remember preferences, and understand how the site is used. You can control cookies through your browser settings.') }}</p>
                </section>

                <section>
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-3">{{ __('4. Sharing of information') }}</h2>
                    <p>{{ __('We may share information with service providers who assist us in hosting, analytics, or email delivery, when required by law, or to protect our rights and users. We do not sell your personal information.') }}</p>
                </section>

                <section>
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-3">{{ __('5. Data retention and security') }}</h2>
                    <p>{{ __('We retain information for as long as needed to provide the service and meet legal requirements. We implement appropriate technical and organizational measures to protect your data.') }}</p>
                </section>

                <section>
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-3">{{ __('6. Your rights') }}</h2>
                    <p>{{ __('Depending on your location, you may have rights to access, correct, delete, or restrict processing of your personal data, or to object to certain processing. Contact us to exercise these rights.') }}</p>
                </section>

                <section>
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-3">{{ __('7. Contact') }}</h2>
                    <p>
                        {{ __('For privacy-related questions, please use our') }}
                        <a href="{{ route('contact') }}" class="text-indigo-600 dark:text-indigo-400 font-medium hover:underline">{{ __('contact page') }}</a>.
                    </p>
                </section>

                <p class="text-xs text-gray-500 dark:text-gray-500 pt-4 border-t border-gray-200 dark:border-gray-700">
                    <a href="{{ route('terms-of-service') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">{{ __('Terms of Service') }}</a>
                    ·
                    <a href="{{ route('home') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">{{ __('Home') }}</a>
                </p>
            </div>
        </article>
    </div>
</x-app-layout>
