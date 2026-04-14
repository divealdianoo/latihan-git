<?php
/**
 * Header Layout
 * Template header untuk semua halaman
 */
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? APP_NAME ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #6366f1;
            --primary-dark: #4f46e5;
            --primary-light: #818cf8;
            --secondary: #0ea5e9;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --info: #06b6d4;
            --dark: #0f172a;
            --dark-card: #1e293b;
            --dark-border: #334155;
            --text-primary: #f1f5f9;
            --text-secondary: #94a3b8;
            --text-muted: #64748b;
            --gradient-1: linear-gradient(135deg, #6366f1, #8b5cf6, #a78bfa);
            --gradient-2: linear-gradient(135deg, #0ea5e9, #06b6d4);
            --gradient-3: linear-gradient(135deg, #10b981, #34d399);
            --shadow-sm: 0 1px 3px rgba(0,0,0,0.3);
            --shadow-md: 0 4px 6px rgba(0,0,0,0.3);
            --shadow-lg: 0 10px 25px rgba(0,0,0,0.4);
            --shadow-glow: 0 0 20px rgba(99,102,241,0.3);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--dark);
            color: var(--text-primary);
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 260px;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            background: var(--dark-card);
            border-right: 1px solid var(--dark-border);
            z-index: 1000;
            transition: transform 0.3s ease;
            display: flex;
            flex-direction: column;
        }

        .sidebar-brand {
            padding: 24px 20px;
            border-bottom: 1px solid var(--dark-border);
            text-align: center;
        }

        .sidebar-brand h4 {
            background: var(--gradient-1);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 800;
            font-size: 1.1rem;
            letter-spacing: -0.5px;
        }

        .sidebar-brand small {
            color: var(--text-muted);
            font-size: 0.75rem;
        }

        .sidebar-nav {
            padding: 16px 12px;
            flex: 1;
            overflow-y: auto;
        }

        .sidebar-nav .nav-label {
            color: var(--text-muted);
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 12px 12px 6px;
        }

        .sidebar-nav .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 14px;
            color: var(--text-secondary);
            border-radius: 10px;
            text-decoration: none;
            font-size: 0.88rem;
            font-weight: 500;
            transition: all 0.2s ease;
            margin-bottom: 2px;
        }

        .sidebar-nav .nav-link:hover {
            background: rgba(99,102,241,0.1);
            color: var(--primary-light);
        }

        .sidebar-nav .nav-link.active {
            background: var(--gradient-1);
            color: #fff;
            box-shadow: 0 4px 12px rgba(99,102,241,0.4);
        }

        .sidebar-nav .nav-link i {
            width: 20px;
            text-align: center;
            font-size: 1rem;
        }

        .sidebar-footer {
            padding: 16px;
            border-top: 1px solid var(--dark-border);
        }

        .sidebar-footer .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 10px;
        }

        .sidebar-footer .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: var(--gradient-1);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.85rem;
            color: #fff;
        }

        .sidebar-footer .user-name {
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--text-primary);
        }

        .sidebar-footer .user-role {
            font-size: 0.7rem;
            color: var(--text-muted);
        }

        .btn-logout {
            width: 100%;
            padding: 8px;
            border: 1px solid var(--dark-border);
            background: transparent;
            color: var(--text-secondary);
            border-radius: 8px;
            font-size: 0.8rem;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-logout:hover {
            background: rgba(239,68,68,0.1);
            border-color: var(--danger);
            color: var(--danger);
        }

        /* Main Content */
        .main-content {
            margin-left: 260px;
            min-height: 100vh;
            padding: 30px;
        }

        .page-header {
            margin-bottom: 28px;
        }

        .page-header h2 {
            font-size: 1.6rem;
            font-weight: 700;
            letter-spacing: -0.5px;
        }

        .page-header p {
            color: var(--text-muted);
            font-size: 0.9rem;
            margin-top: 4px;
        }

        /* Cards */
        .card-glass {
            background: var(--dark-card);
            border: 1px solid var(--dark-border);
            border-radius: 14px;
            padding: 20px;
            transition: all 0.3s ease;
        }

        .card-glass:hover {
            border-color: var(--primary);
            box-shadow: var(--shadow-glow);
        }

        /* Stat Cards */
        .stat-card {
            background: var(--dark-card);
            border: 1px solid var(--dark-border);
            border-radius: 14px;
            padding: 22px;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
        }

        .stat-card.primary::before { background: var(--gradient-1); }
        .stat-card.success::before { background: var(--gradient-3); }
        .stat-card.warning::before { background: linear-gradient(135deg, #f59e0b, #fbbf24); }
        .stat-card.info::before { background: var(--gradient-2); }
        .stat-card.danger::before { background: linear-gradient(135deg, #ef4444, #f87171); }

        .stat-card .stat-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            margin-bottom: 14px;
        }

        .stat-card.primary .stat-icon { background: rgba(99,102,241,0.15); color: var(--primary-light); }
        .stat-card.success .stat-icon { background: rgba(16,185,129,0.15); color: var(--success); }
        .stat-card.warning .stat-icon { background: rgba(245,158,11,0.15); color: var(--warning); }
        .stat-card.info .stat-icon { background: rgba(6,182,212,0.15); color: var(--info); }
        .stat-card.danger .stat-icon { background: rgba(239,68,68,0.15); color: var(--danger); }

        .stat-card .stat-value {
            font-size: 1.8rem;
            font-weight: 800;
            letter-spacing: -1px;
        }

        .stat-card .stat-label {
            font-size: 0.78rem;
            color: var(--text-muted);
            margin-top: 2px;
        }

        /* Tables */
        .table-container {
            background: var(--dark-card);
            border: 1px solid var(--dark-border);
            border-radius: 14px;
            overflow: hidden;
        }

        .table-container .table {
            margin: 0;
            color: var(--text-primary);
        }

        .table-container .table thead th {
            background: rgba(99,102,241,0.08);
            border-bottom: 1px solid var(--dark-border);
            color: var(--text-secondary);
            font-size: 0.78rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 14px 16px;
        }

        .table-container .table tbody td {
            padding: 14px 16px;
            border-bottom: 1px solid rgba(51,65,85,0.5);
            vertical-align: middle;
            font-size: 0.88rem;
        }

        .table-container .table tbody tr:hover {
            background: rgba(99,102,241,0.04);
        }

        .table-container .table tbody tr:last-child td {
            border-bottom: none;
        }

        /* Badges */
        .badge-status {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.72rem;
            font-weight: 600;
            letter-spacing: 0.3px;
        }

        .badge-menunggu {
            background: rgba(245,158,11,0.15);
            color: #fbbf24;
        }

        .badge-diproses {
            background: rgba(6,182,212,0.15);
            color: #22d3ee;
        }

        .badge-selesai {
            background: rgba(16,185,129,0.15);
            color: #34d399;
        }

        .badge-ditolak {
            background: rgba(239,68,68,0.15);
            color: #f87171;
        }

        .badge-rendah {
            background: rgba(16,185,129,0.15);
            color: #34d399;
        }

        .badge-sedang {
            background: rgba(245,158,11,0.15);
            color: #fbbf24;
        }

        .badge-tinggi {
            background: rgba(239,68,68,0.15);
            color: #f87171;
        }

        /* Buttons */
        .btn-primary-custom {
            background: var(--gradient-1);
            border: none;
            color: #fff;
            padding: 8px 18px;
            border-radius: 10px;
            font-size: 0.85rem;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-primary-custom:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(99,102,241,0.4);
            color: #fff;
        }

        .btn-outline-custom {
            background: transparent;
            border: 1px solid var(--dark-border);
            color: var(--text-secondary);
            padding: 8px 18px;
            border-radius: 10px;
            font-size: 0.85rem;
            font-weight: 500;
            transition: all 0.3s;
        }

        .btn-outline-custom:hover {
            border-color: var(--primary);
            color: var(--primary-light);
            background: rgba(99,102,241,0.05);
        }

        .btn-sm-custom {
            padding: 5px 12px;
            font-size: 0.78rem;
            border-radius: 8px;
        }

        /* Forms */
        .form-control-dark {
            background: var(--dark);
            border: 1px solid var(--dark-border);
            color: var(--text-primary);
            border-radius: 10px;
            padding: 10px 14px;
            font-size: 0.88rem;
            transition: all 0.2s;
        }

        .form-control-dark:focus {
            background: var(--dark);
            border-color: var(--primary);
            color: var(--text-primary);
            box-shadow: 0 0 0 3px rgba(99,102,241,0.15);
        }

        .form-control-dark::placeholder {
            color: var(--text-muted);
        }

        .form-select-dark {
            background: var(--dark);
            border: 1px solid var(--dark-border);
            color: var(--text-primary);
            border-radius: 10px;
            padding: 10px 14px;
            font-size: 0.88rem;
        }

        .form-select-dark:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(99,102,241,0.15);
        }

        .form-label-custom {
            font-size: 0.82rem;
            font-weight: 600;
            color: var(--text-secondary);
            margin-bottom: 6px;
        }

        /* Progress Bar */
        .progress-custom {
            height: 8px;
            background: var(--dark);
            border-radius: 10px;
            overflow: hidden;
        }

        .progress-custom .progress-bar {
            background: var(--gradient-1);
            border-radius: 10px;
            transition: width 0.5s ease;
        }

        /* Alert */
        .alert-custom {
            border: none;
            border-radius: 12px;
            padding: 14px 18px;
            font-size: 0.88rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-success-custom {
            background: rgba(16,185,129,0.12);
            color: #34d399;
            border-left: 4px solid var(--success);
        }

        .alert-error-custom {
            background: rgba(239,68,68,0.12);
            color: #f87171;
            border-left: 4px solid var(--danger);
        }

        .alert-warning-custom {
            background: rgba(245,158,11,0.12);
            color: #fbbf24;
            border-left: 4px solid var(--warning);
        }

        /* Timeline / Feedback */
        .feedback-timeline {
            position: relative;
            padding-left: 28px;
        }

        .feedback-timeline::before {
            content: '';
            position: absolute;
            left: 10px;
            top: 0;
            bottom: 0;
            width: 2px;
            background: var(--dark-border);
        }

        .feedback-item {
            position: relative;
            margin-bottom: 20px;
            padding: 14px 18px;
            background: var(--dark);
            border: 1px solid var(--dark-border);
            border-radius: 12px;
        }

        .feedback-item::before {
            content: '';
            position: absolute;
            left: -22px;
            top: 20px;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: var(--primary);
            border: 2px solid var(--dark-card);
        }

        .feedback-item .feedback-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
        }

        .feedback-item .feedback-admin {
            font-size: 0.82rem;
            font-weight: 600;
            color: var(--primary-light);
        }

        .feedback-item .feedback-date {
            font-size: 0.72rem;
            color: var(--text-muted);
        }

        .feedback-item .feedback-content {
            font-size: 0.88rem;
            color: var(--text-secondary);
            line-height: 1.6;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
        }

        .empty-state i {
            font-size: 3rem;
            color: var(--text-muted);
            margin-bottom: 16px;
        }

        .empty-state h5 {
            color: var(--text-secondary);
            font-weight: 600;
            margin-bottom: 8px;
        }

        .empty-state p {
            color: var(--text-muted);
            font-size: 0.88rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .sidebar.show {
                transform: translateX(0);
            }
            .main-content {
                margin-left: 0;
                padding: 20px 15px;
            }
        }

        /* Animation */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-in {
            animation: fadeInUp 0.4s ease forwards;
        }

        .animate-in:nth-child(1) { animation-delay: 0s; }
        .animate-in:nth-child(2) { animation-delay: 0.05s; }
        .animate-in:nth-child(3) { animation-delay: 0.1s; }
        .animate-in:nth-child(4) { animation-delay: 0.15s; }
        .animate-in:nth-child(5) { animation-delay: 0.2s; }

        /* Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }
        ::-webkit-scrollbar-track {
            background: var(--dark);
        }
        ::-webkit-scrollbar-thumb {
            background: var(--dark-border);
            border-radius: 3px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: var(--text-muted);
        }

        /* Mobile Toggle */
        .mobile-toggle {
            display: none;
            position: fixed;
            top: 15px;
            left: 15px;
            z-index: 1001;
            background: var(--dark-card);
            border: 1px solid var(--dark-border);
            border-radius: 10px;
            padding: 8px 12px;
            color: var(--text-primary);
            cursor: pointer;
        }

        @media (max-width: 768px) {
            .mobile-toggle {
                display: block;
            }
        }

        /* Overlay */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.5);
            z-index: 999;
        }

        .sidebar-overlay.show {
            display: block;
        }
    </style>
</head>
<body>
