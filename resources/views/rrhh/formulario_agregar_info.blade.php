
<x-app-layout>
        @if (session('success') || session('errors'))
        <div class="fixed right-1/4 overflow-auto" style="max-height: 90vh" >
            @if(session('success'))
                <div class="sticky top-4 right-1/2">
                    @foreach(session('success') as $successMessage)
                        <p class="p-2 m-2 rounded uppercase bg-green-400 max-w-screen-sm">{{ $successMessage }}</p>
                    @endforeach
                </div>
            @endif

            @if(session('errors'))
                <div class="sticky top-4 right-1/2">
                    @foreach(session('errors') as $errorMessage)
                        <p class="p-2 m-2 rounded uppercase bg-red-400 max-w-screen-sm">{{ $errorMessage }}</p>
                    @endforeach
                </div>
            @endif
        </div>
    @endif

    @if (isset($errors_template))
        <div class="fixed top-5 right-5 overflow-auto" style="max-height: 90vh" >
            @foreach ($errors_template as $value)
                <p class="p-2 m-2 rounded bg-red-400">{{ $value }}</p>
            @endforeach
        </div>
    @endif
    <div id="upload_file" class=" min-h-h_75 ">
        <h2 class="text-center text-2xl font-bold mt-4">ALIMENTACION DEL SISTEMA</h2>

        {{-- Form to Upload Pos --}}
        <div class="grid place-content-center min-h-h_75 w-5/6 bg-gray-600 mx-auto mt-8 my-auto rounded ">
            <form action="{{ route('cargarEnSistema') }}" name="set_info"  id="set_info" method="post" enctype="multipart/form-data" class="grid grid-cols-1 grid-rows-6 items-center justify-center my-auto gap-8">
                @csrf                                                   
                <div class="row-span-3 text-center flex flex-col items-center">
                    <label for="excel_users" class="mb-2">CARGA EXCEL RRHH CSV ,XLSX:</label>
                    <div class="flex flex-col">
                        <input type="file" name="excel_users" id="excel_users" accept=".csv,.xls,.xlsx" class="cursor-pointer">
                        <label for="excel_users" class="cursor-pointer bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md">Choose File</label>
                    </div>
                </div>

            
                <div id="loading" class="spinner">
                    <div class="rect1"></div>
                    <div class="rect2"></div>
                    <div class="rect3"></div>
                    <div class="rect4"></div>
                    <div class="rect5"></div>
                </div>
                <div class=" row-span-1 text-center">
                    <x-button-submit id="upload_buttom">
                        Upload
                    </x-button-submit>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (document.querySelector("#upload_buttom")) {
                const loading_div = document.querySelector("#loading"); // Div de carga 
                const button_submit = document.querySelector("#upload_buttom"); // Boton de ejecucion

                const set_info = document.querySelector("#set_info");
                set_info.addEventListener('submit', async (element) => {
                    loading_div.style.display = "block";
                    button_submit.disabled = true;
                });
            }
        });
    </script>
</x-app-layout>