const map = L.map('map').setView([-7.1357, 107.5436], 12); // Koordinat Kabupaten Bandung

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap contributors'
}).addTo(map);

fetch('http://localhost:3000/api/umkm')
    .then(response => response.json())
    .then(data => {
        data.forEach(umkm => {
            if (umkm.latitude && umkm.longitude) {
                L.marker([umkm.latitude, umkm.longitude])
                    .addTo(map)
                    .bindPopup(`<b>${umkm.nama_usaha}</b><br>${umkm.nama_merek_produk}`);
            }
        });
    })
    .catch(error => console.error('Error fetching UMKM data:', error));
