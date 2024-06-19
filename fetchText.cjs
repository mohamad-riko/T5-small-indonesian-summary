const puppeteer = require('puppeteer');

(async () => {
    const url = process.argv[2];
    if (!url) {
        console.error('URL is required');
        process.exit(1);
    }

    try {
        console.log('Launching browser...');
        const browser = await puppeteer.launch();
        const page = await browser.newPage();
        console.log('Navigating to URL:', url);
        await page.goto(url, { waitUntil: 'networkidle2' });

        // Tunggu beberapa detik untuk memastikan halaman dimuat sepenuhnya
        await page.waitForTimeout(5000);

        // Tunggu elemen tertentu jika diperlukan
        // await page.waitForSelector('css-selector-here');

        console.log('Extracting text...');
        const text = await page.evaluate(() => {
            // Gantikan page.waitForTimeout dengan setTimeout
            return new Promise(resolve => {
                setTimeout(() => {
                    resolve(document.body.innerText);
                }, 5000); // Tambahkan delay yang sama dengan yang sebelumnya
            });
        });

        console.log('Text extracted:');
        console.log(text);

        await browser.close();
    } catch (error) {
        console.error('Error extracting text:', error);
        process.exit(1);
    }
})();
