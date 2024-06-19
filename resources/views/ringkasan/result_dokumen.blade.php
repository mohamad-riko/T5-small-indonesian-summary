<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DOKUMEN-TO-TEKS</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
        }
        .text-box {
            width: calc(50% - 20px);
            padding: 5px;
            border-radius: 8px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        h2 {
            margin-top: 0;
            color: #444;
        }
        h3 {
            margin-top: 20px;
            color: #555;
        }
        p {
            line-height: 1.6;
        }
        
        .container::after {
            content: "";
            clear: both;
            display: table;
        }
        .container > .text-box {
            float: left;
            width: calc(50% - 20px);
        }
        .scrollable {
            max-height: 300px;
            overflow-y: auto; 
        }
        .button-container {
            margin-top: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .button-container form {
            margin: 0 5px;
        }
        .button-container button {
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
            margin: 0 5px;
        }
        .button-container button:hover {
            background-color: rgba(0, 0, 0, 0.1);
        }
        .white-button {
            background-color: #ffffff;
            color: #333333;
        }
        .red-button {
            background-color: #ff0000;
            color: #ffffff;
        }
        .blue-button {
            background-color: #0000ff;
            color: #ffffff;
        }
        .grey-button {
            background-color: #cccccc;
            color: #333333;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 style="text-align: center">SUMMARY TEXT DOKUMEN-TO-TEKS</h1>
    </div>

    <div class="container">
        <div class="text-box">
            <div class="scrollable">
                <br><h4 style="text-align: center"><b>Ringkasan</b></h4>
                <p style="text-align: center"><i>Jumlah Kata: {{ $jumlahKataRingkasan }}</i></p>
                <p style="text-align: justify">{{ $result[0]['summary_text'] ?? '' }}</p>
            </div>
            <div class="button-container">
                <button class="white-button" onclick="copyText('{{ $result[0]['summary_text'] ?? '' }}')">Copy</button>
                <form action="{{ route('download.pdf') }}" method="post">
                    @csrf
                    <input type="hidden" name="text" value="{{ $result[0]['summary_text'] ?? '' }}">
                    <button type="submit" class="red-button">pdf</button>
                </form>
                <form action="{{ route('download.docx') }}" method="post">
                    @csrf
                    <input type="hidden" name="text" value="{{ $result[0]['summary_text'] ?? '' }}">
                    <button type="submit" class="blue-button">docx</button>
                </form>
                <form action="{{ route('download.text') }}" method="post">
                    @csrf
                    <input type="hidden" name="text" value="{{ $result[0]['summary_text'] ?? '' }}">
                    <button type="submit" class="grey-button">txt</button>
                </form>
            </div>
        </div>

        <div class="text-box">
            <div class="scrollable">
                <br><h4 style="text-align: center"><b>Teks Awal</b></h4>
                <p style="text-align: center"><i>Jumlah Kata: {{ $jumlahKataAwal }}</i></p>
                <p style="text-align: justify">{{ $teksAwal }}</p>
            </div>
            <div class="button-container">
                <button class="white-button" onclick="copyText('{{ $teksAwal }}')">Copy</button>
                <form action="{{ route('download.pdf') }}" method="post">
                    @csrf
                    <input type="hidden" name="text" value="{{ $teksAwal }}">
                    <button type="submit" class="red-button">pdf</button>
                </form>
                <form action="{{ route('download.docx') }}" method="post">
                    @csrf
                    <input type="hidden" name="text" value="{{ $teksAwal }}">
                    <button type="submit" class="blue-button">docx</button>
                </form>
                <form action="{{ route('download.text') }}" method="post">
                    @csrf
                    <input type="hidden" name="text" value="{{ $teksAwal }}">
                    <button type="submit" class="grey-button">txt</button>
                </form>
            </div>
        </div>

        <center><a href="/" type="button" class="btn btn-outline-warning">Kembali</a></center>
    </div>
    
    <script>
        function copyText(text) {
            navigator.clipboard.writeText(text)
                .then(() => alert('Teks berhasil disalin!'))
                .catch(err => console.error('Tidak dapat menyalin teks: ', err));
        }
    </script>
</body>
</html>
