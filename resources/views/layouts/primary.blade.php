<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Purple Dashboard')</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome pour les icônes -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f2f2f2;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        /* Style de la Sidebar */
        .sidebar {
            width: 260px;
            background: #ffffff;
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 100;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
            overflow-y: auto;
        }
        .sidebar-brand {
            padding: 20px;
            font-size: 1.5rem;
            font-weight: bold;
            color: #b66dff;
            display: flex;
            align-items: center;
        }
        .user-profile {
            padding: 15px 20px;
            display: flex;
            align-items: center;
            border-bottom: 1px solid #f2f2f2;
        }
        .user-profile img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 10px;
        }
        .nav-sidebar .nav-link {
            color: #333;
            padding: 12px 20px;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .nav-sidebar .nav-link:hover, .nav-sidebar .nav-link.active {
            color: #b66dff;
            background-color: #f8f9fa;
        }
        /* Top Navbar */
        .top-navbar {
            margin-left: 260px;
            height: 70px;
            background: #ffffff;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 30px;
            position: fixed;
            top: 0;
            right: 0;
            left: 260px;
            z-index: 99;
        }
        /* Contenu Principal */
        .main-content {
            margin-left: 260px;
            margin-top: 70px;
            padding: 30px;
        }
        .card-custom {
            background: #ffffff;
            border: none;
            border-radius: 4px;
            box-shadow: 0 0 15px rgba(0,0,0,0.05);
            padding: 30px;
        }
        /* Bouton violet (Purple) */
        .btn-purple {
            background: linear-gradient(to right, #da8cff, #9a55ff);
            border: none;
            color: white;
        }
        .btn-purple:hover {
            background: linear-gradient(to right, #c77aee, #8742e8);
            color: white;
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-brand">
            <i class="fa-solid fa-layer-group me-2"></i> Purple
        </div>
        <div class="user-profile">
            <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=100" alt="User">
            <div>
                <h6 class="mb-0 fw-bold" style="font-size: 0.9rem;">David Grey. H</h6>
                <small class="text-muted" style="font-size: 0.75rem;">Project Manager</small>
            </div>
        </div>
        <ul class="nav flex-column nav-sidebar mt-2">
            <li class="nav-item"><a href="#" class="nav-link"><span class="text-secondary"><i class="fa-solid fa-house me-3"></i> Dashboard</span></a></li>
            <li class="nav-item"><a href="#" class="nav-link"><span class="text-secondary"><i class="fa-solid fa-circle-dot me-3"></i> Basic UI Elements</span> <i class="fa-solid fa-chevron-right small"></i></a></li>
            <li class="nav-item"><a href="#" class="nav-link"><span class="text-secondary"><i class="fa-solid fa-table-cells-large me-3"></i> Forms</span> <i class="fa-solid fa-chevron-right small"></i></a></li>
            <li class="nav-item"><a href="#" class="nav-link"><span class="text-secondary"><i class="fa-solid fa-chart-pie me-3"></i> Charts</span> <i class="fa-solid fa-chevron-right small"></i></a></li>
            <li class="nav-item"><a href="#" class="nav-link"><span class="text-secondary"><i class="fa-solid fa-table me-3"></i> Tables</span> <i class="fa-solid fa-chevron-right small"></i></a></li>
            <li class="nav-item"><a href="#" class="nav-link"><span class="text-secondary"><i class="fa-solid fa-box me-3"></i> Products</span></a></li>
            <li class="nav-item"><a href="#" class="nav-link"><span class="text-secondary"><i class="fa-solid fa-lock me-3"></i> User Pages</span> <i class="fa-solid fa-chevron-right small"></i></a></li>
            <li class="nav-item"><a href="#" class="nav-link"><span class="text-secondary"><i class="fa-solid fa-file-lines me-3"></i> Documentation</span></a></li>
        </ul>
    </div>

    <!-- Top Navbar -->
    <div class="top-navbar">
        <div class="d-flex align-items-center">
            <div class="input-group" style="width: 250px;">
                <span class="input-group-text bg-transparent border-end-0"><i class="fa-solid fa-magnifying-glass text-muted"></i></span>
                <input type="text" class="form-control border-start-0 bg-transparent shadow-none" placeholder="Search projects">
            </div>
        </div>
        <div class="d-flex align-items-center">
            <span class="fw-bold me-2" style="font-size: 0.9rem;">David Greymaax</span>
            <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=100" class="rounded-circle" width="35" height="35" alt="Profile">
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        @yield('content')
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>