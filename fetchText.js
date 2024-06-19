const puppeteer = require('puppeteer');

(async () => {
    const url = process.argv[2];
    if (!url) {
        console.error('No URL provided');
        process.exit(1);
    }

    const browser = await puppeteer.launch({ headless: true });
    const page = await browser.newPage();
    await page.goto(url, { waitUntil: 'networkidle2' });

    // Dapatkan teks dari elemen body atau elemen lain yang diinginkan
    const text = await page.evaluate(() => {
        return document.body.innerText;
    });

    console.log(text);

    await browser.close();
})();
