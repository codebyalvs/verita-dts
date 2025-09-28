<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Distributed Counter') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="text-center">
                        <h3 class="text-2xl font-bold">{{ $counter->value }}</h3>
                        <p class="text-gray-500">Current Count</p>
                    </div>

                    <div class="mt-6 text-center">
                        <form action="{{ route('counter.increment') }}" method="POST">
                            @csrf
                            <x-primary-button>
                                {{ __('Increment') }}
                            </x-primary-button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
