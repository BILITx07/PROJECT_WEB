const Jimp = require('jimp');
const fs = require('fs');
const path = require('path');

async function processGrid(imgPath, outputNames) {
    if (!fs.existsSync(imgPath)) {
        console.log(`File not found: ${imgPath}`);
        return;
    }
    
    const image = await Jimp.read(imgPath);
    const w = image.bitmap.width;
    const h = image.bitmap.height;
    
    // We assume a 2 column x 5 row grid
    const cw = Math.floor(w / 2);
    const ch = Math.floor(h / 5);
    
    let idx = 0;
    for (let row = 0; row < 5; row++) {
        for (let col = 0; col < 2; col++) {
            if (idx >= outputNames.length) break;
            const left = col * cw;
            const top = row * ch;
            
            const clone = image.clone();
            clone.crop(left, top, cw, ch);
            
            const outPath = path.join('public', 'storage', 'items', outputNames[idx]);
            await clone.writeAsync(outPath);
            console.log(`Saved ${outPath}`);
            idx++;
        }
    }
}

async function run() {
    const dir = path.join('public', 'storage', 'items');
    if (!fs.existsSync(dir)) {
        fs.mkdirSync(dir, { recursive: true });
    }

    const names1 = ['tenda_5_6.jpg', 'tenda_4_5.jpg', 'tenda_3_4.jpg', 'tenda_2_3.jpg', 'tenda_1_2.jpg', 'tas_60l.jpg', 'tas_45l.jpg', 'tas_25l.jpg', 'kompor_kecil.jpg', 'kompor_besar.jpg'];
    await processGrid('C:\\Users\\user\\Downloads\\WhatsApp Image 2026-06-24 at 12.47.28.jpeg', names1);
    
    const names2 = ['sleeping_bag.jpg', 'sepatu_gunung.jpg', 'jaket_gunung.jpg', 'hammock.jpg', 'gas_portable.jpg', 'jerigen.jpg', 'kursi_lipat.jpg', 'tracking_pole.jpg', 'meja_lipat.jpg', 'hydropack.jpg'];
    await processGrid('C:\\Users\\user\\Downloads\\WhatsApp Image 2026-06-24 at 12.47.42.jpeg', names2);
    
    const img3 = 'C:\\Users\\user\\Downloads\\WhatsApp Image 2026-06-24 at 12.47.51.jpeg';
    if (fs.existsSync(img3)) {
        fs.copyFileSync(img3, path.join(dir, 'kacamata.jpg'));
        console.log("Saved public/storage/items/kacamata.jpg");
    }
}

run().then(() => console.log('Crop complete!')).catch(console.error);
