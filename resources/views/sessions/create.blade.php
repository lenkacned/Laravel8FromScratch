<x-layout>   
   <section class="px-6 py-8">
        <main class="max-w-lg mx-auto mt-10">
            <x-panel>
                <h1 class="text-center font-bold text-xl">Login!</h1>

                <form method="POST" action="/sessions" class="mt-10">
                <!-- this expands to a hidden input. Laravel create value and behind the scenes check and verify that value. 
                As long as those values mach up we are good to go.           -->
                @csrf
                        <x-form.input name="email" type="email" autocomplete="username" />
                        <x-form.input name="password" type="password" autocomplete="new-password"/>
                        
                        <div class="flex justify-end mt-2 pt-6">
                            <x-submit-button>Log in</x-submit-button>
                        </div> 
                </form>
            </x-panel>
        </main>
    </section>
</x-layout>