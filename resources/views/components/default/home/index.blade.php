<x-default.layout>
    <x-default.home.hero />
    <x-default.home.features />
    @if($articles->isNotEmpty())
        <x-default.home.article-list :articles="$articles"/>
    @endif
    <section>
        <h1>Home</h1>
        <x-ui.button>
            Button
        </x-ui.button>

        <x-ui.button variant="outline">
            Outline
        </x-ui.button>

        <x-ui.dropdown>
            <x-slot:button class="justify-center">
                <x-ui.button >
                    Navigation
                </x-ui.button>
            </x-slot:button>

            <x-slot:menu>
                <x-ui.dropdown.item href="/dashboard" icon="home">
                    Dashboard
                </x-ui.dropdown.item>

                <x-ui.dropdown.item href="/profile" icon="user">
                    Profile
                </x-ui.dropdown.item>

                <x-ui.dropdown.item href="/settings" icon="cog">
                    Settings
                </x-ui.dropdown.item>
            </x-slot:menu>
        </x-ui.dropdown>

        <x-ui.card size="xl" class="mx-auto">
            <x-ui.heading class="flex items-center justify-between mb-4" level="h3" size="sm">
                <span>Welcome to Sheaf UI.</span>
                <a href="https://sheaf.dev">
                    <x-ui.icon name="arrow-up-right" class="text-gray-800 dark:text-white size-4" />
                </a>
            </x-ui.heading>
            <p>
                Powered by the TALL stack, our components offer speed, elegance,
                and accessibility for modern web development.
            </p>
        </x-ui.card>
        <x-ui.alerts variant="success" icon="information-circle">
            <x-ui.alerts.heading>Information</x-ui.alerts.heading>
            <x-ui.alerts.description>This is an informational message.</x-ui.alerts.description>
        </x-ui.alerts>

        <x-ui.navlist>
            <x-ui.navlist.item
                    label="Dashboard"
                    icon="home"
                    href="/dashboard"
            />
            <x-ui.navlist.item
                    label="Settings"
                    icon="cog"
                    href="/settings"
            />
            <x-ui.navlist.item
                    label="Profile"
                    icon="user"
                    href="/profile"
            />
        </x-ui.navlist>

        <!-- Small badge -->
        <x-ui.badge size="sm">Small Badge</x-ui.badge>

        <!-- Default size badge -->
        <x-ui.badge>Default Badge</x-ui.badge>

        <!-- Large badge -->
        <x-ui.badge size="lg" variant="outline">Large Badge</x-ui.badge>
        <img src="{{ asset('storage/laravel-core/images/article/article-1/cover.jpg') }}" alt="cover">
        <img src="{{ asset('storage/laravel-core/images/article/article-1/featured.jpg') }}" alt="featured">
        test
    </section>
</x-default.layout>