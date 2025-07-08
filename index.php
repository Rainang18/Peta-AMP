<!DOCTYPE html>
<html>
<head>
    <title>Peta Interaktif</title>
    <meta charset="utf-8" />
    <style>
        #map { height: 600px; }
        .selector {
            margin: 10px;
        }
    </style>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
</head>
<body>
    <div class="selector">
        <label for="dataSelector">Tampilkan Berdasarkan: </label>
        <select id="dataSelector">
            <option value="AMO">AMO</option>
            <option value="AMF">AMF</option>
        </select>
    </div>
    <div id="map"></div>

    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
    const map = L.map('map').setView([-2.5, 118], 5);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    let markers = [];

    function getColor(value) {
        if (value == 0) return 'red';
        else if (value >= 1 && value <= 3) return 'yellow';
        else if (value >= 4 && value <= 8) return 'green';
        else if (value >= 9 && value <= 15) return 'blue';
        else if (value >= 16 && value <= 25) return 'purple';
        else if (value >= 26 && value <= 35) return 'brown';
        return 'gray';
    }

    function loadData(metric = 'AMO') {
        fetch('get_data.php')
            .then(response => response.json())
            .then(data => {
                // Hapus marker lama
                markers.forEach(m => map.removeLayer(m));
                markers = [];

                data.forEach(item => {
                    const color = getColor(item[metric]);

                    const marker = L.circleMarker([item.lat, item.long], {
                        radius: 8,
                        fillColor: color,
                        color: '#000',
                        weight: 1,
                        opacity: 1,
                        fillOpacity: 0.8
                    }).bindPopup(`
                        <strong>ICAO:</strong> ${item.ICAO}<br/>
                        <strong>AMO:</strong> ${item.AMO}<br/>
                        <strong>AMF:</strong> ${item.AMF}
                    `);

                    marker.addTo(map);
                    markers.push(marker);
                });
            });
    }

    document.getElementById('dataSelector').addEventListener('change', function() {
        loadData(this.value);
    });

    // Load pertama
    loadData();
    </script>
</body>
</html>
