const express = require("express");
const puppeteer = require("puppeteer");

const app = express();

app.get("/crawl", async (req, res) => {
  const url = req.query.url;
  const selector = req.query.selector || 'body'; // ✅ fallback nếu thiếu

  if (!url) return res.status(400).json({ error: "Thiếu URL" });

  try {
    const browser = await puppeteer.launch({
      headless: true,
      args: ["--no-sandbox", "--disable-setuid-sandbox"],
    });
    const page = await browser.newPage();
    await page.goto(url, { waitUntil: "networkidle2", timeout: 0 });

    const content = await page.evaluate((sel) => {
      const el = document.querySelector(sel) || document.body;
      return el.innerText;
    }, selector); // truyền selector vào evaluate

    await browser.close();
    res.json({ content });
  } catch (err) {
    res.status(500).json({ error: err.message });
  }
});

const PORT = 3000;
app.listen(PORT, () => {
  console.log(`Crawler chạy tại http://localhost:${PORT}`);
});
