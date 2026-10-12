<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Digital - {{ $booking->booking_code }} - CampRent</title>
    <link rel="stylesheet" href="{{ asset('css/user.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body style="background-color: var(--bg-cream); padding: 1rem 0;">
    <div class="receipt-wrapper">
        <!-- Receipt Header -->
        <div class="receipt-header">
            <div class="success-icon-circle">
                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                </svg>
            </div>
            <h2 class="receipt-title">Penyewaan Berhasil!</h2>
            <span class="receipt-subtitle">kode Booking</span>
            <div class="booking-code-large">{{ $booking->booking_code }}</div>
        </div>

        <!-- Dashed Divider -->
        <div class="receipt-divider"></div>

        <!-- Receipt Body Details -->
        <div class="receipt-body">
            <!-- Customer Details Block -->
            <div class="receipt-grid" style="margin-bottom: 1.5rem;">
                <div class="receipt-row">
                    <span class="label">Nama Penyewa</span>
                    <span class="val">{{ $booking->customer_name }}</span>
                </div>
                <div class="receipt-row">
                    <span class="label">whatsApp</span>
                    <span class="val">{{ $booking->phone_number }}</span>
                </div>
                <div class="receipt-row">
                    <span class="label">periode sewa</span>
                    <span class="val">{{ $rentalPeriod }}</span>
                </div>
                <div class="receipt-row">
                    <span class="label">Durasi Sewa</span>
                    <span class="val">{{ $duration }} hari</span>
                </div>
            </div>

            <!-- Items Details Block -->
            <h4 class="receipt-section-title" style="margin-top: 1.5rem;">Detail Pesanan</h4>
            <div class="receipt-items-list">
                @foreach ($booking->bookingItems as $bItem)
                    <div class="receipt-item">
                        <div>
                            <span class="receipt-item-name">{{ $bItem->item->name }}</span>
                            <div class="receipt-item-subtext">
                                {{ $bItem->quantity }} barang × {{ $duration }} hari × Rp {{ number_format($bItem->price_per_day, 0, ',', '.') }}
                            </div>
                        </div>
                        <span class="receipt-item-price">
                            Rp {{ number_format($bItem->price_per_day * $bItem->quantity * $duration, 0, ',', '.') }}
                        </span>
                    </div>
                @endforeach
            </div>

            <!-- Total Payment Block -->
            <div class="receipt-total-row">
                <span class="label">Total Bayar</span>
                <span class="val">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
            </div>

            <!-- Payment Status -->
            <div class="receipt-row" style="margin: 1.5rem 0 1rem 0;">
                <span class="label" style="font-weight: 600;">Status pembayaran</span>
                <span class="val" style="color: var(--forest-green);">Bayar Di tempat</span>
            </div>

            <!-- Location & Instructions Card -->
            <div class="receipt-info-box">
                <div class="location-block">
                    <div class="location-icon">
                        <i class="fa-solid fa-location-dot"></i>
                    </div>
                    <div class="location-text">
                        <div class="location-title">Lokasi Pengambilan:</div>
                        Jl. K.H. Abdurrahman Wahid, Kuala Dua, Gg Jambu, No.78
                    </div>
                </div>

                <div class="instructions-block">
                    <div class="instructions-title">Instruksi Booking:</div>
                    <ul class="instructions-list">
                        <li>Screenshot layar ini sebagai bukti booking barang.</li>
                        <li>Tunjukkan kepada admin saat pengambilan di toko.</li>
                        <li>Lakukan pembayaran di tempat.</li>
                        <li>Bawa KTP/SIM/KK asli sebagai jaminan.</li>
                    </ul>
                </div>
            </div>

            <!-- Note Footer -->
            <div class="receipt-footer-text">
                Lakukan pembayaran di tempat saat pengambilan.
            </div>
        </div>

        <!-- Back Button & Download Actions -->
        <div class="receipt-actions" style="display: flex; flex-direction: column; gap: 0.75rem; padding: 0 2rem 2rem 2rem;">
            <button onclick="downloadReceipt()" class="btn-kembali-beranda" style="background-color: var(--forest-green);">
                <i class="fa-solid fa-download"></i> Download Struk (PDF)
            </button>
            <a href="{{ route('user.dashboard') }}" class="btn-kembali-beranda">
                <i class="fa-solid fa-house"></i> Kembali keberanda
            </a>
        </div>
    </div>

    <!-- html2pdf Library and Script -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script>
        function downloadReceipt() {
            const actions = document.querySelector('.receipt-actions');
            // Hide action buttons during PDF generation
            actions.style.display = 'none';

            const elementToPrint = document.querySelector('.receipt-wrapper');
            
            // Generate PDF option
            const opt = {
                margin:       [5, 5, 5, 5],
                filename:     'Struk-CampRent-{{ $booking->booking_code }}.pdf',
                image:        { type: 'jpeg', quality: 0.98 },
                html2canvas:  { scale: 2, useCORS: true, logging: false },
                jsPDF:        { unit: 'mm', format: [130, 250], orientation: 'portrait' } // Custom thermal-like size
            };

            html2pdf().set(opt).from(elementToPrint).save().then(() => {
                // Restore button visibility
                actions.style.display = 'flex';
            }).catch(err => {
                console.error(err);
                actions.style.display = 'flex';
            });
        }
    </script>
</body>
</html>
