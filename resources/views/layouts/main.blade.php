<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SCV-TMNAV') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="{{asset('css/fontgoogle.css')}}">
    <link rel="stylesheet" href="{{asset('css/dropzone.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('css/loading.css')}}">
    <link rel="stylesheet" href="{{asset('css/modals.css')}}">
    <!-- Scripts -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet" />
    <script src="{{ asset('js/jquery-3.6.4.min.js') }}"></script>
    <script src="{{asset('js/select2.min.js')}}"></script>
    <script src="{{asset('js/dropzone.js')}}"></script>
    <script src="{{ asset('js/modals.js') }}"></script>

    
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
</head>

<body>
    <div class="font-sans text-gray-900 antialiased">
        <div class=" bg-gray-800 flex flex-row   text-white">
            {{-- Menu --}}
            <div id="search_menu"
                class="
                fixed top-10 -left-52 h-h_90 w-52 p-2 z-50
                flex flex-col justify-center items-center
                rounded-b bg-gray-700 
                md:relative md:h-screen md:w-56 md:top-0 md:left-0  
                transition-all duration-1000 ease-in-out
            ">
                <div class="w-full mt-4 my-10 grid justify-center items-center">
                    <p class="mb-4 block text-center">Hola, {{ Auth::user()->name }} !</p>
                
                    {{-- Cambio de grupos --}}                    
                   
                        {{-- <p 
                            @can ('MENU.HOME.GROUPS') id="menu_list" @endcan
                            class="flex flex-row justify-start items-center gap-2 text-center p-2 mb-2 bg-gray-500 rounded"
                        >
                            Auth::user()->currentGroup->name
                            @can ('MENU.HOME.GROUPS')
                                <img 
                                    id="arrow_img" class=" w-4 ml-auto transition-all" 
                                    src="{{ asset('/img/svg/expand.svg') }}"
                                >
                            @endcan
                        </p> --}}
                        {{-- <ul class="hidden flex-col relative  bg-gray-600 p-2 rounded mb-2 " aria-expanded="false">   
                            @can ('MENU.HOME.GROUPS')                             
                                @foreach (Auth::user()->allUserGroups as $groups)
                                    <a 
                                    title="{{$groups->group->name}}" 
                                    class="hover:bg-gray-400 p-1 m-1 rounded w-full"
                                    href="route('switch.group',$groups->group->id)"
                                    >
                                        $groups->group->name
                                    </a>
                                @endforeach
                            @endcan
                        </ul> --}}
                        
                    {{-- <a class="grid justify-center my-2" href="{{route('home')}}">
                        <img 
                            class="block {{Auth::user()->currentGroup->name == 'SYSTEMS'? 'h-20' : ''}}" 
                            src="{{asset('/img/'.Auth::user()->currentGroup->name.(Auth::user()->currentGroup->name == 'SYSTEMS' ? '.gif' : '.webp' )) }}">
                    </a> --}}

                    <p class="text-center" id="local-time"></p>
                </div>
                <nav class="overflow-auto overflow-x-hidden"> 
                    
                    <ul class="grid grid-cols-1 gap-2 relative"> {{-- Ul Principal --}}

                        {{-- Home --}}
                        <li>
                            <a class="flex flex-row justify-start items-center gap-2 m-2" href="{{route('home')}}">
                                <img src="{{ asset('/img/icons/home.webp') }}">
                                <p>Home</p>
                            </a>
                        </li>
                        {{-- End Home --}}

                        {{-- Sea & Sea Departures Tracker --}}
                        @can('MENU.HOME.SEA')
                        <li class="relative">
                            <a
                                id="menu_list"
                                class=
                                    "flex flex-row justify-start items-center 
                                    gap-2 m-2" 
                                href="#"
                            >
                                <img src="{{ asset('/img/icons/sea.webp') }}">
                                <p>Sea</p>
                                <img 
                                    id="arrow_img"
                                    class=" w-4 ml-auto transition-all" 
                                    src="{{ asset('/img/svg/expand.svg') }}" 
                                    alt=""
                                >
                            </a>
                            <ul class="hidden flex-col relative  bg-gray-600 p-2 rounded" aria-expanded="false">
                                @can('MENU.HOME.SEA.SEARCH PO')
                                <a title="SPO" 
                                    href="{{ route('pos.list', 'sea') }}" class="hover:bg-gray-400 p-1 m-1 rounded w-full">
                                    <p>Search PO</p>
                                </a>
                                @endcan
                                @can('MENU.HOME.SEA.CTRL CARGO OP')
                                <a title="CCOT" 
                                    href="{{route('control-operations')}}" class="hover:bg-gray-400 p-1 m-1 rounded w-full">
                                    <p>Control of Cargo Operations</p>
                                </a>
                                @endcan
                                @can('MENU.HOME.SEA.PO ADMIN')
                                <a title="POAT" 
                                    href="{{route('adminseatracking.pos')}}" class="hover:bg-gray-400 p-1 m-1 rounded w-full">
                                    <p>PO´s Administration</p>
                                </a>
                                @endcan
                                {{-- <a title="POAT" 
                                href="{{route('dateupdateposub.pos')}}" class="hover:bg-gray-400 p-1 m-1 rounded w-full">
                                <p>Update Dates</p>
                                </a> --}}
                                {{-- solo suburbia id grupo2 old id37   todos los grupos--}}
                                {{-- @if ( Auth::user()->currentGroup->name == "SUBURBIA" && Auth::user()->can('MENU.HOME.SEA.UPDATE DATES') )
                                    <a title="POAT" 
                                        href="{{route('dateupdateposub.pos')}}" class="hover:bg-gray-400 p-1 m-1 rounded w-full">
                                        <p>Update Dates</p>
                                    </a>
                                @endif --}}
                                {{-- solo Liverpool id grupo1 old id  --}}
                                @if ( Auth::user()->currentGroup->name == "LIVERPOOL GROUP" && Auth::user()->can('MENU.HOME.SEA.DEPARTURE CARGO'))
                                    <a title="DepartureCargo" 
                                        href="{{route('departurecargo.pos')}}" class="hover:bg-gray-400 p-1 m-1 rounded w-full">
                                        <p>Departure Cargo</p>
                                    </a>
                                @endif
                                @can('MENU.HOME.SEA.VESSEL CAT')
                                <a title="VSCT" 
                                    href="{{route('vessel_catalog')}}" class="hover:bg-gray-400 p-1 m-1 rounded w-full">
                                    <p>Vessel´s Catalog</p>
                                </a>
                                @endcan
                                @can('MENU.HOME.SEA.CONSOLIDATE PO')
                                <a title="CONPO" 
                                    href="{{route('vessel.consolidate.pos')}}" class="hover:bg-gray-400 p-1 m-1 rounded w-full">
                                    <p>Consolidate PO</p>
                                </a>
                                @endcan
                                @can('MENU.HOME.SEA.APROVE BL IM')
                                <a title="CONPO" 
                                    href="{{route('view.masters','sea')}}" class="hover:bg-gray-400 p-1 m-1 rounded w-full">
                                    <p>Aprove BL's IM</p>
                                </a>
                                @endcan
                            </ul>
                        </li>
                        @endcan
                        {{-- End Sea & Sea Departures Tracker --}}

                        {{-- Air y Air Departures Tracker --}}
                        @can('MENU.HOME.AIR')
                        <li class=" relative">
                            <a 
                                id="menu_list"
                                class=
                                    "flex flex-row justify-start items-center 
                                    gap-2 m-2" 
                                href="#"
                            >
                                <img src="{{ asset('/img/icons/air.webp') }}">
                                <span class="mini-click-non">Air</span>
                                <img 
                                    id="arrow_img"
                                    class=" w-4 ml-auto transition-all" 
                                    src="{{ asset('/img/svg/expand.svg') }}" 
                                    alt=""
                                >
                            </a>
                            <ul class="hidden flex-col relative  bg-gray-600 p-2 rounded" aria-expanded="false">
                                @can('MENU.HOME.AIR.SEARCH PO')
                                <a 
                                    title="search po air" 
                                    class="hover:bg-gray-400 p-1 m-1 rounded w-full"
                                    href="{{route('pos.list', 'air')}}"
                                >
                                    Search PO
                                </a>
                                @endcan
                                @can('MENU.HOME.AIR.FLIGHT')
                                <a 
                                    title="FLIGHT & NEW FLIGHT" 
                                    class="hover:bg-gray-400 p-1 m-1 rounded w-full"
                                    href="{{ route('flight_catalog') }}"
                                >
                                    Flight
                                </a>
                                @endcan
                                @can('MENU.HOME.AIR.CONSOLIDATE PO')
                                <a 
                                    title="Consolidate Po" 
                                    class="hover:bg-gray-400 p-1 m-1 rounded w-full"
                                    href="{{ route('consolidate_poair') }}" 
                                >
                                    Consolidate PO
                                </a>
                                @endcan
                                @can('MENU.HOME.AIR.APROVE BL IA')
                                <a 
                                    title="Aprove BL" 
                                    class="hover:bg-gray-400 p-1 m-1 rounded w-full"
                                    href="{{ route('view.masters', 'air') }}" 
                                >
                                    Aprove BL's IA 
                                </a>
                                @endcan
                            </ul>
                        </li>
                        @endcan
                        {{-- End Air y Air Departures Tracker --}}

                        {{-- Upload Files Tracker --}}
                        @can('MENU.HOME.UPLOAD FILES')
                        <li class=" relative transition-all duration-1000">
                            <a id="menu_list"
                            class=
                                "flex flex-row justify-start items-center 
                                gap-2 m-2" 
                            href="#">
                                <img src="{{ asset('/img/icons/uploadfile.webp') }}">
                                <span class="mini-click-non">Upload Files</span>
                                <img 
                                    id="arrow_img"
                                    class=" w-4 ml-auto transition-all" 
                                    src="{{ asset('/img/svg/expand.svg') }}" 
                                    alt=""
                                >
                            </a>
                            <ul class="hidden flex-col relative  bg-gray-600 p-2 rounded" aria-expanded="true">
                                @can('MENU.HOME.UPLOAD FILES.UPLOAD PO')
                                <a 
                                    title="upload_pre_pos" 
                                    class="hover:bg-gray-400 p-1 m-1 rounded w-full"
                                    href="{{route('pre.upload.pos.show')}}"
                                > 
                                    Upload POs
                                </a>
                                @endcan
                                @can('MENU.HOME.UPLOAD FILES.VALIDATE DATA')
                                <a 
                                    title=""
                                    class="hover:bg-gray-400 p-1 m-1 rounded w-full"
                                    href="{{route('validate.data.pos.show')}}"
                                >
                                    Validate Data
                                </a>
                                @endcan
                
                                @if(
                                    (Auth::user()->currentGroup->name == 'LIVERPOOL GROUP' && Auth::user()->can('MENU.HOME.UPLOAD FILES.PRE REG PO')) || 
                                    Auth::user()->role('SUPER ADMIN')
                                )
                                <a 
                                    title=""
                                    class="hover:bg-gray-400 p-1 m-1 rounded w-full"
                                    href="{{route('pre-registration')}}"
                                >
                                    Pre Register PO
                                </a>
                                @endif

                                <a 
                                    title=""
                                    class="hover:bg-gray-400 p-1 m-1 rounded w-full"
                                    href="{{route('pre-registration-weigh')}}"
                                >
                                    Pre Register PO Weigh Ins
                                </a>

                                <a 
                                    title=""
                                    class="hover:bg-gray-400 p-1 m-1 rounded w-full"
                                    href="{{ route("upload.style.po.show") }}"
                                >
                                    Style-Po File Upload
                                </a>
                                <a title="POAT" 
                                href="{{route('dateupdateposub.pos')}}" class="hover:bg-gray-400 p-1 m-1 rounded w-full">
                                <p>Update Dates</p>
                                </a>
                            </ul>
                        </li>
                        @endcan
                        {{-- end Upload Files Tracker --}}
                        {{-- Capture PO Tracker --}}
                        @can('MENU.HOME.UPLOAD FILES')
                        <li class=" relative">
                            <a 
                                class="flex flex-row justify-start items-center 
                                gap-2 m-2" 
                                title="CAPTURE PO"
                                href="{{ route('manual.upload.pos.show') }}"
                            >
                                <img src="{{asset('/img/icons/capturepo.webp')}}">
                                <span class="mini-click-non">Capture PO</span>
                            </a>
                        </li> 
                        @endcan
                        {{-- End Capture PO Tracker --}}
                        {{-- Catalogues Tracker --}}
                        @can('MENU.HOME.CATALOGUES')
                        <li class=" relative">
                            <a id="menu_list"
                            class=
                                "flex flex-row justify-start items-center 
                                gap-2 m-2" 
                            href="#">
                                <img src="{{ asset('/img/icons/catalogues.webp') }}">
                                <span class="mini-click-non">Catalogues</span>
                                <img 
                                    id="arrow_img"
                                    class=" w-4 ml-auto transition-all" 
                                    src="{{ asset('/img/svg/expand.svg') }}" 
                                    alt=""
                                >
                            </a>
                            <ul class="flex-col hidden relative bg-gray-600 p-2 rounded" aria-expanded="false">    
                                @can('MENU.HOME.CATALOGUES.PORT CAT')
                                <a title="PCATT" 
                                    href="{{ route('port_catalog') }}" class="hover:bg-gray-400 p-1 m-1 rounded w-full"
                                >
                                    <p>Port Catalog</p>
                                </a>
                                @endcan
                                @can('MENU.HOME.CATALOGUES.ADD NEW PORT')
                                <a title="ANPT" 
                                    href="{{ route('port_new') }}" class="hover:bg-gray-400 p-1 m-1 rounded w-full"
                                >
                                    <p>Add New Port</p>
                                </a>
                                @endcan
                                @can('MENU.HOME.CATALOGUES.EXECUTIVE CAT')
                                <a title="ECT" 
                                    href="{{ route('executive_catalog') }}"  class="hover:bg-gray-400 p-1 m-1 rounded w-full"
                                >
                                    <p>Executive Catalog</p>
                                </a>
                                @endcan
                                @can('MENU.HOME.CATALOGUES.SHIPPER CAT')
                                <a title="SCT" 
                                    href="{{ route('shippers_catalog') }}"  class="hover:bg-gray-400 p-1 m-1 rounded w-full"
                                >
                                    <p>Shippers Catalog</p>
                                </a>
                                @endcan
                                @can('MENU.HOME.CATALOGUES.SUPPLIER CAT')
                                <a title="SUPCT" 
                                    href="{{ route('suppliers_catalog')}}" class="hover:bg-gray-400 p-1 m-1 rounded w-full"
                                >
                                    <p>Suppliers Catalog</p>
                                </a>
                                @endcan
                                @can('MENU.HOME.CATALOGUES.AGENTS CAT')
                                <a title="ACT" 
                                    href="{{ route('agents_catalog') }}" class="hover:bg-gray-400 p-1 m-1 rounded w-full"
                                >
                                    <p>Agents Catalog</p>
                                </a>
                                @endcan
                            </ul>
                        </li>
                        @endcan
                        {{-- End Catalogues Tracker --}}
                        {{-- Statistics Tracker --}}
                        @can('MENU.HOME.STATISTICS')
                        <li class=" relative">
                            <a id="menu_list"
                            class=
                                "flex flex-row justify-start items-center 
                                gap-2 m-2" 
                            href="#">
                                <img src="{{asset('/img/icons/statistics.webp')}}">
                                <span class="mini-click-non">Statistics</span>
                                <img 
                                    id="arrow_img"
                                    class=" w-4 ml-auto transition-all" 
                                    src="{{ asset('/img/svg/expand.svg') }}" 
                                    alt=""
                                >
                            </a>
                            <ul class="flex-col hidden relative bg-gray-600 p-2 rounded transition" aria-expanded="false">
                                @can('MENU.HOME.STATISTICS.CNTR RPT')
                                <a title="Containers Report" 
                                    href="{{ route('reportContainers')}}" class="hover:bg-gray-400 p-1 m-1 rounded w-full">
                                    <p>Containers Report</p>
                                </a>
                                @endcan
                                @can('MENU.HOME.STATISTICS.WILLIAM RPT')
                                <a title="Williams Report" 
                                    href="{{route( 'williamsReport-export' )}}"class="hover:bg-gray-400 p-1 m-1 rounded w-full">
                                    <p>Williams Report</p>
                                </a>
                                @endcan
                                @can('MENU.HOME.STATISTICS.CNTR RPT CAP')
                                
                                <a title="CRTR" 
                                    {{-- href="{{route('williamsReport-export')}}" class="hover:bg-gray-400 p-1 m-1 rounded w-full"> --}}
                                    href="{{route('containercapacity')}}" class="hover:bg-gray-400 p-1 m-1 rounded w-full">
                                    <p>Containers Report - Capacity</p>
                                </a>
                               @endcan
                                {{-- @can('MENU.HOME.STATISTICS.REF RPT')
                                <a title="RERETR" 
                                    href="#" class="hover:bg-gray-400 p-1 m-1 rounded w-full">
                                    <p>References Report</p>
                                </a>
                                @endcan --}}
                                @can('MENU.HOME.STATISTICS.TRACKER RPT')
                                <a title="TRARTRA" 
                                    href="{{ route('tracking-report-index') }}" class="hover:bg-gray-400 p-1 m-1 rounded w-full">
                                    <p>Tracker Report</p>
                                </a>
                                @endcan
                                @can('MENU.HOME.STATISTICS.SEA TRACKER RPT')
                                <a title="SEATRARTRA" 
                                    href="{{route('reportAirView')}}" class="hover:bg-gray-400 p-1 m-1 rounded w-full">
                                    <p>Air Tracker Report</p>
                                </a>
                                @endcan
                                {{-- @if(Auth::user()->currentGroup->name == 'LIVERPOOL GROUP' && Auth::user()->can('MENU.HOME.STATISTICS.LIV RPT'))
                                <a title="LIVREPT" 
                                    href="#" class="hover:bg-gray-400 p-1 m-1 rounded w-full">
                                    <p>Liverpool Report</p>
                                </a>
                                @endif --}}
                                {{-- @can('MENU.HOME.STATISTICS.FREIGHT RPT')
                                <a title="FREREPT" 
                                    href="#" class="hover:bg-gray-400 p-1 m-1 rounded w-full">
                                    <p>Freight Report</p>
                                </a>
                                @endcan --}}
                                {{-- @can('MENU.HOME.STATISTICS.ELC RPT')
                                <a title="ELCREPT" 
                                    href="#" class="hover:bg-gray-400 p-1 m-1 rounded w-full">
                                    <p>ELC Report</p>
                                </a>
                                @endcan --}}
                                @can('MENU.HOME.STATISTICS.TRACE MJSFERA')
                                <a title="TMJST" 
                                    href="{{route('reportSferaShow')}}" class="hover:bg-gray-400 p-1 m-1 rounded w-full">
                                    <p>Traceability Moda Joven Sfera</p>
                                </a>
                                @endcan
                                @can('MENU.HOME.STATISTICS.DEP CARGO RPT')
                                <a title="DECAREPT" 
                                    href="{{route('departure-cargo-report')}}" class="hover:bg-gray-400 p-1 m-1 rounded w-full">
                                    <p>Departure Cargo Report</p>
                                </a>
                                @endcan
                                {{-- @can('MENU.HOME.STATISTICS.TRACE AIR RPT')
                                <a title="TRAAIREPT" 
                                    href="#" class="hover:bg-gray-400 p-1 m-1 rounded w-full">
                                    <p>Traceability Air Report</p>
                                </a>
                                @endcan --}}
                                {{-- @can('MENU.HOME.STATISTICS.AIR OP RPT')
                                <a title="AOPREPT" 
                                    href="#" class="hover:bg-gray-400 p-1 m-1 rounded w-full">
                                    <p>Air Operation Report</p>
                                </a>
                                @endcan --}}
                                {{-- @can('MENU.HOME.STATISTICS.SEA OP RPT')
                                <a title="SOPREPT" 
                                    href="#" class="hover:bg-gray-400 p-1 m-1 rounded w-full">
                                    <p>Sea Operation Report</p>
                                </a>
                                @endcan --}}
                                @can('MENU.HOME.STATISTICS.MARC PROP RPT')
                                <a title="MAPREPT" 
                                    href="{{route('reportMarcasShow')}}" class="hover:bg-gray-400 p-1 m-1 rounded w-full">
                                    <p>Marcas Propias Report</p>
                                </a>
                                @endcan
                                @can('MENU.HOME.STATISTICS.AEROPOS REPOR')
                                <a title="" 
                                    href="{{ route('aeropostale-report')}}" class="hover:bg-gray-400 p-1 m-1 rounded w-full">
                                    <p>Aeropostale Report</p>
                                </a>
                                @endcan    
                                @can('MENU.HOME.STATISTICS.EXEC REPOR')
                                <a title="" 
                                    href="{{ route('executive-report')}}" class="hover:bg-gray-400 p-1 m-1 rounded w-full">
                                    <p>Executive Report</p>
                                </a>
                                @endcan
                                @can('MENU.HOME.STATISTICS.POCONT REPOR')
                                <a title="" 
                                    href="{{ route('po-container-report')}}" class="hover:bg-gray-400 p-1 m-1 rounded w-full">
                                    <p>Po by Container Report</p>
                                </a>
                                @endcan  
                                @can('MENU.HOME.STATISTICS.LCLCARG REPOR')
                                <a title="" 
                                    href="{{ route('lcl-cargo-report')}}" class="hover:bg-gray-400 p-1 m-1 rounded w-full">
                                    <p>Report LCL cargo</p>
                                </a>
                                @endcan           
                                {{-- @can('MENU.HOME.STATISTICS.STOCK BOARDING')
                                <a title="ISWOB" 
                                    href="#" class="hover:bg-gray-400 p-1 m-1 rounded w-full">
                                    <p>In Stock/Window of Boarding</p>
                                </a>
                                @endcan --}}

                                {{-- Reporte de pos con master bl que no tiene factura --}}
                                {{-- @include("modal.master-bl.download-master-with-out-invoice")
                                
                                @include("modal.master-bl.download-master-with-out-aprovation") --}}
                            </ul>
                        </li>
                        @endcan
                        {{-- End Statistics Tracker --}}

                        <!--Tracking-->
                    {{--    @can("MENU.HOME.TM")
                            <li class=" relative">
                                <a 
                                    class=
                                        "flex flex-row justify-start items-center 
                                        gap-2 m-2" 
                                    href="#"
                                     href="{{route('hom')}}" 
                                >
                                    <img src="{{asset('/img/icons/tracking.webp')}}">
                                    <span class="mini-click-non">TM</span>
                                </a>
                            </li>
                        @endcan--}}
                        <!--end Tracking-->
                       
                        @can('MENU.HOME.DASHBOARD.NOTIFICATION')
                        <li>
                            <a class="flex flex-row justify-start items-center gap-2 m-2"
                                href="{{ route('settings.notification') }}">
                                <img class=" w-8 h-8" src="{{ asset('/img/svg/address_book.svg') }}">
                                <p>Notifications</p>
                            </a>
                        </li>
                        @endcan

                        @role('SUPER ADMIN')
                        
                            <!--admin-->
                           
                            <li class=" relative">
                                <a 
                                    class=
                                        "flex flex-row justify-start items-center 
                                        gap-2 m-2" 
                                    href="{{ route('dashboard') }}"
                                >
                                    <img 
                                        id="arrow_img"
                                        class=" w-8 h-8" 
                                        src="{{asset('/img/svg/flow_chart.svg')}}"
                                    >
                                    <span class="mini-click-non">Dashboard</span>
                                </a>
                            </li>
                            <!--end admin-->
                        @endrole
                    </ul> {{-- End Ul Principal --}}
                </nav>
            </div>
            <div class="hamburger-menu">
                <span></span>
                <span></span>
                <span></span>
            </div>

            <div class="min-h-h_90 w-screen ">
                <div class="flex justify-end items-center h-10 bg-gray-700">
                    {{-- LogOut --}}
                    <form method="POST" action="{{ route('logout') }}" x-data>
                        @csrf
                        <x-responsive-nav-link  title="Log Out" href="{{ route('logout') }}" @click.prevent="$root.submit();">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-box-arrow-right" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0v2z"/>
                                <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"/>
                            </svg>
                        </x-responsive-nav-link>
                    </form>
                    {{-- End LogOut --}}
                </div>

                <div>
                    {{-- Contenido --}}
                    {{ $slot }}
                </div>
            </div>
            

        </div>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/horaMain.js') }}"></script>
    

</body>
</html>