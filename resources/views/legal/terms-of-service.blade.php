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
                {{ __('Terms of Service') }}
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
                    {{ __('These Terms of Service ("Terms") govern your access to and use of Neogencia. By using our website or services, you agree to these Terms. Replace this document with terms appropriate for your jurisdiction and business, ideally after legal review.') }}
                </p>

                <section>
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-3">{{ __('1. The service') }}</h2>
                    <p>{{ __('Neogencia provides a platform to discover, list, and interact with AI agents and related tools. Features may change over time. We strive for availability but do not guarantee uninterrupted access.') }}</p>
                </section>

                <section>
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-3">{{ __('2. Accounts') }}</h2>
                    <p>{{ __('You are responsible for safeguarding your account credentials and for activity under your account. You must provide accurate information and notify us of any unauthorized use.') }}</p>
                </section>

                <section>
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-3">{{ __('3. User content and conduct') }}</h2>
                    <p>{{ __('You retain rights to content you submit, but grant us a license to host, display, and distribute it as needed to operate the platform. You must not submit unlawful, misleading, infringing, or harmful content, or attempt to disrupt or misuse the service.') }}</p>
                </section>

                <section>
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-3">{{ __('4. Third-party agents and links') }}</h2>
                    <p>{{ __('Listings may link to third-party products or services. We are not responsible for third-party sites, agents, or APIs. Use them at your own risk and subject to their terms.') }}</p>
                </section>

                <section>
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-3">{{ __('5. Disclaimers') }}</h2>
                    <p>{{ __('The service is provided "as is" without warranties of any kind, to the fullest extent permitted by law. We do not warrant that AI outputs or marketplace listings are accurate, complete, or fit for a particular purpose.') }}</p>
                </section>

                <section>
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-3">{{ __('6. Limitation of liability') }}</h2>
                    <p>{{ __('To the maximum extent permitted by applicable law, Neogencia and its affiliates will not be liable for indirect, incidental, special, consequential, or punitive damages, or for loss of profits or data, arising from your use of the service.') }}</p>
                </section>

                <section>
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-3">{{ __('7. Changes') }}</h2>
                    <p>{{ __('We may modify these Terms or the service. We will post updated Terms with a new "Last updated" date where reasonable. Continued use after changes constitutes acceptance.') }}</p>
                </section>

                <section>
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-3">{{ __('8. Contact') }}</h2>
                    <p>
                        {{ __('Questions about these Terms? Reach us through the') }}
                        <a href="{{ route('contact') }}" class="text-indigo-600 dark:text-indigo-400 font-medium hover:underline">{{ __('contact page') }}</a>.
                    </p>
                </section>

                <p class="text-xs text-gray-500 dark:text-gray-500 pt-4 border-t border-gray-200 dark:border-gray-700">
                    <a href="{{ route('privacy-policy') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">{{ __('Privacy Policy') }}</a>
                    ·
                    <a href="{{ route('home') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">{{ __('Home') }}</a>
                </p>
            </div>
        </article>
    </div>
</x-app-layout>
