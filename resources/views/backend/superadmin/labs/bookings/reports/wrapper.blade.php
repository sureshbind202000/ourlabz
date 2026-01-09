<!DOCTYPE html>
<html>
<head>
    <style>
        @page {
            margin: 120px 50px 100px 50px;
        }
        header {
            position: fixed;
            top: -100px;
            left: 0;
            right: 0;
            height: 100px;
            text-align: center;
        }
        footer {
            position: fixed;
            bottom: -80px;
            left: 0;
            right: 0;
            height: 70px;
            text-align: center;
            font-size: 12px;
        }
        .report-content {
            page-break-inside: avoid;
        }
    </style>
</head>
<body>
    <header>
        <img src="{{ public_path($header_path) }}" height="100px" />
    </header>

    <footer>
        <img src="{{ public_path($footer_path) }}" height="70px" />
    </footer>

    <div class="report-content">
        {!! $report_content !!}
    </div>
</body>
</html>
