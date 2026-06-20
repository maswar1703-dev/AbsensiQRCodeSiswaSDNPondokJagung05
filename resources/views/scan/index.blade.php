<!DOCTYPE html>
<html>
<head>
    <title>Scan Absensi</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            text-align: center;
        }

        .container {
            margin-top: 50px;
        }

        #reader {
            width: 320px;
            margin: 0 auto;
            border: 3px solid #333;
            border-radius: 10px;
            overflow: hidden;
            background: white;
        }

        #qr_code {
            margin-top: 20px;
            padding: 10px;
            width: 250px;
            text-align: center;
            font-size: 16px;
        }

        #status {
            margin-top: 15px;
            font-weight: bold;
            font-size: 18px;
        }

        #infoSiswa {
            margin-top: 20px;
            background: white;
            padding: 15px;
            border-radius: 10px;
            width: 320px;
            margin-left: auto;
            margin-right: auto;
            display: none;
            box-shadow: 0 0 10px rgba(0,0,0,.1);
        }

        #infoSiswa h3 {
            margin-top: 0;
        }
    </style>
</head>

<body>

<div class="container">

    <h2>Scan Barcode / QR Absensi</h2>

    <div id="reader"></div>

    <input
    type="text"
    id="qr_code"
    readonly
    placeholder="NIS - Nama - Kelas"
    style="
        margin-top:20px;
        padding:10px;
        width:500px;
        text-align:center;
        font-size:16px;
    "
>
    <p id="status"></p>

<script src="https://unpkg.com/html5-qrcode"></script>

<script>

let scanner = new Html5Qrcode("reader");
let scanLock = false;

function bunyiBeep()
{
    const audioCtx =
        new (window.AudioContext || window.webkitAudioContext)();

    const oscillator =
        audioCtx.createOscillator();

    const gainNode =
        audioCtx.createGain();

    oscillator.connect(gainNode);
    gainNode.connect(audioCtx.destination);

    oscillator.frequency.value = 1000;
    oscillator.type = 'sine';

    oscillator.start();

    setTimeout(() => {
        oscillator.stop();
    }, 150);
}

function onScanSuccess(decodedText)
{
    if (scanLock) return;

    scanLock = true;

    scanner.pause();

    document.getElementById('qr_code').value =
        decodedText;

    document.getElementById('status').innerHTML =
        "⏳ Memproses absensi...";

    fetch("{{ route('scan.store') }}", {

        method: "POST",

        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },

        body: JSON.stringify({
            qr_code: decodedText
        })

    })

    .then(res => res.json())

    .then(data => {

    console.log(data);

    document.getElementById('status').innerText =
        data.message;

    if(data.success)
    {
        document.getElementById('status').style.color =
            "green";

        document.getElementById('qr_code').value =
            data.nis + " - " +
            data.nama + " - " +
            data.kelas;

        bunyiBeep();
    }
    else
    {
        document.getElementById('status').style.color =
            "red";

        if(data.nis)
        {
            document.getElementById('qr_code').value =
                data.nis + " - " +
                data.nama + " - " +
                data.kelas;
        }
    }

    setTimeout(() => {

        scanLock = false;

        scanner.resume();

    }, 1500);
})

    .catch(error => {

        console.log(error);

        document.getElementById('status').innerText =
            "Terjadi kesalahan";

        document.getElementById('status').style.color =
            "red";

        scanLock = false;

        scanner.resume();

    });
}

Html5Qrcode.getCameras().then(devices => {

    if (devices && devices.length)
    {
        scanner.start(
            { facingMode: "environment" },
            {
                fps: 15,
                qrbox: 250
            },
            onScanSuccess
        );
    }

});

</script>

</body>
</html>