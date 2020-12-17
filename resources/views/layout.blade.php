<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tournament</title>

    @yield('head')

<style>  
    table.table-3 {
        border-collapse: collapse;
        border-spacing: 0;
        width: 100%;
    }
    table.table-3 tr {
        background-color: #f8f8f8;
    }

    table.table-3 th,
    table.table-3 td {
        text-align: left;
        padding: 8px;
        border: 1px solid #ddd;
    }

    td.gray {
        background-color: gray;
    }

    @media screen and (max-width: 600px) {
        table.table-3 {
            border: 0;
        }

    
    
        table.table-3 thead {
            border: none;
            clip: rect(0 0 0 0);
            height: 1px;
            margin: -1px;
            overflow: hidden;
            padding: 0;
            position: absolute;
            width: 1px;
        }
    
        table.table-3 tr {
            border-bottom: 1px solid #ddd;
            display: block;
            margin-bottom: 30px;
        }
    
        table.table-3 td {
            display: block;
            text-align: right;
        }
    
        table.table-3 td::before {
            content: attr(data-label);
            float: left;
            font-weight: bold;
            text-transform: uppercase;
        }
    
        table.table-3 td:last-child {
            border-bottom: 0;
        }
    }

    table.table-playoff {
        border-collapse: collapse;
        border-spacing: 0;
        width: 100%;
        border-bottom: 1px solid #ddd;
    }
    table.table-playoff tr {
        background-color: #f8f8f8;
    }

    table.table-playoff th {
        text-align: left;
        padding: 8px;
        border: 1px solid #ddd;
    }

    table.table-playoff td {
        text-align: left;
        padding: 8px;
        border: 0;
    }
    

    @media screen and (max-width: 600px) {
        table.table-playoff {
            border: 0;
        }
    
    
        table.table-playoff thead {
            border: none;
            clip: rect(0 0 0 0);
            height: 1px;
            margin: -1px;
            overflow: hidden;
            padding: 0;
            position: absolute;
            width: 1px;
        }
    
        table.table-playoff tr {
            border-bottom: 1px solid #ddd;
            display: block;
            margin-bottom: 30px;
        }
    
        table.table-playoff td {
            display: block;
            text-align: right;
        }
    
        table.table-playoff td::before {
            content: attr(data-label);
            float: left;
            font-weight: bold;
            text-transform: uppercase;
        }
    
        table.table-playoff td:last-child {
            border-bottom: 0;
        }
    }

</style>    
</head>
<body>
    @yield('button')
    @yield('division')
    @yield('playoff')
    @yield('javascript')
</body>
</html>