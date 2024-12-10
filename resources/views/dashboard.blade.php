<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}
                </div>
                <!-- Formulario para cargar archivo Excel -->
                <div class="p-6">
                    <form action="{{ route('api.upload.excel') }}" method="POST" enctype="multipart/form-data" style="display: flex; flex-direction: column; gap: 1rem;">
                        @csrf
                        <label for="file" style="font-weight: bold; color: #4A5568;">Cargar archivo Excel:</label>
                        <input type="file" name="file" id="file" accept=".xlsx,.xls" required 
                               style="padding: 0.5rem; border: 1px solid #CBD5E0; border-radius: 5px;">
                        <button type="submit" 
                                style="background-color: #4CAF50; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; font-weight: bold; transition: background-color 0.3s;">
                            Subir
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
