<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">   
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bukti Pembelian</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            color: #333;
        }
        #back-wrap {
            margin: 30px;
            width: 500px;
            display: flex;
            justify-content: flex-end;
        }
        .btn-back {
            padding: 10px 20px;
            color: #fff;
            background: #007bff;
            border-radius: 5px;
            text-decoration: none;
            transition: background 0.3s;
        }
        .btn-back:hover {
            background: #0056b3;
        }
        #receipt {
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin: 30px auto;
            width: 500px;
            background: #FFF;
            border-radius: 10px;
        }
        h2 {
            font-size: 1.2rem;
            margin: 10px 0;
        }
        p {
            font-size: 0.9rem;
            color: #666;
            line-height: 1.5rem;
        }
        #top {
            margin-top: 25px;
        }
        #top .info {
            text-align: left;
            margin: 20px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        td {
            padding: 8px 10px;
            border: 1px solid #EEE;
        }
        .tabletitle {
            font-size: 0.9rem;
            background: #007bff;   
            color: #fff;
        }
        .service {
            border-bottom: 1px solid #EEE;
        }
        .itemtext {
            font-size: 0.9rem;   
        }
        #legalcopy {
            margin-top: 15px;
            text-align: center;
        }
        .btn-print {
            float: right;
            color: #007bff;
            font-weight: bold;
            text-decoration: none;
        }
        .btn-print:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div id="back-wrap">
        <a href="{{ route('kasir.order.index') }}" class="btn-back">Kembali</a>
    </div>
    <div id="receipt">
        <a href="#" class="btn-print">Cetak (.pdf)</a>
        <center id="top">
            <div class="info">
                <h2>Swalayan Mart</h2>
            </div>
        </center>
        <div id="mid">
            <div class="info">
                <p>Alamat : Land Of Dawn</br>
                    Email : Swalayanmart@gmail.com</br>
                    Telepon : 021-123-3221</br>
                </p>
            </div>
        </div>
        <div id="bot">
            <div id="table">
                <table>
                    <tr class="tabletitle">
                        <td class="item">
                            <h2>Barang Belanja</h2>
                        </td>
                        <td class="item">
                            <h2>Total</h2>
                        </td>
                        <td class="Rate">
                            <h2>Harga</h2>
                        </td>
                    </tr>
                    
                    @foreach(json_decode($order->swalayans, true) as $swalayan)
                    <tr class="service">
                        <td class="tableitem">
                            <p class="itemtext">{{ $swalayan['name_swalayan'] }}</p>
                        </td>
                        <td class="tableitem">
                            <p class="itemtext">{{ $swalayan['qty'] }}</p>
                        </td>
                        <td class="tableitem">
                            <p class="itemtext">Rp. {{ number_format($swalayan['price'],0,',','.') }}</p>
                        </td>
                    </tr>
                    @endforeach
                    <tr class="tabletitle">
                        <td></td>
                        <td class="Rate">
                            <h2>PPN (10%)</h2>
                        </td>
                        @php
                                $ppn = $order['total_price'] * 0.01;
                        @endphp
                        <td class="payment">
                            <h2>Rp. {{ number_format($ppn,0,',','.') }}</h2>
                        </td>
                    </tr>
                    <tr class="tabletitle">
                        <td></td>
                        <td class="Rate">
                            <h2>Total Harga</h2>
                        </td>
                        <td class="payment">
                            <h2>Rp. {{ number_format($order['total_price'],0,',','.') }}</h2>
                        </td>
                    </tr>
                </table>
            </div>
            <div id="legalcopy">
                <p class="legal"><strong>Terima kasih atas pembelian Anda!</strong><br>
                Dapatkan diskon 10% untuk pembelian berikutnya! Tunjukkan struk ini saat Anda datang lagi.
                </p>
            </div>
        </div>
    </div>
</body>
</html>
