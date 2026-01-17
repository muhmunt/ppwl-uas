<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Cafe Management') }} - Admin</title>

        <!-- Bootstrap 5 CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        
        <!-- Bootstrap Icons -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
        
        <!-- Google Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

        <!-- Custom CSS -->
        <style>
            :root {
                --bs-primary: #dc3545;
                --bs-primary-rgb: 220, 53, 69;
                --primary-gradient: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
                --success-gradient: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
                --danger-gradient: linear-gradient(135deg, #eb3349 0%, #f45c43 100%);
                --warning-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
                --info-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            }
            body {
                font-family: 'Poppins', sans-serif;
                background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
                min-height: 100vh;
            }
            .navbar {
                background: linear-gradient(135deg, #dc3545 0%, #c82333 100%) !important;
                box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            }
            .header-gradient {
                background: linear-gradient(135deg, #dc3545 0%, #c82333 50%, #bd2130 100%);
                box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            }
            .card {
                border: none;
                border-radius: 15px;
                box-shadow: 0 5px 15px rgba(0,0,0,0.08);
                transition: all 0.3s ease;
            }
            .card:hover {
                transform: translateY(-5px);
                box-shadow: 0 10px 25px rgba(0,0,0,0.15);
            }
            .btn {
                border-radius: 10px;
                padding: 10px 20px;
                font-weight: 500;
                transition: all 0.3s ease;
            }
            .btn:hover {
                transform: translateY(-2px);
                box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            }
            .btn-primary {
                background-color: #dc3545;
                border-color: #dc3545;
            }
            .btn-primary:hover {
                background-color: #c82333;
                border-color: #bd2130;
            }
            .bg-primary {
                background-color: #dc3545 !important;
            }
            .text-primary {
                color: #dc3545 !important;
            }
            .border-primary {
                border-color: #dc3545 !important;
            }
        </style>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <div class="min-vh-100">
            @include('layouts.navigation-admin')

            <!-- Page Heading -->
            @if(isset($header))
                <header class="header-gradient text-white py-4 mb-4">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                {{ $header }}
                            </div>
                        </div>
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main class="pb-5">
                <div class="container-fluid px-4">
                    {{ $slot }}
                </div>
            </main>
        </div>

        <!-- Bootstrap 5 JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    </body>
</html>
