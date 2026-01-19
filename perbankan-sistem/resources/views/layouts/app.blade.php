<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Perbankan - SMKN 4 Bandung</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #F4F4F4;
            color: #0C2B4E;
            line-height: 1.6;
        }

        .navbar {
            background-color: #0C2B4E;
            padding: 1rem 2rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand {
            color: white;
            font-size: 1.5rem;
            font-weight: bold;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .nav-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .nav-links {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            transition: background-color 0.3s;
            font-size: 0.9rem;
        }

        .nav-links a:hover,
        .nav-links a.active {
            background-color: #1D546C;
        }

        .container {
            max-width: 1400px;
            margin: 2rem auto;
            padding: 0 1rem;
        }

        .card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            margin-bottom: 2rem;
        }

        .card-header {
            background-color: #1A3D64;
            color: white;
            padding: 1rem;
            border-radius: 6px 6px 0 0;
            margin: -2rem -2rem 2rem -2rem;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }

        th {
            background-color: #1A3D64;
            color: white;
            padding: 12px;
            text-align: left;
        }

        td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        .sql-box {
            background-color: #f8f9fa;
            border-left: 4px solid #1D546C;
            padding: 1rem;
            margin: 1rem 0;
            font-family: 'Courier New', monospace;
            white-space: pre-wrap;
            overflow-x: auto;
            font-size: 0.9rem;
        }

        .btn {
            display: inline-block;
            padding: 0.5rem 1.5rem;
            background-color: #1D546C;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #0C2B4E;
        }

        .footer {
            text-align: center;
            padding: 2rem;
            margin-top: 3rem;
            background-color: #0C2B4E;
            color: white;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: white;
            padding: 1.5rem;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .stat-number {
            font-size: 2rem;
            font-weight: bold;
            color: #0C2B4E;
            margin: 0.5rem 0;
        }

        .stat-label {
            color: #1D546C;
            font-size: 0.9rem;
            text-transform: uppercase;
        }

        .query-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-top: 2rem;
        }

        .query-card {
            background: white;
            padding: 1.5rem;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            border-left: 4px solid #1D546C;
        }

        .query-card h3 {
            color: #1A3D64;
            margin-bottom: 1rem;
        }

        .query-card p {
            color: #666;
            margin-bottom: 1rem;
            font-size: 0.95rem;
        }

        .highlight {
            background-color: #e8f4fd;
            padding: 0.5rem;
            border-radius: 4px;
            margin: 1rem 0;
            border-left: 3px solid #1D546C;
        }

        .badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            background-color: #1D546C;
            color: white;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <nav class="navbar">
        <div class="nav-container">
            <a href="/" class="navbar-brand">
                <span>🏦</span>
                Sistem Perbankan
            </a>
            <div class="nav-links">
                <a href="/" class="{{ request()->is('/') ? 'active' : '' }}">Home</a>
                <a href="/query1" class="{{ request()->is('query1') ? 'active' : '' }}">Query 1</a>
                <a href="/query2" class="{{ request()->is('query2') ? 'active' : '' }}">Query 2</a>
                <a href="/query3" class="{{ request()->is('query3') ? 'active' : '' }}">Query 3</a>
                <a href="/query4" class="{{ request()->is('query4') ? 'active' : '' }}">Query 4</a>
                <a href="/query5" class="{{ request()->is('query5') ? 'active' : '' }}">Query 5</a>
                <a href="/query6" class="{{ request()->is('query6') ? 'active' : '' }}">Query 6</a>
                <a href="/query7" class="{{ request()->is('query7') ? 'active' : '' }}">Query 7</a>
                <a href="/query8" class="{{ request()->is('query8') ? 'active' : '' }}">Query 8</a>
                <a href="/query9" class="{{ request()->is('query9') ? 'active' : '' }}">Query 9</a>
            </div>
        </div>
    </nav>

    <div class="container">
        @yield('content')
    </div>

    <footer class="footer">
        <p>SMKN 4 Bandung - Kelas XI RPL III</p>
        <p>Tugas Basis Data - Sistem Perbankan | 5 Query SQL (JOIN + Subquery)</p>
    </footer>


</body>

</html>